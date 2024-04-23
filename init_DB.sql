-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2024 a las 23:21:49
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `golem_games`
--
CREATE DATABASE IF NOT EXISTS `golem_games` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `golem_games`;

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
-- Estructura de tabla para la tabla `capturasdepantalla`
--

DROP TABLE IF EXISTS `capturasdepantalla`;
CREATE TABLE `capturasdepantalla` (
  `id` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `link_captura` varchar(255) DEFAULT NULL,
  `id_juego` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

DROP TABLE IF EXISTS `juegos`;
CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `link_archivo_juego` varchar(255) NOT NULL,
  `link_descarga` varchar(255) NOT NULL,
  `es_publico` tinyint(1) NOT NULL DEFAULT 1,
  `vistas` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_desarrollador` int(11) DEFAULT NULL
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
-- Estructura de tabla para la tabla `pertenecen`
--

DROP TABLE IF EXISTS `pertenecen`;
CREATE TABLE `pertenecen` (
  `id_juego` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salaschat`
--

DROP TABLE IF EXISTS `salaschat`;
CREATE TABLE `salaschat` (
  `id` int(11) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspenden`
--

DROP TABLE IF EXISTS `suspenden`;
CREATE TABLE `suspenden` (
  `id` int(11) NOT NULL,
  `id_suspendedor` int(11) NOT NULL,
  `id_suspendido` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `caducidad` datetime NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
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
(1, 'admin@admin.com', '$2y$10$74P58tk4DZZ/hj2KwWwd3OnxIkBRpoO8gwDnEkPhS2CXWbjKYTLrG', 'admin', '2024-03-26', 1, 'Soy el admin', 'https://cdn-icons-png.flaticon.com/512/9131/9131529.png', 0),
(3, 'pepe@axax.com', '$2y$10$jfY0aajm7cmL70nHwwPyZuDpXz12UtcTlVI3D1bID0WXEsFmqh3/O', 'pepe1234', '0000-00-00', 1, '', 'https://cdn-icons-png.flaticon.com/512/9131/9131529.png', 0),
(4, 'garcia@correo.com', '$2y$10$38IISO0T.HWIGHsM6ZHpxe.wIpWbxoApS0zft7sF6cTHphD7VWWq2', 'garcia1234', '2024-04-01', 1, '', 'https://cdn-icons-png.flaticon.com/512/9131/9131529.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosingresansalas`
--

DROP TABLE IF EXISTS `usuariosingresansalas`;
CREATE TABLE `usuariosingresansalas` (
  `id_usuario` int(11) NOT NULL,
  `id_sala_chat` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosvenjuegos`
--

DROP TABLE IF EXISTS `usuariosvenjuegos`;
CREATE TABLE `usuariosvenjuegos` (
  `id_juego` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `like` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indices de la tabla `capturasdepantalla`
--
ALTER TABLE `capturasdepantalla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_juego` (`id_juego`);

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
  ADD KEY `id_juego` (`id_juego`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_desarrollador` (`id_desarrollador`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sala_chat` (`id_sala_chat`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pertenecen`
--
ALTER TABLE `pertenecen`
  ADD PRIMARY KEY (`id_juego`,`id_categoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `salaschat`
--
ALTER TABLE `salaschat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suspenden`
--
ALTER TABLE `suspenden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_suspendedor` (`id_suspendedor`),
  ADD KEY `id_suspendido` (`id_suspendido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

--
-- Indices de la tabla `usuariosingresansalas`
--
ALTER TABLE `usuariosingresansalas`
  ADD PRIMARY KEY (`id_usuario`,`id_sala_chat`),
  ADD KEY `id_sala_chat` (`id_sala_chat`);

--
-- Indices de la tabla `usuariosvenjuegos`
--
ALTER TABLE `usuariosvenjuegos`
  ADD PRIMARY KEY (`id_juego`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `capturasdepantalla`
--
ALTER TABLE `capturasdepantalla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salaschat`
--
ALTER TABLE `salaschat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `suspenden`
--
ALTER TABLE `suspenden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `capturasdepantalla`
--
ALTER TABLE `capturasdepantalla`
  ADD CONSTRAINT `capturasdepantalla_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `juegos_ibfk_1` FOREIGN KEY (`id_desarrollador`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_sala_chat`) REFERENCES `salaschat` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pertenecen`
--
ALTER TABLE `pertenecen`
  ADD CONSTRAINT `pertenecen_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `pertenecen_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `suspenden`
--
ALTER TABLE `suspenden`
  ADD CONSTRAINT `suspenden_ibfk_1` FOREIGN KEY (`id_suspendedor`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `suspenden_ibfk_2` FOREIGN KEY (`id_suspendido`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuariosingresansalas`
--
ALTER TABLE `usuariosingresansalas`
  ADD CONSTRAINT `usuariosingresansalas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuariosingresansalas_ibfk_2` FOREIGN KEY (`id_sala_chat`) REFERENCES `salaschat` (`id`);

--
-- Filtros para la tabla `usuariosvenjuegos`
--
ALTER TABLE `usuariosvenjuegos`
  ADD CONSTRAINT `usuariosvenjuegos_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`),
  ADD CONSTRAINT `usuariosvenjuegos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;
