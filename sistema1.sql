-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Jan-2020 às 14:15
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `secundaria`
--

CREATE TABLE `secundaria` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `kinesis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `nascimento` date NOT NULL,
  `primaria` varchar(255) NOT NULL,
  `id_secundaria` int(11) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `comeco` date NOT NULL,
  `senha` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `nascimento`, `primaria`, `id_secundaria`, `genero`, `comeco`, `senha`, `login`, `email`) VALUES
(1, 'Allyson', 'Athyrson', '2000-02-16', 'telecinese', 0, 'masculino', '2018-01-01', '827ccb0eea8a706c4c34a16891f84e7b', 'zharfi', 'athyrsonallyson@gmail.com'),
(2, 'Patrícia', 'Aguiar', '1999-07-02', 'hidrokinese', 0, 'feminino', '2019-05-13', '8e3a8d3e644e608d25ec40162988a137', 'pati', 'pati@gmail.com'),
(3, 'Fernando', 'Oliveira', '2001-06-05', 'luminosinese', 0, 'masculino', '2019-01-01', '900150983cd24fb0d6963f7d28e17f72', 'fer', 'fer@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `secundaria`
--
ALTER TABLE `secundaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `secundaria` (`id_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_secundaria` (`id_secundaria`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `secundaria`
--
ALTER TABLE `secundaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `secundaria`
--
ALTER TABLE `secundaria`
  ADD CONSTRAINT `secundaria` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
