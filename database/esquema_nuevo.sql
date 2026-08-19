-- =====================================================================
--  Justicia Hidrica -- Tablas que reemplazan a los archivos JSON
--  Base de datos: elaguaenslp
-- =====================================================================

SET NAMES utf8mb4;


-- ---------------------------------------------------------------------
-- 1. NOTICIAS   (reemplaza noticias.json)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS noticias (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Titulo          VARCHAR(255)    NOT NULL,
    Imagen          VARCHAR(500)    NOT NULL,
    Desde           DATE            NOT NULL,
    Hasta           DATE            NOT NULL,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_vigencia (Desde, Hasta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 2. EQUIPO   (reemplaza equipo.json)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS equipo_categorias (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre          VARCHAR(200)    NOT NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_categoria (Nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS equipo (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre          VARCHAR(200)    NOT NULL,
    Cargo           TEXT            NULL,   -- "cargo" en el JSON (textos largos)
    Descripcion     TEXT            NULL,   -- "descripcion" / emblema
    Imagen          VARCHAR(500)    NULL,   -- NULL = se usa la foto generica
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (Nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS equipo_categoria (
    equipo_id       INT UNSIGNED    NOT NULL,
    categoria_id    INT UNSIGNED    NOT NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,

    PRIMARY KEY (equipo_id, categoria_id),
    INDEX idx_categoria (categoria_id),
    CONSTRAINT fk_ec_equipo
        FOREIGN KEY (equipo_id) REFERENCES equipo(ID)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ec_categoria
        FOREIGN KEY (categoria_id) REFERENCES equipo_categorias(ID)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 3. GALERIAS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS galerias (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre          VARCHAR(200)    NOT NULL,
    Tipo            ENUM('imagen','video','esquema') NOT NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_galeria (Nombre, Tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS galeria_archivos (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    galeria_id      INT UNSIGNED    NOT NULL,
    Titulo          VARCHAR(255)    NOT NULL,
    Ruta            VARCHAR(500)    NOT NULL,
    Libro           VARCHAR(500)    NULL,   -- enlace externo (flipbook), solo esquemas
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_galeria (galeria_id),
    CONSTRAINT fk_archivo_galeria
        FOREIGN KEY (galeria_id) REFERENCES galerias(ID)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 4. PLANES Y PROGRAMAS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS planes (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Categoria       VARCHAR(255)    NOT NULL,   -- nombre visible del grupo
    Nombre          VARCHAR(255)    NULL,       -- opcional
    Descripcion     TEXT            NULL,
    Anio            VARCHAR(20)     NULL,       -- texto: en el JSON hay "1999", rangos, etc.
    Imagen          VARCHAR(500)    NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (Categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS plan_documentos (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    plan_id         INT UNSIGNED    NOT NULL,
    Nombre          VARCHAR(500)    NOT NULL,
    Ruta            VARCHAR(500)    NOT NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_plan (plan_id),
    CONSTRAINT fk_documento_plan
        FOREIGN KEY (plan_id) REFERENCES planes(ID)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 5. TESIS CON DOCUMENTO
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tesis_documentos (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Titulo          VARCHAR(500)    NOT NULL,
    Autor           VARCHAR(255)    NOT NULL,
    Nivel           VARCHAR(200)    NULL,   -- "Maestra en...", "Doctor en..."
    Ruta            VARCHAR(500)    NOT NULL,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_autor (Autor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 6. PRESAS
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS presas (
    ID                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre              VARCHAR(255)    NOT NULL,
    Sobrenombre         VARCHAR(255)    NULL,
    Imagen              VARCHAR(500)    NULL,
    Fecha               VARCHAR(100)    NULL,   -- texto libre: "15 de Abril de 1997"
    Localidad           VARCHAR(255)    NULL,
    Municipio           VARCHAR(255)    NULL,
    Estado              VARCHAR(100)    NOT NULL DEFAULT 'San Luis Potosi',
    Capacidad           VARCHAR(100)    NULL,
    Corriente           VARCHAR(255)    NULL,
    Cuenca              VARCHAR(255)    NULL,
    Construccion        VARCHAR(255)    NULL,
    Dependencia         VARCHAR(255)    NULL,
    Uso                 VARCHAR(255)    NULL,
    Cortina             VARCHAR(255)    NULL,
    Tipo                VARCHAR(150)    NULL,
    Longitud            VARCHAR(100)    NULL,
    Altura              VARCHAR(100)    NULL,
    Ancho               VARCHAR(100)    NULL,
    Obra                VARCHAR(255)    NULL,
    TipoObra            VARCHAR(255)    NULL,
    Compuertas          VARCHAR(150)    NULL,
    LocalizacionObra    VARCHAR(255)    NULL,
    Medida              VARCHAR(150)    NULL,
    Gasto               VARCHAR(150)    NULL,
    ObraExcedencia      VARCHAR(255)    NULL,
    Cantidad            VARCHAR(150)    NULL,
    Agujas              VARCHAR(150)    NULL,
    LocalizacionAgujas  VARCHAR(255)    NULL,
    TipoAgujas          VARCHAR(150)    NULL,
    LongitudAgujas      VARCHAR(150)    NULL,
    CargaMax            VARCHAR(150)    NULL,
    GastoObra           VARCHAR(150)    NULL,
    CoordX              DECIMAL(10,2)   NULL,
    CoordY              DECIMAL(10,2)   NULL,
    creado_en           TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
                                        ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_municipio (Municipio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------------
-- 7. PORTADA
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS portada (
    ID              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Ruta            VARCHAR(500)    NOT NULL,
    TextoAlt        VARCHAR(255)    NULL,
    Activa          TINYINT(1)      NOT NULL DEFAULT 1,
    Orden           SMALLINT        NOT NULL DEFAULT 0,
    creado_en       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activa (Activa, Orden)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
