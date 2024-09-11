-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2024 a las 18:17:47
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
-- Base de datos: `international`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_libros`
--

CREATE TABLE `cliente_libros` (
  `cliente_id` int(11) NOT NULL,
  `libro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente_libros`
--

INSERT INTO `cliente_libros` (`cliente_id`, `libro_id`) VALUES
(34, 17),
(34, 18),
(35, 17),
(35, 18),
(36, 16),
(36, 17),
(36, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `visible_para_cliente` tinyint(1) DEFAULT 0,
  `pdf_url` varchar(255) DEFAULT NULL,
  `portada_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `contenido`, `visible_para_cliente`, `pdf_url`, `portada_url`) VALUES
(16, 'El SISTEMA DE GESTIÓN DOCUMENTAL-Módulo 1', 'Generalidades del Sistema\r\nGAITÁN DIDIER, María Claudia, MESA ACHURY, Ana Rosalba.\r\n2007', 0, '../visorpdf/modulo1.html', 'uploads/portadas/libro modulo 1.jpg'),
(17, 'El SISTEMA DE GESTIÓN DOCUMENTAL-Módulo 2', '\r\nCaracteristicas del documento electronico\r\nGadier Profesionales de Informacion.\r\n2022', 0, '../visorpdf/modulo2.html', 'uploads/portadas/Imagen libro nuevo 1.jpg\r\n'),
(18, 'NORMATIVIDAD DE LA GESTIÓN DOCUMENTAL', '\r\nCLAUDIA GAITAN DIDIER\r\nCOMPILADORA\r\n2007', 0, '../visorpdf/norma.html', 'uploads/portadas/1723731861397.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('cliente','admin') NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contrasena`, `rol`, `telefono`, `nombre_cliente`, `email`, `fecha_registro`, `estado`) VALUES
(22, 'JhefryH', '$2y$10$tv2PjsKVoFqBwL2j607PkeXd/bSmgfHC1TNiv5j5wwT1CrAix5rNa', 'admin', '3157762008', 'Jhefry Herrera', 'jhefrygerador.herrera@gmail.com', '2024-09-10', 'activo'),
(23, 'FelixB', '$2y$10$YQaeDUOAynJbBnYILuamZ.laExZU4YZ6uVi0veLD/V7Nfon6QO0G6', 'admin', '31245875', 'Felix Buelvas', 'sistemas@gadier.com', '2024-09-10', 'activo'),
(29, 'StivenR', '$2y$10$vM2iKfN/YgHWlxnapkwFCuaB6YEqyGFT0JZZlJJE51Er.B./xNnlW', 'admin', '310352985', 'Stiven Rodriguez', 'wsrodriguez98@gmail.com', '2024-09-10', 'activo'),
(34, 'felix', '$2y$10$ifFz06GI5bEDJArH5JzKkegcjoQZzADK.4hpFADVD0ykXTvr.hQcG', 'cliente', '3103088872', 'felix', 'desarrolloweb1@gadiersistemas.com', '2024-09-10', 'activo'),
(35, 'JenniferLo', '$2y$10$71eM8C9Oqk3BeMa.yfSvv.GVldfon4C018qlpthLi15yekFfpdNmu', 'cliente', '3029258741', 'Jennifer Lopez', 'jenniLG@gmail.com', '2024-09-10', 'activo'),
(36, 'JhefryHe', '$2y$10$da7NLHj1GdcdupwZIFAyW.TE8fjadwqAhGKmvKm4VyXyYIkdqQBS2', 'cliente', '3157762008', 'Jhefry Herrera', 'jhefryherreragerador.herrera@gmail.com', '2024-09-10', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente_libros`
--
ALTER TABLE `cliente_libros`
  ADD PRIMARY KEY (`cliente_id`,`libro_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente_libros`
--
ALTER TABLE `cliente_libros`
  ADD CONSTRAINT `cliente_libros_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `cliente_libros_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
