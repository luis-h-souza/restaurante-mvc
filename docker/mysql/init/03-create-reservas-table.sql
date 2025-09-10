-- Usar o banco de dados
USE `restaurante-mvc`;

-- Tabela de reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `idReserva` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `data_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL,
  `numero_pessoas` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `observacoes` text,
  `status` varchar(20) NOT NULL DEFAULT 'pendente',
  `data_criacao` timestamp DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idReserva`),
  KEY `fk_reserva_mesa` (`idMesa`),
  CONSTRAINT `fk_reserva_mesa` FOREIGN KEY (`idMesa`) REFERENCES `mesas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir algumas reservas de exemplo
INSERT INTO `reservas` (`nome`, `email`, `telefone`, `data_reserva`, `hora_reserva`, `numero_pessoas`, `idMesa`, `observacoes`, `status`) VALUES
('João Silva', 'joao@email.com', '(11) 99999-9999', '2024-09-15', '19:00:00', 4, 1, 'Mesa perto da janela', 'confirmada'),
('Maria Santos', 'maria@email.com', '(11) 88888-8888', '2024-09-15', '20:30:00', 2, 3, 'Aniversário de casamento', 'pendente'),
('Pedro Costa', 'pedro@email.com', '(11) 77777-7777', '2024-09-16', '18:30:00', 6, 2, 'Reunião de negócios', 'confirmada'),
('Ana Oliveira', 'ana@email.com', '(11) 66666-6666', '2024-09-16', '21:00:00', 2, 5, '', 'cancelada');
