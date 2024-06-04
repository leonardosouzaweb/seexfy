-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 03/06/2024 às 23:59
-- Versão do servidor: 5.7.39
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `seexfy`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `fullname` varchar(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'assets/images/default/defaultAvatar.svg',
  `email` varchar(100) NOT NULL,
  `maritalStatus` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `interests` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `age` int(11) DEFAULT NULL,
  `sexualOrientation` varchar(50) DEFAULT NULL,
  `sign` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `smokes` varchar(5) DEFAULT NULL,
  `drink` varchar(5) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gender` varchar(11) DEFAULT NULL,
  `galleryPhotos` text,
  `likes` int(11) DEFAULT NULL,
  `statusPhotos` text,
  `agePartner` int(11) DEFAULT NULL,
  `sexualOrientationPartner` varchar(50) DEFAULT NULL,
  `signPartner` varchar(50) DEFAULT NULL,
  `heightPartner` varchar(50) DEFAULT NULL,
  `smokesPartner` varchar(5) DEFAULT NULL,
  `drinkPartner` varchar(5) DEFAULT NULL,
  `experiencePartner` varchar(100) DEFAULT NULL,
  `galleryPhotosPartner` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `city`, `avatar`, `email`, `maritalStatus`, `password`, `interests`, `created_at`, `age`, `sexualOrientation`, `sign`, `height`, `smokes`, `drink`, `experience`, `description`, `gender`, `galleryPhotos`, `likes`, `statusPhotos`, `agePartner`, `sexualOrientationPartner`, `signPartner`, `heightPartner`, `smokesPartner`, `drinkPartner`, `experiencePartner`, `galleryPhotosPartner`) VALUES
(18, 'Leo', NULL, 'Embu das Artes', 'assets/images/default/defaultAvatar.svg', 'ileeo@live.com', 'Solteiro', '$2y$10$xUKAxzGuKd9btXDdi/LC0uudB65uElrggyp9Heewj3EBE8l.pz24W', 'Mulheres', '2024-06-03 05:14:30', 25, 'Teste3', 'Teste', '1.89', 'nao', 'nao', '1 ano e meio', 'teste', 'Masculino', NULL, NULL, NULL, 15, 'Hetero', 'Touro', '1.59', 'Nao', 'Sim', '5', NULL),
(19, 'leo2', NULL, 'Embu das Artes', 'assets/images/default/defaultAvatar.svg', 'leeoesouza@gmail.com', 'Casado', '$2y$10$eod3u4cp8GwjhtfZ7lNcXuJxP/c9I0XrrGjg2oDZeXmtTw.ZNJEXq', 'Mulheres', '2024-06-03 15:07:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
