-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2023 a las 21:38:43
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `expenseapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `color`) VALUES
(1, 'comida', '#DE1F59'),
(2, 'hogar', '#DE1FAA'),
(3, 'ropa', '#B01FDE'),
(4, 'Juegos', '#681FDE'),
(5, 'Viajes', '#1FAADE'),
(6, 'tecnologia', '#21c424');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` int(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category_id` int(5) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `category_id`, `amount`, `date`, `id_user`) VALUES
(1, 'prueba', 3, 12.40, '2020-03-21', 5),
(2, 'starbucks', 1, 60.00, '2020-03-21', 5),
(4, 'Regalo de cumpleaños mamá', 2, 1200.00, '2020-03-22', 5),
(5, 'Nintendo Switch', 4, 4600.00, '2020-03-26', 5),
(6, 'Viaje a Nueva York', 5, 20000.00, '2020-01-25', 5),
(7, 'Chocolates Ferrero', 1, 140.00, '2020-03-27', 5),
(10, 'sdsdsd', 1, 2323.00, '2020-04-03', 5),
(11, 'sadas', 1, 232.00, '2020-04-03', 5),
(12, 'sadas', 3, 11.00, '2020-04-03', 5),
(13, 'sdsd', 5, 23.00, '2020-04-03', 5),
(14, 'sdsd', 5, 23.00, '2020-04-03', 5),
(20, 'juego de Halo', 4, 1100.00, '2020-04-04', 5),
(21, 'Uñas', 3, 200.00, '2020-04-09', 6),
(23, 'pastillas para la tos', 2, 21.00, '2020-06-06', 5),
(24, 'Ropa nueva', 3, 300.00, '2020-06-04', 5),
(25, 'juego Nintendo', 2, 200.00, '2020-07-12', 5),
(26, 'ida al cine', 1, 100.00, '2023-07-20', 16),
(27, 'gasto comida', 1, 20.00, '2023-07-20', 5),
(28, 'recibo', 2, 30.00, '2023-07-20', 5),
(29, 'compra gorra', 3, 60.00, '2023-07-20', 5),
(30, 'gorra', 3, 13.00, '2023-07-22', 16),
(31, 'transporte trabajo', 5, 30.00, '2023-07-23', 16),
(32, 'diversion ', 4, 40.00, '2023-07-03', 16),
(33, 'memoria', 6, 190.00, '2023-07-29', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `budget` float(10,2) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `budget`, `photo`, `name`) VALUES
(5, 'marcos', '$2y$10$0aOmd1LTFHtBLCEtDrJgy.xxs7FArnOlzHXLrviwP85LWS.XbxsNO', 'user', 500.00, '1a10d23fbb10cb6ec0cfefece06d796c.jpg', 'Marcos Rivas'),
(6, 'lena', '$2y$10$C/MX.IRvzrNuMyo4pk5uU.bCD20hSWChoCM1bp4n3kEzO2TYamSI.', 'user', 16000.00, '', 'Lenis'),
(7, 'omar', '$2y$10$2YzZ9yzk2rSLbcbfBGkcIuWZ1HzjcNT8lTcgeidTiYbq2yzcNVxuq', 'admin', 20000.00, '', 'El Pozos'),
(16, 'jhonyd55', '$2y$10$jcPTkbkjRwqn3ooMBB.TjeHkZZFU./FZBMvlcPdE7B8/mrtHXTwLi', 'user', 8000.00, 'e0a1758f92a796be612e9b63122bfa4d.jpg', 'jhony duran '),
(17, 'jhony', '$2y$10$hDoehP0LebDU5gdj3QWY.eJeLbP4RXel72PF0uDS.M.ma4nbrqkve', 'user', 0.00, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_expense` (`id_user`),
  ADD KEY `id_category_expense` (`category_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `id_category_expense` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `id_user_expense` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
