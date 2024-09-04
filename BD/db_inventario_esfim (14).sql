-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 10:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventario_esfim`
--

-- --------------------------------------------------------

--
-- Table structure for table `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `id_asignacion` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Fecha_asignacion` datetime NOT NULL,
  `Observaciones` varchar(500) NOT NULL,
  `docPdf` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `id_asignacion`, `usuario_id`, `Nombre_usuario`, `Fecha_asignacion`, `Observaciones`, `docPdf`) VALUES
(8, 'ASIGNACION-1b1c0a', 3, 'PRUEBA PDF', '2024-09-04 16:55:47', 'GSFHGF', 0x436572746966696361746563342e706466),
(9, 'ASIGNACION-2d690b', 1, 'pepito', '2024-09-04 17:48:27', 'SE REALIZA PRUEBA DE FUNCIONAMIENTO SIN NOVEDAD', 0x50726f707565737461202045636f6e6f6d6963612e706466),
(10, 'ASIGNACION-cb0787', 1, 'pepito', '2024-09-04 17:51:37', 'SE REALIZA PRUEBA SIN NOVEDAD', 0x50726f707565737461202045636f6e6f6d6963612e706466),
(11, 'ASIGNACION-422cd1', 4, 'DE LA VEGA', '2024-09-04 21:15:19', 'DSGF', 0x464163747572612053697374656d612064652063616d617261732e706466),
(12, 'ASIGNACION-1e0226', 4, 'DE LA VEGA', '2024-09-04 21:20:16', 'DFD', 0x464163747572612053697374656d612064652063616d617261732e706466);

-- --------------------------------------------------------

--
-- Table structure for table `detalles_asignacion`
--

CREATE TABLE `detalles_asignacion` (
  `id` int(11) NOT NULL,
  `id_asignacion` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Serie_equipo` varchar(50) NOT NULL,
  `Equipo` varchar(100) NOT NULL,
  `Cantidad_asignada` int(11) NOT NULL,
  `placa_equipo` varchar(100) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_asignacion`
--

INSERT INTO `detalles_asignacion` (`id`, `id_asignacion`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_asignada`, `placa_equipo`, `Estado`) VALUES
(27, 8, 3, 'PRUEBA PDF', 'PT002', 'Cabina Yamaha', 1, 'C10000', '0'),
(28, 8, 3, 'PRUEBA PDF', 'PT001', 'Pantalla HP', 1, 'P10000', '0'),
(29, 9, 1, 'pepito', 'PT004', 'Camara', 1, 'djnjhdch788s', '0'),
(30, 10, 1, 'pepito', 'PT004', 'Camara', 1, 'JKNCHJDSNJCBJK5545', '0'),
(31, 11, 4, 'DE LA VEGA', 'PT001', 'Pantalla HP', 1, 'SN', '0'),
(32, 12, 4, 'DE LA VEGA', 'PT004', 'Camara', 1, 'SN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `detalles_entrega`
--

CREATE TABLE `detalles_entrega` (
  `id` int(11) NOT NULL,
  `id_entrega` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Serie_equipo` varchar(100) NOT NULL,
  `Equipo` varchar(100) NOT NULL,
  `Cantidad_entregada` int(11) NOT NULL,
  `placa_equipo` varchar(50) NOT NULL,
  `Estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_entrega`
--

INSERT INTO `detalles_entrega` (`id`, `id_entrega`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_entregada`, `placa_equipo`, `Estado`) VALUES
(114, 134, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', 'Entregado'),
(115, 134, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C20000', 'Entregado'),
(116, 134, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', 'Entregado'),
(117, 134, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', 'Entregado'),
(118, 134, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', 'Entregado'),
(119, 134, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM2000', 'Entregado'),
(122, 138, 2, 'Andres', 'PT002', 'Cabina Yamaha', 1, 'C10000', 'Entregado'),
(123, 138, 2, 'Andres', 'PT001', 'Pantalla HP', 1, 'P10000', 'Entregado'),
(124, 139, 3, 'PRUEBA PDF', 'PT002', 'Cabina Yamaha', 1, 'C10000', 'Entregado'),
(125, 139, 3, 'PRUEBA PDF', 'PT001', 'Pantalla HP', 1, 'P10000', 'Entregado'),
(126, 140, 3, 'PRUEBA PDF', 'PT002', 'Cabina Yamaha', 1, 'ASHBDHEWB5', 'Entregado'),
(127, 141, 4, 'DE LA VEGA', 'PT002', 'Cabina Yamaha', 1, 'SN', 'Entregado'),
(128, 141, 4, 'DE LA VEGA', 'PT001', 'Pantalla HP', 1, 'SN', 'Entregado'),
(129, 141, 4, 'DE LA VEGA', 'PT003', 'Impresora HP', 1, 'SN', 'Entregado'),
(130, 142, 4, 'DE LA VEGA', 'PT001', 'Pantalla HP', 1, 'SN', 'Entregado');

-- --------------------------------------------------------

--
-- Table structure for table `detalles_prestamo`
--

CREATE TABLE `detalles_prestamo` (
  `id` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Serie_equipo` varchar(50) NOT NULL,
  `Equipo` varchar(100) NOT NULL,
  `Cantidad_prestada` int(11) NOT NULL,
  `placa_equipo` varchar(100) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_prestamo`
--

INSERT INTO `detalles_prestamo` (`id`, `id_prestamo`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_prestada`, `placa_equipo`, `Estado`) VALUES
(168, 68, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'SDCS', '0'),
(170, 70, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'SN', '0'),
(171, 71, 4, 'DE LA VEGA', 'PT002', 'Cabina Yamaha', 1, 'C10000', '0'),
(172, 72, 4, 'DE LA VEGA', 'PT001', 'Pantalla HP', 1, 'SN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `Cod_entrega` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Fecha_entregado` datetime NOT NULL,
  `Observaciones` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entregas`
--

INSERT INTO `entregas` (`id`, `Cod_entrega`, `usuario_id`, `Nombre_usuario`, `Fecha_entregado`, `Observaciones`) VALUES
(134, 'ENTREGA-d494a7', 1, 'pepito', '2024-09-03 17:37:55', 'PRUEBAAA'),
(138, 'ENTREGA-aa33a7', 2, 'Andres', '2024-09-04 17:35:40', 'ninguna'),
(139, 'ENTREGA-af28c7', 3, 'PRUEBA PDF', '2024-09-04 17:41:09', 'ninguna observacion'),
(140, 'ENTREGA-3ff5dd', 3, 'PRUEBA PDF', '2024-09-04 17:53:26', 'ENTREGA TODO SIN NOVEDAD'),
(141, 'ENTREGA-1977e6', 4, 'DE LA VEGA', '2024-09-04 21:23:55', ''),
(142, 'ENTREGA-87ab4c', 4, 'DE LA VEGA', '2024-09-04 21:27:10', 'PANTALLA DAÑADA');

-- --------------------------------------------------------

--
-- Table structure for table `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `Serie` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Categoria` varchar(100) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Imagen` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipos`
--

INSERT INTO `equipos` (`id`, `Serie`, `Nombre`, `Categoria`, `Estado`, `Cantidad`, `Imagen`) VALUES
(4, 'PT002', 'Cabina Yamaha', 'Tecnologia', 'Bueno', 2, 0x6173736574732f696d672f65717569706f732f636162696e612e6a7067),
(5, 'PT001', 'Pantalla HP', 'Tecnologia', 'Bueno', 4, 0x6173736574732f696d672f65717569706f732f70616e74616c6c2068702e6a7067),
(7, 'PT003', 'Impresora HP', 'Tecnologia', 'Bueno', 9, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067),
(8, 'PT004', 'Camara', 'Tecnologia', 'Bueno', 5, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `Cod_prestamo` varchar(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Fecha_prestamo` datetime NOT NULL,
  `Observaciones` text DEFAULT NULL,
  `docPdf` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestamos`
--

INSERT INTO `prestamos` (`id`, `Cod_prestamo`, `usuario_id`, `Nombre_usuario`, `Fecha_prestamo`, `Observaciones`, `docPdf`) VALUES
(64, 'PRESTAMO-f10525', 3, 'PRUEBA PDF', '2024-09-04 16:37:14', 'ninguna', 0x6164647265732e706466),
(65, 'PRESTAMO-08bc22', 2, 'Andres', '2024-09-04 16:41:35', 'dfsgsdfhd', 0x42415252494f53204d55c3914f5a204c554953204645524e414e444f2e706466),
(66, 'PRESTAMO-5fb3e4', 3, 'PRUEBA PDF', '2024-09-04 17:52:40', 'S/N', 0x50726f707565737461202045636f6e6f6d6963612e706466),
(67, 'PRESTAMO-60600c', 4, 'DE LA VEGA', '2024-09-04 21:22:31', 'SAD', 0x31313334332e706466),
(68, 'PRESTAMO-9bcf47', 1, 'pepito', '2024-09-04 21:24:54', '', 0x50524f434544494d49454e544f2050415241204c4120415349474e414349c3934e204445204d4154455249414c20444520434f4d554e49434143494f4e45532059204f54524f5320454c454d454e544f532044452041504f594f2041204c415320554e494441444553204445204c412041524d414441204e4143494f4e414c2047455449432d50542d3030332d4a4f4c414e2d5630352e706466),
(69, 'PRESTAMO-a63cc4', 4, 'DE LA VEGA', '2024-09-04 21:25:28', 'DS', 0x31313334332e706466),
(70, 'PRESTAMO-7af212', 1, 'pepito', '2024-09-04 21:26:49', 'DSF', 0x31313334332e706466),
(71, 'PRESTAMO-f33879', 4, 'DE LA VEGA', '2024-09-04 22:04:15', 'SDFSDFSD', 0x43657274696669636174656334202832292e706466),
(72, 'PRESTAMO-ceed13', 4, 'DE LA VEGA', '2024-09-04 22:13:12', 'sfdasf', 0x31313334332e706466);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Observador');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `Documento` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Cargo` varchar(50) NOT NULL,
  `Unidad` varchar(50) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `Documento`, `Nombre`, `Cargo`, `Unidad`, `Usuario`, `contrasena`, `ID_Rol`) VALUES
(1, '1010', 'Luis Barrios', 'ING', 'ESFIM', 'luis.barrios', '9ca069fd2ed5a65f521770dbcd39a7c4764e3053', 1),
(4, '432234', 'Alexis Paternina', 'SV', 'ESFIM', 'tellys.alexis', 'dd1506610e7e7cd1b07cc764ce41b32475a11777', 1),
(9, '325234', 'pepito', 'SM', 'ESFIM', 'pepito', 'e04820372e7f2ebb2d76987433579219b11c2ba5', 1),
(11, '000000', 'Diana Garcia', 'TELEMATICA', 'ESFIM', 'diana.garcia', 'c57cdb819378db4a28f57b12814aafbda5854963', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_prestamo`
--

CREATE TABLE `usuarios_prestamo` (
  `id` int(11) NOT NULL,
  `Documento` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Cargo` varchar(100) NOT NULL,
  `Unidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios_prestamo`
--

INSERT INTO `usuarios_prestamo` (`id`, `Documento`, `Nombre`, `Cargo`, `Unidad`) VALUES
(1, '12345', 'pepito', 'ADMIN', 'ESFIM'),
(2, '55555', 'Andres', 'almacen', 'ESFIM'),
(3, '1111111111111', 'PRUEBA PDF', 'almacen 2', 'ESFIM'),
(4, '67425635', 'DE LA VEGA', 'TEC', 'ESFIM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asignaciones_usuarios` (`usuario_id`);

--
-- Indexes for table `detalles_asignacion`
--
ALTER TABLE `detalles_asignacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalles_asignaciones_usuarios` (`usuario_id`),
  ADD KEY `fk_asignaciones` (`id_asignacion`),
  ADD KEY `fk_asignaciones_equipos` (`Serie_equipo`);

--
-- Indexes for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_entrega_entrega` (`id_entrega`),
  ADD KEY `fk_det_entrega_equipos` (`Serie_equipo`),
  ADD KEY `fk_detalles_entregas_usuarios` (`usuario_id`);

--
-- Indexes for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prestamo` (`id_prestamo`),
  ADD KEY `fk_det_prestamo_equipos` (`Serie_equipo`),
  ADD KEY `fk_det_prestamo_usuarios` (`usuario_id`);

--
-- Indexes for table `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Cod_entrega` (`Cod_entrega`);

--
-- Indexes for table `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Serie` (`Serie`);

--
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_rol` (`ID_Rol`);

--
-- Indexes for table `usuarios_prestamo`
--
ALTER TABLE `usuarios_prestamo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `detalles_asignacion`
--
ALTER TABLE `detalles_asignacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usuarios_prestamo`
--
ALTER TABLE `usuarios_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `fk_asignaciones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalles_asignacion`
--
ALTER TABLE `detalles_asignacion`
  ADD CONSTRAINT `fk_asignaciones` FOREIGN KEY (`id_asignacion`) REFERENCES `asignaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignaciones_equipos` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_asignaciones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD CONSTRAINT `fk_det_entrega_entrega` FOREIGN KEY (`id_entrega`) REFERENCES `entregas` (`id`),
  ADD CONSTRAINT `fk_det_entrega_equipos` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_detalles_entregas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  ADD CONSTRAINT `detalles_prestamo_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id`),
  ADD CONSTRAINT `fk_det_prestamo_equipos` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_detalle_prestamos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `fk_entregas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prstamos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
