-- =====================================================================
--  Justicia Hidrica -- Datos iniciales
--
-- =====================================================================

SET NAMES utf8mb4;

-- ----------------------------------------------------------
-- 1. NOTICIAS
-- ----------------------------------------------------------
DELETE FROM noticias;
ALTER TABLE noticias AUTO_INCREMENT = 1;
INSERT INTO noticias (Titulo, Imagen, Desde, Hasta) VALUES
('Seminario, Ríos en Comunidad (Ser comunidad) - Hidropesquisa comunitario para la gestión participativa de los ríos', 'img/Noticias/SeminarioRosenComunidadSercomunidadHidropesquisacomunitarioparalagestinparticipativadelosros2024-11-212024-11-29.png', '2024-11-21', '2024-11-29');

-- ----------------------------------------------------------
-- 2. EQUIPO  (personas unicas + categorias + asignaciones)
--    Una persona puede estar en varias categorias: se inserta
--    UNA vez y se enlaza varias veces en equipo_categoria.
-- ----------------------------------------------------------
DELETE FROM equipo_categoria;
DELETE FROM equipo;
DELETE FROM equipo_categorias;
ALTER TABLE equipo AUTO_INCREMENT = 1;
ALTER TABLE equipo_categorias AUTO_INCREMENT = 1;
INSERT INTO equipo_categorias (ID, Nombre, Orden) VALUES
(1, 'Coordinadores', 0),
(2, 'Equipo técnico de soporte digital y documental', 1),
(3, 'Investigadores COLSAN', 2),
(4, 'Colaboradores de instituciones extranjeras', 3),
(5, 'Colaboradores de instituciones mexicanas', 4);

INSERT INTO equipo (ID, Nombre, Cargo, Descripcion, Imagen, Orden) VALUES
(1, 'Francisco Javier Peña De Paz', 'Doctor en Ciencias Sociales, con especialidad en Antropología Social. Centro de Investigaciones y Estudios Superiores en Antropología Social (CIESAS-Occidente)', 'Coordinador del proyecto Justicia Hídrica México', 'img/Equipo/Francisco Javier Peña De Paz.png', 0),
(2, 'Elda Barbosa Briones', 'Doctora en Ciencias Ambientales', 'Doctorante en el Colegio de San Luis A.C.', 'img/Equipo/Elda Barbosa Briones.png', 0),
(3, 'Luis Enrique Granados Muñoz', 'Doctor en Ciencias Sociales', 'Coordinador del proyecto Justicia Hídrica México', 'img/Equipo/Luis Enrique Granados Muñoz.png', 0),
(4, 'Montserrat Guadalupe Galván Ojeda', 'Ingeniera en Sistemas Inteligentes - UASLP', 'Me especializo en programación y desarrollo multiplataforma, principalmente web dentro de proyectos que me permitan generar un impacto positivo en la sociedad a través de la tecnología.', 'img/Equipo/Montserrat Guadalupe Galván Ojeda.png', 0),
(5, 'Ángel Gabriel Esparza Roque', 'Licenciado en Ciencias Sociales', 'Aquí va una descripción personal, frase o emblema', 'img/foto.png', 0),
(6, 'Perla Gabriela Monreal Salinas', 'Licenciada en Geografía - Universidad Autónoma de San Luis Potosí', 'Experiencia en investigación, con enfoque en temas socioambientales. Especialista en análisis geoespacial, diseño y aplicación de talleres participativos.', 'img/Equipo/Perla Gabriela Monreal Salinas.png', 0),
(7, 'Germán Santacruz De León', 'Doctor en Ciencias Ambientales por el Programa Multidisciplinario de Posgrado en Ciencias Ambientales de la Universidad Autónoma de San Luis Potosí', 'Coordinador del proyecto Justicia Hídrica México', 'img/Equipo/Germán Santacruz De León.png', 0),
(8, 'Hortensia Camacho Altamirano', 'Doctora en Ciencias Sociales, PNPC-CONACYT, en el Colegio de Michoacán.', 'Aquí va una descripción personal, frase o emblema', 'img/Equipo/Hortensia Camacho Altamirano.png', 0),
(9, 'Edgar Talledos Sánchez', 'Doctor', 'Aquí va una descripción personal, frase o emblema', 'img/Equipo/Edgar Talledos Sánchez.png', 0),
(10, 'Tania Rodríguez Echavarría', 'Doctora en Geografía del Desarrollo por la Universidad de París Diderot – Paris 7 Sorbonne Paris-Cité y máster en Estudios sobre América Latina por el Instituto de Altos Estudios de América Latina de la Universidad de París 3 – Nueva Sorbona.', 'Profesora Catedrática en las Escuelas de Ciencias Políticas y de la Escuela de Geografía de la UCR. Además de la docencia, ha realizado un amplio número de investigaciones,  proyectos y publicaciones en ambas disciplinas. Actualmente es Directora del Posgrado en Ciencias Políticas, cargo asumido desde el año 2020. Sus líneas de investigación son las fronteras, los conflictos socio-ambientales y los procesos de cooperación transfronteriza.', 'img/Equipo/Tania Rodríguez Echavarría.png', 0),
(11, 'Alonso Ramírez Cover', 'Doctor en Estudios del Desarrollo por el International Institute of Social Studies de Erasmus University Rotterdam', 'Profesor Asociado de Economía Política Global y Geopolítica en la Escuela de Ciencias Políticas de la Universidad de Costa Rica. También es investigador y director del Centro de Investigación y Estudios Políticos (CIEP) de la misma universidad. Entre 2007 y 2010 trabajé como investigador del Instituto de Investigaciones Sociales de la Universidad de Costa Rica. Sus temas de interés incluyen ecología política, desarrollo sostenible y geopolítica.', 'img/Equipo/Alonso Ramírez Cover.png', 0),
(12, 'Alberto Gutiérrez Arguedas', 'Doctor en Ciencias Sociales sobre América Central', 'Investigador del CIEP, profesor de la Sección de Historia y Geografía de la Sede de Occidente de la Universidad de Costa Rica. Sus temas de interés incluyen conflictos socioambientales, proyectos hidroeléctricos, movimientos sociales y política del agua.', 'img/Equipo/Alberto Gutiérrez Arguedas.png', 0),
(13, 'Rutgerd Boelens', 'Doctor en Gestión sostenible del territorio y del agua en España', 'profesor de Ecología Política del Agua en América Latina y ocupa una cátedra especial a tiempo parcial en CEDLA y la Universidad de Ámsterdam (Fac. Humanidades). También trabaja como profesor de Gobernanza del Agua y Justicia Social en la Universidad de Wageningen (Grupo de Ciencias Ambientales, Gestión de Recursos Hídricos) y es profesor visitante en la Universidad Católica del Perú y la Universidad Central del Ecuador. Dirige la alianza internacional Justicia Hídrica/Water Justice, dedicada a la investigación comparativa y la formación sobre acumulación de agua, conflicto y acción de la sociedad civil.', 'img/Equipo/Rutgerd Boelens.png', 0),
(14, 'Bibiana Angélica Duarte Abadía', 'Investigador postdoctoral en proyectos River Commons y Riverhoods', 'Académica de Wageningen University, experta en la ecología política del agua, tiene formación socioambiental transdisciplinaria, basada en el desarrollo rural.', 'img/Equipo/Bibiana Angélica Duarte Abadía.png', 0),
(15, 'Javier Bogantes Díaz', 'Licenciado', 'Fundador y presidente del Tribunal Latinoamericano del Agua (TLA)', 'img/Equipo/Javier Bogantes Díaz.png', 0),
(16, 'Edgar Isch López', 'Doctor en Antropología y Pedagogía', 'Docente de la Universidad Central del Ecuador. Investigador y consultor de varios organismos ecuatorianos e internacionales. Ha trabajado distintos temas sociales y ambientales que se han reproducido en varias obras impresas relacionadas principalmente con Educación, Derechos de la Niñez, Género, Ecología Política y recursos hídricos. Es activista por los derechos económicos, sociales y ambientales en Ecuador, participando con organizaciones populares de todo el país. Ha ejercido las funciones de Ministro de Ambiente del Ecuador y Director de Posgrados de la Universidad Técnica de Cotopaxi. Integrante de la Alianza Internacional de “Justicia Hídrica”, de la Red SEPA por la educación pública en América y la Red ESTRADO sobre trabajo docente.', 'img/Equipo/Edgar Isch López.png', 0),
(17, 'Martina Nebbiai', 'Doctor en Filosofía', 'Profesora presso Universidad Central del Ecuador, marcos legales del agua y su influencia en el bienestar cotidiano de la población campesina. Investigación cualitativa, participativa y comunicacional. Participación ciudadana en la gestión integral del agua', 'img/Equipo/Martina Nebbiai.png', 0),
(18, 'Darío Cepeda Bastidas', 'Doctor en Filosofía', 'Profesor titular de economía agraria / comercio agropecuario Universidad Central del Ecuador y director de posgrados de la facultad de agronomía.', 'img/Equipo/Darío Cepeda Bastidas.png', 0),
(19, 'Ludivina Mejía González', 'Doctora en Ciencias Sociales - El Colegio de San Luis A.C.', 'Profesora-Investigadora en la Sede CIESAS-Sureste. Su trayectoria durante doce años en la investigación social, le ha permitido colaborar en proyectos de investigación que se han desarrollado en el sur de México, y en las fronteras  entre México-Guatemala, México-Belice y El Salvador-Guatemala, enfocados al tema del agua, el territorio y las fronteras. Particularmente, ha trabajado con localidades rurales e indígenas en torno a las dinámicas locales de la gestión del agua; participación de actores locales y convenios transfronterizos, formas de organización de comunidades indígenas y rurales en torno al agua, conflictos en territorios hídricos y fragmentos fronterizos de  la zona Sierra, Frontera y Selva, en el estado de Chiapas.', 'img/Equipo/Ludivina Mejía González.png', 0),
(20, 'Gabriela Arias Hernández', 'Doctora en Ciencias en Desarrollo Sustentable en la Universidad Michoacana de San Nicolás de Hidalgo', 'Profesora en la Universidad Intercultural Indígena de Michoacán. Ha organizado encuentros latinoamericanos en Agricultura urbana y periurbana, y otros sobre la relación cultura - naturaleza. 
Tiene varios libros sobre Agricultura Urbana y Periurbana, algunos artículos indexados sobre vinculación comunitaria universitaria y varios de divulgación sobre maíz, papa y agroecología, producción orgánica, saberes agroecológicos, soberanía alimentaria etc.
Es fundadora de la Red Latinoamericana de Investigación Acción en Agricultura Urbana y Periurbana RED AGUILA), con sede en la Habana, Cuba.
Es fundadora de la Red de Circuitos Cortos de Comercialización y Agricultura Familiar (RECCCAF) con sede en Ibagué, Colombia.', 'img/Equipo/Gabriela Arias Hernández.png', 0),
(21, 'María Verónica Ibarra García', 'Doctora, Maestra y Licenciada en Geografía por la UNAM', 'Profesora en la facultad de filosofía y letras de la UNAM', 'img/Equipo/María Verónica Ibarra García.png', 0),
(22, 'Aracely Rojas', 'Maestra en Estudios para la Paz y el Desarrollo, Licenciada en Ciencias Ambientales', 'Universidad Autónoma del Estado de México', 'img/foto.png', 0),
(23, 'Sócrates López Pérez', 'Doctor en Ciencias Sociales en el área de Planeación y Desarrollo Económico por la Universidad Autónoma Metropolitana', 'Profesor Investigador del Instituto de Ciencias Sociales y Humanidades de la Universidad Autónoma del Estado de Hidalgo. Miembro del Sistema Nacional de Investigadores Nivel I. Miembro de la Academia de Investigación UAEH. Medalla al Mérito Académico del Doctorado por la UAM. Premio Nacional de Economía Ricardo Torres Gaytan 2002 otorgado por el Instituto de Investigaciones Económicas de la UNAM. Estancia Posdoctoral en la Universidad de Münster. Miembro de la comisión científica de la CAMe, hasta el 2024.', 'img/Equipo/Sócrates López Pérez.png', 0),
(24, 'Genaro García Guzmán', 'Maestría en Gestión Integrada de Cuencas por la Universidad Autónoma de Querétaro', 'Profesor de tiempo libre con adscripción a la Facultad de Ciencias Políticas y Sociales UAQ. Coordinador de la Licenciatura en Estudios Socioterritoriales. Ha trabajado como promotor social comunitario en proyectos de fortalecimiento del capital
social de empresas cooperativas indígenas en el municipio de Amealco y participa en
proyectos de desarrollo local con organizaciones de la sociedad civil en el municipio de
Huimilpan.
 Sus líneas de investigación-intervención son la Gestión Integrada del Territorio
(construcción y relación de espacios urbanos y nuevas ruralidades), desarrollo rural,
relación cultura-naturaleza, y acción colectiva y movimientos sociales.', 'img/Equipo/Genaro García Guzmán.png', 0),
(25, 'Mónica Ribeiro Palacios', 'Doctora en Ciencias Ambientales por el Instituto Potosino de Investigación Científica y Tecnológica', 'Profesora investigadora de tiempo completo en el Área de Desarrollo Humano para la Sustentabilidad de la Universidad Autónoma de Querétaro. Cuenta con diversas publicaciones de investigación y divulgación en revistas, libros y otros medios.
Miembro del Cuerpo Académico de Estudios Interdisciplinarios sobre capitalismo, modos de vida y medio ambiente.
Forma parte de la Red Internacional para las sostenibilidad de las Zonas Áridas (RISZA). 
En años recientes sus investigaciones se han centrado en Desigualdades socioambientales y territoriales, desarrollo metropolitano en el contexto del Antropoceno y coproducción de conocimiento.', 'img/Equipo/Mónica Ribeiro Palacios.png', 0),
(26, 'Eduardo Solorio Santiago', 'Doctor en Antropología Social, El Colegio de Michoacán, A.C.', 'Profesor en la facultad de filosofía de la UAQ. Se especializa en líneas de investigación como región, cultura, territorio, impulsando investigaciones y proyectos locales y regionales.', 'img/Equipo/Eduardo Solorio Santiago.png', 0),
(27, 'Acela Montes de Oca Hernández', 'Doctora en Ciencias Agropecuarias y Recursos Naturales', 'Profesora de tiempo completo en la Universidad Autónoma del Estado de México, Centro de Investigación en Ciencias Sociales y Humanidades', 'img/Equipo/Acela Montes de Oca Hernández.png', 0),
(28, 'Gloria Camacho Pichardo', 'Doctora en Historia', 'Profesora investigadora, Universidad Autónoma del Estado de México', 'img/Equipo/Gloria Camacho Pichardo.png', 0),
(29, 'Héctor González Picazo', 'Licenciado', 'Universidad Intercultural de San Luis Potosí', 'img/Equipo/Héctor González Picazo.png', 0),
(30, 'Esmeralda Pliego Alvarado', 'Doctora', 'Universidad Autónoma Metropolitana', 'img/foto.png', 0);

INSERT INTO equipo_categoria (equipo_id, categoria_id, Orden) VALUES
(1, 1, 0),
(2, 1, 1),
(3, 1, 2),
(2, 2, 0),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),

(7, 3, 0),
(1, 3, 1),
(8, 3, 2),
(2, 3, 3),
(9, 3, 4),
(3, 3, 5),
(10, 4, 0),
(11, 4, 1),
(12, 4, 2),
(13, 4, 3),
(14, 4, 4),
(15, 4, 5),
(16, 4, 6),
(17, 4, 7),
(18, 4, 8),
(19, 5, 0),
(20, 5, 1),
(21, 5, 2),
(22, 5, 3),
(23, 5, 4),
(24, 5, 5),
(25, 5, 6),
(26, 5, 7),
(27, 5, 8),
(28, 5, 9),
(29, 5, 10),
(30, 5, 11);

-- ----------------------------------------------------------
-- 3. GALERIAS  (imagenes + videos + esquemas unificados)
-- ----------------------------------------------------------
DELETE FROM galeria_archivos;
DELETE FROM galerias;
ALTER TABLE galeria_archivos AUTO_INCREMENT = 1;
ALTER TABLE galerias AUTO_INCREMENT = 1;
INSERT INTO galerias (ID, Nombre, Tipo, Orden) VALUES
(1, 'Agua en San Luis Potosí', 'imagen', 0),
(2, 'Trasvases y Justicia Hidríca', 'imagen', 1),
(3, 'Guardianes de la Sierra', 'imagen', 2),
(4, 'Agua en San Luis Potosí', 'video', 0),
(5, 'Agua en San Luis Potosí', 'esquema', 0);

INSERT INTO galeria_archivos (galeria_id, Titulo, Ruta, Libro, Orden) VALUES
(1, 'Arroyo de la Estancias', 'img/Fotos/AguaenSanLuisPotosí/Arroyo de  la estancia.jpg', NULL, 0),
(1, 'Caballos', 'img/Fotos/AguaenSanLuisPotosí/Caballos.jpg', NULL, 1),
(1, 'Cocina', 'img/Fotos/AguaenSanLuisPotosí/Cocinando-Francisco I Madero.jpg', NULL, 2),
(1, 'Carlos en el río', 'img/Fotos/AguaenSanLuisPotosí/Carlos en el río.jpg', NULL, 3),
(1, 'Acarreando Agua - Tancanhuitz', 'img/Fotos/AguaenSanLuisPotosí/Acarrear agua-Tancanhuitz.JPG', NULL, 4),
(1, 'Horno', 'img/Fotos/AguaenSanLuisPotosí/DSC01839.JPG', NULL, 5),
(1, 'Cochinos al agua', 'img/Fotos/AguaenSanLuisPotosí/Cochinos al agua.jpg', NULL, 6),
(1, 'Ejidatarios de Independencia', 'img/Fotos/AguaenSanLuisPotosí/Ejidatarios de Independencia.JPG', NULL, 7),
(1, 'Vigilando las bombas - Río Coy', 'img/Fotos/AguaenSanLuisPotosí/Vigilando las bombas-Río Coy.JPG', NULL, 8),
(1, 'Huasteca', 'img/Fotos/AguaenSanLuisPotosí/HUASTECA-8-GSDL.JPG', NULL, 9),
(1, 'José y Alfredo', 'img/Fotos/AguaenSanLuisPotosí/Jose y Alfredo.jpg', NULL, 10),
(1, 'Lavando ropa Mexquitic', 'img/Fotos/AguaenSanLuisPotosí/Lavando ropa-Mexquitic.JPG', NULL, 11),
(1, 'Río Tampaón', 'img/Fotos/AguaenSanLuisPotosí/Río Tampaón.JPG', NULL, 12),
(1, 'Salinas', 'img/Fotos/AguaenSanLuisPotosí/10.jpg', NULL, 13),
(1, 'Refrescándonos', 'img/Fotos/AguaenSanLuisPotosí/Refrescándonos- manantial en la Huasteca.JPG', NULL, 14),
(1, 'Nacimiento del Río Coy', 'img/Fotos/AguaenSanLuisPotosí/Nacimiento del Río Coy.JPG', NULL, 15),
(1, 'La lavadora', 'img/Fotos/AguaenSanLuisPotosí/La lavadora.jpg', NULL, 16),
(1, 'Ordeñando', 'img/Fotos/AguaenSanLuisPotosí/Ordeñando.jpg', NULL, 17),
(1, 'Parcelas regadas - Fco. I. Madero', 'img/Fotos/AguaenSanLuisPotosí/Parcela regada-Francisco I. Madero.jpg', NULL, 18),
(1, 'Acarreando Agua - Las Tablas', 'img/Fotos/AguaenSanLuisPotosí/Acarreando agua-Las Tablas.jpg', NULL, 19),
(1, 'Sacando Gusanos', 'img/Fotos/AguaenSanLuisPotosí/Sacando gusanos-Independencia.jpg', NULL, 20),
(1, 'Tanque de la Casa Blanca', 'img/Fotos/AguaenSanLuisPotosí/Tanque de la casas blancas plouf.jpg', NULL, 21),
(1, 'Tamasopo Zona de Balnearios', 'img/Fotos/AguaenSanLuisPotosí/Tamasopo-zona de balnearios.jpg', NULL, 22),
(1, 'Tranquilidad en Tamul', 'img/Fotos/AguaenSanLuisPotosí/Tranquilidad en Tamul.jpg', NULL, 23),
(1, 'Charcas', 'img/Fotos/AguaenSanLuisPotosí/13.jpg', NULL, 24),
(1, 'Un chapuzón', 'img/Fotos/AguaenSanLuisPotosí/Un chapuzón de Johan.jpg', NULL, 25),
(1, 'Un paseo', 'img/Fotos/AguaenSanLuisPotosí/Un paseo-Francisco I Madero.jpg', NULL, 26),
(1, 'Vigilante Pozo Nacimineto del Coy', 'img/Fotos/AguaenSanLuisPotosí/DSC01838.JPG', NULL, 27),
(1, 'Salinas', 'img/Fotos/AguaenSanLuisPotosí/04.jpg', NULL, 28),
(1, 'Salinas', 'img/Fotos/AguaenSanLuisPotosí/07.jpg', NULL, 29),
(1, 'Salinas', 'img/Fotos/AguaenSanLuisPotosí/08.jpg', NULL, 30),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_110216.jpg', NULL, 0),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_121034.jpg', NULL, 1),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_131806.jpg', NULL, 2),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_132435.jpg', NULL, 3),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_143737.jpg', NULL, 4),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_143827.jpg', NULL, 5),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_143934.jpg', NULL, 6),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211008_144043.jpg', NULL, 7),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/20211114_122141.jpg', NULL, 8),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05285.JPG', NULL, 9),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05286.JPG', NULL, 10),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05287.JPG', NULL, 11),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05288.JPG', NULL, 12),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05289.JPG', NULL, 13),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05290.JPG', NULL, 14),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05291.JPG', NULL, 15),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05292.JPG', NULL, 16),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05293.JPG', NULL, 17),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05294.JPG', NULL, 18),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05295.JPG', NULL, 19),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05296.JPG', NULL, 20),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05297.JPG', NULL, 21),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05298.JPG', NULL, 22),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05299.JPG', NULL, 23),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05300.JPG', NULL, 24),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05301.JPG', NULL, 25),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05302.JPG', NULL, 26),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05303.JPG', NULL, 27),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05304.JPG', NULL, 28),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05305.JPG', NULL, 29),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05306.JPG', NULL, 30),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05307.JPG', NULL, 31),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05308.JPG', NULL, 32),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05309.JPG', NULL, 33),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05310.JPG', NULL, 34),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05311.JPG', NULL, 35),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05312.JPG', NULL, 36),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05313.JPG', NULL, 37),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05314.JPG', NULL, 38),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05316.JPG', NULL, 39),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05317.JPG', NULL, 40),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05319.JPG', NULL, 41),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05320.JPG', NULL, 42),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05321.JPG', NULL, 43),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05322.JPG', NULL, 44),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05323.JPG', NULL, 45),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05324.JPG', NULL, 46),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05325.JPG', NULL, 47),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05326.JPG', NULL, 48),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05327.JPG', NULL, 49),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05328.JPG', NULL, 50),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05329.JPG', NULL, 51),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05330.JPG', NULL, 52),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05331.JPG', NULL, 53),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05337.JPG', NULL, 54),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05338.JPG', NULL, 55),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05339.JPG', NULL, 56),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05340.JPG', NULL, 57),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05341.JPG', NULL, 58),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05343.JPG', NULL, 59),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05344.JPG', NULL, 60),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05345.JPG', NULL, 61),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05346.JPG', NULL, 62),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05347.JPG', NULL, 63),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05348.JPG', NULL, 64),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05349.JPG', NULL, 65),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05350.JPG', NULL, 66),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/DSC05351.JPG', NULL, 67),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_101851070.jpg', NULL, 68),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_140120933.jpg', NULL, 69),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_142255749.jpg', NULL, 70),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_145127780.jpg', NULL, 71),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_145130980.jpg', NULL, 72),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_152618238.jpg', NULL, 73),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_152655396.jpg', NULL, 74),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220525_154339824.jpg', NULL, 75),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220703_114108377.jpg', NULL, 76),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220913_131728708_MFNR.jpg', NULL, 77),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220913_131739081_MFNR.jpg', NULL, 78),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220913_131741114_MFNR.jpg', NULL, 79),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220913_141036147_MFNR.jpg', NULL, 80),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220924_105113943_MFNR.jpg', NULL, 81),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20220924_125005459_MFNR.jpg', NULL, 82),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20221025_111602617_MFNR.jpg', NULL, 83),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20221025_112706946_MFNR.jpg', NULL, 84),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20221025_112858218_MFNR.jpg', NULL, 85),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/IMG_20221025_124030272_MFNR.jpg', NULL, 86),
(2, 'Sin titulo', 'img/Fotos/TrasvasesyJusticiaHidríca/Portada.jpg', NULL, 87),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04462.JPG', NULL, 0),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04463.JPG', NULL, 1),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04470.JPG', NULL, 2),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04471.JPG', NULL, 3),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04478.JPG', NULL, 4),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04479.JPG', NULL, 5),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04482.JPG', NULL, 6),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04486.JPG', NULL, 7),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04488.JPG', NULL, 8),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04489.JPG', NULL, 9),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04495.JPG', NULL, 10),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04499.JPG', NULL, 11),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04507.JPG', NULL, 12),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04516.JPG', NULL, 13),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04520.JPG', NULL, 14),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04521.JPG', NULL, 15),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04524.JPG', NULL, 16),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04532.JPG', NULL, 17),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04533.JPG', NULL, 18),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04536.JPG', NULL, 19),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04543.JPG', NULL, 20),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04551.JPG', NULL, 21),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04552.JPG', NULL, 22),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04555.JPG', NULL, 23),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04558.JPG', NULL, 24),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04573.JPG', NULL, 25),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04574.JPG', NULL, 26),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04580.JPG', NULL, 27),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04581.JPG', NULL, 28),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04583.JPG', NULL, 29),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04585.JPG', NULL, 30),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04586.JPG', NULL, 31),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04587.JPG', NULL, 32),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04594.JPG', NULL, 33),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04599.JPG', NULL, 34),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04607.JPG', NULL, 35),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04616.JPG', NULL, 36),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04623.JPG', NULL, 37),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04624.JPG', NULL, 38),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04626.JPG', NULL, 39),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04632.JPG', NULL, 40),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04633.JPG', NULL, 41),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04641.JPG', NULL, 42),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04648.JPG', NULL, 43),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04651.JPG', NULL, 44),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04654.JPG', NULL, 45),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04660.JPG', NULL, 46),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04662.JPG', NULL, 47),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04669.JPG', NULL, 48),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04674.JPG', NULL, 49),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04679.JPG', NULL, 50),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04686.JPG', NULL, 51),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04697.JPG', NULL, 52),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04698.JPG', NULL, 53),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04700.JPG', NULL, 54),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04704.JPG', NULL, 55),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04705.JPG', NULL, 56),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04708.JPG', NULL, 57),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04715.JPG', NULL, 58),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04716.JPG', NULL, 59),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04719.JPG', NULL, 60),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04721.JPG', NULL, 61),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/DSC04724.JPG', NULL, 62),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6394.JPG', NULL, 63),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6424.JPG', NULL, 64),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6426.JPG', NULL, 65),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6436.JPG', NULL, 66),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6437.JPG', NULL, 67),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6450.JPG', NULL, 68),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6461.JPG', NULL, 69),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6470.JPG', NULL, 70),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6482.JPG', NULL, 71),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6496.JPG', NULL, 72),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6504.JPG', NULL, 73),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/GOPR6506.JPG', NULL, 74),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0011.JPG', NULL, 75),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0070.JPG', NULL, 76),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0077.JPG', NULL, 77),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0089.JPG', NULL, 78),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0111.JPG', NULL, 79),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0115.JPG', NULL, 80),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0116.JPG', NULL, 81),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0122.JPG', NULL, 82),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0127.JPG', NULL, 83),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0130.JPG', NULL, 84),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0210.JPG', NULL, 85),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0222.JPG', NULL, 86),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0229.JPG', NULL, 87),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0234.JPG', NULL, 88),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0316.JPG', NULL, 89),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_0322.JPG', NULL, 90),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_8606.JPG', NULL, 91),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_8610.JPG', NULL, 92),
(3, 'Sin titulo', 'img/Fotos/GuardianesdelaSierra/IMG_8613.JPG', NULL, 93),
(4, 'Junta de Ejidatarios en Independencia', 'img/Videos/AguaenSanLuisPotosí/juntaIndependencia6.mp4', NULL, 0),
(4, 'Junta de Ejidatarios en Independencia', 'img/Videos/AguaenSanLuisPotosí/juntaIndependencia7.mp4', NULL, 1),
(5, 'Programa de saneamiento', 'img/Doc/AguaenSanLuisPotosí/Programa de saneamiento.pdf', 'https://heyzine.com/flip-book/71d71703ff.html', 0);

-- ----------------------------------------------------------
-- 4. PLANES Y PROGRAMAS
-- ----------------------------------------------------------
DELETE FROM plan_documentos;
DELETE FROM planes;
ALTER TABLE plan_documentos AUTO_INCREMENT = 1;
ALTER TABLE planes AUTO_INCREMENT = 1;
INSERT INTO planes (ID, Categoria, Nombre, Descripcion, Anio, Imagen, Orden) VALUES
(1, 'Plan Estatal de Desarrollo', NULL, 'Secretaría general de gobierno y comisión estatal de agua', '2022', 'img/Planes/PROGRAMA SECTORIAL RECUPERACIÓN HÍDRICA CON ENFOQUE DE CUENCAS 2022-2027.png', 0),
(2, 'Sistema Estatal de Planeación', NULL, 'Programas Sectoriales - Desarollo Social', '1999', 'img/Planes/Planeacion.jpg', 1),
(3, 'Plan Integral de Saneamiento', NULL, 'Comisión Estatal de Agua', '1995', 'img/Planes/PlanEstatal.png', 2);

INSERT INTO plan_documentos (plan_id, Nombre, Ruta, Orden) VALUES
(1, 'PROGRAMA SECTORIAL RECUPERACIÓN HÍDRICA CON ENFOQUE DE CUENCAS 2022-2027', 'doc/PP PROGRAMA SECTORIAL RECUPERACIÓN HÍDRICA CON ENFOQUE DE CUENCAS 2022-2027.pdf', 0),
(2, 'Agua Potable y Saneamiento', 'doc/Agua Potable y Saneamiento.pdf', 0),
(2, 'Ecología y Gestión Ambiental', 'doc/Ecologia y Gestion Ambiental.pdf', 1),
(3, 'Reuso de las aguas residuales tratadas de la ciudad de San Luis Potosí y su Zona conurbada de Soledad de Graciano Sánchez', 'doc/PlanIntegraldeSaneamiento.pdf', 0);

-- ----------------------------------------------------------
-- 5. TESIS CON DOCUMENTO  (tabla aparte del catalogo `tesis`)
-- ----------------------------------------------------------
DELETE FROM tesis_documentos;
ALTER TABLE tesis_documentos AUTO_INCREMENT = 1;
INSERT INTO tesis_documentos (Titulo, Autor, Nivel, Ruta, Orden) VALUES
('Conflictos Sociales en la Implementacion del Proyecto Tenorio-Villa de Reyes', 'Claudia Yolanda Gómez Montealvo', 'Maestra en Administración y Políticas Públicas', 'doc/TESIS CGM 03-2004.pdf', 0),
('La Política Intergubernamental del Servicio de Agua Potable en San Luis Potosí, SLP 1989 - 2002', 'Rosario de María Alcalde Alderete', 'Maestra en Administración y Política Pública', 'doc/TesisRosario.pdf', 1),
('Agricultura, agua y migración: lo global y lo local', 'Ana Cecilia Martínez Barbosa', 'Licenciada en Relaciones Internacionales', 'doc/TESIS CECILIA MTZ LRI.pdf', 2),
('Hacia una Gestión Integral de los Recursos Hidricos en la Cuenca del Río Valles, Huasteca México', 'Germán Santacruz De León', 'Doctor en Ciencias Ambientales', 'doc/TESIS DR.SANTACRUZ.pdf', 3);

-- ----------------------------------------------------------
-- 6. PRESAS  (x/y son coordenadas del mapa SVG, no lat/lng)
-- ----------------------------------------------------------
DELETE FROM presas;
ALTER TABLE presas AUTO_INCREMENT = 1;
INSERT INTO presas (`Nombre`, `Sobrenombre`, `Imagen`, `Fecha`, `Localidad`, `Municipio`, `Estado`, `Capacidad`, `Corriente`, `Cuenca`, `Construccion`, `Dependencia`, `Uso`, `Cortina`, `Tipo`, `Longitud`, `Altura`, `Ancho`, `Obra`, `TipoObra`, `Compuertas`, `LocalizacionObra`, `Medida`, `Gasto`, `ObraExcedencia`, `Cantidad`, `Agujas`, `LocalizacionAgujas`, `TipoAgujas`, `LongitudAgujas`, `CargaMax`, `GastoObra`, `CoordX`, `CoordY`) VALUES
('Las Lajillas', NULL, 'img/Presas/Lajillas.png', '15 de Abril de 1997', 'Cd. Valles', 'Cd. Valles', 'San Luis Potosí', '41.5 mm3', 'A. Grande', 'Pánuco', '1965', 'SRH', 'Riego', NULL, 'Materiales graduados', '409.0 Mt', '35.0 Mt', '6.0 Mt', NULL, 'Tubería a presión', '2', 'Margen izquierda', '24´´', NULL, NULL, '1', 'Sin agujas', 'Margen derecha', 'Cresta libre', '4.0 Mt', '85.0 Mt', NULL, 608.0, 402.0),
('Alvaro Obregón', 'Palomas', 'img/Presas/AlvaroObregonAlaq.png', '04 de Abril de 1997', 'San Jóse de Palmas', 'Alaquines', 'San Luis Potosí', '5.2 mm3', 'A. la Cañada', 'Pánuco', 'Junio de 1937', 'CNI', 'Riego', 'De arcilla', 'Materiales graduados', '350.0 Mt', '30.0 Mt', '4.0 Mt', NULL, 'Tubería a presión', '2 válvulas', 'Margen izquierda', '24´´', NULL, NULL, '1', 'Sin agujas', 'Margen derecha', 'Canal lateral', '2.0 Mt', '48.0 Mt', NULL, 514.0, 410.0),
('La Atravezada', NULL, 'img/Presas/LaAtravezada.png', '16 de Abril de 1997', 'Amoladeras', 'Rayón', 'San Luis Potosí', '3.5 mm3', 'A. el Terrero', 'Pánuco', '1985 - 1986', 'SARH', 'Riego', NULL, 'Materiales graduados', '186.0 Mt', '26.0 Mt', '8.0 Mt', NULL, 'Torre y galería con tubería a', '2', 'Margen izquierda', 'Mariposa a 20´´- Compuerta', NULL, NULL, '1', 'Sin agujas', 'Margen derecha', 'Canal lateral', '1.32 Mt', '30.0 Mt', '91.5', 494.0, 479.0),
('Golondrinas', NULL, 'img/Presas/Golondrinas.png', '01 de Abril de 1997', 'Laguna de Santo Domingo', 'San Nicolás Tolentino', 'San Luis Potosí', '30 mm3', 'R. San Nicolás', 'Pánuco', '1979 - 1981', 'SARH', 'Riego', NULL, 'Materiales graduados', '334.0 Mt', '50.0 Mt', '6.0 Mt', NULL, 'Torre galería', '2 compuertas', 'Margen izquierda', NULL, '20.35 m3/s', NULL, '1', 'Sin agujas', 'Margen derecha', 'Cresta libre, con rápida y', '6.15 Mt', '85.0 Mt', '2595.0', 387.0, 422.0),
('La Muñeca', NULL, 'img/Presas/LaMuñeca.png', '17 de Abril de 1997', 'Tierra Nueva', 'Tierra Nueva', 'San Luis Potosí', '25 mm3', 'R. Jofre', 'Pánuco', 'Inaugurada en Febrero de 1982', 'SARH', 'Riego', NULL, 'Materiales graduados', '365.0 Mt', '40.25 Mt', '6.0 Mt', NULL, 'Torre galería', '2 compuertas', 'Margen derecha', NULL, '2.0 m3/s', NULL, '1', 'Sin agujas', 'Margen izquierda', 'Abanico cresta libre', '4.05 Mt', '100.0 Mt', '1610', 362.0, 515.0),
('San José de Villela', NULL, 'img/Presas/SanJoseVillela.png', '16 de Abril de 1997', 'Santo Domingo', 'Santa María del Río', 'San Luis Potosí', '4.1 mm3', 'A. Las Cuevas', 'Pánuco', NULL, 'Particulares', 'Riego', NULL, 'Contrafuertes', '190.0 Mt', '10.0 Mt', '0.7 Mt', NULL, 'Tubería a presión', '3 válvulas', '2 Margen derecha - 1 Al', '8´´- 10´´ - 6´´', NULL, 'No tiene', NULL, NULL, 'Vierte por encima de la corona', NULL, NULL, NULL, NULL, 325.0, 523.0),
('Mariano Moctezuma', 'El Arenal', 'img/Presas/MarianoMoctezuma.png', '16 de Abril de 1997', 'La Yerbabuena', 'Santa María del Río', 'San Luis Potosí', '3.2 mm3', 'A. El Arenal', 'Pánuco', 'Inaugurada en Septiembre de 1976', 'SARH', 'Riego', NULL, 'Flexible de materiales', '275.0 Mt', '31.5 Mt', '6.0 Mt', NULL, 'Torre galería', '2 compuertas', 'Margen derecha', NULL, '0.40 m3/s', NULL, '1', NULL, 'Margen izquierda', 'Lavadero (Descarga Directa)', '1.60 Mt', '140.0 Mt', '540.0', 322.0, 505.0),
('Valentín Gama', 'Ojocaliente', 'img/Presas/ValentinGama.png', '22 de Abril de 1997', 'Pardo', 'Santa María del Río', 'San Luis Potosí', '10 mm3', 'R. Santa María', 'Pánuco', '1966-1968 Inaugurada en Noviembre', 'SARH', 'Riego', NULL, 'Rígido en arco sección', '102.0 Mt', '24.0 Mt', '2.5 Mt', NULL, 'Torre galería', '2 compuertas', 'Margen derecha', NULL, '2.85 m3/s', NULL, '1', NULL, 'Al centro', 'Descarga libre', '4.1 Mt', '40.0 Mt', '1035.0', 314.0, 473.0),
('El Refugio', 'El Hundido', 'img/Presas/ElRefugio.png', '31 de Marzo de 1997', 'San Miguel', 'Villa de Reyes', 'San Luis Potosí', '5.72 mm3', 'A. La Hilada', 'Pánuco', NULL, 'Particulares', 'Riego', NULL, 'Contrafuertes', '800.0 Mt', '2.2 Mt', '1.0 Mt', 'No tiene', NULL, NULL, NULL, NULL, NULL, NULL, '2', NULL, 'Margen derecha y al centro', 'Descarga libre (sin revestir)', NULL, NULL, NULL, 293.0, 492.0),
('Santa Ana', NULL, 'img/Presas/SantaAna.png', '25 de Marzo de 1997', 'Calderón', 'Villa de Reyes', 'San Luis Potosí', '4 mm3', 'A. Guadalupe', 'Pánuco', '1886 - 1913', 'Particulares', 'Riego', NULL, 'Rígida contrafuertes', '156.0 Mt', '30.0 Mt', '2.0 Mt', NULL, 'Tubería (cuenta con canal de)', '2 válvulas', 'Margen izquierda', NULL, NULL, NULL, '3', 'Sin agujas', 'Margen derecha e izquierda', 'Descarga libre (Dos en el)', '0.50 Mt', '3.0 Mt cada uno', NULL, 278.0, 482.0),
('Gonzalo N. Santos', 'El Peaje', 'img/Presas/GonzaloNSantos.png', '02 de Mayo de 1997', 'San Luis Potosí', 'San Luis Potosí', 'San Luis Potosí', '6 mm3', 'A. Grande o Azul', 'Salado', '1949', 'CNI', 'Agua potable', NULL, 'Enrocamiento con pantalla de', '130.0 Mt', '39.0 Mt', '5.0 Mt', NULL, 'Tubería a presión (Dos tuberías)', '2 de emergencia', 'Margen derecha', '14´´', '200 lps', NULL, '1', 'Sin agujas', 'Margen derecha', 'Caida libre (Abanico)', '3.0 Mt', '40.0 Mt', '175.0', 270.0, 435.0),
('El Potosino', NULL, 'img/Presas/ElPotosino.png', '02 de Mayo de 1997', 'Escalerillas', 'San Luis Potosí', 'San Luis Potosí', '3.5 mm3', 'A. El Potosino', 'Salado', '1989', 'Gobierno del Estado', 'Control de', NULL, 'Mampostería', '170.0 Mt', '32.0 Mt', '2.5 Mt', NULL, 'Tubería a presión, con dos', '1 de Mariposa', 'Margen derecha cargada', '18´´', '1.5 - 2.0 m3/s', NULL, NULL, 'Sin agujas', 'Centro de la cortina', 'Cresta libre', '1.5 Mt', '5.0 Mt', NULL, 278.0, 431.0),
('San José', NULL, 'img/Presas/SanJoseSLP.png', '02 de Mayo de 1997', 'San Luis Potosí', 'San Luis Potosí', 'San Luis Potosí', '5.6 mm3', 'R. Santiago', 'Salado', '1896 - 1905', 'Particulares', 'Agua potable', 'Mampostería', 'Gravedad', '170.0 Mt', '32.0 Mt', '5.0 Mt', NULL, '5 de Tubería a presión, 4 en', '8 válvulas de', 'Una en el centro (sin operar)', '18´´', '1.5 - 2.0 m3/s', NULL, '2', 'Sin agujas', 'Margen derecha - Margen izquierda', 'Cresta libre - Cresta libre', '1.3 Mt - 1.6 MT', '9 Mt - 15 Mt', NULL, 282.0, 420.0),
('Alvaro Obregón', 'Mexquitic', 'img/Presas/AlvaroObregonMezq.png', '01 de Abril de 1997', 'Mexquitic de Carmona', 'Mexquitic de Carmona', 'San Luis Potosí', '6 mm3', 'A. Mexquitic', 'Salado', '1922 - 1926', 'SRH', 'Riego', NULL, 'Gravedad', '80.0 Mt', '19.0 Mt', '2.5 Mt', NULL, 'Tubería a presión', '1 válvula', 'Margen derecha', '20´´', '600 lps', NULL, '1', 'Sin agujas', 'Margen izquierda', 'Puerta natural', NULL, '150 Mt aprox.', NULL, 267.0, 401.0),
('Santa Genoveva', 'La Parada', 'img/Presas/SantaGenoveva.png', '31 de Marzo de 1997', 'San Agustín', 'Mexquitic de Carmona', 'San Luis Potosí', '4 mm3', 'A. La Parada', 'Salado', '1885 - 1891', 'Hacendados', 'Riego', NULL, 'Mampostería', '142.0 Mt', '24.0 Mt', '2.0 Mt', NULL, 'Galería con compuertas', '1 compuerta', 'Margen izquierda', '0.80 x 1.00 m', NULL, NULL, '1', 'Con', 'Margen izquierda', 'Cresta libre (Mampostería)', '1.6 Mt', '23.0 Mt', NULL, 238.0, 403.0);

-- ----------------------------------------------------------
-- 7. PORTADA
--    No venia de JSON: el index.php viejo leia la carpeta con
--    glob(). Aqui se registran las imagenes que ya existian.
--    Si agregas mas archivos a img/Portada/, agrega su fila.
-- ----------------------------------------------------------
DELETE FROM portada;
ALTER TABLE portada AUTO_INCREMENT = 1;
INSERT INTO portada (Ruta, TextoAlt, Activa, Orden) VALUES
('img/Portada/AcueductoII.png', 'Acueducto II', 1, 0),
('img/Portada/MonterreyVI.png', 'Monterrey VI', 1, 1),
('img/Portada/Realito.jpg', 'El Realito', 1, 2);