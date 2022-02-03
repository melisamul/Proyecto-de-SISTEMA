-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-02-2017 a las 21:07:14
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloque`
--

CREATE TABLE IF NOT EXISTS `bloque` (
  `idBloque` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `idCuestionario` int(11) NOT NULL,
  PRIMARY KEY (`idBloque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidato`
--

CREATE TABLE IF NOT EXISTS `candidato` (
  `idCandidato` int(11) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `nrodocumento` int(11) NOT NULL,
  `fecha_de_nacimiento` date DEFAULT NULL,
  `nrocandidato` int(11) NOT NULL,
  `genero` varchar(45) DEFAULT NULL,
  `nacionalidad` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `escolaridad` varchar(45) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  `idTipoDocumento` int(11) NOT NULL,
  PRIMARY KEY (`idCandidato`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `candidato`
--

INSERT INTO `candidato` (`idCandidato`, `apellido`, `nombre`, `nrodocumento`, `fecha_de_nacimiento`, `nrocandidato`, `genero`, `nacionalidad`, `email`, `escolaridad`, `eliminado`, `idTipoDocumento`) VALUES
(1, 'Salvadori', 'Hernan', 24533547, '1975-02-20', 1, 'M', 'Argentina', 'hernan.salvadori@hotmail.com', 'UNIVERSITARIO', 0, 2),
(2, 'Perez', 'Marcelo', 37766012, '1994-07-22', 2, 'M', 'Argentina', NULL, NULL, NULL, 2),
(3, 'Guns', 'Camila', 31021194, '1989-02-02', 3, 'F', 'Argentina', NULL, NULL, NULL, 2),
(4, 'Torres', 'Brisa', 33040186, '1990-12-30', 4, 'F', 'Argentina', NULL, NULL, NULL, 2),
(5, 'Flores', 'Franco', 20347085, '1970-04-30', 5, 'M', 'Argentina', 'franco.flores@arnet.com.ar', 'UNIVERSITARIO', 0, 2),
(6, 'Rodriguez', 'Jose', 203470856, '1998-04-08', 6, 'M', 'Peruano', NULL, 'SECUNDARIO', 0, 2),
(7, 'Calderon', 'Romina', 34131586, '1992-09-14', 7, 'F', 'Argentina', NULL, NULL, NULL, 2),
(8, 'Ramirez', 'Andres', 35363811, '1991-10-05', 8, 'M', 'Argentina', NULL, NULL, NULL, 2),
(9, 'Inocenti', 'Mirta', 16629334, '1964-03-19', 9, 'F', 'Argentina', 'minoceti@miempresa.com', 'SECUNDARIO', 0, 2),
(10, 'Lamic', 'Debora', 36020594, '1994-03-24', 10, 'F', 'Argentina', NULL, NULL, NULL, 2),
(11, 'Gomitolo', 'Aylen', 37798022, '1994-07-25', 11, 'F', 'Argentina', NULL, NULL, NULL, 2),
(12, 'Ruiz', 'Norma', 13806276, '1957-09-09', 12, 'F', 'Argentina', 'nruiz@miempresa.com', 'SECUNDARIO', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia`
--

CREATE TABLE IF NOT EXISTS `competencia` (
  `idCompetencia` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  `idRegistro_de_Auditoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCompetencia`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `competencia`
--

INSERT INTO `competencia` (`idCompetencia`, `codigo`, `nombre`, `descripcion`, `eliminado`, `idRegistro_de_Auditoria`) VALUES
(1, 0, 'Pasion', 'Pasion', NULL, NULL),
(2, 1, 'Vision', 'Vision', NULL, NULL),
(3, 2, 'Sociabilidad', 'Capacidad para mezclase fácilmente con otras personas. Abierto y participativo', NULL, NULL),
(4, 3, 'Gestion de Proyectos', 'Gestion de Proyectos', NULL, NULL),
(5, 4, 'Lealtad', 'consistente en el cumplimiento de lo que exigen las normas de fidelidad, honor y gratitud', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia evaluada`
--

CREATE TABLE IF NOT EXISTS `competencia evaluada` (
  `idCompetencia_Evaluada` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `ponderacion` int(11) NOT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `idCuestionario` int(11) NOT NULL,
  PRIMARY KEY (`idCompetencia_Evaluada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultor`
--

CREATE TABLE IF NOT EXISTS `consultor` (
  `idConsultor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `puestoConsultor` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  PRIMARY KEY (`idConsultor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `consultor`
--

INSERT INTO `consultor` (`idConsultor`, `nombre`, `apellido`, `puestoConsultor`, `user`) VALUES
(1, 'Micaela', 'Robere', 'Jefe de Contabilidad', 'MicaR'),
(2, 'Duilio', 'Muzu', 'Gerente General', 'DuilioM'),
(3, 'German', 'Pisku', 'Secretario General', 'GermanP'),
(4, 'Camila', 'Cairo', 'Tecnico de Estructura', 'CamilaC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario`
--

CREATE TABLE IF NOT EXISTS `cuestionario` (
  `idCuestionario` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_de_creacion` date NOT NULL,
  `idPuesto` int(11) NOT NULL,
  `idCandidato` int(11) NOT NULL,
  `instrucciones` varchar(1000) DEFAULT NULL,
  `cantidad_accesos` int(11) DEFAULT NULL,
  `clave` varchar(45) NOT NULL,
  `ultimo_acceso` date DEFAULT NULL,
  PRIMARY KEY (`idCuestionario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario_has_estado`
--

CREATE TABLE IF NOT EXISTS `cuestionario_has_estado` (
  `Cuestionario_idCuestionario` int(11) NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  `fechayhora` datetime NOT NULL,
  PRIMARY KEY (`Cuestionario_idCuestionario`,`Estado_idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `contacto` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEmpresa`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombre`, `telefono`, `contacto`, `direccion`) VALUES
(1, 'EPE', 4550055, 'Adolfo clis', 'Rioja 1120'),
(2, 'BLANCALEY', 4555000, 'Carola blanca', 'Tucuman 9834'),
(3, 'EFICON', 4657801, 'Marcelo Eficon', 'San Martín 201'),
(4, 'ALMEIDA', 4880488, 'Andres Alme', 'Ayacucho 234'),
(5, 'BOYACA', 4882325, 'Leonel Juar', 'Catamarca 9129'),
(6, 'Desarrollador S.A.', 4550043, 'Pablo Andres', 'Necochea 8345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `idEstado` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`idEstado`),
  UNIQUE KEY `tipo de estado_UNIQUE` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idEstado`, `tipo`) VALUES
(1, 'ACTIVO'),
(3, 'COMPLETO'),
(2, 'EN PROCESO'),
(4, 'FINALIZADO'),
(5, 'INCOMPLETO'),
(6, 'SIN CONTESTAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factor`
--

CREATE TABLE IF NOT EXISTS `factor` (
  `idFactor` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `nro_de_orden` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  `Competencia_idCompetencia` int(11) NOT NULL,
  `idRegistro_de_Auditoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`idFactor`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `factor`
--

INSERT INTO `factor` (`idFactor`, `codigo`, `nombre`, `descripcion`, `nro_de_orden`, `eliminado`, `Competencia_idCompetencia`, `idRegistro_de_Auditoria`) VALUES
(1, 1, 'Energía', 'Energía', NULL, NULL, 5, NULL),
(2, 2, 'Bienestar', 'Bienestar', NULL, NULL, 5, NULL),
(3, 3, 'Mentalidad Emprendedora', 'Mentalidad Emprendedora', NULL, NULL, 1, NULL),
(4, 4, 'Planeación', 'Planeación', NULL, NULL, 1, NULL),
(5, 5, 'Gestión del alcance', 'Gestión del alcance', NULL, NULL, 3, NULL),
(6, 6, 'Gestión del tiempo', 'Gestión del tiempo', NULL, NULL, 3, NULL),
(7, 7, 'Gestión del costo', 'Gestión del costo', NULL, NULL, 3, NULL),
(8, 8, 'Credibilidad', 'Credibilidad', NULL, NULL, 2, NULL),
(9, 9, 'Compromiso', 'Compromiso', NULL, NULL, 2, NULL),
(10, 10, 'Gestion de Alcance', 'Gestion de Alcance', NULL, NULL, 4, NULL),
(11, 11, 'Gestion de Tiempo', 'Gestion de Tiempo', NULL, NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factor evaluado`
--

CREATE TABLE IF NOT EXISTS `factor evaluado` (
  `idFactor_Evaluado` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `puntaje` float DEFAULT NULL,
  `idCompetencia_Evaluada` int(11) NOT NULL,
  PRIMARY KEY (`idFactor_Evaluado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ldap`
--

CREATE TABLE IF NOT EXISTS `ldap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ldap`
--

INSERT INTO `ldap` (`id`, `user`, `pass`) VALUES
(1, 'MicaR', 'algoritm0s'),
(2, 'DuilioM', 'disenio35'),
(3, 'GermanP', 'basedat0s'),
(4, 'CamilaC', '13analisis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE IF NOT EXISTS `opcion` (
  `idOpcion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `orden_visualizacion` int(11) DEFAULT NULL,
  `idOpcion_de_Respuesta` int(11) NOT NULL,
  PRIMARY KEY (`idOpcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idOpcion`, `nombre`, `orden_visualizacion`, `idOpcion_de_Respuesta`) VALUES
(1, 'MALO', 1, 1),
(2, 'REGULAR', 2, 1),
(3, 'BUENO', 3, 1),
(4, 'MUY BUENO', 4, 1),
(5, 'EXCELENTE', 5, 1),
(6, '1', 1, 2),
(7, '0', 2, 2),
(8, 'SI', 1, 3),
(9, 'NO', 2, 3),
(10, 'NUNCA ', 1, 4),
(11, 'A VECES', 2, 4),
(12, 'SIEMPRE', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion de respuesta`
--

CREATE TABLE IF NOT EXISTS `opcion de respuesta` (
  `idOpcion_de_Respuesta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idOpcion_de_Respuesta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `opcion de respuesta`
--

INSERT INTO `opcion de respuesta` (`idOpcion_de_Respuesta`, `nombre`, `descripcion`, `eliminado`) VALUES
(1, 'ESCALA 5', 'PRESENTA 5 VALORES POSIBLES', NULL),
(2, 'VERDADERO/FALSO', 'PRESENTA SOLO DOS VALORES:VERDADERO-FALSO', NULL),
(3, 'SI/NO', 'PRESENTA DOS OPCIONES: SI Y NO', NULL),
(4, 'ESCALA 3', 'PRESENTA 3 VALORES PORIBLES', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion evaluada`
--

CREATE TABLE IF NOT EXISTS `opcion evaluada` (
  `idOpcion_Evaluada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `valor_elegido` int(11) DEFAULT NULL,
  `ponderacion_evaluada` int(11) NOT NULL,
  `idPregunta_Evaluada` int(11) NOT NULL,
  `orden_visualizacion` int(11) NOT NULL,
  PRIMARY KEY (`idOpcion_Evaluada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT NULL,
  `idRegistro_de_Auditoria` int(11) DEFAULT NULL,
  `Factor_idFactor` int(11) NOT NULL,
  `idOpcion_de_Respuesta` int(11) NOT NULL,
  PRIMARY KEY (`idPregunta`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `codigo`, `pregunta`, `descripcion`, `eliminado`, `idRegistro_de_Auditoria`, `Factor_idFactor`, `idOpcion_de_Respuesta`) VALUES
(1, 1, 'En mi trabajo constantemente realizo mis actividades laborales de manera dinámica.', 'Pregunta 1', NULL, NULL, 1, 4),
(2, 2, 'Considero que mi actitud en el trabajo es: Soy constante y mantengo el ritmo de trabajo durante mi j', 'Pregunta 2', NULL, NULL, 1, 4),
(3, 3, 'En mi trabajo, por lo general soy arduo y multitareas.', 'Pregunta 3', NULL, NULL, 1, 4),
(4, 4, 'Durante la jornada laboral, mi ritmo de trabajo lo adecuo a las circunstancias.', 'Pregunta 4', NULL, NULL, 1, 4),
(5, 5, 'Durante la jornada laboral, mi ritmo de trabajo es dinámico.', 'Pregunta 5', NULL, NULL, 1, 4),
(6, 6, 'En el trabajo me siento a gusto con el clima laboral y las funciones que realizo.', 'Pregunta 6', NULL, NULL, 2, 4),
(7, 7, 'Disfruto mis funciones laborales que llevo a cabo en el trabajo, gracias al clima laboral que existe', 'Pregunta 7', NULL, NULL, 2, 4),
(8, 8, 'Para mí es importante el clima laboral, porque me permite desarrollar mi trabajo de la mejor forma p', 'Pregunta 8', NULL, NULL, 2, 4),
(9, 9, 'El trabajo que desempeño actualmente me genera bienestar porque me genera orgullo pertenecer a la em', 'Pregunta 9', NULL, NULL, 2, 4),
(10, 10, 'Me siento satisfecho en mi trabajo porque me gusta lo que hago.', 'Pregunta 10', NULL, NULL, 2, 4),
(11, 11, 'Me siento satisfecho en mi trabajo porque me genera beneficios.', 'Pregunta 11', NULL, NULL, 2, 4),
(12, 12, 'Me siento satisfecho en mi trabajo porque me genera beneficios.', 'Pregunta 12', NULL, NULL, 2, 4),
(13, 13, 'Las tendencias laborales las sigo con la finalidad de emprender acciones rentables y exitosas.', 'Pregunta 13', NULL, NULL, 3, 4),
(14, 14, 'En mi trabajo llevo a cabo mis funciones con base en un plan trazado previamente.', 'Pregunta 14', NULL, NULL, 4, 4),
(15, 15, '¿La descomposición de estructura de trabajo (WBS) forma parte de la definición del alcance?', 'Pregunta 15', NULL, NULL, 5, 3),
(16, 16, '¿Cuándo se define un alcance, debe definirse una línea base de requerimientos?', 'Pregunta 16', NULL, NULL, 5, 3),
(17, 17, 'Al momento de planificar el alcance del proyecto,  ¿el acta de constitución del proyecto es un docum', 'Pregunta 17', NULL, NULL, 5, 3),
(18, 18, 'Cuando se está definiendo el alcance del proyecto,  la "identificación de alternativas" es una herra', 'Pregunta 18', NULL, NULL, 5, 3),
(19, 19, '¿Las solicitudes de cambio por aprobar generar un impacto en la definición de la WBS?', 'Pregunta 19', NULL, NULL, 5, 3),
(20, 20, 'En el cronograma de un proyecto, una relación "fin a comienzo" entre las actividades A y B significa', 'Pregunta 20', NULL, NULL, 6, 3),
(21, 21, 'El método de camino crítico calcula las fechas de inicio y finalización tempranas y tardías teóricas', 'Pregunta 21', NULL, NULL, 6, 2),
(22, 22, '¿La WBS es un documento de entrada para la gestión del costo?', 'Pregunta 22', NULL, NULL, 7, 3),
(23, 23, '¿Los riesgos forman parte de la estimación de los costos del proyecto?', 'Pregunta 23', NULL, NULL, 7, 3),
(24, 24, 'La línea base de costos es un presupuesto distribuido en el tiempo que se usa como base respecto a l', 'Pregunta 24', NULL, NULL, 7, 2),
(25, 25, 'La metodología de "Valor ganado" permite predecir cuánto dinero se gastará en un proyecto según los ', 'Pregunta 25', NULL, NULL, 7, 3),
(26, 26, 'Un valor CPI (índice de rendimiento del costo) menor a 1 significa un sobrecosto con respecto a las ', 'Pregunta 26', NULL, NULL, 7, 2),
(27, 27, 'El costo real (AC) es el costo planificado en el proyecto hasta una fecha dada.', 'Pregunta 27', NULL, NULL, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta evaluada`
--

CREATE TABLE IF NOT EXISTS `pregunta evaluada` (
  `idPregunta_Evaluada` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `idFactor_Evaluado` int(11) NOT NULL,
  `orden_enbloque` int(11) DEFAULT NULL,
  `idBloque` int(11) NOT NULL,
  PRIMARY KEY (`idPregunta_Evaluada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_opcion`
--

CREATE TABLE IF NOT EXISTS `pregunta_opcion` (
  `ponderacion` int(11) NOT NULL,
  `Pregunta_idPregunta` int(11) NOT NULL,
  `Opcion_idOpcion` int(11) NOT NULL,
  PRIMARY KEY (`Pregunta_idPregunta`,`Opcion_idOpcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pregunta_opcion`
--

INSERT INTO `pregunta_opcion` (`ponderacion`, `Pregunta_idPregunta`, `Opcion_idOpcion`) VALUES
(0, 1, 10),
(4, 1, 11),
(6, 1, 12),
(0, 2, 10),
(4, 2, 11),
(6, 2, 12),
(0, 3, 10),
(4, 3, 11),
(6, 3, 12),
(5, 4, 10),
(4, 4, 11),
(1, 4, 12),
(0, 5, 10),
(3, 5, 11),
(7, 5, 12),
(0, 6, 10),
(4, 6, 11),
(6, 6, 12),
(0, 7, 10),
(4, 7, 11),
(6, 7, 12),
(0, 8, 10),
(4, 8, 11),
(6, 8, 12),
(0, 9, 10),
(4, 9, 11),
(6, 9, 12),
(0, 10, 10),
(4, 10, 11),
(6, 10, 12),
(0, 11, 10),
(4, 11, 11),
(6, 11, 12),
(3, 12, 10),
(4, 12, 11),
(3, 12, 12),
(3, 13, 10),
(3, 13, 11),
(4, 13, 12),
(1, 14, 10),
(3, 14, 11),
(6, 14, 12),
(10, 15, 8),
(0, 15, 9),
(10, 16, 8),
(0, 16, 9),
(10, 17, 8),
(0, 17, 9),
(0, 18, 8),
(10, 18, 9),
(0, 19, 8),
(10, 19, 9),
(0, 20, 8),
(10, 20, 9),
(10, 21, 6),
(0, 21, 7),
(10, 22, 8),
(0, 22, 9),
(10, 23, 8),
(0, 23, 9),
(10, 24, 6),
(0, 24, 7),
(10, 25, 8),
(0, 25, 9),
(10, 26, 6),
(0, 26, 7),
(0, 27, 6),
(10, 27, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE IF NOT EXISTS `puesto` (
  `idPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT '0',
  `idEmpresa` int(11) NOT NULL,
  `idRegistro_de_Auditoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPuesto`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`idPuesto`, `codigo`, `nombre`, `descripcion`, `eliminado`, `idEmpresa`, `idRegistro_de_Auditoria`) VALUES
(1, 1000, 'PRUEBA 1', 'ESTO ES SOLO UNA PRUEBA MUY IMPROBABLE                  \r\n            ', 0, 4, NULL),
(2, 1001, 'PRUEBA 2', 'ES LA SEGUNDA PRUEBA VAMOS A VER QUE PASA DESDE AQUI EN ADELANTE CON LAS DEMAS PRUEBAS ESPERO QUE TODO SALGA BIEN                  \r\n            ', 1, 3, 1),
(3, 987, 'enfermeria', '                  \r\n            ', 0, 1, NULL),
(4, 120, 'sadna', 'smasdm                  \r\n            ', 1, 2, 3),
(5, 123, 'hgs', '                  \r\n            ', 1, 4, 2),
(6, 1234, 'hgjdft', '  \r\n            ', 1, 4, 5),
(7, 0, 'NOsad', '                  \r\n            ', 1, 2, 4),
(8, 2334, 'Prueba 2', '                                   \r\n             \r\n            ', 0, 4, NULL),
(9, 2939, 'BETA TESTING', '', 0, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto_competencia`
--

CREATE TABLE IF NOT EXISTS `puesto_competencia` (
  `ponderacion` int(11) NOT NULL,
  `Puesto_idPuesto` int(11) NOT NULL,
  `Competencia_idCompetencia` int(11) NOT NULL,
  PRIMARY KEY (`Puesto_idPuesto`,`Competencia_idCompetencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `puesto_competencia`
--

INSERT INTO `puesto_competencia` (`ponderacion`, `Puesto_idPuesto`, `Competencia_idCompetencia`) VALUES
(9, 1, 1),
(8, 3, 3),
(8, 8, 5),
(10, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_de_auditoria`
--

CREATE TABLE IF NOT EXISTS `registro_de_auditoria` (
  `idRegistro_de_Auditoria` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `idConsultor` int(11) NOT NULL,
  PRIMARY KEY (`idRegistro_de_Auditoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `registro_de_auditoria`
--

INSERT INTO `registro_de_auditoria` (`idRegistro_de_Auditoria`, `fecha`, `idConsultor`) VALUES
(1, '2017-01-09', 1),
(2, '2017-01-10', 1),
(3, '2017-01-10', 1),
(4, '2017-01-17', 1),
(5, '2017-01-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_de_ejecucion`
--

CREATE TABLE IF NOT EXISTS `registro_de_ejecucion` (
  `idRegistro_de_Ejecucion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `accion` varchar(45) NOT NULL,
  PRIMARY KEY (`idRegistro_de_Ejecucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_param`
--

CREATE TABLE IF NOT EXISTS `sys_param` (
  `idSys_param` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_accesos` int(11) DEFAULT NULL,
  `instruccion_cuestionario` varchar(1000) DEFAULT NULL,
  `duracion_evaluacion` int(11) DEFAULT NULL,
  `tiempo_activo` varchar(45) DEFAULT NULL,
  `user_log` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSys_param`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sys_param`
--

INSERT INTO `sys_param` (`idSys_param`, `cantidad_accesos`, `instruccion_cuestionario`, `duracion_evaluacion`, `tiempo_activo`, `user_log`) VALUES
(1, 3, '- Lee las preguntas atentamente, revisa todas las opciones y elige la respuesta que prefieras. - Para rellenar el cuestionario selecciona una opcion dentro de todas las que se presentan en pantalla para cada pregunta. - Dispone de 5 días para completar el cuestionario apartir de la fecha en que se notifico que esta habilitado para realizar el mismo. - La cantidad de accesos máximos para esta evaluación son 3. - Cada bloque de preguntas, (entiéndase por bloque la agrupación de una cierta cantidad de preguntas que se presentan en pantalla) debe ser contestado en su integridad para que sus respuestas sean guardadas. - Una vez presionado el botón siguiente, no podra regresar al bloque de preguntas anterior, de modo que le sugerimos este seguro de su respuesta antes de avanzar. Saludos y merecidos exitos!', 5, '2', 'MicaR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `idDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`idDocumento`),
  UNIQUE KEY `descripcion_UNIQUE` (`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`idDocumento`, `tipo`) VALUES
(4, 'CEDULA'),
(2, 'DNI'),
(1, 'LE'),
(3, 'PASSAPORTE');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
