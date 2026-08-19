<?php

defined('JH_APP') || exit('Acceso no permitido.');

final class Database
{
    private static ?PDO $instance = null;

    public static function conn(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $cfg = $GLOBALS['config']['db'];
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['name']};charset={$cfg['charset']}";

        try {
            self::$instance = new PDO($dsn, $cfg['user'], $cfg['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log('Error de conexión a BD: ' . $e->getMessage());

            if (($GLOBALS['config']['env'] ?? 'prod') === 'dev') {
                exit('Error de conexión (dev): ' . $e->getMessage());
            }
            http_response_code(500);
            exit('El sitio no está disponible en este momento.');
        }

        return self::$instance;
    }
}
