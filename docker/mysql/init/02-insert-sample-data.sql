-- Usar o banco de dados
USE `restaurante-mvc`;

-- Inserir usuário administrador padrão
INSERT INTO `usuarios` (`nome`, `usuario`, `senha`, `nivelAcesso`) VALUES
('Administrador', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Inserir algumas mesas de exemplo
INSERT INTO `mesas` (`lugares`, `tipo`, `caracteristicas`) VALUES
(4, 'Quadrada', 'Perto da janela, Vista para o jardim'),
(6, 'Retangular', 'Mesa grande, Ideal para famílias'),
(2, 'Redonda', 'Romântica, Vista para o mar'),
(8, 'Retangular', 'Mesa de reunião, Privativa'),
(4, 'Meia lua', 'Confortável, Ar condicionado');

-- Inserir disponibilidade das mesas
INSERT INTO `disponibilidade` (`numero_mesa`, `periodo`) VALUES
(1, 'manhã'),
(1, 'tarde'),
(1, 'noite'),
(2, 'tarde'),
(2, 'noite'),
(3, 'noite'),
(4, 'manhã'),
(4, 'tarde'),
(5, 'tarde'),
(5, 'noite');

-- Inserir itens do cardápio
INSERT INTO `cardapio` (`nome`, `preco`, `tipo`, `descricao`, `foto`, `status`) VALUES
('Pizza Margherita', 35.90, 'Prato quente', 'Pizza tradicional com molho de tomate, mussarela e manjericão', 'pizza-margherita.jpg', 1),
('Salada Caesar', 18.50, 'Prato frio', 'Salada fresca com alface, croutons, parmesão e molho caesar', 'salada-caesar.jpg', 1),
('Tiramisu', 12.90, 'Sobremesa', 'Sobremesa italiana tradicional com café e mascarpone', 'tiramisu.jpg', 1),
('Coca-Cola', 5.50, 'Bebida', 'Refrigerante gelado 350ml', 'coca-cola.jpg', 1),
('Risotto de Camarão', 42.90, 'Prato quente', 'Risotto cremoso com camarões frescos e ervas', 'risotto-camarao.jpg', 1),
('Água Mineral', 3.50, 'Bebida', 'Água mineral natural 500ml', 'agua-mineral.jpg', 1);

-- Inserir algumas avaliações de exemplo
INSERT INTO `avaliacao` (`nota`, `comentario`, `idCardapio`, `data`, `nome`, `email`, `situacao`) VALUES
(5, 'Pizza deliciosa! Massa perfeita e ingredientes frescos.', 1, '2024-01-15', 'João Silva', 'joao@email.com', 'aprovado'),
(4, 'Muito boa, mas poderia ter mais molho.', 1, '2024-01-16', 'Maria Santos', 'maria@email.com', 'aprovado'),
(5, 'Salada fresca e crocante, perfeita!', 2, '2024-01-17', 'Pedro Costa', 'pedro@email.com', 'aprovado'),
(3, 'Saboroso, mas demorou para chegar.', 5, '2024-01-18', 'Ana Oliveira', 'ana@email.com', 'novo');
