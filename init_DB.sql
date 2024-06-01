-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2024 a las 16:41:55
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `golem_games`
--
CREATE DATABASE IF NOT EXISTS `golem_games` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `golem_games`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `select_usuarios_ven_juegos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `select_usuarios_ven_juegos` (`id_usu` INT, `id_jue` INT)   BEGIN
	INSERT IGNORE INTO usuarios_ven_juegos (id_usuario, id_juego) VALUES (id_usu, id_jue);
	SELECT `like` FROM usuarios_ven_juegos WHERE id_usuario = id_usu AND id_juego = id_jue;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

DROP TABLE IF EXISTS `avisos`;
CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `fecha` datetime NOT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_administrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capturas_pantalla`
--

DROP TABLE IF EXISTS `capturas_pantalla`;
CREATE TABLE `capturas_pantalla` (
  `id` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `link_captura` varchar(255) DEFAULT NULL,
  `id_juego` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capturas_pantalla`
--

INSERT INTO `capturas_pantalla` (`id`, `borrado`, `link_captura`, `id_juego`) VALUES
(3, 0, 'uploads/screenshots/luigi1.png', 1),
(4, 0, 'uploads/screenshots/luigi2.png', 1),
(5, 0, 'uploads/screenshots/luigi3.png', 1),
(8, 0, 'uploads/screenshots/luigi4.png', 1),
(9, 0, 'uploads/screenshots/luigi5.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `texto` text NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_juego` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `fecha`, `texto`, `borrado`, `id_juego`, `id_usuario`) VALUES
(1, '2024-04-19 22:43:00', 'Me encanta este juego, gracias por subirlo', 0, 1, 1),
(3, '2024-04-19 00:00:00', 'Pero si eres tu mismo jajaj', 0, 1, 3),
(15, '2024-04-24 00:00:00', 'asdsa', 0, 1, 1),
(16, '2024-04-24 00:00:00', 'Prueba #2\r\n', 0, 1, 1),
(17, '2024-04-24 07:54:33', 'Preuba #3', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

DROP TABLE IF EXISTS `juegos`;
CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `link_archivo_juego` varchar(255) NOT NULL,
  `link_descarga` varchar(255) NOT NULL,
  `es_publico` tinyint(1) NOT NULL DEFAULT 1,
  `vistas` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_desarrollador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `titulo`, `descripcion`, `fecha`, `link_archivo_juego`, `link_descarga`, `es_publico`, `vistas`, `borrado`, `id_desarrollador`) VALUES
(1, 'Luigis Casino', 'Minjuegos clasicos en el Casino de Luigi', '2024-05-31 15:40:58', 'uploads/games/1', 'uploads/games/1/index.html', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_destacados`
--

DROP TABLE IF EXISTS `juegos_destacados`;
CREATE TABLE `juegos_destacados` (
  `id_juego` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos_destacados`
--

INSERT INTO `juegos_destacados` (`id_juego`, `fecha`, `id_administrador`, `borrado`) VALUES
(1, '2024-05-07 00:47:37', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_pertenecen_categoria`
--

DROP TABLE IF EXISTS `juegos_pertenecen_categoria`;
CREATE TABLE `juegos_pertenecen_categoria` (
  `id_juego` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `texto` text NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_sala_chat` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas_juegos`
--

DROP TABLE IF EXISTS `plataformas_juegos`;
CREATE TABLE `plataformas_juegos` (
  `id_juego` int(11) NOT NULL,
  `plataforma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plataformas_juegos`
--

INSERT INTO `plataformas_juegos` (`id_juego`, `plataforma`) VALUES
(1, 'windows');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas_chat`
--

DROP TABLE IF EXISTS `salas_chat`;
CREATE TABLE `salas_chat` (
  `id` int(11) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspensiones`
--

DROP TABLE IF EXISTS `suspensiones`;
CREATE TABLE `suspensiones` (
  `id` int(11) NOT NULL,
  `id_suspendido` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `caducidad` datetime NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `clave` char(60) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `fecha_registro` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `sobre_mi` varchar(255) NOT NULL DEFAULT '',
  `foto_perfil` varchar(255) NOT NULL DEFAULT '',
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo_electronico`, `clave`, `nombre`, `fecha_registro`, `activo`, `sobre_mi`, `foto_perfil`, `borrado`) VALUES
(1, 'admin@admin.com', '$2y$10$74P58tk4DZZ/hj2KwWwd3OnxIkBRpoO8gwDnEkPhS2CXWbjKYTLrG', 'admin', '2024-03-26', 1, 'GOGOGO', 'uploads/profiles/GQ3D3A==.png', 0),
(3, 'pepe@axax.com', '$2y$10$jfY0aajm7cmL70nHwwPyZuDpXz12UtcTlVI3D1bID0WXEsFmqh3/O', 'pepe1234', '0000-00-00', 1, '', 'https://cdn-icons-png.flaticon.com/512/9131/9131529.png', 0),
(4, 'garcia@correo.com', '$2y$10$38IISO0T.HWIGHsM6ZHpxe.wIpWbxoApS0zft7sF6cTHphD7VWWq2', 'garcia1234', '2024-04-01', 1, '', 'https://cdn-icons-png.flaticon.com/512/9131/9131529.png', 0),
(5, 'comunista4ever@redmail.com', '$2y$10$h3c57ag63EWcUEIu6l8RYOh9sx4nXjWIdEkBXL.pmIG1zmZurJnou', 'carlmaxx', '2024-05-17', 1, '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ingresan_salas`
--

DROP TABLE IF EXISTS `usuarios_ingresan_salas`;
CREATE TABLE `usuarios_ingresan_salas` (
  `id_usuario` int(11) NOT NULL,
  `id_sala_chat` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ven_juegos`
--

DROP TABLE IF EXISTS `usuarios_ven_juegos`;
CREATE TABLE `usuarios_ven_juegos` (
  `id_juego` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `like` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_ven_juegos`
--

INSERT INTO `usuarios_ven_juegos` (`id_juego`, `id_usuario`, `like`, `borrado`) VALUES
(1, 1, 1, 0),
(1, 4, 1, 0),
(1, 5, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avisos_ibfk_1` (`id_administrador`);

--
-- Indices de la tabla `capturas_pantalla`
--
ALTER TABLE `capturas_pantalla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `capturas_pantalla_ibfk_1` (`id_juego`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comentarios_ibfk_1` (`id_juego`),
  ADD KEY `comentarios_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `juegos_ibfk_1` (`id_desarrollador`);

--
-- Indices de la tabla `juegos_destacados`
--
ALTER TABLE `juegos_destacados`
  ADD PRIMARY KEY (`id_juego`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indices de la tabla `juegos_pertenecen_categoria`
--
ALTER TABLE `juegos_pertenecen_categoria`
  ADD PRIMARY KEY (`id_juego`,`id_categoria`),
  ADD KEY `juegos_pertenecen_categoria_ibfk_2` (`id_categoria`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_ibfk_1` (`id_sala_chat`),
  ADD KEY `mensajes_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `plataformas_juegos`
--
ALTER TABLE `plataformas_juegos`
  ADD PRIMARY KEY (`id_juego`,`plataforma`);

--
-- Indices de la tabla `salas_chat`
--
ALTER TABLE `salas_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suspensiones_ibfk_2` (`id_suspendido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

--
-- Indices de la tabla `usuarios_ingresan_salas`
--
ALTER TABLE `usuarios_ingresan_salas`
  ADD PRIMARY KEY (`id_usuario`,`id_sala_chat`),
  ADD KEY `usuarios_ingresan_salas_ibfk_2` (`id_sala_chat`);

--
-- Indices de la tabla `usuarios_ven_juegos`
--
ALTER TABLE `usuarios_ven_juegos`
  ADD PRIMARY KEY (`id_juego`,`id_usuario`),
  ADD KEY `usuarios_ven_juegos_ibfk_2` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `capturas_pantalla`
--
ALTER TABLE `capturas_pantalla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salas_chat`
--
ALTER TABLE `salas_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `capturas_pantalla`
--
ALTER TABLE `capturas_pantalla`
  ADD CONSTRAINT `capturas_pantalla_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `juegos_ibfk_1` FOREIGN KEY (`id_desarrollador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos_destacados`
--
ALTER TABLE `juegos_destacados`
  ADD CONSTRAINT `juegos_destacados_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `juegos_destacados_ibfk_2` FOREIGN KEY (`id_administrador`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `juegos_pertenecen_categoria`
--
ALTER TABLE `juegos_pertenecen_categoria`
  ADD CONSTRAINT `juegos_pertenecen_categoria_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `juegos_pertenecen_categoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_sala_chat`) REFERENCES `salas_chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  ADD CONSTRAINT `suspensiones_ibfk_2` FOREIGN KEY (`id_suspendido`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_ingresan_salas`
--
ALTER TABLE `usuarios_ingresan_salas`
  ADD CONSTRAINT `usuarios_ingresan_salas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ingresan_salas_ibfk_2` FOREIGN KEY (`id_sala_chat`) REFERENCES `salas_chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_ven_juegos`
--
ALTER TABLE `usuarios_ven_juegos`
  ADD CONSTRAINT `usuarios_ven_juegos_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ven_juegos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


