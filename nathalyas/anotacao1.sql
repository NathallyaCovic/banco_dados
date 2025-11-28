-- phpMyAdmin SQL Dump
-- versão 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2025 às 18:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

 /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `anotacao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `cor` varchar(7) DEFAULT '#ffffff',
  `fixada` tinyint(1) DEFAULT 0,
  `arquivada` tinyint(1) DEFAULT 0,
  `criada_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizada_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Inserindo dados da tabela `notas`
--

INSERT INTO `notas` (`id`, `usuario_id`, `titulo`, `conteudo`, `categoria`, `cor`, `fixada`, `arquivada`, `criada_em`, `atualizada_em`) VALUES
(1, 1, 'Título de Exemplo', 'Este é um conteúdo de exemplo para o aplicativo de anotações.', 'Pessoal', '#ffffff', 1, 0, '2025-10-30 08:30:10', '2025-10-30 08:30:10'),
(3, 2, 'sadfgm,', 'SADFDGFHGJH,J.K', 'adsf', '#ffffff', 0, 0, '2025-11-28 14:07:59', '2025-11-28 14:07:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nota_etiquetas`
--

CREATE TABLE `nota_etiquetas` (
  `nota_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Inserindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_usuario`, `email`, `senha`, `criado_em`) VALUES
(1, 'user', 'user@example.com', '$2y$10$5SPxyulVfdSFRiiWwbS78.Sn8Hehdm2BMJb2356LFKd0AAhi4D4N2', '2025-10-28 07:06:14'),
(2, 'admin', 'nathalya.silvacovic@gmail.com', '$2y$10$07.aiVHu5MTTXwnByD1PKeZpC6dUSucOS8EzzsdZbEXz2RqPXy0li', '2025-11-28 11:51:04');

-- --------------------------------------------------------

--
-- Índices das tabelas
--

-- Índices da tabela `notas`
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

-- Índices da tabela `nota_etiquetas`
ALTER TABLE `nota_etiquetas`
  ADD PRIMARY KEY (`nota_id`,`etiqueta_id`),
  ADD KEY `etiqueta_id` (`etiqueta_id`);

-- Índices da tabela `etiquetas`
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Índices da tabela `usuarios`
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_usuario` (`nome_usuario`),
  ADD UNIQUE KEY `email` (`email`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT das tabelas
--

ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `etiquetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- --------------------------------------------------------

--
-- Restrições (Foreign Keys)
--

ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

ALTER TABLE `nota_etiquetas`
  ADD CONSTRAINT `nota_etiquetas_ibfk_1` FOREIGN KEY (`nota_id`) REFERENCES `notas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nota_etiquetas_ibfk_2` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE;

COMMIT;

 /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
