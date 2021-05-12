-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2021 a las 19:05:05
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bolsaempleo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Madera'),
(2, 'Informatica'),
(3, 'Educacion'),
(4, 'Automoviles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210316122517', '2021-03-16 13:27:52', 1426),
('DoctrineMigrations\\Version20210317103046', '2021-03-17 11:31:59', 9498),
('DoctrineMigrations\\Version20210317103531', '2021-03-17 11:35:35', 813),
('DoctrineMigrations\\Version20210317103635', '2021-03-17 11:38:28', 1068),
('DoctrineMigrations\\Version20210318103038', '2021-03-18 11:32:38', 1744),
('DoctrineMigrations\\Version20210422105833', '2021-04-22 12:58:54', 582),
('DoctrineMigrations\\Version20210424141115', '2021-04-24 16:12:09', 4899),
('DoctrineMigrations\\Version20210425111401', '2021-04-25 13:15:14', 5717),
('DoctrineMigrations\\Version20210502092457', '2021-05-02 11:25:07', 7207),
('DoctrineMigrations\\Version20210502102502', '2021-05-02 12:25:09', 583);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `cif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `cif`, `nombre`, `pass`, `correo`, `telefono`, `direccion`, `codigo_postal`, `pais`, `provincia`, `localidad`, `descripcion`) VALUES
(1, '543633453', 'SkeletonJobs SL', '$2y$10$25X9OH0lfCcpnGg.VMx6AeBHz9MEXxnMcyUWzsTztA5.PAER84.jm', 'SkeletonJobs@gmail.com', 666666666, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '6456546', 'Pepe SL', '$2y$10$5baKNIo0gujneON.SaoUSuLjBLKCFB17MWbMm2B0cCb2zALUjlkfm', 'pepesl@gmail.com', 659784545, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'e341234', 'asdf', '$2y$10$.99bzEGotFvrRTtKDr4W7.BZWu2Qija38V6SBH2lHgEIOh4hxM/r.', 'asd@gmail.com', 156141817, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '123456789', 'Juan SL', '$2y$10$9V4mzP7.p7ldhhSCXOMOOO2iNYMgfmeIeU974INdSeVpnRqqRt7Hi', 'juansl@hotmail.com', 625141815, NULL, NULL, NULL, NULL, NULL, 'somos una empresa muy seria'),
(5, '4564847', 'Paco SL', '$2y$10$KYRC1ZsoDAHI7lBrgMViOe5em7yC9CruKbQbniuTgjCwo6bNBVgzy', 'pacosl@gmail.com', 652141517, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '4564847', 'Paco Empresa', '$2y$10$3326E.aTIZRzZfSutWb34O7UEQKY.bPF.RotiR452DQwN7fim5hGK', 'ftrujillo9711@gmail.com', 625151418, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `islas`
--

CREATE TABLE `islas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `islas`
--

INSERT INTO `islas` (`id`, `nombre`) VALUES
(1, 'La Palma'),
(2, 'La Gomera'),
(3, 'El Hierro'),
(4, 'Tenerife'),
(5, 'Gran Canaria'),
(6, 'Fuerteventura'),
(7, 'Lanzarote'),
(8, 'La Graciosa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `islas_ofertas`
--

CREATE TABLE `islas_ofertas` (
  `islas_id` int(11) NOT NULL,
  `ofertas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `islas_ofertas`
--

INSERT INTO `islas_ofertas` (`islas_id`, `ofertas_id`) VALUES
(4, 32),
(5, 32),
(6, 32),
(7, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `id_empresa_id` int(11) NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `puesto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `borrador` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `id_empresa_id`, `descripcion`, `puesto`, `fecha`, `tipo`, `categoria_id`, `provincia`, `activo`, `borrador`) VALUES
(4, 5, 'Deberá desempeñar las funciones de montador de carpintería de aluminio y de PVC, techos, mamparas, cerramientos y todo lo relacionado con la instalación.', 'Montador de carpintería de PVC', '2021-03-19', 'Jornada completa', 1, NULL, 1, 0),
(5, 5, 'Buscamos una persona dinámica, polivalente y resolutiva para las siguientes labores:\r\n\r\n-Reparación de todo tipo de equipos informáticos a nivel de software y hardware.\r\n-Soporte y atención a clientes\r\n-Detección y resolución de incidencias\r\n-Gestión de puestos de trabajo, redes, servidores, etc\r\n-Trabajo en equipo', 'Técnico Informático', '2021-04-12', 'Jornada completa', 2, NULL, 1, 0),
(6, 4, ' Empresa que presta servicios de Formación Superior y Consultoría, busca incorporar Gestor/a de Proyectos de Innovación.', 'Gestor/a de Proyectos de Innovación.', '2021-04-08', 'Jornada Completa', 3, NULL, 1, 0),
(7, 5, 'Se precisa docente de lengua inglesa.', 'Docente de lengua inglesa', '2021-03-31', 'Jornada Completa', 4, NULL, 1, 0),
(10, 5, 'Pequeña empresa de servicios de comunicación especializada en proyectos europeos busca PROGRAMADOR/A.', 'PROGRAMADOR/A. app JUNIOR', '2021-04-07', 'Contrato Temporal', 3, NULL, 1, 0),
(11, 4, ' Si crees que otra educación es posible, ésta es tu oportunidad. Desarrolla tu carrera profesional y sigue a tus compañeros/as. (Debido al COVID-19 el proceso de selección es on-line)', 'Maestro/a de educacion infantil', '2021-04-17', 'Jornada Completa', 3, NULL, 1, 0),
(24, 4, 'Impartir clases para preparar oposiciones de educación en Donostia en las ramas de:\r\nDBH gorputz hezkuntza,\r\nDBH fisika,\r\nDBH geografia eta historia,\r\nDBH matematika,\r\nDBH Orientatzaile,\r\nDBH Ingelesa y\r\nLH pedagogia terapeutikoa', 'Profesor de oposición de educación', '2021-04-24', 'Jornada Completa', 1, NULL, 1, 0),
(25, 4, 'El puesto consiste en cubrir la tutoría y asignaturas de un grupo de Sexto de Primaria así como las horas de Educación Física de los grupos de Quinto y Sexto de Primaria.', 'Profesor de Educación Física', '2021-04-24', 'Jornada Completa', 3, NULL, 1, 0),
(27, 4, 'Buscamos un mecánico/a - personal de ventas para importante empresa del sector de la automoción.', 'Mecánico/a - personal de ventas', '2021-04-24', 'Jornada Completa', 4, NULL, 1, 0),
(28, 4, 'Dominio de maquinaria y utillaje propios de la Industria del Metal.\r\n- Persona metódica, organizada, versátil y con especial atención por los detalles. Con capacidad para trabajar en equipo.', 'Oficial de carpintería mecánica', '2021-04-24', 'Jornada Completa', 1, NULL, 1, 0),
(29, 4, 'Se precisa oficial de carpinteria de madera, requisito imprescindible del cantidato es demostrar experiencia demostrable, .', 'Oficial de carpinteria', '2021-04-24', 'Jornada Completa', 1, NULL, 1, 0),
(30, 4, 'Debido a la ampliación del departamento, buscamos un programador web para desarrollo aplicaciones web con:\r\n\r\n- ASP Clásico/.NET o Visual Basic/VBA\r\n- HTML/5- bootstrap, Javascript- PHP, preferiblemente LARAVEL\r\n- SQL imprescindible. Conocimientos básicos herramientas BBDD SQL Server/Mysql.\r\n- También ofrecerá soporte telefónico a clientes de la propia aplicación.', 'Programador Web', '2021-04-24', 'Jornada Completa', 2, NULL, 1, 0),
(31, 4, ' Buscamos una persona que aporte experiencia como Programador/a Senior Java con la versión 6 y conocimiento de Struts para trabajar en el mantenimiento de una aplicación de un cliente del sector Bancario', 'Programador/a Senior', '2021-04-24', 'Jornada Completa', 1, NULL, 1, 0),
(32, 4, 'Buscamos un perfil de Programador C++ con experiencia en Oracle, para importante cliente en Málaga.\r\n\r\nMuy valorable experiencia con CORBA.', 'Programador/a C++ Oracle', '2021-04-24', 'Jornada Completa', 2, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `oferta_id` int(11) NOT NULL,
  `pregunta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requerido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `pass`, `dni`, `correo`, `fecha_nacimiento`, `telefono`, `direccion`, `codigo_postal`, `pais`, `provincia`, `localidad`, `cv`, `descripcion`) VALUES
(4, 'Eric', 'Alvarado Ruano', '$2y$10$lIBXQcWbqE0F.WNRBGiBs.IpOBaUD1QFvqfnxaVnCIhJqJiOi6jAK', '45331025A', 'ericjackson199@gmail.com', '1995-04-20', 620357850, 'Triana', 35002, 'España', 'Las Palmas', 'Las Palmas de Gran Canaria', 'EricAlvaradoRuano-6088799f2e6bb.html', 'Soy un chico sexy'),
(5, 'Pepe', 'Suarez', '$2y$10$VL/lqUOmXA3w894Df.n6vuSAtCNU3lxlAvxxrQofJC/qFJsrlNBs2', '45333333F', 'pepe@gmail.com', '1950-03-05', 666666666, 'mi casa', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Paco', 'Trujillo', '$2y$10$f09z/NLyjAqF1hyMTOCxyu.9zB5B0dBxlhUsaf8jihTPKoVxlH4S6', '45181514L', 'paco@gmail.com', '1997-03-14', 620151414, 'en mi casa', NULL, NULL, NULL, NULL, 'Instalar-Tomcat-en-Ubuntu-Francisco-Jose-Trujillo-Jimenez-6071992a59f79.pdf', NULL),
(7, 'Francisco', 'Trujillo', '$2y$10$ex/rIQRfwkzflMrUJXeDjugv3Q2eq9wklG3GBuKFlGJHJAvNMlCTG', '4444441P', 'ftrujillo9711@gmail.com', '2021-04-13', 925154147, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Manolo', 'Alvarez', '$2y$10$zuthlk8GQZZK/gf1PcyhVeW7GGcZFPT9SR0VAEmiRxzKQAfnOLldS', '45331022F', 'rikdweof@gmail.com', '1334-03-12', 2147483647, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Alfonso', 'Alvarez', '$2y$10$xmi8Nv2lQZ2d7m71Rs2NF.q46V8IVd9qaH0myimD/PANIZKsFvMvi', '44444444E', 'alfonso@gmail.com', '2001-06-14', 654343232, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Usuario', 'Ramirez', '$2y$10$DrzqUeeWsx7g/blwpnBayeRvvY/OXKC/8MIFYfuSLNfTK7gWed926', '45454545', 'temek38411@87708b.com', '2007-02-02', 925154147, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'ASDASJID', 'ajdsfkas', '$2y$10$tgWNP.Xh14ilojoJTV2yueWzTOt/qiLHvfKyLGPKCkYbOK8maZb4W', '444444A', 'asssfdhsajkfsdafhdsi@yopmail.com', '1994-05-21', 625151415, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_empresas_ofertas`
--

CREATE TABLE `usuarios_empresas_ofertas` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `id_empresa_id` int(11) NOT NULL,
  `ofertas_id` int(11) NOT NULL,
  `descartado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_empresas_ofertas`
--

INSERT INTO `usuarios_empresas_ofertas` (`id`, `usuarios_id`, `id_empresa_id`, `ofertas_id`, `descartado`) VALUES
(13, 7, 4, 25, NULL),
(25, 7, 5, 5, NULL),
(26, 7, 4, 6, NULL),
(27, 4, 4, 11, NULL),
(28, 4, 4, 29, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `islas`
--
ALTER TABLE `islas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `islas_ofertas`
--
ALTER TABLE `islas_ofertas`
  ADD PRIMARY KEY (`islas_id`,`ofertas_id`),
  ADD KEY `IDX_21A04A764CE82CC3` (`islas_id`),
  ADD KEY `IDX_21A04A76DB88A202` (`ofertas_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_48C925F3F7949946` (`id_empresa_id`),
  ADD KEY `IDX_48C925F33397707A` (`categoria_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_38794855FAFBF624` (`oferta_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5CD06EB1DB38439E` (`usuario_id`),
  ADD KEY `IDX_5CD06EB131A5801E` (`pregunta_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_empresas_ofertas`
--
ALTER TABLE `usuarios_empresas_ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FBB6ACFEF01D3B25` (`usuarios_id`),
  ADD KEY `IDX_FBB6ACFEDB88A202` (`ofertas_id`),
  ADD KEY `IDX_FBB6ACFEF7949946` (`id_empresa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `islas`
--
ALTER TABLE `islas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios_empresas_ofertas`
--
ALTER TABLE `usuarios_empresas_ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `islas_ofertas`
--
ALTER TABLE `islas_ofertas`
  ADD CONSTRAINT `FK_21A04A764CE82CC3` FOREIGN KEY (`islas_id`) REFERENCES `islas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_21A04A76DB88A202` FOREIGN KEY (`ofertas_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `FK_48C925F33397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `FK_48C925F3F7949946` FOREIGN KEY (`id_empresa_id`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `FK_38794855FAFBF624` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `FK_5CD06EB131A5801E` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `FK_5CD06EB1DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios_empresas_ofertas`
--
ALTER TABLE `usuarios_empresas_ofertas`
  ADD CONSTRAINT `FK_FBB6ACFEDB88A202` FOREIGN KEY (`ofertas_id`) REFERENCES `ofertas` (`id`),
  ADD CONSTRAINT `FK_FBB6ACFEF01D3B25` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FK_FBB6ACFEF7949946` FOREIGN KEY (`id_empresa_id`) REFERENCES `empresas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
