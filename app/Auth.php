<?php

/**
 * Autenticación y control de acceso del panel.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class Auth
{
    private const MAX_INTENTOS  = 5;
    private const MINUTOS_BLOQUEO = 15;

    private const MINUTOS_INACTIVIDAD = 45;
    private const HORAS_MAXIMAS = 8;

    private static function db(): PDO
    {
        return Database::conn();
    }

    public static function ip(): string
    {
        return substr($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0', 0, 45);
    }

    /* =================================================================
     *  ENTRADA
     * ================================================================= */

    /**     Comprueba usuario y contraseña.     */
    public static function entrar(string $usuario, string $clave): array
    {
        $usuario = trim($usuario);
        $ip      = self::ip();

        $espera = self::minutosBloqueo($usuario, $ip);
        if ($espera > 0) {
            return [false, "Demasiados intentos fallidos. Vuelve a intentarlo en {$espera} minutos."];
        }

        $stmt = self::db()->prepare(
            "SELECT * FROM usuarios WHERE Usuario = ? AND Activo = 1 LIMIT 1"
        );
        $stmt->execute([$usuario]);
        $u = $stmt->fetch();

        $hash = $u['Clave'] ?? '$2y$12$invalidinvalidinvalidinvalidinvalidinvalidinvalidinvalidin';
        $ok   = password_verify($clave, $hash) && $u !== false;

        self::registrarIntento($usuario, $ip, $ok);

        if (!$ok) {
            return [false, 'Usuario o contraseña incorrectos.'];
        }

        // --- Sesión ---
        session_regenerate_id(true);

        $_SESSION['auth'] = [
            'id'      => (int) $u['ID'],
            'usuario' => $u['Usuario'],
            'nombre'  => $u['Nombre'],
            'rol'     => $u['Rol'],
            'cambiar' => (bool) $u['CambiarClave'],
            'inicio'  => time(),
            'ultimo'  => time(),
            'huella'  => self::huella(),
        ];

        self::db()->prepare("UPDATE usuarios SET UltimoAcceso = NOW() WHERE ID = ?")
                  ->execute([$u['ID']]);

        self::bitacora('entro');

        return [true, ''];
    }

    public static function salir(): void
    {
        if (self::activo()) {
            self::bitacora('salio');
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                      $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    /* =================================================================
     *  ESTADO
     * ================================================================= */

    private static function huella(): string
    {
        return hash('sha256', ($_SERVER['HTTP_USER_AGENT'] ?? '') . '|jh');
    }

    public static function activo(): bool
    {
        $a = $_SESSION['auth'] ?? null;
        if (!is_array($a)) {
            return false;
        }

        if (($a['huella'] ?? '') !== self::huella()) {
            self::salir();
            return false;
        }

        $ahora = time();

        if ($ahora - ($a['ultimo'] ?? 0) > self::MINUTOS_INACTIVIDAD * 60
            || $ahora - ($a['inicio'] ?? 0) > self::HORAS_MAXIMAS * 3600) {
            self::salir();
            return false;
        }

        $_SESSION['auth']['ultimo'] = $ahora;
        return true;
    }

    public static function usuario(): ?array
    {
        return self::activo() ? $_SESSION['auth'] : null;
    }

    public static function es(string $rol): bool
    {
        return (self::usuario()['rol'] ?? '') === $rol;
    }

    public static function esAdmin(): bool
    {
        return self::es('administrador');
    }

    public static function requerir(?string $rol = null): void
    {
        if (!self::activo()) {
            $destino = urlencode($_SERVER['REQUEST_URI'] ?? '');
            redirect(base_url('admin/login') . '?volver=' . $destino);
        }

        $actual = $_SERVER['SCRIPT_NAME'] ?? '';
        if (($_SESSION['auth']['cambiar'] ?? false) && !str_contains($actual, 'clave')) {
            redirect(base_url('admin/clave'));
        }

        if ($rol !== null && !self::es($rol)) {
            http_response_code(403);
            exit('No tienes permiso para ver esta sección.');
        }
    }

    /* =================================================================
     *  INTENTOS FALLIDOS
     * ================================================================= */

    private static function registrarIntento(string $usuario, string $ip, bool $ok): void
    {
        self::db()->prepare(
            "INSERT INTO intentos_acceso (Usuario, IP, Exito) VALUES (?, ?, ?)"
        )->execute([substr($usuario, 0, 60), $ip, $ok ? 1 : 0]);

        if ($ok) {
            self::db()->prepare(
                "DELETE FROM intentos_acceso WHERE Usuario = ? AND Exito = 0"
            )->execute([$usuario]);
        }
    }

    /**
     * Minutos que faltan para poder reintentar, o 0 si no está bloqueado.
     */
    private static function minutosBloqueo(string $usuario, string $ip): int
    {
        $sql = "SELECT COUNT(*) AS fallos, MAX(Momento) AS ultimo
                FROM intentos_acceso
                WHERE Exito = 0
                  AND Momento > DATE_SUB(NOW(), INTERVAL ? MINUTE)
                  AND (Usuario = ? OR IP = ?)";

        $stmt = self::db()->prepare($sql);
        $stmt->execute([self::MINUTOS_BLOQUEO, $usuario, $ip]);
        $r = $stmt->fetch();

        if ((int) $r['fallos'] < self::MAX_INTENTOS) {
            return 0;
        }

        $pasados = (time() - strtotime($r['ultimo'])) / 60;
        return max(1, (int) ceil(self::MINUTOS_BLOQUEO - $pasados));
    }

    /* =================================================================
     *  LOG
     * ================================================================= */

    public static function bitacora(
        string $accion,
        ?string $entidad = null,
        ?string $registro = null,
        ?string $detalle = null
    ): void {
        $u = $_SESSION['auth'] ?? null;

        self::db()->prepare(
            "INSERT INTO bitacora (usuario_id, UsuarioNom, Accion, Entidad, RegistroID, Detalle, IP)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        )->execute([
            $u['id'] ?? null,
            $u['usuario'] ?? 'desconocido',
            $accion,
            $entidad,
            $registro,
            $detalle !== null ? mb_substr($detalle, 0, 500) : null,
            self::ip(),
        ]);
    }

    /* =================================================================
     *  CONTRASEÑAS
     * ================================================================= */

    public static function validarClave(string $clave): string
    {
        if (mb_strlen($clave) < 10) {
            return 'La contraseña debe tener al menos 10 caracteres.';
        }
        if (!preg_match('/[a-zA-Z]/', $clave) || !preg_match('/\d/', $clave)) {
            return 'La contraseña debe incluir letras y números.';
        }
        return '';
    }

    public static function cambiarClave(int $idUsuario, string $nueva): void
    {
        $hash = password_hash($nueva, PASSWORD_DEFAULT);

        self::db()->prepare(
            "UPDATE usuarios SET Clave = ?, CambiarClave = 0 WHERE ID = ?"
        )->execute([$hash, $idUsuario]);

        if (isset($_SESSION['auth'])) {
            $_SESSION['auth']['cambiar'] = false;
        }
        self::bitacora('cambio su contraseña');
    }
}
