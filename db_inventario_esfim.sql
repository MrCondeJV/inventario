-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 10:03 PM
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

--
-- Dumping data for table `detalles_prestamo`
--

INSERT INTO `detalles_prestamo` (`id`, `id_prestamo`, `usuario_id`, `Nombre_usuario`, `Serie_equipo`, `Equipo`, `Cantidad_prestada`, `Estado`) VALUES
(29, 14, 1, 'Luis Barrios', 'PT002', 'Cabina Yamaha', 1, '0'),
(30, 14, 1, 'Luis Barrios', 'PT001', 'Pantalla HP', 1, '0'),
(31, 14, 1, 'Luis Barrios', 'PT003', 'Impresora HP', 1, '0'),
(32, 14, 1, 'Luis Barrios', 'PT004', 'Camara', 1, '0'),
(33, 15, 4, 'Alexis Paternina', 'PT002', 'Cabina Yamaha', 1, '0'),
(34, 15, 4, 'Alexis Paternina', 'PT001', 'Pantalla HP', 1, '0'),
(35, 15, 4, 'Alexis Paternina', 'PT003', 'Impresora HP', 1, '0'),
(36, 15, 4, 'Alexis Paternina', 'PT004', 'Camara', 1, '0'),
(37, 16, 9, 'pepito', 'PT002', 'Cabina Yamaha', 2, '0'),
(38, 16, 9, 'pepito', 'PT001', 'Pantalla HP', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `Cod_entrega` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `Nombre_usuario` varchar(100) NOT NULL,
  `Fecha_entregado` datetime NOT NULL
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

--
-- Dumping data for table `equipos`
--

INSERT INTO `equipos` (`id`, `Serie`, `Nombre`, `Categoria`, `Estado`, `Cantidad`, `Imagen`) VALUES
(4, 'PT002', 'Cabina Yamaha', 'Tecnologia', 'Bueno', 0, 0x6173736574732f696d672f65717569706f732f636162696e612e6a7067),
(5, 'PT001', 'Pantalla HP', 'Tecnologia', 'Bueno', 1, 0x6173736574732f696d672f65717569706f732f70616e74616c6c2068702e6a7067),
(7, 'PT003', 'Impresora HP', 'Tecnologia', 'Bueno', 2, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067),
(8, 'PT004', 'Camara', 'Tecnologia', 'Bueno', 2, 0x6173736574732f696d672f65717569706f732f696d707265736f72612e6a7067);

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
(14, 'PR-1ee298', 1, 'Luis Barrios', '2024-06-27 19:25:46', 'dfsfs', 'sdfsdf'),
(15, 'PR-c3e76b', 4, 'Alexis Paternina', '2024-06-27 21:20:19', 'gfhfghfgxhfg', 'tredsfsdfsdvdfgdf'),
(16, 'PR-253ed9', 9, 'pepito', '2024-06-27 21:20:54', 'hfgxhf', 'drsfs');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalles_prestamo`
--
ALTER TABLE `detalles_prestamo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
