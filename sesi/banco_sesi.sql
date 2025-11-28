-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2025 às 20:05
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
-- Banco de dados: `banco_sesi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `description`, `teacher_id`, `created_at`) VALUES
(1, 'Grade 1  - Section 2', 'Grade 1 students in section 2 class', NULL, '2025-09-30 04:00:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `classroom_students`
--

CREATE TABLE `classroom_students` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `classroom_students`
--

INSERT INTO `classroom_students` (`id`, `classroom_id`, `student_id`, `enrolled_at`) VALUES
(1, 1, 3, '2025-09-30 04:02:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) NOT NULL,
  `grade_type` enum('quiz','assignment','exam','project') NOT NULL,
  `remarks` text DEFAULT NULL,
  `graded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `description`) VALUES
(1, 'English', 'ENG_01', 'English Subject');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `first_name`, `last_name`, `created_at`) VALUES
(1, 'Diretora Luciana', '$2y$10$M6zgd5fQozY9PjXSyQ6BDuzmcP5ksY6iOJMbXIEnP3u/1dr.29gly', 'luciana@sesidiretora.com', 'admin', 'Luciana', 'Admin', '2025-09-30 03:54:39'),
(3, 'gabriel.oliveira', '$2y$10$WQTIPaixwagK8foS18NTduAb6tVkNAGCHkP728nSkqMRL7G1To/BS', 'gabriel.oliveira@portalsesisp.org.br', 'student', 'Gabriel de', 'Oliveira', '2025-09-30 04:01:42'),
(4, 'miguel.kovac', '$2y$10$Q8yMIbl9mqV/s4SyMeAn4eygG0fW26kJRU5TCHV54xJMnB7mVwtgq', 'miguel.kovac@portalsesisp.org.br', 'student', 'Miguel', 'Kovac', '2025-11-17 18:33:04'),
(5, 'suzi.leide', '$2y$10$3SiBZBG8ZihuTxMjL0ThDe6OV4ivLVAQbMUvG3zH414MDpNAjvxPq', 'suzi.leide@portalsesisp.org.br', 'teacher', 'Susi', 'Leide', '2025-11-17 18:59:10'),
(6, 'arthur.rafael', '$2y$10$e5K1pkory69.qRdGt1.dbusU5j6kF7xivS.baXj2cQpR/Nn3Tvftu', 'arthur.rafael@portalsesisp.org.br', 'student', 'Arthur', 'Rafael', '2025-11-17 19:04:01');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Índices de tabela `classroom_students`
--
ALTER TABLE `classroom_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Índices de tabela `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Índices de tabela `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `classroom_students`
--
ALTER TABLE `classroom_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `classroom_students`
--
ALTER TABLE `classroom_students`
  ADD CONSTRAINT `classroom_students_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`),
  ADD CONSTRAINT `classroom_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`),
  ADD CONSTRAINT `grades_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
