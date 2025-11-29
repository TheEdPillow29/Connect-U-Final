-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 29-11-2025 a las 05:22:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemagruposv2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `ID_grupo` varchar(20) NOT NULL,
  `administradorGrupo` varchar(20) DEFAULT NULL,
  `nombreGrupo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cupoMaximo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`ID_grupo`, `administradorGrupo`, `nombreGrupo`, `descripcion`, `estado`, `fecha`, `cupoMaximo`) VALUES
('RHD-10273', 'IRJ-40842', 'Zboncak Group', 'Low Dose Rate (LDR) Brachytherapy of Diaphragm using Californium 252 (Cf-252)', 'Activo', '2024-11-11', 10),
('RHD-10767', 'IRJ-24185', 'Estudios Generales de Métodos numéricos', 'Tutorías para estudiantes universitarios', 'Activo', '2025-06-30', 10),
('RHD-11123', 'IRJ-11460', 'Estadistica Aplicada a las TIC', 'Hola, en este grupo de estudio, busca desarrollar el conocimientos técnico de las plataformas como Excell  ', 'Activo', '2025-07-14', 5),
('RHD-13218', 'IRJ-76583', 'Shields-Heidenreich', 'Insertion of Intraluminal Device into Hemiazygos Vein, Percutaneous Endoscopic Approach', 'Activo', '2025-03-11', 10),
('RHD-15517', 'IRJ-96944', 'Jast-Maggio', 'Revision of Nonautologous Tissue Substitute in Right Acetabulum, Percutaneous Approach', 'Activo', '2023-02-19', 20),
('RHD-15569', 'IRJ-53920', 'Cartwright-Farrell', 'Bypass Splenic Artery to Bilateral Renal Artery with Nonautologous Tissue Substitute, Open Approach', 'Oculto', '2022-10-11', 10),
('RHD-16942', 'IRJ-49266', 'Runolfsson LLC', 'Bypass Right External Iliac Artery to Bilateral Internal Iliac Arteries, Percutaneous Endoscopic Approach', 'Oculto', '2024-08-29', 30),
('RHD-23031', 'IRJ-39257', 'Swift, Schmidt and Beahan', 'Fusion of Left Carpal Joint with Nonautologous Tissue Substitute, Percutaneous Approach', 'Oculto', '2022-08-06', 30),
('RHD-28273', 'IRJ-24185', 'Estudios Generales de Métodos numéricos', 'hola', 'Activo', '2025-06-30', 5),
('RHD-36198', 'IRJ-85209', 'Monahan-Harvey', 'Dilation of Left Renal Artery, Bifurcation, with Three Intraluminal Devices, Percutaneous Endoscopic Approach', 'Activo', '2024-03-30', 30),
('RHD-37088', 'IRJ-35564', 'Medhurst Inc', 'Repair Bilateral Lungs, Percutaneous Endoscopic Approach', 'Activo', '2025-02-01', 20),
('RHD-40110', 'IRJ-20765', 'Bartoletti LLC', 'Revision of External Fixation Device in Left Carpal Joint, External Approach', 'Oculto', '2022-11-27', 20),
('RHD-41640', 'IRJ-60864', 'King, Barrows and Anderson', 'Repair Left Hand, External Approach', 'Oculto', '2022-09-03', 30),
('RHD-41802', 'IRJ-13743', 'Cassin LLC', 'Removal of Nonautologous Tissue Substitute from Lumbar Vertebral Joint, Open Approach', 'Activo', '2022-04-03', 20),
('RHD-54170', 'IRJ-64342', 'Hayes Inc', 'Control Bleeding in Oral Cavity and Throat, Via Natural or Artificial Opening', 'Activo', '2024-06-08', 10),
('RHD-56234', 'IRJ-69699', 'Schuppe, Kirlin and Wilderman', 'Supplement Buccal Mucosa with Nonautologous Tissue Substitute, External Approach', 'Activo', '2024-10-08', 10),
('RHD-59329', 'IRJ-11460', 'CISCO', 'UNETE', 'Activo', '2025-07-21', 30),
('RHD-65256', 'IRJ-36257', 'Effertz-Conn', 'Repair Right Ankle Joint, Percutaneous Approach', 'Oculto', '2024-10-13', 20),
('RHD-68067', 'IRJ-45317', 'Runolfsson and Sons', 'Supplement Left Upper Arm with Nonautologous Tissue Substitute, Percutaneous Endoscopic Approach', 'Activo', '2022-06-15', 20),
('RHD-72086', 'IRJ-35119', 'Emmerich-Davis', 'Extirpation of Matter from Left Iris, Percutaneous Approach', 'Activo', '2025-02-21', 20),
('RHD-73138', 'IRJ-11074', 'uoihoupojuh', 'hiopoiy\'0ihpo0', 'Activo', '2025-07-26', 9),
('RHD-84141', 'IRJ-11460', 'Termodinamica ', 'Curso de termodinamica de las cosas jajajajaj', 'Activo', '2025-07-26', 10),
('RHD-86629', 'IRJ-65957', 'Streich Inc', 'Replacement of Left Thorax Tendon with Autologous Tissue Substitute, Open Approach', 'Activo', '2024-03-27', 10),
('RHD-89398', 'IRJ-11074', 'Wiegand Group', 'Release Right Testis, Percutaneous Approach', 'Activo', '2022-08-27', 10),
('RHD-94622', 'IRJ-24185', 'curso de python', 'Este grupo está formado por estudiantes interesados en aprender programación con Python, un lenguaje versátil y fácil de entender. A lo largo del curso, el grupo explora temas como variables, estructuras de control, funciones, manejo de archivos, listas, diccionarios, programación orientada a objetos y desarrollo de proyectos prácticos. Los integrantes colaboran para resolver ejercicios, compartir recursos, resolver dudas y desarrollar habilidades que les permitan crear sus propias aplicaciones o scripts automatizados.', 'Activo', '2025-07-14', 20),
('RHD-96545', 'IRJ-98006', 'Schuster LLC', 'Revision of Drainage Device in Left Carpal Joint, Open Approach', 'Activo', '2025-05-06', 10),
('RHD-96782', 'IRJ-89340', 'Kihn Inc', 'Destruction of Right Elbow Bursa and Ligament, Percutaneous Endoscopic Approach', 'Activo', '2023-11-01', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupoestudio`
--

CREATE TABLE `grupoestudio` (
  `ID_grupo` varchar(20) NOT NULL,
  `Materia` varchar(100) DEFAULT NULL,
  `Turno` varchar(50) DEFAULT NULL,
  `Modalidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupoestudio`
--

INSERT INTO `grupoestudio` (`ID_grupo`, `Materia`, `Turno`, `Modalidad`) VALUES
('RHD-10767', 'Mat.Sup', 'Matutino', 'Virtual'),
('RHD-11123', 'Estadística. Tic', 'Matutino', 'Mixta'),
('RHD-13218', 'Física General', 'Matutino', 'Mixta'),
('RHD-15517', 'Inteligencia Artificial', 'Vespertino', 'Presencial'),
('RHD-15569', 'Bases de Datos', 'Nocturno', 'Virtual'),
('RHD-16942', 'Matemáticas Discretas', 'Vespertino', 'Virtual'),
('RHD-28273', 'Mat.Sup', 'Matutino', 'Presencial'),
('RHD-40110', 'Sistemas Operativos', 'Vespertino', 'Virtual'),
('RHD-41640', 'Inteligencia Artificial', 'Vespertino', 'Presencial'),
('RHD-54170', 'Matemáticas Discretas', 'Matutino', 'Mixta'),
('RHD-59329', 'Herramientas de programación IV ', 'Matutino', 'Virtual'),
('RHD-65256', 'Física General', 'Matutino', 'Mixta'),
('RHD-84141', 'Estatica', 'Matutino', 'Virtual'),
('RHD-86629', 'Estructura de Datos', 'Nocturno', 'Mixta'),
('RHD-94622', 'Herramientas de programación IV ', 'Matutino', 'Virtual'),
('RHD-96782', 'Álgebra Lineal', 'Vespertino', 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupoinvestigacion`
--

CREATE TABLE `grupoinvestigacion` (
  `ID_grupo` varchar(20) NOT NULL,
  `LineaInvestigacion` varchar(100) DEFAULT NULL,
  `NivelAcademico` varchar(50) DEFAULT NULL,
  `Modalidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupoinvestigacion`
--

INSERT INTO `grupoinvestigacion` (`ID_grupo`, `LineaInvestigacion`, `NivelAcademico`, `Modalidad`) VALUES
('RHD-23031', 'ComputaciÃ³n en la Nube', 'Postgrado', 'Virtual'),
('RHD-37088', 'BiotecnologÃ­a', 'Pregrado', 'Presencial'),
('RHD-41802', 'AnÃ¡lisis de ImÃ¡genes MÃ©dicas', 'Pregrado', 'Mixta'),
('RHD-72086', 'ComputaciÃ³n CuÃ¡ntica', 'Postgrado', 'Presencial'),
('RHD-89398', 'BiotecnologÃ­a', 'Pregrado', 'Mixta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupovoluntariado`
--

CREATE TABLE `grupovoluntariado` (
  `ID_grupo` varchar(20) NOT NULL,
  `ID_responsable` varchar(20) DEFAULT NULL,
  `OrganismoReceptor` varchar(100) DEFAULT NULL,
  `ComunidadBeneficiada` varchar(100) DEFAULT NULL,
  `LugarActividad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupovoluntariado`
--

INSERT INTO `grupovoluntariado` (`ID_grupo`, `ID_responsable`, `OrganismoReceptor`, `ComunidadBeneficiada`, `LugarActividad`) VALUES
('RHD-10273', 'IRJ-99536', 'SecretarÃ­a de Desarrollo Social', 'Personas con discapacidad', 'Unidad Deportiva Sur'),
('RHD-36198', 'IRJ-25640', 'ProtecciÃ³n Civil', 'Mujeres vÃ­ctimas de violencia', 'Unidad Deportiva Sur'),
('RHD-56234', 'IRJ-24219', 'Cruz Roja', 'JÃ³venes en riesgo', 'Parque EcolÃ³gico Central'),
('RHD-68067', 'IRJ-48646', 'Casa Hogar Esperanza', 'Mujeres vÃ­ctimas de violencia', 'Comedor Comunitario Nueva Vida'),
('RHD-73138', NULL, 'ou9hu09uuh9', 'iojhoih09i0gu9uj', 'oij09u9y9ju8uh\'0'),
('RHD-96545', 'IRJ-51499', 'Banco de Alimentos', 'NiÃ±os en situaciÃ³n vulnerable', 'Colonia San Rafael');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembrosgrupos`
--

CREATE TABLE `miembrosgrupos` (
  `ID_miembro` varchar(20) NOT NULL,
  `ID_usuario` varchar(20) DEFAULT NULL,
  `ID_grupo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembrosgrupos`
--

INSERT INTO `miembrosgrupos` (`ID_miembro`, `ID_usuario`, `ID_grupo`) VALUES
('ORJ-23166', 'IRJ-35119', 'RHD-72086'),
('ORJ-30180', 'IRJ-36257', 'RHD-65256'),
('ORJ-32649', 'IRJ-53920', 'RHD-15569'),
('ORJ-34622', 'IRJ-89340', 'RHD-96782'),
('ORJ-34630', 'IRJ-40842', 'RHD-10273'),
('ORJ-43946', 'IRJ-49266', 'RHD-16942'),
('ORJ-47032', 'IRJ-13743', 'RHD-41802'),
('ORJ-50108', 'IRJ-85209', 'RHD-36198'),
('ORJ-61631', 'IRJ-60864', 'RHD-41640'),
('ORJ-66080', 'IRJ-35564', 'RHD-37088'),
('ORJ-72528', 'IRJ-76583', 'RHD-13218'),
('ORJ-73589', 'IRJ-64342', 'RHD-54170'),
('ORJ-77125', 'IRJ-11074', 'RHD-89398'),
('ORJ-80921', 'IRJ-96944', 'RHD-15517'),
('ORJ-82348', 'IRJ-65957', 'RHD-86629'),
('ORJ-83605', 'IRJ-39257', 'RHD-23031'),
('ORJ-87869', 'IRJ-98006', 'RHD-96545'),
('ORJ-95756', 'IRJ-20765', 'RHD-40110'),
('ORJ-97480', 'IRJ-69699', 'RHD-56234'),
('ORJ-99428', 'IRJ-45317', 'RHD-68067');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `IDusuario` varchar(20) NOT NULL,
  `tipoResponsable` varchar(20) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `dependencia` varchar(100) DEFAULT NULL,
  `correoInstitucional` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`IDusuario`, `tipoResponsable`, `cargo`, `dependencia`, `correoInstitucional`, `telefono`) VALUES
('IRJ-14538', 'Institucional', 'Asesor acadÃ©mico', 'Enlace institucional', 'jhelmkeh@nationalgeographic.com', '657-968-5764'),
('IRJ-18699', 'Institucional', 'Asesor acadÃ©mico', 'Responsable de voluntariado', 'jattenborrow3@live.com', '380-331-8505'),
('IRJ-19389', 'Academico', 'Coordinador institucional', 'Responsable de voluntariado', 'fwattishamp@meetup.com', '969-726-0889'),
('IRJ-20781', 'Academico', 'Profesor', 'Coordinador institucional', 'espracklingk@yandex.ru', '387-324-6814'),
('IRJ-22174', 'Institucional', 'Asesor acadÃ©mico', 'Responsable de voluntariado', 'etavinorj@techcrunch.com', '368-637-3083'),
('IRJ-24185', 'Academico', 'Tutor', 'Director', 'mcanaped@livejournal.com', '973-223-8754'),
('IRJ-24219', 'Academico', 'Tutor', 'Jefe de unidad', 'hmchenrym@auda.org.au', '113-744-3444'),
('IRJ-25640', 'Academico', 'Profesor', 'Coordinador institucional', 'mpedycana@globo.com', '570-118-8260'),
('IRJ-33378', 'Institucional', 'Asesor acadÃ©mico', 'Responsable de voluntariado', 'abrandse@altervista.org', '144-850-3590'),
('IRJ-33552', 'Academico', 'Investigador', 'Coordinador institucional', 'abuddles6@privacy.gov.au', '809-857-6882'),
('IRJ-36833', 'Academico', 'Jefe de departamento', 'Coordinador institucional', 'vletts2@i2i.jp', '383-322-4985'),
('IRJ-48646', 'Academico', 'Director', 'Responsable de voluntariado', 'jmeechanq@networksolutions.com', '511-224-4275'),
('IRJ-49037', 'Institucional', 'Asesor acadÃ©mico', 'Responsable de voluntariado', 'mbracegirdle7@cargocollective.com', '239-543-9796'),
('IRJ-50102', 'Institucional', 'Jefe de departamento', 'Responsable de voluntariado', 'lfairlaw5@reuters.com', '183-396-2819'),
('IRJ-50769', 'Institucional', 'Jefe de departamento', 'Responsable de voluntariado', 'gdudnyt@aol.com', '888-821-1801'),
('IRJ-51499', 'Academico', 'Asesor acadÃ©mico', 'Coordinador institucional', 'rettritch0@chronoengine.com', '706-204-7837'),
('IRJ-51791', 'Institucional', 'Coordinador acadÃ©mico', 'Director', 'lsuett9@psu.edu', '453-617-9651'),
('IRJ-52663', 'Institucional', 'Responsable de voluntariado', 'Enlace institucional', 'abassickn@typepad.com', '694-138-2508'),
('IRJ-59196', 'Institucional', 'Asesor acadÃ©mico', 'Jefe de unidad', 'darblasters@aboutads.info', '497-169-2891'),
('IRJ-64451', 'Institucional', 'Jefe de departamento', 'Coordinador institucional', 'mbassof@domainmarket.com', '532-339-8886'),
('IRJ-65490', 'Institucional', 'Tutor', 'Responsable de voluntariado', 'tclapham1@google.it', '618-214-3557'),
('IRJ-66608', 'Institucional', 'Investigador', 'Responsable de voluntariado', 'jsouthallg@altervista.org', '787-253-8473'),
('IRJ-78331', 'Institucional', 'Jefe de unidad', 'Enlace institucional', 'dnolir@sbwire.com', '752-891-5468'),
('IRJ-79537', 'Institucional', 'Asesor acadÃ©mico', 'Enlace institucional', 'tpatulloc@hao123.com', '502-983-6364'),
('IRJ-83290', 'Institucional', 'Asesor acadÃ©mico', 'Enlace institucional', 'odelisle8@g.co', '841-234-3967'),
('IRJ-84375', 'Academico', 'Responsable de voluntariado', 'Jefe de unidad', 'achanderso@wordpress.org', '979-246-7609'),
('IRJ-84996', 'Institucional', 'Coordinador acadÃ©mico', 'Director', 'rsamsonl@howstuffworks.com', '619-571-4907'),
('IRJ-87827', 'Academico', 'Asesor acadÃ©mico', 'Coordinador institucional', 'haguilar4@virginia.edu', '619-944-1958'),
('IRJ-97282', 'Academico', 'Investigador', 'Responsable de voluntariado', 'ndominettib@technorati.com', '309-617-1226'),
('IRJ-99536', 'Academico', 'Jefe de departamento', 'Responsable de voluntariado', 'hglasoni@independent.co.uk', '445-270-7330');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudgrupo`
--

CREATE TABLE `solicitudgrupo` (
  `ID_solicitud` varchar(20) NOT NULL,
  `IDusuario` varchar(20) DEFAULT NULL,
  `ID_grupo` varchar(20) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` enum('Pendiente','Aprobado','Rechazado') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudgrupo`
--

INSERT INTO `solicitudgrupo` (`ID_solicitud`, `IDusuario`, `ID_grupo`, `mensaje`, `fecha`, `estado`) VALUES
('IRN-10324', 'IRJ-11460', 'RHD-94622', 'Me gusta su idea', '2025-07-20', 'Pendiente'),
('IRN-15289', 'IRJ-11460', 'RHD-10767', 'Solicito unirme', '2025-07-20', 'Pendiente'),
('IRN-17247', 'IRJ-24185', 'RHD-10767', 'kjhjkluh', '2025-07-14', 'Pendiente'),
('IRN-17333', 'IRJ-98223', 'RHD-37088', 'Revision of Infusion Device in Ureter, Percutaneous Endoscopic Approach', '2024-07-08', 'Pendiente'),
('IRN-21582', 'IRJ-11460', 'RHD-11123', 'Buenos días, puedo unirme a su grupo de estudio? ', '2025-07-21', 'Pendiente'),
('IRN-32319', 'IRJ-11460', 'RHD-96782', 'TRATATRARARA', '2025-11-28', 'Pendiente'),
('IRN-32618', 'IRJ-24185', 'RHD-94622', 'Quiero unirme si?', '2025-07-14', 'Pendiente'),
('IRN-34640', 'IRJ-11460', 'RHD-11123', 'Hola quiero unirme', '2025-07-20', 'Pendiente'),
('IRN-36491', 'IRJ-11460', 'RHD-11123', 'eofajoefjaoewge', '2025-07-17', 'Pendiente'),
('IRN-39150', 'IRJ-11074', 'RHD-84141', 'hola', '2025-07-26', 'Pendiente'),
('IRN-40911', 'IRJ-24185', 'RHD-10767', 'Hola que hay? ', '2025-07-14', 'Pendiente'),
('IRN-47776', 'IRJ-11460', 'RHD-11123', 'fefergre', '2025-07-23', 'Pendiente'),
('IRN-48254', 'IRJ-24185', 'RHD-10767', 'trkdykyduldld', '2025-07-14', 'Pendiente'),
('IRN-54792', 'IRJ-24185', 'RHD-94622', 'dfaraerharhaetatnatna', '2025-07-14', 'Pendiente'),
('IRN-55051', 'IRJ-24185', 'RHD-10767', 'eetjetjet', '2025-07-14', 'Pendiente'),
('IRN-56001', 'IRJ-11074', 'RHD-10273', 'jiug8uojivyu', '2025-10-10', 'Pendiente'),
('IRN-63829', 'IRJ-36348', 'RHD-40110', 'Drainage of Thoracolumbar Vertebral Disc, Percutaneous Approach', '2024-09-25', 'Pendiente'),
('IRN-71518', 'IRJ-11074', 'RHD-13218', 'kihioph', '2025-07-26', 'Pendiente'),
('IRN-73595', 'IRJ-21879', 'RHD-94622', 'Quiero unirme', '2025-11-28', 'Pendiente'),
('IRN-76626', 'IRJ-11460', 'RHD-11123', 'Hola puedo unirme?', '2025-07-21', 'Pendiente'),
('IRN-77303', 'IRJ-11074', 'RHD-73138', 'oiuihpuoopb09pñoiuopuo9', '2025-07-26', 'Pendiente'),
('IRN-78213', 'IRJ-24185', 'RHD-10767', 'enzrfnaten', '2025-07-14', 'Pendiente'),
('IRN-92698', 'IRJ-45365', 'RHD-13218', 'Excision of Adenoids, Percutaneous Approach, Diagnostic', '2024-07-27', 'Pendiente'),
('IRN-94339', 'IRJ-24996', 'RHD-86629', 'Supplement Left Axillary Vein with Autologous Tissue Substitute, Percutaneous Approach', '2024-12-28', 'Pendiente'),
('IRN-96050', 'IRJ-24185', 'RHD-28273', 'QUE HAY BRO?', '2025-07-14', 'Pendiente'),
('sol_6872dd07aea13', 'IRJ-24185', 'RHD-10273', 'eofioehaéghragoaeihgaegheiojgoe', '2025-07-13', 'Pendiente'),
('sol_68743846c089b', 'IRJ-24185', 'RHD-10273', 'Hola, puedo Unirme a su grupo Estudiantil?', '2025-07-14', 'Pendiente'),
('sol_687439496ff0c', 'IRJ-24185', 'RHD-10273', 'Hola puedo unirme? :)', '2025-07-14', 'Pendiente'),
('sol_68743a527849d', 'IRJ-24185', 'RHD-10273', 'Hola, puedo Unirme a su grupo Estudiantil?', '2025-07-14', 'Pendiente'),
('sol_68743a82c46c6', 'IRJ-24185', 'RHD-15517', 'Hola Quiero Unirme si?', '2025-07-14', 'Pendiente'),
('sol_68743b0e4d645', 'IRJ-24185', 'RHD-10273', 'rhetethetetetjet', '2025-07-14', 'Pendiente'),
('sol_68743bd7667d0', 'IRJ-24185', 'RHD-10273', 'rhetethetetetjet', '2025-07-14', 'Pendiente'),
('sol_68743bece4045', 'IRJ-24185', 'RHD-15517', 'dagewgararha', '2025-07-14', 'Pendiente'),
('sol_68743e7d3834d', 'IRJ-24185', 'RHD-10273', 'QUIERO UNIRME!!!!!!!!!!', '2025-07-14', 'Pendiente'),
('sol_68743fd781a19', 'IRJ-24185', 'RHD-10273', 'FSWH', '2025-07-14', 'Pendiente'),
('sol_68744250bccd4', 'IRJ-24185', 'RHD-10767', 'eetjetjet', '2025-07-14', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IDusuario` varchar(20) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `Numtelefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IDusuario`, `correo`, `nombre`, `contrasena`, `Numtelefono`) VALUES
('IRJ-11074', 'tvasyuchovu@rakuten.com', 'Thedrick', 'pM0<w@PA}}<~/', '338-808-2406'),
('IRJ-11460', 'mtheobald22@jimdo.com', 'Mildrid', 'iC5)_o3?&Y,%S_Q', '480-963-1561'),
('IRJ-13743', 'woxtobyw@narod.ru', 'Wake', 'rK8}cyRADdmZN', '129-856-7682'),
('IRJ-14538', 'mjoreauh@ocn.ne.jp', 'Morganne', 'dF5.EkVPWEZ', '950-860-0970'),
('IRJ-18699', 'jstacy3@xing.com', 'Jacenta', 'aB1{ZA3Xu', '659-191-1839'),
('IRJ-19338', 'lboecke2d@indiegogo.com', 'Lonee', 'aI2$$(qsPNQ', '805-740-9821'),
('IRJ-19389', 'cwilgarp@geocities.jp', 'Clarice', 'fB3_RXpDGF3z', '680-654-1615'),
('IRJ-20765', 'gmonkz@gnu.org', 'Guinevere', 'pM4}54qJDwkL', '425-402-7100'),
('IRJ-20781', 'lbestimank@vimeo.com', 'Lindsey', 'sT0+>s\\_%g', '569-386-4131'),
('IRJ-21103', 'tcamell1n@businesswire.com', 'Teodor', 'gS5{Y`PJHN', '526-672-3520'),
('IRJ-21879', 'mniland2j@phoca.cz', 'Marv', 'mW6}/y#b?Q8', '473-292-1568'),
('IRJ-22174', 'jeagleshamj@reference.com', 'Jae', 'uV9\"CytuLEo|h=~+', '562-728-1987'),
('IRJ-22925', 'chenricsson29@networkadvertising.org', 'Claudelle', 'uD9+#6vm&J.', '864-664-6427'),
('IRJ-23480', 'shalle1v@loc.gov', 'Sinclare', 'uK7/e>00G', '902-774-1762'),
('IRJ-24185', 'kwhitewoodd@microsoft.com', 'Kaycee', 'dD5$npCd=\\5gK/}Q', '936-826-6381'),
('IRJ-24219', 'mlockhartm@furl.net', 'Marita', 'wQ6{Y?4m', '585-246-6693'),
('IRJ-24403', 'ksawkin1z@psu.edu', 'Kristoforo', 'uX0<XCuBLOq\\9FN', '972-929-8669'),
('IRJ-24996', 'hhan2q@nytimes.com', 'Hillier', 'sF1<frAf~\"kq/6yM', '577-948-6317'),
('IRJ-25605', 'borht20@gizmodo.com', 'Brnaba', 'dC3+nv$B<t', '775-863-9267'),
('IRJ-25640', 'mhowsina@loc.gov', 'Maximilianus', 'yL9.Rv$dgZ}', '308-456-4950'),
('IRJ-28610', 'icossam1p@barnesandnoble.com', 'Iver', 'jM6*<bWX', '963-818-8816'),
('IRJ-33173', 'hmccloughen1m@dell.com', 'Harold', 'yX1_GWA<M~F0PK', '740-430-3875'),
('IRJ-33378', 'llabroe@trellian.com', 'Latrina', 'tG9~t4xju', '132-665-5006'),
('IRJ-33552', 'idreschler6@epa.gov', 'Ira', 'yM8+@p0D', '765-579-9627'),
('IRJ-35119', 'fleefev@dagondesign.com', 'Flory', 'wG3=|t0h7X4', '695-256-4455'),
('IRJ-35453', 'nblaxley21@weebly.com', 'Nels', 'tM8.oBk`P', '851-606-8448'),
('IRJ-35564', 'rroggieriy@npr.org', 'Raffaello', 'aH1}R(1OJ\\ZM', '322-885-9155'),
('IRJ-36025', 'jcavnor24@aol.com', 'Joete', 'kE7>cMnTm>5!4h', '892-721-7667'),
('IRJ-36257', 'bsawart18@cdc.gov', 'Bab', 'yY9?1eI\"g,rGzJ(', '699-726-2571'),
('IRJ-36348', 'nbrimmacombe2p@mit.edu', 'Novelia', 'iU7!QEo8SSNn\"&#', '271-502-6186'),
('IRJ-36833', 'llethieulier2@japanpost.jp', 'Lauretta', 'jK1`#ENC', '778-640-8124'),
('IRJ-37327', 'amaclean2l@cafepress.com', 'Anthea', 'xK8$dP%6D=x+knx', '125-301-0372'),
('IRJ-39257', 'upettecrewx@earthlink.net', 'Uriah', 'uJ4=_)5J\'ojb@', '526-877-0383'),
('IRJ-39561', 'asoden1h@china.com.cn', 'Arnold', 'xD3\"_1Ig`6e3M', '774-966-5183'),
('IRJ-39960', 'gnorrie1g@engadget.com', 'Giacinta', 'zC0\\#$<ie0bX{8D', '899-269-3540'),
('IRJ-40364', 'awoodstock2f@meetup.com', 'Adrian', 'wO3%bI~xmZ\"', '637-421-2280'),
('IRJ-40842', 'ufrichley1b@tuttocitta.it', 'Ugo', 'zD4#Jv?v25io=', '717-195-4466'),
('IRJ-41194', 'ldever2n@blogs.com', 'Lanna', 'dA9.eQo7uF4c6A', '506-701-7447'),
('IRJ-43196', 'lskerritt2k@creativecommons.org', 'Liv', 'mI3\\}Mk\\4fD', '777-867-8200'),
('IRJ-43270', 'ajuliano28@webeden.co.uk', 'Abramo', 'hE0#Jyk?7&3BE_Y', '396-575-3128'),
('IRJ-45317', 'lcoushe1d@plala.or.jp', 'Laraine', 'xT0,_&AzV09I==m', '290-123-5256'),
('IRJ-45365', 'mpods2r@behance.net', 'Maisie', 'fT4*e+xZp\'l(\\x%', '846-520-5299'),
('IRJ-45806', 'abramall2a@chicagotribune.com', 'Araldo', 'hZ0{$O3*', '743-430-2202'),
('IRJ-48646', 'halenichicovq@over-blog.com', 'Holden', 'gC7=pPXz)KKd=Jis', '851-417-7231'),
('IRJ-49037', 'iholah7@paginegialle.it', 'Ida', 'uB7/z8G_t', '318-321-8101'),
('IRJ-49266', 'rkislingbury14@t-online.de', 'Rudiger', 'bF0*3M)a\'.', '545-795-6959'),
('IRJ-49402', 'eestrella2b@zimbio.com', 'Emmet', 'lX2=GY<lniwKq+', '578-538-2903'),
('IRJ-49538', 'lepperson1k@nationalgeographic.com', 'Lorne', 'zC6(c=qz!', '371-889-7389'),
('IRJ-49567', 'dcressar26@comcast.net', 'Dorian', 'qK6#XlKSLA1PF=', '432-188-9343'),
('IRJ-50102', 'rlunnon5@wp.com', 'Rory', 'uR1>>I3u', '626-460-8379'),
('IRJ-50769', 'erenact@nature.com', 'Edie', 'dU6(s9@AN#MULa,s', '547-706-6143'),
('IRJ-51499', 'alightbourne0@soup.io', 'Amie', 'hT7+R\"mvBG+', '726-616-4549'),
('IRJ-51791', 'ttilio9@nps.gov', 'Talia', 'hW0+e2db\'', '632-674-8063'),
('IRJ-52663', 'bdonann@i2i.jp', 'Bridie', 'bL9`yQ(/nfyy', '273-551-3416'),
('IRJ-53038', 'ahefner1q@jimdo.com', 'Arturo', 'gV3.`cFIR0_WS%Tj', '817-150-3664'),
('IRJ-53920', 'nburthom12@loc.gov', 'Nicolais', 'dH8(_)\'A7Q}', '925-587-7297'),
('IRJ-55871', 'afigiovanni1j@comsenz.com', 'Amy', 'tA0/j/t<oFh', '547-107-9269'),
('IRJ-59047', 'jklimontovich1u@soundcloud.com', 'Joseito', 'uJ9=/GL&unuB*\'', '736-730-9450'),
('IRJ-59196', 'sginos@nps.gov', 'Shani', 'uK7\\Gi+bQ', '611-865-2676'),
('IRJ-60864', 'sjersch16@narod.ru', 'Selena', 'oW9)J.@p{\"C|>B(`', '199-663-1938'),
('IRJ-62284', 'bwhytock1x@msu.edu', 'Brana', 'tG5!C54Rx(A5', '391-781-5833'),
('IRJ-62994', 'cscatchar27@google.com.br', 'Cathrine', 'sG5|f=aq3Fq4f', '219-648-6183'),
('IRJ-64342', 'myokel15@hud.gov', 'Mort', 'mQ7~Z`2hS3P>7', '159-200-6535'),
('IRJ-64451', 'kmbarronf@msu.edu', 'Kameko', 'fB4+{SHhH9w', '880-617-6592'),
('IRJ-65184', 'lremington2i@forbes.com', 'Loretta', 'uU7=#bA0H6T<L', '388-308-2192'),
('IRJ-65490', 'vchicotti1@facebook.com', 'Vanya', 'aW2}Pc@y23>_=xh', '636-114-4777'),
('IRJ-65957', 'rrickert10@seesaa.net', 'Rolf', 'iB6(_8)+', '693-769-8509'),
('IRJ-66061', 'rmccloy2c@nifty.com', 'Reeba', 'pT6/oE%K69#a>+1', '171-580-1027'),
('IRJ-66608', 'djillsg@pbs.org', 'Dedie', 'yQ6$1x+=ZB\"', '917-616-0036'),
('IRJ-67710', 'ctregian2e@amazon.co.uk', 'Clemens', 'lD0~h%!rq', '442-496-4927'),
('IRJ-69699', 'jbarkhouse1c@merriam-webster.com', 'Jackelyn', 'xB3#W1extk?Bg', '599-165-4251'),
('IRJ-72332', 'csmittoune1f@cocolog-nifty.com', 'Cordula', 'rT0=<Y,Ojp', '596-494-7629'),
('IRJ-73408', 'hclerk2g@dailymail.co.uk', 'Hart', 'mU7@H>$B$.8tu_Lo', '877-885-4779'),
('IRJ-73870', 'adearlove1y@ucsd.edu', 'Adham', 'hS9(#\'N&H0vIB%2', '352-433-8568'),
('IRJ-74611', 'ekaubisch1s@shutterfly.com', 'Erminie', 'yP5{fsfDA', '586-816-8919'),
('IRJ-75550', 'crealy1i@statcounter.com', 'Chevalier', 'iK6=Z921})@u', '379-733-1342'),
('IRJ-76583', 'pkyle11@github.io', 'Pippy', 'qE3&#$}ZUc!E}qO0', '437-180-2395'),
('IRJ-78331', 'ethunderr@wikia.com', 'Edna', 'nO8\"WO>T<', '789-694-0602'),
('IRJ-79537', 'ajephcottc@unblog.fr', 'Angil', 'gC5}!$(O2_UD|', '805-116-0624'),
('IRJ-80427', 'scallaghan2m@bloglines.com', 'Shea', 'tQ7%mS@R', '939-292-4898'),
('IRJ-81421', 'grodgier1l@mozilla.org', 'Gustave', 'oQ6>\'?stvm>zyX', '759-290-7410'),
('IRJ-81861', 'imolian2h@xing.com', 'Irvine', 'jM3=6<F~', '767-917-4858'),
('IRJ-83290', 'lmiltonwhite8@seesaa.net', 'Lucias', 'lI8)mQxPz#<+rnm/', '583-856-7876'),
('IRJ-84074', 'kdronsfield1t@umich.edu', 'Kessia', 'nQ9)aEFF5K4', '530-971-8030'),
('IRJ-84375', 'erymello@sun.com', 'Elvera', 'iZ1_DqY!XP&n', '561-852-3738'),
('IRJ-84996', 'fmarrilll@yolasite.com', 'Freida', 'eW1.6qr|\"77<,', '811-308-2853'),
('IRJ-85209', 'wbraney1a@gmpg.org', 'Wilma', 'fU4(vb%zJP', '939-142-7235'),
('IRJ-86647', 'bohenecan23@google.co.uk', 'Blane', 'vQ3)rQnF3},k', '930-779-8878'),
('IRJ-87827', 'zkorda4@fema.gov', 'Zebedee', 'nN7{gVxUKEe9qf2', '714-243-2359'),
('IRJ-89340', 'satcherley13@cloudflare.com', 'Suzie', 'zT1!e9_5', '716-126-7501'),
('IRJ-94984', 'nfarley1o@w3.org', 'Naoma', 'sX1%bczw', '632-895-9247'),
('IRJ-95016', 'ctullis1w@paginegialle.it', 'Chucho', 'aK1/HRQOY=J4AQH', '150-906-7163'),
('IRJ-96117', 'mauletta25@apple.com', 'Malinda', 'tH7%v}0gB', '535-703-8221'),
('IRJ-96483', 'pdebiasio1e@angelfire.com', 'Phil', 'vW2\'C8uABC', '695-343-6621'),
('IRJ-96944', 'aalsobrook17@myspace.com', 'Angel', 'eC2?En*=N|tm.i9', '189-800-7949'),
('IRJ-97282', 'lpeadb@canalblog.com', 'Lukas', 'tR7&P7dvxD', '449-157-5083'),
('IRJ-98006', 'rbernhardi19@wp.com', 'Rena', 'cY6(NW9Qh|C', '512-313-7575'),
('IRJ-98223', 'gnecrews2o@themeforest.net', 'Gabriellia', 'iW3\'p=R/odUXg', '446-237-6019'),
('IRJ-99536', 'sdorriani@diigo.com', 'Sandra', 'aG4|p*X\"aVhe2j~', '182-908-2238'),
('IRJ-99730', 'eleed1r@hugedomains.com', 'Eydie', 'mG8<|zZV,DlQuS', '845-487-2270');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validacion`
--

CREATE TABLE `validacion` (
  `ID_validacion` varchar(20) NOT NULL,
  `ID_grupo` varchar(20) DEFAULT NULL,
  `ID_responsable` varchar(20) DEFAULT NULL,
  `ID_responsableInstitucional` varchar(20) DEFAULT NULL,
  `estadoValidacion` varchar(20) DEFAULT NULL,
  `fechaValidacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `validacion`
--

INSERT INTO `validacion` (`ID_validacion`, `ID_grupo`, `ID_responsable`, `ID_responsableInstitucional`, `estadoValidacion`, `fechaValidacion`) VALUES
('JUE-11407', 'RHD-10273', 'IRJ-99536', 'IRJ-79537', 'Aprobado', '2025-03-09'),
('JUE-14302', 'RHD-96545', 'IRJ-51499', 'IRJ-65490', 'Aprobado', '2025-03-07'),
('JUE-19406', 'RHD-68067', 'IRJ-48646', 'IRJ-79537', 'Aprobado', '2025-03-11'),
('JUE-26950', 'RHD-56234', 'IRJ-24219', 'IRJ-66608', 'Aprobado', '2025-03-10'),
('JUE-48834', 'RHD-36198', 'IRJ-25640', 'IRJ-83290', 'Aprobado', '2025-03-08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`ID_grupo`),
  ADD KEY `administradorGrupo` (`administradorGrupo`);

--
-- Indices de la tabla `grupoestudio`
--
ALTER TABLE `grupoestudio`
  ADD PRIMARY KEY (`ID_grupo`);

--
-- Indices de la tabla `grupoinvestigacion`
--
ALTER TABLE `grupoinvestigacion`
  ADD PRIMARY KEY (`ID_grupo`);

--
-- Indices de la tabla `grupovoluntariado`
--
ALTER TABLE `grupovoluntariado`
  ADD PRIMARY KEY (`ID_grupo`),
  ADD KEY `ID_responsable` (`ID_responsable`);

--
-- Indices de la tabla `miembrosgrupos`
--
ALTER TABLE `miembrosgrupos`
  ADD PRIMARY KEY (`ID_miembro`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_grupo` (`ID_grupo`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`IDusuario`);

--
-- Indices de la tabla `solicitudgrupo`
--
ALTER TABLE `solicitudgrupo`
  ADD PRIMARY KEY (`ID_solicitud`),
  ADD KEY `IDusuario` (`IDusuario`),
  ADD KEY `ID_grupo` (`ID_grupo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IDusuario`);

--
-- Indices de la tabla `validacion`
--
ALTER TABLE `validacion`
  ADD PRIMARY KEY (`ID_validacion`),
  ADD KEY `ID_grupo` (`ID_grupo`),
  ADD KEY `ID_responsable` (`ID_responsable`),
  ADD KEY `ID_responsableInstitucional` (`ID_responsableInstitucional`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`administradorGrupo`) REFERENCES `usuario` (`IDusuario`);

--
-- Filtros para la tabla `grupoestudio`
--
ALTER TABLE `grupoestudio`
  ADD CONSTRAINT `grupoestudio_ibfk_1` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`);

--
-- Filtros para la tabla `grupoinvestigacion`
--
ALTER TABLE `grupoinvestigacion`
  ADD CONSTRAINT `grupoinvestigacion_ibfk_1` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`);

--
-- Filtros para la tabla `grupovoluntariado`
--
ALTER TABLE `grupovoluntariado`
  ADD CONSTRAINT `grupovoluntariado_ibfk_1` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`),
  ADD CONSTRAINT `grupovoluntariado_ibfk_2` FOREIGN KEY (`ID_responsable`) REFERENCES `responsable` (`IDusuario`);

--
-- Filtros para la tabla `miembrosgrupos`
--
ALTER TABLE `miembrosgrupos`
  ADD CONSTRAINT `miembrosgrupos_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`IDusuario`),
  ADD CONSTRAINT `miembrosgrupos_ibfk_2` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`);

--
-- Filtros para la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `responsable_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuario` (`IDusuario`);

--
-- Filtros para la tabla `solicitudgrupo`
--
ALTER TABLE `solicitudgrupo`
  ADD CONSTRAINT `solicitudgrupo_ibfk_1` FOREIGN KEY (`IDusuario`) REFERENCES `usuario` (`IDusuario`),
  ADD CONSTRAINT `solicitudgrupo_ibfk_2` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`);

--
-- Filtros para la tabla `validacion`
--
ALTER TABLE `validacion`
  ADD CONSTRAINT `validacion_ibfk_1` FOREIGN KEY (`ID_grupo`) REFERENCES `grupo` (`ID_grupo`),
  ADD CONSTRAINT `validacion_ibfk_2` FOREIGN KEY (`ID_responsable`) REFERENCES `responsable` (`IDusuario`),
  ADD CONSTRAINT `validacion_ibfk_3` FOREIGN KEY (`ID_responsableInstitucional`) REFERENCES `responsable` (`IDusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
