-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 08:51 AM
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
(17, 'ASIGNACION-9a776d', 1, 'pepito', '2024-09-10 08:46:09', 'NA', 0x455854524143544f5f706f727461666f6c696f323032343038333132303031323030333136343835332e706466);

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
(48, 17, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', '0'),
(49, 17, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', '0'),
(50, 17, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', '0'),
(51, 17, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', '0');

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
(146, 148, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', 'Entregado'),
(147, 148, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', 'Entregado'),
(148, 148, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', 'Entregado'),
(149, 148, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', 'Entregado');

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
(148, 'ENTREGA-c0f4fd', 1, 'pepito', '2024-09-10 08:47:45', 'NA');

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
(4, 'PT002', 'Cabina Yamaha', 'Tecnologia', 'Bueno', 9, 0x6173736574732f696d672f65717569706f732f636162696e612e6a7067),
(5, 'PT001', 'Pantalla HP', 'Tecnologia', 'Bueno', 9, 0x6173736574732f696d672f65717569706f732f70616e74616c6c2068702e6a7067),
(7, 'PT003', 'Impresora HP', 'Tecnologia', 'Bueno', 9, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067),
(8, 'PT004', 'Camara', 'Tecnologia', 'Bueno', 9, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `historial_asignaciones`
--

CREATE TABLE `historial_asignaciones` (
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
-- Dumping data for table `historial_asignaciones`
--

INSERT INTO `historial_asignaciones` (`id`, `id_asignacion`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_asignada`, `placa_equipo`, `Estado`) VALUES
(3, 17, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', '0'),
(4, 17, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', '0'),
(5, 17, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', '0'),
(6, 17, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `historial_entregas`
--

CREATE TABLE `historial_entregas` (
  `id` int(11) NOT NULL,
  `id_entrega` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Serie_equipo` varchar(50) NOT NULL,
  `Equipo` varchar(100) NOT NULL,
  `Cantidad_entregada` int(11) NOT NULL,
  `placa_equipo` varchar(100) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historial_entregas`
--

INSERT INTO `historial_entregas` (`id`, `id_entrega`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_entregada`, `placa_equipo`, `Estado`) VALUES
(7, 148, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', 'Entregado'),
(8, 148, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', 'Entregado'),
(9, 148, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', 'Entregado'),
(10, 148, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', 'Entregado');

-- --------------------------------------------------------

--
-- Table structure for table `historial_prestamos`
--

CREATE TABLE `historial_prestamos` (
  `id` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Serie_equipo` varchar(50) NOT NULL,
  `Equipo` varchar(100) NOT NULL,
  `Cantidad_prestada` int(11) NOT NULL,
  `placa_equipo` varchar(100) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historial_prestamos`
--

INSERT INTO `historial_prestamos` (`id`, `id_prestamo`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_prestada`, `placa_equipo`, `Estado`) VALUES
(15, 86, 1, 'pepito', 'PT002', 'Cabina Yamaha', 1, 'C10000', '0'),
(16, 86, 1, 'pepito', 'PT001', 'Pantalla HP', 1, 'P10000', '0'),
(17, 86, 1, 'pepito', 'PT003', 'Impresora HP', 1, 'I10000', '0'),
(18, 86, 1, 'pepito', 'PT004', 'Camara', 1, 'CAM1000', '0');

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
(86, 'PRESTAMO-70971e', 1, 'pepito', '2024-09-10 08:47:33', 'NA', 0x50726f707565737461202045636f6e6f6d696361202831292e706466);

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
  ADD UNIQUE KEY `Cod_entrega` (`Cod_entrega`),
  ADD KEY `fk_entregas_usuarios` (`usuario_id`);

--
-- Indexes for table `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Serie` (`Serie`);

--
-- Indexes for table `historial_asignaciones`
--
ALTER TABLE `historial_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_asignacion` (`id_asignacion`) USING BTREE,
  ADD KEY `fk_usuarios_asignacion` (`usuario_id`),
  ADD KEY `fk_serie_equipo_entrega` (`Serie_equipo`);

--
-- Indexes for table `historial_entregas`
--
ALTER TABLE `historial_entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_entrega` (`usuario_id`),
  ADD KEY `fk_id_entrega` (`id_entrega`);

--
-- Indexes for table `historial_prestamos`
--
ALTER TABLE `historial_prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_prestamo` (`usuario_id`),
  ADD KEY `fk_serie_equipo_prestamo` (`Serie_equipo`);

--
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prstamos_usuarios` (`usuario_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detalles_asignacion`
--
ALTER TABLE `detalles_asignacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `historial_asignaciones`
--
ALTER TABLE `historial_asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `historial_entregas`
--
ALTER TABLE `historial_entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `historial_prestamos`
--
ALTER TABLE `historial_prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `usuarios_prestamo`
--
ALTER TABLE `usuarios_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `fk_entregas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `historial_asignaciones`
--
ALTER TABLE `historial_asignaciones`
  ADD CONSTRAINT `fk_serie_equipo_asignacion` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_serie_equipo_entrega` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_usuario_asignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignaciones` (`id`),
  ADD CONSTRAINT `fk_usuarios_asignacion` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`);

--
-- Constraints for table `historial_entregas`
--
ALTER TABLE `historial_entregas`
  ADD CONSTRAINT `fk_id_entrega` FOREIGN KEY (`id_entrega`) REFERENCES `entregas` (`id`),
  ADD CONSTRAINT `fk_usuario_entrega` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`);

--
-- Constraints for table `historial_prestamos`
--
ALTER TABLE `historial_prestamos`
  ADD CONSTRAINT `fk_serie_equipo_prestamo` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_usuario_prestamo` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`);

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prstamos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_prestamo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
