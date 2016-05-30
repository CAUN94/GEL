-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-05-2016 a las 07:26:31
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `software`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adminsynchronization`
--

CREATE TABLE `adminsynchronization` (
  `id` int(10) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Period` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Active` varchar(255) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Timecreated` int(11) DEFAULT NULL,
  `Timemodified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `adminsynchronization`
--

INSERT INTO `adminsynchronization` (`id`, `Unit`, `Period`, `Category`, `Active`, `Comment`, `Status`, `Timecreated`, `Timemodified`) VALUES
(16, 'Pregrado', 'Example', 'Example', 'Example', 'Example', 'StandBy', NULL, NULL),
(17, 'Omega', 'Example', 'Example', 'Example', 'Example', 'StandBy', NULL, NULL),
(18, 'WebCursos', 'Example', 'Example', 'Example', 'Example', 'StandBy', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adminsynchronization`
--
ALTER TABLE `adminsynchronization`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adminsynchronization`
--
ALTER TABLE `adminsynchronization`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
