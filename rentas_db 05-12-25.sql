-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2025 a las 21:01:15
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
-- Base de datos: `rentas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colonia`
--

CREATE TABLE `colonia` (
  `id_colonia` int(11) NOT NULL,
  `id_municipio` int(11) DEFAULT NULL,
  `nombre_colonia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colonia`
--

INSERT INTO `colonia` (`id_colonia`, `id_municipio`, `nombre_colonia`) VALUES
(1, 4, 'Indeco'),
(2, 4, 'Casa Blanca 1a Sección'),
(3, 4, 'Casa Blanca 2a Sección'),
(4, 4, 'Espejo 1'),
(5, 4, 'Espejo 2'),
(6, 4, 'Loma Linda'),
(7, 4, 'Linda Vista'),
(8, 4, 'Reforma'),
(9, 4, 'Guayabal'),
(10, 4, 'Nueva Imagen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id_municipio` int(11) NOT NULL,
  `nombre_municipio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_municipio`, `nombre_municipio`) VALUES
(1, 'Balancán'),
(2, 'Cárdenas'),
(3, 'Centla'),
(4, 'Centro'),
(5, 'Comalcalco'),
(6, 'Cunduacán'),
(7, 'Emiliano Zapata'),
(8, 'Huimanguillo'),
(9, 'Jalapa'),
(10, 'Jalpa de Méndez'),
(11, 'Jonuta'),
(12, 'Macuspana'),
(13, 'Nacajuca'),
(14, 'Paraíso'),
(15, 'Tacotalpa'),
(16, 'Teapa'),
(17, 'Tenosique');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id_propiedad` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_colonia` int(11) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id_propiedad`, `id_usuario`, `id_tipo`, `id_colonia`, `titulo`, `descripcion`, `precio`, `direccion`, `foto`, `fecha_publicacion`) VALUES
(1, 1, 1, 1, 'Casa en renta en Indeco', 'Casa amplia cerca de escuelas y supermercados. 3 recámaras, 2 baños y cochera. Perfecto para familias grandes que necesitan una casa     espaciosa. Cuenta con todos los servicios necesarios, amueblada.', 12000.00, 'Calle Principal #45', 'fotos_viviendas/vivienda3.png', '2025-12-01 07:32:05'),
(8, 1, 2, 1, 'Departamento en Indeco', 'Bonito departamento en Indeco', 10000.00, 'Calle #14', 'fotos_viviendas/693331800e44c_vivienda2.png', '2025-12-05 19:24:48'),
(9, 2, 1, 4, 'Casa en Espejo I', 'Bonita casa en la colonia Espejo I', 12000.00, 'Calle Poniente #345', 'fotos_viviendas/6933324281a37_vivienda1.png', '2025-12-05 19:28:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`) VALUES
(1, 'Amueblada'),
(2, 'Mascotas permitidas'),
(3, 'Garage'),
(4, 'Agua potable'),
(5, 'Luz'),
(6, 'Cerca de centros comerciales'),
(7, 'Transporte cercano'),
(8, 'Aire acondicionado'),
(9, 'Wifi'),
(10, 'Cuarto compartido'),
(11, 'Patio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_propiedades`
--

CREATE TABLE `servicios_propiedades` (
  `id_propiedad` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_propiedades`
--

INSERT INTO `servicios_propiedades` (`id_propiedad`, `id_servicio`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_propiedad`
--

CREATE TABLE `tipo_propiedad` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_propiedad`
--

INSERT INTO `tipo_propiedad` (`id_tipo`, `nombre_tipo`) VALUES
(1, 'Casa'),
(2, 'Departamento'),
(3, 'Cuarto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(15) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `whatsapp`, `foto_perfil`, `fecha_registro`, `descripcion`) VALUES
(1, 'Juan Pérez', 'juanperez@hotmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '+529931013196', 'fotos_usuarios/juanperez.png', '2025-12-01 07:25:31', 'Hola, soy Juan Pérez, propietario con más de 5 años de experiencia en alquileres. Me esfuerzo por ofrecer viviendas cómodas y bien mantenidas para asegurar una estancia agradable a mis inquilinos. ¡Estoy aquí para ayudarte a encontrar tu próximo hogar!'),
(2, 'Lezlye Guerrero', 'lezlyeguerrero2004@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '9931013196', 'fotos_usuarios/693331edab212_CV.jpg', '2025-12-05 19:26:37', 'Hola, me llamo Lezlye');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colonia`
--
ALTER TABLE `colonia`
  ADD PRIMARY KEY (`id_colonia`),
  ADD KEY `id_municipio` (`id_municipio`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id_propiedad`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_colonia` (`id_colonia`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `servicios_propiedades`
--
ALTER TABLE `servicios_propiedades`
  ADD PRIMARY KEY (`id_propiedad`,`id_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `tipo_propiedad`
--
ALTER TABLE `tipo_propiedad`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colonia`
--
ALTER TABLE `colonia`
  MODIFY `id_colonia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id_propiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_propiedad`
--
ALTER TABLE `tipo_propiedad`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `colonia`
--
ALTER TABLE `colonia`
  ADD CONSTRAINT `colonia_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id_municipio`);

--
-- Filtros para la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `propiedades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `propiedades_ibfk_2` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_propiedad` (`id_tipo`),
  ADD CONSTRAINT `propiedades_ibfk_3` FOREIGN KEY (`id_colonia`) REFERENCES `colonia` (`id_colonia`);

--
-- Filtros para la tabla `servicios_propiedades`
--
ALTER TABLE `servicios_propiedades`
  ADD CONSTRAINT `servicios_propiedades_ibfk_1` FOREIGN KEY (`id_propiedad`) REFERENCES `propiedades` (`id_propiedad`),
  ADD CONSTRAINT `servicios_propiedades_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
