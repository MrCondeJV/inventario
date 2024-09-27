-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 11:13 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `equipos_especificos`
--

CREATE TABLE `equipos_especificos` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, '55555', 'Andres', 'almacen', 'ESFIM');

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
-- Indexes for table `equipos_especificos`
--
ALTER TABLE `equipos_especificos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipo` (`id_equipo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detalles_asignacion`
--
ALTER TABLE `detalles_asignacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `equipos_especificos`
--
ALTER TABLE `equipos_especificos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `historial_asignaciones`
--
ALTER TABLE `historial_asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historial_entregas`
--
ALTER TABLE `historial_entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historial_prestamos`
--
ALTER TABLE `historial_prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

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
-- Constraints for table `equipos_especificos`
--
ALTER TABLE `equipos_especificos`
  ADD CONSTRAINT `equipos_especificos_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id`) ON DELETE CASCADE;

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
