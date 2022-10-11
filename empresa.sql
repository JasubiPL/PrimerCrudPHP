-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-10-2022 a las 04:06:09
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(250) NOT NULL,
  `Apellidop` varchar(250) NOT NULL,
  `Apellidom` varchar(250) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Foto` varchar(1000) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID`, `Nombre`, `Apellidop`, `Apellidom`, `Correo`, `Foto`) VALUES
(72, 'Mariana', 'Prado', 'Perez', 'Mrado@yahoo.com', '1665452921_Maria.jpg'),
(73, 'Gerzom', 'Piñeyro', 'Flores', 'couchegerzom@hotmail.com', '1665453026_Yo.jpg'),
(76, 'Carlos', 'Vallarta', 'Garcia', 'pedro@hotmail.com', '1665460786_Carlos.jpg'),
(61, 'Jasubi Lehem', 'Piñeyro', 'Legaspi', 'gameportal7@hotmail.com', '1665453044_Perfil.jpg'),
(66, 'Angeles Yulisa', 'Jimenez', 'Hernandez', 'yiyi@outlook.com', '1665345865_YIYI.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
