-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 15:12:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almacen_cdi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT INTO `beneficiarios` (`codigo`, `nombre`, `apellido`, `curso`, `puntos`) VALUES
(1, 'Juan', 'Pérez', 'Restauradores', 50),
(2, 'María', 'Gómez', 'Triunfadores', 25),
(3, 'Carlos', 'Rodríguez', 'Triunfadores', 30),
(4, 'Lucía', 'Fernández', 'Pre gap', 50),
(5, 'Pedro', 'Martínez', 'Pre gap', 20),
(6, 'Ana', 'López', 'Restauradores', 20),
(7, 'José', 'Hernández', 'Triunfadores', 40),
(8, 'Laura', 'García', 'Pre gap', 55),
(9, 'Miguel', 'Torres', 'Pre gap', 10),
(10, 'Carmen', 'Sánchez', 'Gap', 85),
(11, 'Luis', 'Ramírez', 'Pre gap', 65),
(12, 'Elena', 'Díaz', 'Triunfadores', 45),
(13, 'David', 'Morales', 'Triunfadores', 70),
(14, 'Sara', 'Vargas', 'Restauradores', 25),
(15, 'Jorge', 'Rojas', 'Restauradores', 15),
(16, 'Marta', 'Castro', 'Restauradores', 40),
(17, 'Raúl', 'Ortiz', 'Gap', 60),
(18, 'Rosa', 'Cruz', 'Gap', 70),
(19, 'Víctor', 'Mendoza', 'Pre gap', 80),
(20, 'Natalia', 'Jiménez', 'Restauradores', 20),
(800, 'Luis', 'Mamani', 'Gap', 180);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `codigo_beneficiario` varchar(50) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `puntos_gastados` int(11) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `codigo_beneficiario`, `producto_id`, `cantidad`, `puntos_gastados`, `fecha_entrega`) VALUES
(3, '1', 15, 1, 20, '2024-10-11 21:12:09'),
(7, '11', 104, 1, 30, '2024-10-11 21:24:36'),
(11, '1', 7, 1, 15, '2024-10-13 20:11:56'),
(37, '1', 7, 1, 15, '2024-10-13 15:32:20'),
(44, '2', 108, 1, 10, '2024-10-13 21:24:36'),
(45, '2', 108, 1, 10, '2024-10-13 21:24:38'),
(46, '800', 13, 2, 120, '2024-10-13 21:35:42'),
(47, '800', 13, 2, 120, '2024-10-13 21:35:58'),
(48, '800', 16, 1, 100, '2024-10-13 21:35:58'),
(49, '800', 13, 2, 120, '2024-10-13 21:35:59'),
(50, '800', 16, 1, 100, '2024-10-13 21:35:59'),
(51, '5', 17, 1, 35, '2024-10-14 16:28:25'),
(52, '5', 17, 1, 35, '2024-10-14 16:28:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Item` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `puntos` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Item`, `nombre`, `descripcion`, `puntos`, `cantidad`) VALUES
(1, 'Yogurt frutado', 'lhkjh', 80, 62),
(2, 'Leches evaporadas', 'ads', 40, 32),
(3, 'Leche condensada', 'asd', 55, 78),
(4, 'Margarinas reyna 425 g', 'asd', 60, 55),
(5, 'Sardina', 'sd', 60, 80),
(6, 'Leche polvo 800 g', 'sdf', 140, 67),
(7, 'Fideo bolsa 400 g', 'sdf', 15, 51),
(8, 'Aceite 900 ml', 'asd', 45, 63),
(9, 'Azúcar bolsa 2 kg', 'asd', 45, 51),
(10, 'Aceite 4.5 L', 'asd', 275, 40),
(11, 'Lenteja bol. 1 kg', 'd', 60, 24),
(12, 'Picadillo', 'asd', 15, 95),
(13, 'Duraznos en mitades 820 g', 'dsdf', 60, 161),
(14, 'Avena instantánea', 'fg', 40, 240),
(15, 'Gelatina 230 g', 'wer', 20, 304),
(16, 'Kriskao clásico 1 kg', 're', 100, 379),
(17, 'Maicena caja 400 g', 'wer', 35, 449),
(18, 'Cereales bolsa', 'sdf', 150, 524),
(19, 'Mermeladas pequeñas', 'qwe', 25, 594),
(20, 'Galleta crackers 1 kg', 'das', 125, 666),
(21, 'Galleta cracker 1/2 kilo', 'dsdf', 70, 737),
(22, 'Huevo 30 und', 'sdf', 110, 808),
(23, 'Yogurt 2 litros', 'dfs', 90, 879),
(51, 'Marcador 12 pzas', 'asds', 65, 54),
(56, 'Colores 12 pzas largos', 'dasd', 65, 42),
(57, 'Hojas carpeta', 'sdasdasdas', 115, 54),
(58, 'Papel bond carta', 'fgd', 125, 55),
(59, 'Papel bond oficio', 'ghg', 150, 34),
(60, 'Cuadernos espiral 1/2 oficio', 'dasd', 30, 67),
(61, 'Cuadernos espiral carta', 'asd', 55, 34),
(62, 'Lápiz negro', 'sdf', 5, 89),
(63, 'Papel bond color carta', 'sdasdasdsdass', 290, 54),
(64, 'Papel bond color oficio', 'asd', 310, 43),
(65, 'Pegamento de isocola 80', 'asdas', 30, 21),
(66, 'Pegamento barra', 'asd', 45, 87),
(68, 'Estuche geométrico', 'asdd', 30, 54),
(70, 'Borrador', 'sdf', 5, 34),
(100, 'Alcohol gel 390 ml', 'dfdg', 65, 43),
(101, 'Jabón líquido 370 ml', 'fgdfg', 45, 23),
(103, 'Shampoo grande', 'gfbfb', 65, 67),
(104, 'Crema de zapato', 'rdfgd', 30, 51),
(105, 'Lavandina 1 L', 'rgdd', 60, 878),
(108, 'Cepillo dental', 'sdf', 10, 442),
(109, 'Detergente 200g pequeño', 'ser', 25, 34),
(110, 'Jaboncillo', 'sdf', 15, 455),
(112, 'Colgate 180g', 'sr', 50, 34),
(113, 'Alcohol 1 L', 'sdfsr', 60, 65),
(114, 'Barbijo', 'vssd', 75, 65);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_entregados`
--

CREATE TABLE `productos_entregados` (
  `id_entrega` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_beneficiario` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `puntos` int(11) DEFAULT 0,
  `tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasena`, `puntos`, `tipo`) VALUES
(1, 'cdi', 'cdi608', 0, 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Item`);

--
-- Indices de la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
  ADD PRIMARY KEY (`id_entrega`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_beneficiario` (`id_beneficiario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=801;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT de la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
  MODIFY `id_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
  ADD CONSTRAINT `productos_entregados_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`Item`),
  ADD CONSTRAINT `productos_entregados_ibfk_2` FOREIGN KEY (`id_beneficiario`) REFERENCES `beneficiarios` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
