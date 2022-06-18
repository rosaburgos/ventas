-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2022 at 08:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ventas`
--

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `cantidad`) VALUES
(1, 'Lapiz', 500, 31),
(2, 'Borrador', 200, 98),
(3, 'Cinta', 2000, 133),
(4, 'Block de papel', 3000, 3423),
(5, 'Pegante', 2000, 99);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `nombre`, `contrasena`) VALUES
('lucho', 'Luis ANgel', '$2y$10$nhzRWXemIcZ2KcAYFMm1guP54OmMiCPkuEhAcEJRvGeUTyid3HfJq');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `usuario`, `producto`, `cantidad`) VALUES
(48400840, 'lucho', 1, 1),
(48400840, 'lucho', 3, 1),
(48400840, 'lucho', 4, 1),
(48400840, 'lucho', 5, 1),
(67376635, 'lucho', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`,`usuario`,`producto`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `producto` (`producto`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
