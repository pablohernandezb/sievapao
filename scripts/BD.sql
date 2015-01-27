-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2012 at 06:54 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_dace`
--

-- --------------------------------------------------------

--
-- Table structure for table `Archivo`
--

CREATE TABLE IF NOT EXISTS `Archivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `tipoA` varchar(20) NOT NULL,
  `tipoS` varchar(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`nombre`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Calendar`
--

CREATE TABLE IF NOT EXISTS `Calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(20) NOT NULL,
  `descrip` text NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `trim` set('1','0','2') NOT NULL,
  `ftrim` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Dependencias`
--

CREATE TABLE IF NOT EXISTS `Dependencias` (
  `cod_id` int(11) NOT NULL AUTO_INCREMENT,
  `dependencia` text NOT NULL,
  PRIMARY KEY (`cod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

--
-- Dumping data for table `Dependencias`
--

INSERT INTO `Dependencias` (`cod_id`, `dependencia`) VALUES
(2, 'Decanato de Postgrado'),
(3, 'Decanato de Estudios Profesionales'),
(4, 'Dpto BC'),
(5, 'Dpto BO'),
(6, 'Dpto CC'),
(7, 'Dpto CI'),
(8, 'Dpto MA'),
(10, 'Dpto CE'),
(11, 'Dpto CO'),
(12, 'Dpto CS'),
(13, 'Dpto CT'),
(14, 'Dpto DA'),
(15, 'Dpto EA'),
(16, 'Dpto EC'),
(17, 'Dpto FF'),
(18, 'Dpto FS'),
(19, 'Dpto GC'),
(20, 'Dpto ID'),
(21, 'Dpto LL'),
(22, 'Dpto MC'),
(23, 'Dpto MT'),
(24, 'Dpto PB'),
(25, 'Dpto PL'),
(26, 'Dpto PS'),
(27, 'Dpto QM'),
(28, 'Dpto TF'),
(29, 'Dpto TS'),
(30, 'Dpto TI'),
(31, 'Dpto FG'),
(32, 'Departamento de Admisión'),
(33, 'Dirección (DACE)'),
(34, 'Dsip'),
(35, 'Secretaría'),
(36, 'Rectorado'),
(37, 'Vicerectorado Academico'),
(38, 'Vicerectorado Administrativo'),
(39, 'FCEUSB'),
(40, 'Coord. Ing Electica'),
(41, 'Coord. Ing Mecanica'),
(42, 'Coord. Ing Quimica'),
(43, 'Coord. Lic Quimica'),
(44, 'Coord. Lic Matematica'),
(45, 'Coord. Ing Electronica'),
(46, 'Coord. Arquitectura'),
(47, 'Coord. Ing Computacion'),
(48, 'Coord. Lic Fisica'),
(49, 'Coord. Urbanismo'),
(50, 'Coord. Ing Geofisica'),
(51, 'Coord. Ing Materiales'),
(52, 'Coord. Ing Produccion'),
(53, 'Coord. Lic Biologia'),
(54, 'Coord. Tec Electrica'),
(55, 'Coord. Tec electronica'),
(56, 'Coord. Tec Comercio exterior'),
(57, 'Coord. Tec Organización Empresarial'),
(58, 'Coord. Ing Telecomunicaciones'),
(59, 'Decanato de Estudios Tecnologicos'),
(60, 'Decanato de Estudios Generales'),
(61, 'Coord. Del Ciclo Basíco'),
(62, 'Encuesta opinion de  Estudiantil'),
(64, 'Entes Externos'),
(65, 'Decanato de Extención'),
(66, 'DIDE'),
(67, 'DGCH'),
(68, 'DII'),
(69, 'Planificación'),
(70, 'PIO'),
(71, 'Direccion de Servicios'),
(72, 'Dirección(dace)'),
(73, 'Control Estudios'),
(74, 'Admisión y Egresos(dace)'),
(75, 'Servicios de Información y Producción(dace)'),
(76, 'Control de Estudios(dace_sl)'),
(77, 'Maestría en Filosofía'),
(78, 'Doctorado en Computación'),
(79, 'Maestría en Ciencias de la Computación'),
(80, 'Maestría en Psicología'),
(81, 'Especialización en Opinión Pública y Comunicación Política'),
(82, 'Doctorado en Ciencias Biológicas'),
(83, 'Maestría en Ciencias Biológicas'),
(84, 'Doctorado en Nutrición'),
(85, 'Maestría en Nutrición'),
(86, 'Especialización en Nutrición Clínica'),
(87, 'Doctorado en Desarrollo Sostenible'),
(88, 'Maestría en Desarrollo y Ambiente'),
(89, 'Especialización en Gestión Ambiental'),
(90, 'Doctorado en Ciencia de los Alimentos'),
(91, 'Maestría en Ciencia de los Alimentos'),
(93, 'Especialización en Didáctica de las Matemáticas'),
(94, 'Doctorado en Matemáticas'),
(95, 'Maestría en Matemáticas'),
(96, 'Especialización en Finanzas de la Empresa'),
(97, 'Especialización en Gerencia de Proyectos'),
(98, 'Especialización en Gerencia de Mercadeo'),
(99, 'Especialización en Desarrollo Organizacional'),
(100, 'Especialización en Gerencia de la Empresa'),
(101, 'Maestría en Administración de Empresas'),
(102, 'Especialización en Gerencia de Auditoría de Estado'),
(103, 'Especialización en Gerencia de la Tecnología y la Innovación'),
(104, 'Especialización en Gerencia del Negocio del Gas Natural'),
(105, 'Maestría en Ingeniería de Sistemas'),
(106, 'Doctorado en Física'),
(107, 'Maestría en Física'),
(108, 'Maestría en Ingeniería Electrónica'),
(109, 'Especialización en Gerencia de las Telecomunicaciones'),
(110, 'Especialización en Telemática'),
(111, 'Especialización en Ingeniería Clínica'),
(112, 'Maestría en Ingeniería Eléctrica'),
(113, 'Especialización en Sistemas de Potencia Eléctrica'),
(114, 'Especialización en Transmisión de Energía Eléctrica'),
(115, 'Especialización en Distribución de Energía Eléctrica'),
(116, 'Especialización en Instalaciones Eléctricas'),
(117, 'Doctorado en Ciencia Política'),
(118, 'Maestría en Ciencia Política'),
(119, 'Doctorado en Letras'),
(120, 'Maestría en Literatura Latinoamericana'),
(121, 'Especialización en Gestión Sociocultural'),
(122, 'Maestría en Transporte Urbano'),
(123, 'Especialización en Transporte Público'),
(124, 'Especialización Técnica en Transporte Urbano'),
(125, 'Doctorado en Química'),
(126, 'Maestría en Química'),
(127, 'Maestría en Ingeniería Química'),
(128, 'Maestría en Ingeniería Mecánica'),
(129, 'Especialización en Equipos Rotativos'),
(130, 'Especialización en Confiabilidad de Sistemas Industriales'),
(131, 'Maestría en Ingeniería de Materiales'),
(132, 'Especialización en Informática Educativa'),
(133, 'Maestría en Linguistica Aplicada'),
(134, 'Especialización en Enseñanza de Idiomas Extranjeros'),
(135, 'Maestría en Ingeniería Biomédica'),
(136, 'Maestría en Música'),
(137, 'Doctorado en Ingeniería'),
(138, 'Maestría en Estadística'),
(139, 'Especialización en Estadística Computacional'),
(140, 'Maestría en Ciencias de la Tierra'),
(141, 'Doctorado en Ciencias Sociales y Humanidades'),
(142, 'Doctorado interdisciplinario en Ciencias'),
(143, 'Perfeccionamiento Profesional en Ingeniería Clínica. Nivel I'),
(144, 'Perfeccionamiento Profesional en Filosofía Antigua y Medieval'),
(145, 'Perfeccionamiento Profesional en Filosofía Moderna y Contemporánea'),
(146, 'Perfeccionamiento Profesional en Metodología Filosófica'),
(149, 'Comisión Electoral'),
(150, 'División de Ciencias Físicas y Matemáticas'),
(151, 'Centro de Estudiantes (todos)'),
(152, 'Dirección de Relaciones Internacionales'),
(153, 'Aminta Villegas'),
(154, 'Coord. CIU'),
(155, 'Asociación de Egresados de la USB'),
(156, 'DSM'),
(157, 'FONDESIBO'),
(158, 'Tesoreria'),
(159, 'Coordinación Cursos Intensivos'),
(160, 'Biblioteca Unidad de Sistema'),
(161, 'GADE'),
(162, 'BAJA SAE'),
(163, 'Dirección de Servicios Telematicos'),
(164, 'Dirección de Servicios Multimedia'),
(165, 'Dirección de Servicios'),
(166, 'Direccion de Gestion del Capital Humano'),
(167, 'División de Ciencias Sociales y Humanidades'),
(168, 'División de Ciencias Biologicas'),
(169, 'Comisión Tecnica de Admisión');

-- --------------------------------------------------------

--
-- Table structure for table `Estadistica`
--

CREATE TABLE IF NOT EXISTS `Estadistica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trimestre` varchar(11) NOT NULL,
  `anio` int(4) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `aprobadas` int(11) NOT NULL,
  `modificadas` int(11) NOT NULL,
  `rechazadas` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `actual` set('1','0') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_Descarga`
--

CREATE TABLE IF NOT EXISTS `log_Descarga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instruccion` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_SQL`
--

CREATE TABLE IF NOT EXISTS `log_SQL` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instruccion` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Permiso`
--

CREATE TABLE IF NOT EXISTS `Permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `usbid` varchar(20) NOT NULL,
  KEY `id` (`id`),
  KEY `nombre` (`nombre`),
  KEY `usbid` (`usbid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Plantillas`
--

CREATE TABLE IF NOT EXISTS `Plantillas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Solicitud`
--

CREATE TABLE IF NOT EXISTS `Solicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solicitante` varchar(20) NOT NULL,
  `fsolicitud` date NOT NULL,
  `fsolicitada` date NOT NULL,
  `fsolicitadaT` varchar(20) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `asunto` varchar(60) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `archivo` text NOT NULL,
  `estado` varchar(20) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Solicitante` (`solicitante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Trimestre`
--

CREATE TABLE IF NOT EXISTS `Trimestre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13') NOT NULL,
  `lunes` date NOT NULL,
  `martes` date NOT NULL,
  `miercoles` date NOT NULL,
  `jueves` date NOT NULL,
  `viernes` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usbid` varchar(20) NOT NULL,
  `dependencia` text NOT NULL,
  `email` varchar(40) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`usbid`),
  UNIQUE KEY `Email` (`email`),
  KEY `ID` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`id`, `usbid`, `dependencia`, `email`, `tipo`) VALUES
(1, 'Todos', '', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Permiso`
--
ALTER TABLE `Permiso`
  ADD CONSTRAINT `Permiso_ibfk_1` FOREIGN KEY (`nombre`) REFERENCES `Archivo` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Permiso_ibfk_2` FOREIGN KEY (`usbid`) REFERENCES `Usuario` (`usbid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Solicitud`
--
ALTER TABLE `Solicitud`
  ADD CONSTRAINT `Solicitud_ibfk_1` FOREIGN KEY (`solicitante`) REFERENCES `Usuario` (`usbid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
