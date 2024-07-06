-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2024 a las 18:07:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peliculas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `estreno` date DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `idioma` varchar(50) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id`, `titulo`, `sinopsis`, `img`, `estreno`, `genero`, `idioma`, `duracion`) VALUES
(13, 'Cazafantasmas: Imperio helado', 'La familia Spengler regresa a la famosa estación de bomberos de la ciudad de Nueva York con los cazafantasmas originales. Cuando un antiguo artefacto desata una fuerza maligna, los cazafantasmas nuevos y antiguos deben unirse para proteger el mundo.', 'https://i.ibb.co/2hSvbK2/4b3aa854842e.jpg', '2024-03-22', 'Fantastico, Comedia', 'Inglés', 115),
(14, 'Furiosa', 'La joven Furiosa es arrebatada del Paraje Verde de las Muchas Madres por una horda de motociclistas. El señor de la guerra que dirige su grupo se enfrenta a otro tirano y, mientras tanto, Furiosa aprovecha la batalla para intentar volver a casa.', 'https://i.ibb.co/Gvg6Tv8/5ebce444fd17.jpg', '2024-05-23', 'Ciencia Ficcion, Aventura, Accion', 'Inglés', 148),
(16, 'Bad Boys: Hasta la muerte', 'Bad Boys: Ride or Die es una película de comedia de acción estadounidense de 2024, dirigida por Adil El Arbi & Bilall. Es la secuela de Bad Boys for Life y la cuarta entrega de la franquicia Bad Boys.', 'https://i.ibb.co/X2xvH72/6940d989a485.jpg', '2024-06-06', 'Acción', 'Inglés', 115),
(17, 'Robot Salvaje', 'La épica aventura sigue el viaje de un robot –ROZZUM unidad 7134, \"Roz\"– que naufraga en una isla deshabitada y debe aprender a adaptarse al duro entorno, estableciendo gradualmente relaciones con los animales de la isla y convirtiéndose en el padre adoptivo de un ganso bebé huérfano.', 'https://i.ibb.co/1qDK0MJ/8d921936fa94.jpg', '2024-09-27', 'Animación, Aventura', 'Inglés', 90),
(18, 'Abigail', 'Después de que una banda de aspirantes a malhechores secuestra a una bailarina de 12 años, hija de un poderoso capo del hampa, solo les queda vigilar a la niña durante una noche para recoger el rescate de 50 millones de dólares. En una mansión alejada de todo, los captores empiezan a desaparecer uno a uno y descubren, con creciente horror, que están encerrados con una niña nada normal.', 'https://i.ibb.co/McyZy76/33d955fae209.jpg', '2024-04-19', 'Thriller', 'Inglés', 109),
(19, 'Rivales', 'Tashi, entrenadora de tenis, ha convertido a Art, su esposo, en una de las grandes estrellas del circuito. Art, quien atraviesa una mala época, acepta jugar un torneo sin importancia, donde se enfrenta al exnovio de Tashi, su antiguo mejor amigo.', 'https://i.ibb.co/p2KCL03/ac431e51673f.jpg', '2024-04-25', 'Drama', 'Inglés', 131);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `rol`) VALUES
(7, 'admin', 'admin@email.com', '$2y$10$6F1sNp2ZhspZNo8MhXATH.lX46lP9qaEzX9WLGBvdtJGzjpHJ38tm', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
