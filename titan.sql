-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 27-Maio-2022 às 20:31
-- Versão do servidor: 8.0.27
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `titan`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE IF NOT EXISTS `estoque` (
  `cod_prod` int NOT NULL,
  `loj_prod` int NOT NULL,
  `qtd_prod` decimal(15,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`cod_prod`, `loj_prod`, `qtd_prod`) VALUES
(1, 1, '20.000'),
(2, 1, '18.000'),
(3, 2, '60.000'),
(4, 2, '300.000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojas`
--

DROP TABLE IF EXISTS `lojas`;
CREATE TABLE IF NOT EXISTS `lojas` (
  `loj_prod` int NOT NULL,
  `desc_loj` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `lojas`
--

INSERT INTO `lojas` (`loj_prod`, `desc_loj`) VALUES
(1, 'SM CENTRO - MATRIZ'),
(2, 'SM SHOP VALE SUL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `precos`
--

DROP TABLE IF EXISTS `precos`;
CREATE TABLE IF NOT EXISTS `precos` (
  `id_preco` int NOT NULL AUTO_INCREMENT,
  `preco` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id_preco`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
-- Tabela tem mais campos pois foi usado para fins de validação das sql do teste inicial
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `cod_prod` int NOT NULL,
  `loj_prod` int NOT NULL,
  `desc_prod` varchar(40) NOT NULL,
  `dt_inclu_prod` date NOT NULL,
  `preco_prod` decimal(8,3) NOT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `idpreco` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`cod_prod`, `loj_prod`, `desc_prod`, `dt_inclu_prod`, `preco_prod`, `cor`, `idpreco`) VALUES
(1, 1, 'ACHOC TODDY 200ML', '2022-05-10', '8.900', NULL, NULL),
(2, 1, 'ARROZ CAMIL 5KG', '2022-05-26', '17.800', NULL, NULL),
(3, 2, 'DET NEUTRO YPE 180ML', '2022-05-09', '2.150', NULL, NULL),
(4, 2, 'REF COCA-COLA 2L', '2022-05-18', '8.690', NULL, NULL),
(170, 2, 'LEITE CONDENSADO MOCOCA', '2010-12-30', '95.400', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
