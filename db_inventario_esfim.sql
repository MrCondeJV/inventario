-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 08:53 PM
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
  `Estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_entrega`
--

INSERT INTO `detalles_entrega` (`id`, `id_entrega`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_entregada`, `Estado`) VALUES
(90, 125, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 2, 'Entregado'),
(91, 125, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado'),
(92, 125, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 2, 'Entregado'),
(93, 125, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado'),
(94, 126, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado'),
(95, 126, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado'),
(96, 126, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado'),
(97, 126, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, 'Entregado');

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
  `Recomendaciones` varchar(500) NOT NULL,
  `Observaciones` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entregas`
--

INSERT INTO `entregas` (`id`, `Cod_entrega`, `usuario_id`, `Nombre_usuario`, `Fecha_entregado`, `Recomendaciones`, `Observaciones`) VALUES
(125, 'ENTREGA-66b53411cd3f34.16155832', 1, 'Luis Barrios', '2024-08-08 23:09:37', 'HJGHJGH', 'SDFSDF'),
(126, 'ENTREGA-66b5355264a086.69198110', 1, 'Luis Barrios', '2024-08-08 23:14:58', 'NINGUNA', 'SDFSD');

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
(4, 'PT002', 'Cabina Yamaha', 'Tecnologia', 'Bueno', 4, 0x6173736574732f696d672f65717569706f732f636162696e612e6a7067),
(5, 'PT001', 'Pantalla HP', 'Tecnologia', 'Bueno', 4, 0x6173736574732f696d672f65717569706f732f70616e74616c6c2068702e6a7067),
(7, 'PT003', 'Impresora HP', 'Tecnologia', 'Bueno', 4, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067),
(8, 'PT004', 'Camara', 'Tecnologia', 'Bueno', 4, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067);

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
  `Recomendaciones` text DEFAULT NULL,
  `Observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestamos`
--

INSERT INTO `prestamos` (`id`, `Cod_prestamo`, `usuario_id`, `Nombre_usuario`, `Fecha_prestamo`, `Recomendaciones`, `Observaciones`) VALUES
(50, 'PRESTAMO-2c5013', 1, 'Luis Barrios', '2024-08-08 23:09:13', 'SDFSDF', 'SDFSDFS'),
(51, 'PRESTAMO-557217', 1, 'Luis Barrios', '2024-08-08 23:13:51', 'NINGUNA', 'NINGUNA');

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
(4, '432234', 'Alexis Paternina', 'SV', 'ESFIM', 'tellys.alexis', '1234', 1),
(9, '325234', 'pepito', 'SM', 'ESFIM', 'pepito', 'e04820372e7f2ebb2d76987433579219b11c2ba5', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_entrega_entrega` (`id_entrega`),
  ADD KEY `fk_det_entrega_equipos` (`Serie_equipo`),
  ADD KEY `fk_det_entrega_usuarios` (`usuario_id`);

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
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prestamos_usuarios` (`usuario_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalles_entrega`
--
ALTER TABLE `detalles_entrega`
  ADD CONSTRAINT `fk_det_entrega_entrega` FOREIGN KEY (`id_entrega`) REFERENCES `entregas` (`id`),
  ADD CONSTRAINT `fk_det_entrega_equipos` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_det_entrega_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  ADD CONSTRAINT `detalles_prestamo_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id`),
  ADD CONSTRAINT `fk_det_prestamo_equipos` FOREIGN KEY (`Serie_equipo`) REFERENCES `equipos` (`Serie`),
  ADD CONSTRAINT `fk_det_prestamo_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `fk_entregas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prestamos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
