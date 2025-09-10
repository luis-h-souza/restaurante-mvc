-- Criar banco de dados se não existir
CREATE DATABASE IF NOT EXISTS `restaurante-mvc` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE `restaurante-mvc`;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL UNIQUE,
  `senha` varchar(255) NOT NULL,
  `nivelAcesso` varchar(20) NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de mesas
CREATE TABLE IF NOT EXISTS `mesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lugares` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `caracteristicas` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de disponibilidade das mesas
CREATE TABLE IF NOT EXISTS `disponibilidade` (
  `numero_mesa` int(11) NOT NULL,
  `periodo` varchar(50) NOT NULL,
  KEY `fk_mesa_disponibilidade` (`numero_mesa`),
  CONSTRAINT `fk_mesa_disponibilidade` FOREIGN KEY (`numero_mesa`) REFERENCES `mesas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de cardápio
CREATE TABLE IF NOT EXISTS `cardapio` (
  `idCardapio` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descricao` text,
  `foto` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCardapio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de avaliações
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idAvaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `nota` int(11) NOT NULL,
  `comentario` text,
  `idCardapio` int(11) NOT NULL,
  `data` date NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'novo',
  PRIMARY KEY (`idAvaliacao`),
  KEY `fk_cardapio_avaliacao` (`idCardapio`),
  CONSTRAINT `fk_cardapio_avaliacao` FOREIGN KEY (`idCardapio`) REFERENCES `cardapio` (`idCardapio`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
