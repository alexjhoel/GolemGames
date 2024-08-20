-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-08-2024 a las 02:16:46
-- Versión del servidor: 10.11.8-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u612317551_golem_games`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`u612317551_golem_admin`@`127.0.0.1` PROCEDURE `insert_usuarios_ingresan_salas` (IN `id_usu` INT, IN `id_sala` INT)   INSERT INTO usuarios_ingresan_salas
  (id_usuario, id_sala_chat)
VALUES
  (id_usu, id_sala)
ON DUPLICATE KEY UPDATE
  borrado = 0$$

CREATE DEFINER=`u612317551_golem_admin`@`127.0.0.1` PROCEDURE `select_usuarios_ven_juegos` (`id_usu` INT, `id_jue` INT)   BEGIN
	INSERT IGNORE INTO usuarios_ven_juegos (id_usuario, id_juego) VALUES (id_usu, id_jue);
	SELECT `like` FROM usuarios_ven_juegos WHERE id_usuario = id_usu AND id_juego = id_jue;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

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

CREATE TABLE `capturas_pantalla` (
  `id` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `link_captura` varchar(255) DEFAULT NULL,
  `id_juego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capturas_pantalla`
--

INSERT INTO `capturas_pantalla` (`id`, `borrado`, `link_captura`, `id_juego`) VALUES
(3, 1, 'uploads/screenshots/luigi1.png', 1),
(4, 1, 'uploads/screenshots/luigi2.png', 1),
(5, 1, 'uploads/screenshots/luigi3.png', 1),
(8, 1, 'uploads/screenshots/luigi4.png', 1),
(9, 1, 'uploads/screenshots/luigi5.png', 1),
(10, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 2),
(11, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 3),
(12, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 4),
(13, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 5),
(14, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 6),
(15, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 7),
(16, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 8),
(17, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 9),
(18, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 10),
(19, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 11),
(20, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 12),
(21, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 13),
(22, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 14),
(23, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 15),
(24, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 16),
(25, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 17),
(26, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 18),
(27, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 19),
(28, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 21),
(29, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 22),
(30, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 23),
(31, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 24),
(32, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 25),
(33, 1, 'https://cdn.magicdecor.in/com/2024/02/08163057/Vibrant-Gaming-Controller-Wallpaper-for-Gaming-Lovers.jpg', 26),
(52, 0, 'uploads/screenshots/52.jpg', 41),
(53, 0, 'uploads/screenshots/53.jpg', 42),
(54, 0, 'uploads/screenshots/54.jpg', 1),
(55, 0, 'uploads/screenshots/55.jpg', 1),
(56, 1, 'uploads/screenshots/56.jpg', 43),
(57, 1, 'uploads/screenshots/57.jpg', 43),
(58, 0, 'uploads/screenshots/58.jpg', 44),
(59, 1, 'uploads/screenshots/59.jpg', 25),
(60, 0, 'uploads/screenshots/60.jpg', 23),
(61, 0, 'uploads/screenshots/61.jpg', 25),
(62, 0, 'uploads/screenshots/62.jpg', 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `borrado`) VALUES
(1, 'Acción', 'Juegos de acción', 0),
(2, 'Aventuras', 'Juegos de aventura', 0),
(3, 'Deportes', 'Juegos de deportes', 0),
(4, 'Juegos de rol', 'Juegos de rol', 0),
(5, 'Arcade', 'Arcade', 0),
(6, 'Peleas', '', 1),
(7, 'Peleas', '', 0),
(8, 'Casino', '', 0),
(9, 'Nueva categoría', '', 1),
(10, 'Plataformas', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_destacadas`
--

CREATE TABLE `categorias_destacadas` (
  `orden` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `link_imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_destacadas`
--

INSERT INTO `categorias_destacadas` (`orden`, `id_categoria`, `link_imagen`) VALUES
(1, 1, '../uploads/categories/1.png'),
(2, 5, '../uploads/categories/2.png'),
(3, 3, '../uploads/categories/3.png'),
(4, 4, 'https://cdn01.x-plarium.com/browser/content/blog/common/widget/mobile/raid_aside.webp'),
(5, 2, 'https://phantom-elmundo.unidadeditorial.es/647dfec588ecbc704118394a2da06a54/crop/153x0/759x404/resize/414/f/jpg/assets/multimedia/imagenes/2020/03/30/15855939110237.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

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
(17, '2024-04-24 07:54:33', 'Preuba #3', 0, 1, 1),
(18, '2024-06-29 17:52:56', 'Una pruebita', 0, NULL, NULL),
(19, '2024-06-29 17:57:39', 'Una pruebita', 0, 1, 3),
(20, '2024-07-01 20:09:28', 'Hola', 0, 45, 1),
(21, '2024-07-31 02:10:40', '', 0, 26, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

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
(1, 'Luigis Casino', 'Minjuegos clasicos en el Casino de Luigi', '2024-05-31 15:40:58', 'uploads/games_players/1', 'uploads/games_downloads/1/Luigi%20Casino.zip', 1, 0, 0, 1),
(2, 'Aventura en la Selva', 'Explora la selva y descubre sus secretos.', '2023-02-01 11:00:00', '', '', 0, 200, 0, 3),
(3, 'Defensa Pixel', 'Defiende la base!', '2023-03-01 12:00:00', 'uploads/games_players/3', 'uploads/games_downloads/3/PixelDefense.zip', 1, 300, 0, 4),
(4, 'Carreras Extremas', 'Compite en carreras alocadas y peligrosas.', '2023-04-01 13:00:00', '', '', 0, 150, 0, 5),
(5, 'Batalla Galáctica', 'Lucha en el espacio contra enemigos intergalácticos.', '2023-05-01 14:00:00', '', '', 0, 250, 1, 1),
(6, 'Misterio en la Mansión', 'Resuelve misterios en una mansión encantada.', '2023-06-01 15:00:00', '', '', 0, 350, 0, 3),
(7, 'Rescate en el Ártico', 'Embárcate en una misión de rescate en el frío Ártico.', '2023-07-01 16:00:00', '', '', 0, 180, 0, 1),
(8, 'El Tesoro Perdido', 'Encuentra el tesoro escondido en esta aventura épica.', '2023-08-01 17:00:00', '', '', 0, 210, 0, 3),
(9, 'Defensa Alienígena', 'Defiende la Tierra de invasores alienígenas.', '2023-09-01 18:00:00', '', '', 0, 190, 1, 4),
(10, 'Safari Salvaje', 'Atraviesa la sabana en esta aventura de safari.', '2023-10-01 19:00:00', '', '', 0, 170, 0, 5),
(11, 'Ciudad Zombi', 'Sobrevive en una ciudad infestada de zombis.', '2023-11-01 20:00:00', '', '', 0, 220, 0, 1),
(12, 'Reinos de Magia', 'Descubre y domina el poder de la magia en varios reinos.', '2023-12-01 21:00:00', '', '', 0, 200, 0, 3),
(13, 'Operación Secreta', 'Completa misiones secretas sin ser detectado.', '2024-01-01 22:00:00', '', '', 0, 230, 0, 4),
(14, 'La Gran Carrera', 'Participa en la carrera más importante del año.', '2024-02-01 23:00:00', '', '', 0, 240, 0, 5),
(15, 'Aventura Submarina', 'Explora el mundo submarino y descubre sus secretos.', '0000-00-00 00:00:00', '', '', 0, 250, 0, 1),
(16, 'Guerras Medievales', 'Conquista castillos y derrota a tus enemigos en tiempos medievales.', '2024-04-01 10:00:00', '', '', 0, 260, 0, 3),
(17, 'Expedición al Everest', 'Lidera una expedición para escalar el Everest.', '2024-05-01 11:00:00', '', '', 0, 270, 0, 4),
(18, 'Bandidos del Oeste', 'Vive la vida de un bandido en el viejo oeste.', '2024-06-01 12:00:00', '', '', 0, 280, 0, 5),
(19, 'Robots en Guerra', 'Participa en batallas épicas con robots.', '2024-07-01 13:00:00', '', '', 0, 290, 0, 1),
(20, 'La Última Fortaleza', 'Defiende tu fortaleza contra oleadas de enemigos.', '2024-08-01 14:00:00', '', '', 0, 300, 0, 3),
(21, 'Piratas del Caribe', 'Navega los mares como un pirata y encuentra tesoros.', '2024-09-01 15:00:00', '', '', 0, 310, 0, 4),
(22, 'Cazadores de Dinosaurios', 'Caza dinosaurios en un mundo prehistórico.', '2024-10-01 16:00:00', '', '', 0, 320, 1, 5),
(23, 'Tiny Crate', 'Juego de plataformas retro', '2024-11-01 17:00:00', 'uploads/games_players/23', 'uploads/games_downloads/23/tinycrate-windows.zip', 1, 330, 0, 1),
(24, 'El Laberinto', 'Encuentra la salida en este laberinto lleno de trampas.', '2024-12-01 18:00:00', '', '', 0, 340, 1, 3),
(25, 'Clumsy Bird', 'Un juego muy familiar a uno popular, que pondrá a prueba tu paciencia.', '2025-01-01 19:00:00', 'uploads/games_players/25', 'uploads/games_downloads/25/clumsy-bird.zip', 1, 350, 0, 4),
(26, 'Asedio Medieval', 'Defiende tu castillo del asedio enemigo.', '2025-02-01 20:00:00', '', '', 0, 360, 0, 5),
(39, 'Prueba 3', '', '2024-06-22 20:37:51', '', 'uploads/games_downloads/39/Stewie Tweaks INI-66347-2-1-1562243757.zip', 0, 0, 0, 1),
(40, 'Prueba 4', '', '2024-06-22 20:39:12', '', 'uploads/games_downloads/40/Stewie Tweaks INI-66347-2-1-1562243757.zip', 0, 0, 0, 1),
(41, 'Prueba 4', '', '2024-06-22 20:40:19', '', 'uploads/games_downloads/41/Stewie Tweaks INI-66347-2-1-1562243757.zip', 0, 0, 0, 1),
(42, 'Prueba 4', '', '2024-06-22 20:40:37', '', 'uploads/games_downloads/42/Stewie Tweaks INI-66347-2-1-1562243757.zip', 0, 0, 0, 1),
(43, 'El juego de pepe', '', '2024-06-26 22:17:04', '', 'uploads/games_downloads/43/Build.zip', 0, 0, 0, 3),
(44, 'Prueba de categorías', 'Probar la funcion de categorias', '2024-06-29 01:23:06', '', 'uploads/games_downloads/44/Stewie Tweaks INI-66347-2-1-1562243757.zip', 0, 0, 0, 3),
(45, 'Mi juego', '', '2024-07-01 20:09:13', '', 'uploads/games_downloads/45/E0005.zip', 0, 0, 0, 1),
(46, 'Última prueba 1', 'The last', '2024-08-03 23:02:13', '', 'uploads/games_downloads/46/Luigi Casino (1).zip', 1, 0, 0, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_destacados`
--

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
(1, '2024-08-01 00:03:44', 1, 0),
(3, '2024-08-01 00:03:36', 1, 0),
(5, '2024-08-01 00:03:55', 1, 0),
(9, '2024-08-01 00:04:00', 1, 0),
(23, '2024-08-01 00:04:08', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_pertenecen_categoria`
--

CREATE TABLE `juegos_pertenecen_categoria` (
  `id_juego` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos_pertenecen_categoria`
--

INSERT INTO `juegos_pertenecen_categoria` (`id_juego`, `id_categoria`) VALUES
(1, 5),
(1, 8),
(2, 2),
(3, 4),
(3, 5),
(23, 5),
(23, 10),
(25, 5),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(45, 3),
(46, 3),
(46, 7),
(46, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `texto` text NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_sala_chat` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `fecha`, `texto`, `oculto`, `borrado`, `id_sala_chat`, `id_usuario`) VALUES
(2, '2024-07-12 00:05:00', 'adsa', 0, 0, 2, 1),
(3, '2024-07-15 23:49:07', 'Alo\n', 0, 0, 2, 4),
(4, '2024-07-15 23:49:07', 'Alo\n', 0, 0, 2, 4),
(5, '2024-07-15 23:52:27', 'Meme', 0, 0, 1, 1),
(6, '2024-07-17 16:26:58', '', 0, 0, 1, 1),
(7, '2024-07-18 14:40:21', 'Hola', 0, 0, 2, 1),
(8, '2024-07-18 15:47:41', 'hello', 0, 0, 2, 3),
(9, '2024-07-18 15:49:45', 'gola', 0, 0, 2, 3),
(10, '2024-07-18 15:50:31', 'tuto', 0, 0, 2, 3),
(11, '2024-07-18 16:02:48', 'Sapeca', 0, 0, 2, 1),
(12, '2024-07-18 16:03:55', 'Trolteca', 0, 0, 2, 1),
(13, '2024-07-18 16:04:21', 'Sacateca', 0, 0, 2, 1),
(14, '2024-07-18 16:05:20', 'Guilmeca', 0, 0, 2, 1),
(15, '2024-07-18 16:14:12', 'Sapoteca', 0, 0, 2, 1),
(16, '2024-07-18 16:15:16', 'gRANADA', 0, 0, 2, 1),
(17, '2024-07-18 16:17:52', 'Tema', 0, 0, 2, 1),
(18, '2024-07-18 16:28:26', 'jaja', 0, 0, 2, 1),
(19, '2024-07-18 16:29:03', 'Kev', 0, 0, 2, 1),
(20, '2024-07-18 16:31:15', 'Fee', 0, 0, 2, 1),
(21, '2024-07-18 16:32:53', 'tata', 0, 0, 2, 1),
(22, '2024-07-18 16:33:56', 'garcia', 0, 0, 2, 1),
(23, '2024-07-18 16:40:31', 'Sure;o', 0, 0, 2, 1),
(24, '2024-07-18 16:41:00', 'Sure bro', 0, 0, 2, 1),
(25, '2024-07-18 20:01:01', 'Sure bro', 0, 0, 2, 1),
(26, '2024-07-18 21:01:30', 'Hello my friend', 0, 0, 2, 1),
(27, '2024-07-18 21:01:46', 'Hi fella', 0, 0, 2, 3),
(28, '2024-07-18 21:03:41', 'Aloha\n', 0, 0, 2, 1),
(29, '2024-07-18 21:04:02', 'Monteveo', 0, 0, 2, 3),
(30, '2024-07-18 21:04:50', 'Hello', 0, 0, 2, 1),
(31, '2024-07-20 23:51:22', 'Bonjour', 0, 0, 2, 3),
(32, '2024-07-21 00:07:15', 'Great day!', 0, 0, 2, 1),
(33, '2024-07-21 00:15:52', 'Buen mensaje', 0, 0, 2, 3),
(34, '2024-07-21 19:29:10', 'Hello', 0, 0, 2, 1),
(35, '2024-07-21 19:31:59', 'Buen dia', 0, 0, 2, 1),
(36, '2024-07-21 19:32:54', 'hola', 0, 0, 2, 1),
(37, '2024-07-21 19:37:16', 'Buenas', 0, 0, 2, 1),
(38, '2024-07-21 19:37:25', 'Buenas', 0, 0, 2, 1),
(39, '2024-07-21 19:38:10', 'genial', 0, 0, 2, 1),
(40, '2024-07-21 19:39:34', 'Nos vemos', 0, 0, 2, 1),
(41, '2024-07-21 19:41:40', 'hi', 0, 0, 2, 1),
(42, '2024-07-21 19:48:43', 'Gutierrez', 0, 0, 2, 1),
(43, '2024-07-21 19:59:04', 'Contesta', 0, 0, 2, 1),
(44, '2024-07-21 19:59:10', 'Contesta', 0, 0, 2, 1),
(45, '2024-07-21 20:05:59', 'Contesta', 0, 0, 2, 1),
(46, '2024-07-21 20:06:54', 'Buenas', 0, 0, 2, 3),
(47, '2024-07-21 20:07:08', 'Qué cuentan?', 0, 0, 2, 3),
(48, '2024-07-21 20:15:46', 'SOy nuevo', 0, 0, 2, 6),
(49, '2024-07-21 20:16:11', 'Tapa', 0, 0, 2, 3),
(50, '2024-07-21 20:16:12', 'Tapita', 0, 0, 2, 1),
(51, '2024-07-21 20:16:13', 'Tapón', 0, 0, 2, 6),
(52, '2024-07-21 20:17:36', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 2, 3),
(53, '2024-07-21 20:17:38', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 2, 1),
(54, '2024-07-21 20:17:38', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 2, 6),
(55, '2024-07-22 02:23:39', 'Hola', 0, 0, 2, 1),
(56, '2024-07-22 02:23:49', 'Sambuches', 0, 0, 2, 1),
(57, '2024-07-22 02:23:56', 'Hahahahaha', 0, 0, 2, 1),
(58, '2024-07-22 02:24:04', 'Jejej', 0, 0, 2, 1),
(59, '2024-07-22 02:24:08', 'Kula\r\n', 0, 0, 2, 1),
(60, '2024-07-22 02:24:12', 'FF', 0, 0, 2, 1),
(61, '2024-07-22 02:24:13', '', 0, 0, 2, 1),
(62, '2024-07-22 02:24:15', 'F', 0, 0, 2, 1),
(63, '2024-07-22 02:24:17', 'F', 0, 0, 2, 1),
(64, '2024-07-22 02:24:19', 'F', 0, 0, 2, 1),
(65, '2024-07-22 02:24:20', 'F', 0, 0, 2, 1),
(66, '2024-07-22 02:24:22', 'F', 0, 0, 2, 1),
(67, '2024-07-22 02:24:24', 'F', 0, 0, 2, 1),
(68, '2024-07-22 02:24:25', 'F', 0, 0, 2, 1),
(69, '2024-07-22 02:24:27', 'F', 0, 0, 2, 1),
(70, '2024-07-22 02:24:28', 'F', 0, 0, 2, 1),
(71, '2024-07-22 02:24:30', 'F', 0, 0, 2, 1),
(72, '2024-07-22 02:24:31', 'F', 0, 0, 2, 1),
(73, '2024-07-22 02:24:34', 'F', 0, 0, 2, 1),
(74, '2024-07-22 02:24:35', 'F', 0, 0, 2, 1),
(75, '2024-07-22 02:24:37', 'F', 0, 0, 2, 1),
(76, '2024-07-22 02:24:39', 'F', 0, 0, 2, 1),
(77, '2024-07-22 02:24:40', 'F', 0, 0, 2, 1),
(78, '2024-07-22 02:24:41', 'F', 0, 0, 2, 1),
(79, '2024-07-22 02:24:43', 'F', 0, 0, 2, 1),
(80, '2024-07-22 02:24:44', 'F', 0, 0, 2, 1),
(81, '2024-07-22 02:24:45', 'F', 0, 0, 2, 1),
(82, '2024-07-22 02:24:46', 'F', 0, 0, 2, 1),
(83, '2024-07-22 02:24:47', 'F', 0, 0, 2, 1),
(84, '2024-07-22 02:24:48', 'F', 0, 0, 2, 1),
(85, '2024-07-22 02:24:49', 'F', 0, 0, 2, 1),
(86, '2024-07-22 02:24:50', 'F', 0, 0, 2, 1),
(87, '2024-07-22 02:24:51', 'F', 0, 0, 2, 1),
(88, '2024-07-22 02:24:52', 'F', 0, 0, 2, 1),
(89, '2024-07-22 02:24:53', 'F', 0, 0, 2, 1),
(90, '2024-07-22 02:24:54', 'F', 0, 0, 2, 1),
(91, '2024-07-22 02:24:55', 'F', 0, 0, 2, 1),
(92, '2024-07-22 21:37:30', 'Hola', 0, 0, 2, 6),
(93, '2024-07-22 21:37:35', 'hola\r\n', 0, 0, 2, 1),
(94, '2024-07-22 21:37:46', 'todo bien\r\n', 0, 0, 2, 1),
(95, '2024-07-22 21:38:06', 'Pasaremos la defensa?', 0, 0, 2, 1),
(96, '2024-07-22 21:38:25', 'UY\r\n', 0, 0, 2, 1),
(97, '2024-07-22 21:38:30', '😀', 0, 0, 2, 6),
(98, '2024-07-22 21:38:43', '🇺🇾', 0, 0, 2, 1),
(99, '2024-07-25 04:13:57', 'Hola', 0, 0, 1, 1),
(100, '2024-07-25 04:14:05', 'Epa', 0, 0, 4, 1),
(101, '2024-07-25 04:14:22', 'Que paso', 0, 0, 4, 1),
(102, '2024-07-25 17:24:42', 'Jajaj', 0, 0, 5, 1),
(103, '2024-07-26 05:22:27', 'Buenas grupo', 0, 0, 6, 1),
(104, '2024-08-03 04:41:30', 'Je', 0, 0, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas_juegos`
--

CREATE TABLE `plataformas_juegos` (
  `id_juego` int(11) NOT NULL,
  `plataforma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plataformas_juegos`
--

INSERT INTO `plataformas_juegos` (`id_juego`, `plataforma`) VALUES
(1, 'android'),
(1, 'windows'),
(3, 'linux'),
(3, 'windows'),
(23, 'windows'),
(25, 'android'),
(25, 'apple'),
(25, 'linux'),
(25, 'windows'),
(40, 'android'),
(40, 'apple'),
(40, 'linux'),
(40, 'windows'),
(41, 'windows'),
(42, 'windows'),
(43, 'android'),
(43, 'apple'),
(43, 'linux'),
(43, 'windows'),
(44, 'android'),
(44, 'windows'),
(45, 'android'),
(45, 'windows');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas_chat`
--

CREATE TABLE `salas_chat` (
  `id` int(11) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `id_creador` int(11) NOT NULL,
  `fecha_creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salas_chat`
--

INSERT INTO `salas_chat` (`id`, `tema`, `descripcion`, `oculto`, `borrado`, `id_creador`, `fecha_creado`) VALUES
(1, 'Tema', 'Una desc', 0, 1, 1, '2024-07-18 22:22:19'),
(2, 'Tema 2', 'Desc 2', 0, 0, 1, '2024-07-19 22:22:30'),
(3, 'Tema 3', 'Desc 3', 0, 0, 3, '2024-07-01 22:22:34'),
(4, 'sdfdf', 'dfsfsdf', 0, 1, 1, '2024-07-04 22:22:41'),
(5, 'Discutamos', 'Discusiones discusiones discusiones', 0, 1, 1, '0000-00-00 00:00:00'),
(6, 'Otro grupo igual', 'JIJIJI', 0, 0, 3, '2024-07-25 22:33:06'),
(7, 'Tema 1.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:19:43'),
(8, 'Tema 2.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:20:14'),
(9, 'Tema 3.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:20:30'),
(10, 'Tema 4.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:20:39'),
(11, 'Zema 5.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:23:24'),
(12, 'Zema 6.0', 'Descripcion', 0, 0, 3, '2024-07-26 18:23:40'),
(13, 'Zema .0', 'Descripcion', 0, 0, 3, '2024-07-26 18:23:49'),
(14, 'Zema 8.0', 'Descripcion', 0, 1, 3, '2024-07-26 18:24:07'),
(15, 'Constantinoplia 9.0', 'Descripcion', 0, 1, 3, '2024-07-26 18:24:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspensiones`
--

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

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `clave` char(60) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `fecha_registro` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `sobre_mi` varchar(255) NOT NULL DEFAULT '',
  `foto_perfil` varchar(255) NOT NULL DEFAULT 'assets/images/default_profile_icon.png',
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `nivel_acceso` int(11) NOT NULL DEFAULT 2,
  `token` varchar(36) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo_electronico`, `clave`, `nombre`, `fecha_registro`, `activo`, `sobre_mi`, `foto_perfil`, `borrado`, `nivel_acceso`, `token`) VALUES
(1, 'admin@admin.com', '$2y$10$74P58tk4DZZ/hj2KwWwd3OnxIkBRpoO8gwDnEkPhS2CXWbjKYTLrG', 'adminadmin', '2024-03-26', 1, 'Soy el admin123', 'uploads/profiles/1.jpg', 0, 4, '171686ad-51de-11ef-9ddd-03dd4de69e62'),
(3, 'pepe@axax.com', '$2y$10$jfY0aajm7cmL70nHwwPyZuDpXz12UtcTlVI3D1bID0WXEsFmqh3/O', 'pepe1234', '0000-00-00', 1, '', 'assets/images/default_profile_icon.png', 0, 2, 'fe6ca517-5143-11ef-9ddd-03dd4de69e62'),
(4, 'garcia@correo.com', '$2y$10$38IISO0T.HWIGHsM6ZHpxe.wIpWbxoApS0zft7sF6cTHphD7VWWq2', 'garcia1234', '2024-04-01', 1, '', 'assets/images/default_profile_icon.png', 0, 2, '604c89fa-3fd1-11ef-a6e7-fc3fdbffb53b'),
(5, 'comunista4ever@redmail.com', '$2y$10$h3c57ag63EWcUEIu6l8RYOh9sx4nXjWIdEkBXL.pmIG1zmZurJnou', 'carlmaxx', '2024-05-17', 1, '', 'assets/images/default_profile_icon.png', 0, 3, '604c8b32-3fd1-11ef-a6e7-fc3fdbffb53b'),
(6, 'alex@correo.com', '$2y$10$WdgebomFSelc0vRaduxg8OiCCX/tGNhJ4XoKPeZ61.jXlpUtSZeEi', 'alexanderloco', '2024-07-19', 1, '', 'assets/images/default_profile_icon.png', 0, 2, '1b5407d3-51ec-11ef-9ddd-03dd4de69e62'),
(7, 'cantare816@gmail.com', '$2y$10$.nLN88JfAuzPdcN1mfAFDebrYLJ7vPfHLErF.nzXKx9NxLe2.I/eK', 'Bikeruru23', '2024-07-20', 1, '', 'assets/images/default_profile_icon.png', 0, 2, 'c6dba8dd-4648-11ef-ae23-31a8b698d76f'),
(8, 'alexanderalmeida20@gmail.com', '$2y$10$ZUYQo87m3YSwGQfKnPcRtucMJQcZjTx5hp7D1K8oIV4s6rz2cDw0u', 'usuario1', '2024-08-03', 1, 'Soy el usuario #1', 'assets/images/default_profile_icon.png', 0, 2, 'f5ce4b89-51dd-11ef-9ddd-03dd4de69e62'),
(10, 'otrocorreo@correo.com', '$2y$10$rb4Z5fLB5J.MbGlS/EFtH.lFTh6pbB0bGfLp4W/9purwalav94xDC', 'usuario2', '2024-08-03', 1, 'Soy el usuario 2', 'assets/images/default_profile_icon.png', 0, 2, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ingresan_salas`
--

CREATE TABLE `usuarios_ingresan_salas` (
  `id_usuario` int(11) NOT NULL,
  `id_sala_chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_ingresan_salas`
--

INSERT INTO `usuarios_ingresan_salas` (`id_usuario`, `id_sala_chat`) VALUES
(1, 14),
(1, 15),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ven_juegos`
--

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
(1, 3, 1, 0),
(1, 4, 1, 0),
(1, 5, 0, 0),
(1, 6, 0, 0),
(1, 7, 0, 0),
(2, 1, 0, 0),
(2, 3, 0, 0),
(2, 4, 1, 0),
(2, 5, 0, 0),
(3, 1, 1, 0),
(3, 3, 0, 0),
(3, 5, 1, 0),
(3, 6, 0, 0),
(4, 1, 0, 0),
(4, 3, 0, 0),
(4, 4, 0, 0),
(5, 1, 1, 0),
(5, 3, 1, 0),
(6, 3, 0, 0),
(6, 4, 0, 0),
(6, 5, 1, 0),
(7, 1, 1, 0),
(7, 3, 0, 0),
(8, 3, 0, 0),
(8, 4, 1, 0),
(8, 5, 0, 0),
(9, 1, 1, 0),
(9, 3, 1, 0),
(10, 4, 0, 0),
(10, 5, 1, 0),
(11, 1, 1, 0),
(11, 3, 1, 0),
(12, 1, 0, 0),
(12, 4, 0, 0),
(12, 5, 1, 0),
(13, 1, 1, 0),
(13, 3, 0, 0),
(14, 1, 0, 0),
(14, 4, 1, 0),
(14, 5, 0, 0),
(15, 1, 1, 0),
(15, 3, 1, 0),
(16, 4, 0, 0),
(16, 5, 1, 0),
(17, 1, 1, 0),
(17, 3, 1, 0),
(18, 1, 0, 0),
(18, 4, 0, 0),
(18, 5, 1, 0),
(19, 1, 1, 0),
(19, 3, 1, 0),
(20, 4, 0, 0),
(20, 5, 1, 0),
(21, 1, 1, 0),
(22, 1, 0, 0),
(23, 1, 0, 0),
(24, 1, 0, 0),
(24, 3, 0, 0),
(25, 1, 1, 0),
(25, 3, 1, 0),
(26, 1, 1, 0),
(26, 3, 0, 0),
(39, 1, 0, 0),
(40, 1, 0, 0),
(41, 1, 0, 0),
(41, 3, 0, 0),
(42, 1, 0, 0),
(43, 3, 1, 0),
(44, 1, 1, 0),
(44, 3, 0, 0),
(45, 1, 0, 0),
(46, 6, 0, 0);

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
-- Indices de la tabla `categorias_destacadas`
--
ALTER TABLE `categorias_destacadas`
  ADD PRIMARY KEY (`orden`),
  ADD KEY `id_categoria` (`id_categoria`);

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
ALTER TABLE `juegos` ADD FULLTEXT KEY `datos_juego` (`titulo`,`descripcion`);

--
-- Indices de la tabla `juegos_destacados`
--
ALTER TABLE `juegos_destacados`
  ADD PRIMARY KEY (`id_juego`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_creador` (`id_creador`);

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
ALTER TABLE `usuarios` ADD FULLTEXT KEY `nombre_usuario` (`nombre`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categorias_destacadas`
--
ALTER TABLE `categorias_destacadas`
  MODIFY `orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `salas_chat`
--
ALTER TABLE `salas_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `suspensiones`
--
ALTER TABLE `suspensiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Filtros para la tabla `categorias_destacadas`
--
ALTER TABLE `categorias_destacadas`
  ADD CONSTRAINT `categorias_destacadas_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

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
-- Filtros para la tabla `salas_chat`
--
ALTER TABLE `salas_chat`
  ADD CONSTRAINT `salas_chat_ibfk_1` FOREIGN KEY (`id_creador`) REFERENCES `usuarios` (`id`);

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
