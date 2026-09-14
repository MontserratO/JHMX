-- =====================================================================
--  Justicia Hidrica -- Tablas del panel de administracion sobre la base elaguaenslp
-- =====================================================================

SET NAMES utf8mb4;


-- ---------------------------------------------------------------------
-- 1. USUARIOS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Usuario         VARCHAR(60)     NOT NULL,
    Nombre          VARCHAR(150)    NOT NULL,
    Correo          VARCHAR(190)    NULL,
    Clave           VARCHAR(255)    NOT NULL,   -- hash, nunca la contrasena
    Rol             ENUM('administrador','editor') NOT NULL DEFAULT 'editor',

    -- Activo = 0 revoca el acceso sin borrar la cuenta.
    Activo          TINYINT(1)      NOT NULL DEFAULT 1,

    CambiarClave    TINYINT(1)      NOT NULL DEFAULT 1,

    UltimoAcceso    DATETIME        NULL,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_usuario (Usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 2. INTENTOS DE ACCESO
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS intentos_acceso (
    ID          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Usuario     VARCHAR(60)     NOT NULL,
    IP          VARCHAR(45)     NOT NULL,   -- cabe una IPv6
    Exito       TINYINT(1)      NOT NULL DEFAULT 0,
    Momento     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_usuario (Usuario, Momento),
    INDEX idx_ip (IP, Momento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 3. LOG
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS bitacora (
    ID          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT UNSIGNED    NULL,        -- NULL si la cuenta se borro
    UsuarioNom  VARCHAR(60)     NOT NULL,    -- copia, para que no se pierda
    Accion      VARCHAR(30)     NOT NULL,    -- creo / edito / elimino / entro
    Entidad     VARCHAR(60)     NULL,        -- tabla o seccion afectada
    RegistroID  VARCHAR(60)     NULL,
    Detalle     VARCHAR(500)    NULL,
    IP          VARCHAR(45)     NULL,
    Momento     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_momento (Momento),
    INDEX idx_usuario (usuario_id),
    CONSTRAINT fk_bitacora_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(ID)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
