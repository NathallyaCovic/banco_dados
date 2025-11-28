-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/11/2025 às 20:42
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
-- Banco de dados: `prova`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

CREATE TABLE `questoes` (
  `codigo` int(6) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `ano` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `doze_tabuas` varchar(50) NOT NULL,
  `coment_um` int(255) NOT NULL,
  `democracia` int(255) NOT NULL,
  `vassalagem` varchar(3) NOT NULL,
  `coment_dois` varchar(255) NOT NULL,
  `mercantilismo` varchar(50) NOT NULL,
  `coronelismo` varchar(255) NOT NULL,
  `coment_tres` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`codigo`, `nome`, `ano`, `email`, `cpf`, `doze_tabuas`, `coment_um`, `democracia`, `vassalagem`, `coment_dois`, `mercantilismo`, `coronelismo`, `coment_tres`) VALUES
(1, 'Miguel', '423', 'aluno', '44969827818', 'nao', 0, 0, 'sim', '', '', '', ''),
(2, 'Miguel Fernandes Kovac', '2ºano A', 'miguelitokovac@gmail.com', '44969827818', 'sim', 0, 0, 'b f', 'xxxxxxxxxxxxxxx', 'nao', 'sim', 'hfxdyn');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `codigo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
