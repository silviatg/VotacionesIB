-- ---------------------------------------------------------
-- 
-- Base de datos descargada:
-- 
--          db732579980
--
-- Host Connection Info: db732579980.db.1and1.com via TCP/IP
-- Generation Time: February 21, 2019 at 07:18 AM ( Europe/Madrid )
-- Server version: 
-- PHP Version: 5.6.40
--
-- ---------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- ---------------------------------------------------------
--
-- Table structure for table : `Donaciones`
--
-- ---------------------------------------------------------

CREATE TABLE `Donaciones` (
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nif` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `provincia` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `donacion` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `Donaciones`
--

INSERT INTO `Donaciones` (`nombre`, `nif`, `provincia`, `donacion`) VALUES
('NOMBRE Y APELLIDOS', 'NIF.', 'PROVINCIA', 'IMPORTE DE LA DONACION'),
(('EIRENE (DATOS JURIDICOS)', '', 'BURGOS', '1.000,00 ?');



-- ---------------------------------------------------------
--
-- Table structure for table : `candidatos`
--
-- ---------------------------------------------------------
CREATE TABLE `candidatos` (
  `ID` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_provincia` smallint(3) unsigned zerofill NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `sexo` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'H',
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `anadido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_anadido` datetime NOT NULL,
  `modif` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modif` datetime NOT NULL,
  `id_vut` int(6) NOT NULL DEFAULT '0',
  `imagen` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `imagen_pequena` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `URLVideo` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ---------------------------------------------------------
--
-- Table structure for table : `ccaa`
--
-- ---------------------------------------------------------

CREATE TABLE `ccaa` (
  `ID` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `ccaa` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `especial` int(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- ---------------------------------------------------------
--
-- Table structure for table : `debate_comentario`
--
-- ---------------------------------------------------------

CREATE TABLE `debate_comentario` (
  `idcomentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned zerofill NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `tema` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `comentario` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcomentario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- ---------------------------------------------------------
--
-- Table structure for table : `debate_preguntas`
--
-- ---------------------------------------------------------

CREATE TABLE `debate_preguntas` (
  `ID` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pregunta` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `respuestas` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `anadido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_anadido` datetime NOT NULL,
  `modif` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modif` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `debate_votos`
--
-- ---------------------------------------------------------

CREATE TABLE `debate_votos` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `id_votante` int(10) unsigned zerofill NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  `voto` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `codigo_val` char(128) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `id_votacion` (`id_votacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `elvoto`
--
-- ---------------------------------------------------------

CREATE TABLE `elvoto` (
  `ID` char(64) COLLATE utf8_spanish_ci NOT NULL,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `id_candidato` smallint(6) unsigned zerofill NOT NULL,
  `voto` text COLLATE utf8_spanish_ci NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `codigo_val` char(128) COLLATE utf8_spanish_ci NOT NULL,
  `especial` smallint(1) NOT NULL DEFAULT '0',
  `incluido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `id_candidato` (`id_candidato`),
  KEY `id_votacion` (`id_votacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `grupo_trabajo`
--
-- ---------------------------------------------------------

CREATE TABLE `grupo_trabajo` (
  `ID` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tipo` smallint(1) NOT NULL DEFAULT '0',
  `subgrupo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `especial` int(3) NOT NULL,
  `id_provincia` int(3) NOT NULL,
  `id_ccaa` int(3) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `acceso` smallint(1) NOT NULL,
  `activo` smallint(1) NOT NULL,
  `creado` smallint(10) unsigned zerofill NOT NULL,
  `tipo_votante` char(2) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `interventores`
--
-- ---------------------------------------------------------

CREATE TABLE `interventores` (
  `ID` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_provincia` smallint(3) unsigned zerofill NOT NULL,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `correo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `anadido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_anadido` datetime NOT NULL,
  `modif` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modif` datetime NOT NULL,
  `pass` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `usuario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '0',
  `codigo_rec` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_ultimo` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- ---------------------------------------------------------
--
-- Table structure for table : `municipios`
--
-- ---------------------------------------------------------

CREATE TABLE `municipios` (
  `id_municipio` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `id_provincia` smallint(6) NOT NULL,
  `cod_municipio` int(11) NOT NULL COMMENT 'Código de muncipio DENTRO de la provincia, campo no único',
  `DC` int(11) NOT NULL COMMENT 'Digito Control. El INE no revela cómo se calcula, secreto nuclear.',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_municipio`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `id_provincia`, `cod_municipio`, `DC`, `nombre`) VALUES
(1, 9, 59, 7, 'Burgos Capital');



-- ---------------------------------------------------------
--
-- Table structure for table : `nivel_usuario`
--
-- ---------------------------------------------------------

CREATE TABLE `nivel_usuario` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nivel_usuario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `nivel_usuario`
--

INSERT INTO `nivel_usuario` (`id`, `nivel_usuario`) VALUES
(1, 'Usuario'),
(2, 'Administrador'),
(3, 'Administrador provincia'),
(4, 'Administrador CCAA'),
(5, 'Interventor'),
(6, 'Administrador Grupo Trabajo');


-- ---------------------------------------------------------
--
-- Table structure for table : `paginas`
--
-- ---------------------------------------------------------

CREATE TABLE `paginas` (
  `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` tinytext NOT NULL,
  `texto` text NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `incluido` tinytext NOT NULL,
  `borrable` char(2) NOT NULL DEFAULT 'si',
  `pagina` smallint(2) NOT NULL,
  `zona_pagina` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- ---------------------------------------------------------
--
-- Table structure for table : `provincia`
--
-- ---------------------------------------------------------

CREATE TABLE `provincia` (
  `ID` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `provincia` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `especial` int(3) NOT NULL,
  `id_ccaa` int(3) unsigned zerofill NOT NULL,
  `correo_notificaciones` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `provincia`
--

INSERT INTO `provincia` (`ID`, `provincia`, `especial`, `id_ccaa`, `correo_notificaciones`) VALUES
(009, 'Burgos Capital', 0, 007, '');



-- ---------------------------------------------------------
--
-- Table structure for table : `usuario_admin_x_provincia`
--
-- ---------------------------------------------------------

CREATE TABLE `usuario_admin_x_provincia` (
  `ID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned zerofill NOT NULL,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `usuario_x_g_trabajo`
--
-- ---------------------------------------------------------

CREATE TABLE `usuario_x_g_trabajo` (
  `ID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned zerofill NOT NULL,
  `id_grupo_trabajo` int(4) unsigned zerofill NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `estado` int(1) NOT NULL DEFAULT '0',
  `razon_bloqueo` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_grupo_trabajo` (`id_grupo_trabajo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- ---------------------------------------------------------
--
-- Table structure for table : `usuario_x_votacion`
--
-- ---------------------------------------------------------

CREATE TABLE `usuario_x_votacion` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `id_votante` int(10) unsigned zerofill NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `tipo_votante` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `correo_usuario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `ip` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `forma_votacion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_presencial` timestamp NULL DEFAULT NULL,
  `campotexto_adicional_voto` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4072 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- ---------------------------------------------------------
--
-- Table structure for table : `votacion`
--
-- ---------------------------------------------------------

CREATE TABLE `votacion` (
  `ID` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `activa` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `nombre_votacion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `resumen` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `tipo_votante` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1',
  `numero_opciones` int(3) NOT NULL,
  `anadido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_anadido` datetime NOT NULL,
  `modif` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modif` datetime NOT NULL,
  `fecha_com` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `activos_resultados` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `fin_resultados` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `id_ccaa` int(2) NOT NULL DEFAULT '0',
  `id_subzona` int(4) NOT NULL DEFAULT '0',
  `id_grupo_trabajo` int(4) unsigned zerofill NOT NULL DEFAULT '0000',
  `demarcacion` int(2) NOT NULL DEFAULT '0',
  `seguridad` int(2) NOT NULL,
  `interventores` int(1) NOT NULL DEFAULT '0',
  `interventor` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `recuento` int(1) NOT NULL DEFAULT '0',
  `id_municipio` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla de las votaciones activas';


-- ---------------------------------------------------------
--
-- Table structure for table : `votantes`
--
-- ---------------------------------------------------------

CREATE TABLE `votantes` (
  `ID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `id_municipio` smallint(6) NOT NULL,
  `nombre_usuario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `apellido_usuario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `nivel_usuario` int(2) NOT NULL DEFAULT '1',
  `nivel_acceso` smallint(4) NOT NULL DEFAULT '10',
  `correo_usuario` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nif` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `id_ccaa` int(3) NOT NULL DEFAULT '0',
  `pass` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tipo_votante` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_ultima` datetime NOT NULL,
  `codigo_rec` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `bloqueo` char(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `razon_bloqueo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'usuario.jpg',
  `imagen_pequena` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'peq_usuario.jpg',
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_control` date NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `sms_validation_code` char(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sms_expire_time` timestamp NULL DEFAULT NULL,
  `sms_validated` tinyint(1) NOT NULL DEFAULT '0',
  `Comentarios` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_votante_OLD` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `sms_validated_old` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `nif` (`nif`),
  UNIQUE KEY `correo_usuario` (`correo_usuario`),
  UNIQUE KEY `Telefono` (`telefono`),
  UNIQUE KEY `usuario_2` (`usuario`),
  FULLTEXT KEY `Usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=1691 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla donde se reflejan los votantes registrados';

-- ---------------------------------------------------------
--
-- Table structure for table : `votantes_x_admin`
--
-- ---------------------------------------------------------

CREATE TABLE `votantes_x_admin` (
  `id` int(12) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_votante` int(10) unsigned zerofill NOT NULL,
  `id_admin` int(10) unsigned zerofill NOT NULL,
  `accion` int(1) unsigned zerofill NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4019 DEFAULT CHARSET=latin1 COMMENT='Tabla que registra quien ha incluido o modificado votantes';


-- ---------------------------------------------------------
--
-- Table structure for table : `votos`
--
-- ---------------------------------------------------------

CREATE TABLE `votos` (
  `ID` char(64) COLLATE utf8_spanish_ci NOT NULL,
  `id_provincia` int(3) unsigned zerofill NOT NULL,
  `id_candidato` smallint(6) unsigned zerofill NOT NULL,
  `voto` decimal(7,5) NOT NULL,
  `id_votacion` int(6) unsigned zerofill NOT NULL,
  `codigo_val` char(128) COLLATE utf8_spanish_ci NOT NULL,
  `especial` smallint(1) NOT NULL DEFAULT '0',
  `incluido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `vote_id` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `position` int(3) NOT NULL,
  `otros` int(3) NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `id_candidato` (`id_candidato`),
  KEY `id_votacion` (`id_votacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;