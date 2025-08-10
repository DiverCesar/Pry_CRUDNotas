-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 01:32:12
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
-- Base de datos: `admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Bebidas', 'Refrescos, jugos y aguas'),
(2, 'Snacks', 'Aperitivos y botanas'),
(3, 'Panadería', 'Pan, bollería y repostería'),
(4, 'Frutas', 'Deliciosas y frescas frutas del día'),
(6, 'Verduras', 'La vida es dura, pero más dura la verdura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(7, 7, 1, 1, 1.20),
(11, 11, 5, 1, 2.00),
(12, 12, 3, 3, 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `nombre_materia` varchar(250) NOT NULL,
  `nrc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre_materia`, `nrc`) VALUES
(1, 'DESARROLLO DE SOFTWARE SEGURO', 12345),
(2, 'PROGRAMACION WEB', 23245),
(5, 'BASE DE DATOS', 34523),
(6, 'COMPUTACION PARALELA', 36452),
(7, 'COMPUTACION DIGITAL', 37831),
(8, 'CALCULO VECTORIAL', 20254),
(9, 'ROBOTICA', 19281),
(10, 'USABILIDAD', 12103),
(11, 'WEB AVANZADA', 12780);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `nota1` decimal(5,2) NOT NULL,
  `nota2` decimal(5,2) NOT NULL,
  `nota3` decimal(5,2) NOT NULL,
  `promedio` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `id_usuario`, `id_materia`, `nota1`, `nota2`, `nota3`, `promedio`) VALUES
(1, 7, 2, 20.00, 20.00, 20.00, 20.00),
(2, 10, 2, 19.19, 17.48, 6.11, 14.26),
(3, 22, 1, 13.45, 14.35, 9.10, 12.30),
(4, 10, 1, 13.45, 12.56, 12.46, 12.82),
(5, 19, 2, 20.00, 20.00, 20.00, 20.00),
(6, 11, 1, 14.54, 12.45, 13.56, 13.52),
(7, 29, 2, 20.00, 20.00, 20.00, 20.00),
(8, 14, 2, 20.00, 20.00, 20.00, 20.00),
(9, 27, 6, 18.00, 16.00, 17.00, 17.00),
(10, 34, 5, 14.00, 17.00, 13.00, 14.67),
(11, 7, 1, 7.00, 8.00, 9.00, 8.00),
(12, 28, 2, 19.19, 17.45, 18.63, 18.42),
(14, 36, 1, 17.00, 18.00, 19.00, 18.00),
(15, 37, 2, 18.00, 19.00, 20.00, 19.00),
(18, 10, 7, 13.00, 10.00, 0.00, 7.67),
(19, 35, 8, 15.45, 16.73, 13.45, 15.21),
(20, 38, 9, 14.40, 13.40, 14.40, 14.07),
(21, 16, 10, 17.89, 18.90, 14.30, 17.03),
(22, 22, 11, 18.00, 19.00, 20.00, 19.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` enum('pendiente','procesando','completado','cancelado') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha`, `total`, `estado`) VALUES
(7, 22, '2025-08-01 14:00:30', 1.20, 'cancelado'),
(11, 26, '2025-08-04 01:39:19', 2.00, 'completado'),
(12, 27, '2025-08-04 03:11:35', 3.00, 'cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `id_categoria`) VALUES
(1, 'Coca-Cola 500ml', 'Refresco de cola', 1.20, 100, 1),
(2, 'Agua Mineral 600ml', 'Agua sin gas', 0.80, 150, 1),
(3, 'Papas Fritas', 'Snack de papa sabor original', 1.00, 200, 2),
(4, 'Galletas de Chocolate', 'Paquete de galletas', 1.50, 120, 2),
(5, 'Pan Integral 400g', 'Pan saludable integral', 2.00, 75, 3),
(6, 'Croissant', 'Bollería francesa', 1.75, 50, 3),
(9, 'Manzanilla', 'Fresca y dulce de manzano', 0.18, 20, 4),
(10, 'Zanahoria', 'Jefe conocido de un juego de tasas', 0.16, 23, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email`, `edad`) VALUES
(7, 'DiverCesar', 'cesar@gmail.com', 32),
(10, 'Cesitar', 'clgalarza@espe.edu.ec', 23),
(11, 'MPengu', 'maria@pengu.com', 9),
(12, 'David', 'david@web.com', 45),
(14, 'Pincho', 'flores@gmail.com', 34),
(16, 'OpaGabo', 'style@gmail.com', 14),
(19, 'Cesar Luis', 'clgalarza@gmail.com', 34),
(20, 'EnHonor', 'caidos@gmail.com', 34),
(22, 'Pengu', 'chiquito@gmail.com', 300),
(23, 'Pengu Chiquito', 'super@chiquito.com', 350),
(25, 'PenguGrande', 'chiquito@pescadito', 3),
(26, 'Aviici', 'levels@gmail.com', 21),
(27, 'Zoey', 'huntrix@gmail.com', 21),
(28, 'Estudiante', 'prueba@gmail.com', 23),
(29, 'Estudioso', 'estudiante@gmail.com', 32),
(34, 'Francis', 'gamer@gmail.com', 20),
(35, 'Francis', 'diver.cesar123@gmail.com', 90),
(36, 'Mario', 'bros@super.com', 45),
(37, 'Luigui', 'mario@super.com', 40),
(38, 'Allison', 'ardiaz@gmail.com', 30),
(39, 'Papu', 'papu@re.com', 34),
(40, 'Ricardo', 'milo@milos.com', 34),
(41, 'Baby', 'dont@hurtme.com', 39);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_pedido_pedidos` (`id_pedido`),
  ADD KEY `fk_detalle_pedido_productos` (`id_producto`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD UNIQUE KEY `uq_usuario_materia` (`id_usuario`,`id_materia`),
  ADD KEY `fk_notas_materia` (`id_materia`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedidos_usuarios` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_productos_categorias` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedido_pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_pedido_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_notas_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
