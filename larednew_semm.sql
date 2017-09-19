-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-06-2013 a las 13:36:57
-- Versión del servidor: 5.0.91
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `larednew_semm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes`
--

CREATE TABLE IF NOT EXISTS `aspirantes` (
  `id_aspirante` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `born_date` date NOT NULL,
  `ci_num` int(10) NOT NULL,
  `cp_num` int(10) NOT NULL,
  `tel_num` varchar(15) NOT NULL,
  `cel_num` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `egreso_facultad` int(4) NOT NULL default '1999',
  `imagen` varchar(20) NOT NULL,
  `create_cv_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `fecha_actualizacion_cv` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_aspirante`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `aspirantes`
--

INSERT INTO `aspirantes` (`id_aspirante`, `name`, `last_name`, `born_date`, `ci_num`, `cp_num`, `tel_num`, `cel_num`, `email`, `pass`, `egreso_facultad`, `imagen`, `create_cv_date`, `fecha_actualizacion_cv`) VALUES
(19, 'Mar&iacute;a Jos&eac', 'Marfetan', '1969-12-31', 40380579, 1122, '27104444', '099111111', 'mmarfetan@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1999, '', '2013-06-10 13:36:33', '0000-00-00 00:00:00'),
(2, 'Vicente', 'ScÃ³pise', '1966-02-06', 19019987, 1234, '', '094015658', 'vscopise@hotmail.com', '202cb962ac59075b964b07152d234b70', 1999, 'tmb_2_66.jpg', '2013-04-05 12:40:08', '2013-06-14 01:47:41'),
(3, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'vscopise@gmail.com', '682f36af5866221e5ac5dab8bfc92602', 1999, '', '2013-04-05 12:42:37', '0000-00-00 00:00:00'),
(4, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'vscopise@adinet.com.uy', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-04-05 12:47:14', '0000-00-00 00:00:00'),
(5, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'herwolfi@hotmail.com', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-04-05 12:47:35', '0000-00-00 00:00:00'),
(6, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'heerwolfi@hotmail.com', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-04-05 12:48:18', '0000-00-00 00:00:00'),
(7, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'herwolfy@hotmail.com', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-04-05 12:53:34', '0000-00-00 00:00:00'),
(8, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'hrrwolfi@hotmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1999, '', '2013-04-05 12:55:46', '0000-00-00 00:00:00'),
(9, 'nombre', 'apellido', '1966-12-11', 123456, 123, '123456', '123456', 'hermolfi@hotmail.com', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-04-05 12:58:41', '0000-00-00 00:00:00'),
(18, 'Guillermo', 'Spinatelli', '0000-00-00', 12345678, 123, '12345678', '99699034', 'guillermo.spinatelli@gmail.com', '4f356e71899d4e6ac647d2ed22a81dd2', 1936, 'tmb_18.jpg', '2013-05-21 19:49:44', '2013-05-21 20:21:02'),
(11, 'Gabriel', 'Fernandez', '1973-08-03', 30098520, 12345, '27109278', '097083205', 'gfernandez@lared.com.uy', '49683c4116be6ac933a9045967cd5fba', 1999, 'tmb_11_65.jpg', '2013-04-29 15:58:44', '2013-06-13 16:45:36'),
(12, 'Mar&iacute;a Jos&eac', 'Marfet&aacute;n', '1969-12-31', 40380579, 1122, '27103261', '099150407', 'mmarfetan@hotmail.com', 'be5f296596381863bcc9e7bdd49cd7a1', 1999, '', '2013-05-02 12:47:31', '0000-00-00 00:00:00'),
(13, 'melina', 'melina', '1969-12-31', 1111, 1111, '1111', '1111', 'herreramelus@gmail.com', '5a99df9e79a4eb6a1ba7aa3fb2511f17', 1999, '', '2013-05-10 14:40:32', '0000-00-00 00:00:00'),
(14, 'vfsdfs', 'sdfsdfsds', '1999-12-12', 1234567, 123456, '654789', '0974458', 'vicente.s@adinet.com.uy', '202cb962ac59075b964b07152d234b70', 1999, '', '2013-05-10 19:35:42', '0000-00-00 00:00:00'),
(15, 'n', 'b', '1969-12-31', 40380579, 2222, '222', '222', 'kfffffm@jj.com', '0486a0eaade8a13e8b69526c8cc7d928', 1999, '', '2013-05-13 17:53:50', '0000-00-00 00:00:00'),
(16, 'Maria', 'Marfetan', '1969-12-31', 40380579, 2222, '033454545', '099454545', 'mmarfetan@mjf.com.uy', '25f9e794323b453885f5181f1b624d0b', 1999, '', '2013-05-13 17:54:50', '0000-00-00 00:00:00'),
(17, 'Virginia', 'Acu&ntilde;a', '1969-12-31', 44660523, 1234, '27112222', '094834001', 'marketing@semm.com.uy', 'e10adc3949ba59abbe56e057f20f883e', 1999, '', '2013-05-14 17:18:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_adjuntos`
--

CREATE TABLE IF NOT EXISTS `aspirantes_adjuntos` (
  `id_aspirantes_adjuntos` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_adjuntos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=665 ;

--
-- Volcado de datos para la tabla `aspirantes_adjuntos`
--

INSERT INTO `aspirantes_adjuntos` (`id_aspirantes_adjuntos`, `id_aspirante`, `titulo`, `filename`) VALUES
(516, 11, '', ''),
(64, 18, '', '20130206_124856.jpg'),
(664, 2, 'Foto', ''),
(663, 2, 'Ninguno', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_congresos`
--

CREATE TABLE IF NOT EXISTS `aspirantes_congresos` (
  `id_aspirantes_congresos` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tema` varchar(50) NOT NULL,
  `fecha` int(4) NOT NULL,
  `caracter` int(1) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_congresos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=889 ;

--
-- Volcado de datos para la tabla `aspirantes_congresos`
--

INSERT INTO `aspirantes_congresos` (`id_aspirantes_congresos`, `id_aspirante`, `nombre`, `tema`, `fecha`, `caracter`) VALUES
(888, 2, 'Jornadas de Ginecolog&iacute;a', 'Gine', 2012, 2),
(887, 2, 'Congreso de Medicina Familiar', 'Medicina', 1234, 1),
(739, 11, 'lkjlkj', 'lkjlkj', 1234, 1),
(260, 18, 'La gripe', 'es jodida', 2012, 2),
(740, 11, 'lkjlkj', 'lkjlkj', 1234, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_cursos`
--

CREATE TABLE IF NOT EXISTS `aspirantes_cursos` (
  `id_aspirantes_cursos` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `extra` varchar(50) NOT NULL,
  `vigencia` varchar(15) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_cursos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=632 ;

--
-- Volcado de datos para la tabla `aspirantes_cursos`
--

INSERT INTO `aspirantes_cursos` (`id_aspirantes_cursos`, `id_aspirante`, `id_curso`, `extra`, `vigencia`, `lugar`) VALUES
(631, 2, 4, '', '2014', 'ssss'),
(557, 11, 1, '', '', ''),
(302, 18, 3, '', '12', 'en casa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_exp_laboral`
--

CREATE TABLE IF NOT EXISTS `aspirantes_exp_laboral` (
  `id_aspirantes_exp_laboral` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `ingreso` int(4) NOT NULL,
  `cese` int(4) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_exp_laboral`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=766 ;

--
-- Volcado de datos para la tabla `aspirantes_exp_laboral`
--

INSERT INTO `aspirantes_exp_laboral` (`id_aspirantes_exp_laboral`, `id_aspirante`, `empresa`, `cargo`, `ingreso`, `cese`) VALUES
(691, 11, 'lkj', 'lkj', 1111, 1111),
(765, 2, 'Ningunao', 'oo', 1234, 1234),
(294, 18, 'hospital', 'matasano', 1815, 2090);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_idiomas`
--

CREATE TABLE IF NOT EXISTS `aspirantes_idiomas` (
  `id_aspirantes_idiomas` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `idioma` varchar(50) NOT NULL,
  `extra` varchar(50) NOT NULL,
  `habilidad` int(1) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_idiomas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1400 ;

--
-- Volcado de datos para la tabla `aspirantes_idiomas`
--

INSERT INTO `aspirantes_idiomas` (`id_aspirantes_idiomas`, `id_aspirante`, `idioma`, `extra`, `habilidad`) VALUES
(1103, 11, 'Ninguno', '', 0),
(1399, 2, 'Otro', 'polaco', 7),
(1398, 2, 'Portugues', '', 5),
(1397, 2, 'Frances', '', 2),
(1396, 2, 'Ingles', '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_meritos`
--

CREATE TABLE IF NOT EXISTS `aspirantes_meritos` (
  `id_aspirantes_meritos` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `merito` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_meritos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=823 ;

--
-- Volcado de datos para la tabla `aspirantes_meritos`
--

INSERT INTO `aspirantes_meritos` (`id_aspirantes_meritos`, `id_aspirante`, `merito`) VALUES
(822, 2, 'Recorrer todo el pa&iacute;s en coche'),
(821, 2, 'Trabajar en condiciones inhumanas'),
(674, 11, 'No tengo'),
(222, 18, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_otros_cursos`
--

CREATE TABLE IF NOT EXISTS `aspirantes_otros_cursos` (
  `id_aspirantes_otros_cursos` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `id_otros_cursos` int(11) NOT NULL,
  `inicio` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_otros_cursos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=885 ;

--
-- Volcado de datos para la tabla `aspirantes_otros_cursos`
--

INSERT INTO `aspirantes_otros_cursos` (`id_aspirantes_otros_cursos`, `id_aspirante`, `id_otros_cursos`, `inicio`, `nombre`, `lugar`) VALUES
(884, 2, 4, '2012', 'Traslado de pacientes', 'MSP'),
(883, 2, 2, '2009', 'Vacunaciones', 'CASMU'),
(736, 11, 1, '', '', ''),
(272, 18, 3, '2001', 'space  odyssey', 'dvd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_postgrados`
--

CREATE TABLE IF NOT EXISTS `aspirantes_postgrados` (
  `id_aspirantes_postgrados` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `id_tipo_postgrado` int(11) NOT NULL,
  `inicio` int(4) NOT NULL,
  `cursa` int(2) NOT NULL,
  `egresado` tinyint(1) NOT NULL,
  `egreso` int(4) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_postgrados`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=644 ;

--
-- Volcado de datos para la tabla `aspirantes_postgrados`
--

INSERT INTO `aspirantes_postgrados` (`id_aspirantes_postgrados`, `id_aspirante`, `id_especialidad`, `id_tipo_postgrado`, `inicio`, `cursa`, `egresado`, `egreso`) VALUES
(320, 18, 33, 1, 2050, 1, 1, 2015),
(643, 2, 3, 1, 1234, 1, 1, 0),
(583, 11, 3, 1, 1, 1, 1, 1),
(319, 18, 35, 6, 1915, 4, 0, 2030);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes_referencias`
--

CREATE TABLE IF NOT EXISTS `aspirantes_referencias` (
  `id_aspirantes_referencias` int(11) NOT NULL auto_increment,
  `id_aspirante` int(11) NOT NULL,
  `medico` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `funcionario_semm` tinyint(1) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_aspirantes_referencias`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=676 ;

--
-- Volcado de datos para la tabla `aspirantes_referencias`
--

INSERT INTO `aspirantes_referencias` (`id_aspirantes_referencias`, `id_aspirante`, `medico`, `celular`, `mail`, `funcionario_semm`, `lugar`) VALUES
(675, 2, 'Ningunall', 'll', 'mail@mail.com', 0, 'll'),
(601, 11, 'Ningunalkjlkj', 'lkj', 'lkj@lkj.com', 0, 'lkj'),
(216, 18, 'Dr.', '99123456', 'dr@semm.com', 0, 'semm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL auto_increment,
  `curso_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_curso`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `curso_nombre`) VALUES
(2, 'A.C.L.S.'),
(3, 'PH.T.L.S.'),
(4, 'RCP'),
(1, 'No tengo'),
(5, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE IF NOT EXISTS `especialidades` (
  `id_especialidades` int(11) NOT NULL auto_increment,
  `nombre_especialidad` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_especialidades`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidades`, `nombre_especialidad`) VALUES
(1, 'No tiene'),
(3, 'Medicina Intensiva'),
(4, 'Anestesiolog&iacute;a'),
(5, 'Pediatr&iacute;a'),
(6, 'Cardiolog&iacute;a'),
(7, 'Medicina Interna'),
(8, 'Medicina Familiar'),
(9, 'Emergencia'),
(10, 'Anatom&iacute;a Patol&oacute;gica'),
(11, 'Cardio Cirug&iacute;a'),
(12, 'Cirug&iacute;a'),
(13, 'Cirug&iacute;a Pl&aacute;stica'),
(14, 'Dermatolog&iacute;a'),
(15, 'Endocrinolog&iacute;a'),
(16, 'Fisiatr&iacute;a'),
(17, 'Gastroenterolog&iacute;a'),
(18, 'Geriatr&iacute;a'),
(19, 'Ginecolog&iacute;a'),
(20, 'Imagenolog&iacute;a'),
(21, 'Laboratorio Cl&iacute;nico'),
(22, 'Medicina del Deporte'),
(23, 'Medicina Legal'),
(24, 'Medicina Nuclear'),
(25, 'Medicina Transfusional'),
(26, 'Microbiolog&iacute;a'),
(27, ' Neurocirug&iacute;a'),
(28, 'Oftalmolog&iacute;a'),
(29, 'Oncolog&iacute;a Cl&iacute;nica'),
(30, 'Oncolog&iacute;a Radioterapia'),
(31, 'Orientaci&oacute;n &Aacute;rea Social'),
(32, 'Orientaci&oacute;n M&eacute;dica'),
(33, 'O.R.L.'),
(34, 'Parasitolog&iacute;a'),
(35, 'Psiquiatr&iacute;a'),
(36, 'Psiquiatr&iacute;a Infantil'),
(37, 'Reumatolog&iacute;a'),
(38, 'Toxicolog&iacute;a'),
(39, 'Traumatolog&iacute;a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_cursos`
--

CREATE TABLE IF NOT EXISTS `otros_cursos` (
  `id_otros_cursos` int(11) NOT NULL auto_increment,
  `otros_cursos_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_otros_cursos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `otros_cursos`
--

INSERT INTO `otros_cursos` (`id_otros_cursos`, `otros_cursos_nombre`) VALUES
(2, 'Taller'),
(3, 'Seminario'),
(4, 'Curso'),
(5, 'Otros'),
(1, 'No tengo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_postgrado`
--

CREATE TABLE IF NOT EXISTS `tipo_postgrado` (
  `id_tipo_postgrado` int(11) NOT NULL auto_increment,
  `tipo_postgrado_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_tipo_postgrado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `tipo_postgrado`
--

INSERT INTO `tipo_postgrado` (`id_tipo_postgrado`, `tipo_postgrado_nombre`) VALUES
(1, 'Residencia'),
(2, 'Postgrado'),
(3, 'Diplomatura'),
(4, 'Maestr&iacute;a'),
(5, 'Doctorado'),
(6, 'Postdoctorado');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

