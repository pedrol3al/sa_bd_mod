-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08/09/2025 às 08:43
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `conserta_tech_sa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf` varchar(18) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nome` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `sexo` enum('M','F') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logradouro` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(18) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inativo` tinyint DEFAULT '0',
  PRIMARY KEY (`id_cliente`),
  KEY `fk_cliente_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_usuario`, `email`, `cpf`, `nome`, `observacao`, `data_nasc`, `data_cad`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `telefone`, `uf`, `bairro`, `inativo`) VALUES
(1, 1, 'maria.silva@email.com', '12345678901', 'Maria Silva', 'Cliente preferencial', '1985-03-15', '2023-01-10', 'F', '01234-567', 'Rua das Flores', 'Casa', 'Apto 102', 123, 'São Paulo', '(11) 99999-1234', 'SP', 'Centro', 0),
(2, 1, 'joao.santos@email.com', '23456789012', 'João Santos', NULL, '1990-07-22', '2023-02-15', 'M', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', '(11) 98888-5678', 'SP', 'Bela Vista', 0),
(3, 1, 'ana.oliveira@email.com', '34567890123', 'Ana Oliveira', 'Entregar apenas de dia', '2000-09-06', '2023-03-20', 'F', '07897-757', 'Rua Augusta', 'Loja', 'Sala 3', 789, 'São Paulo', '(11) 97777-9013', 'SC', 'Consolação', 1),
(4, 1, 'carlos.rodrigues@email.com', '45678901234', 'Carlos Rodrigues', 'Cliente desde 2022', '2006-09-14', '2023-04-25', 'M', '02345-678', 'Praça da Sé', 'Casa', 'Fundos', 101, 'São Paulo', '(11) 96666-3456', 'SP', 'Sé', 1),
(5, 1, 'juliana.lima@email.com', '56789012345', 'Juliana Lima', NULL, '1995-05-18', '2023-05-30', 'F', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', '(11) 95555-7890', 'SP', 'Jardins', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamentos_os`
--

DROP TABLE IF EXISTS `equipamentos_os`;
CREATE TABLE IF NOT EXISTS `equipamentos_os` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `fabricante` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_serie` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_aparelho` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `defeito_reclamado` text COLLATE utf8mb4_general_ci,
  `condicao` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `fk_equipamentos_os` (`id_os`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `id_fornecedor` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `razao_social` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cnpj` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_fundacao` date DEFAULT NULL,
  `produto_fornecido` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logradouro` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(18) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacoes` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inativo` tinyint DEFAULT '0',
  PRIMARY KEY (`id_fornecedor`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cnpj` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id_fornecedor`, `id_usuario`, `email`, `razao_social`, `cnpj`, `data_fundacao`, `produto_fornecido`, `data_cad`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `observacoes`, `inativo`) VALUES
(1, 1, 'contato@alimentosbrasil.com.br', 'Alimentos Brasil Ltda', '12.345.678/0001-90', '1998-05-15', 'Matéria-prima alimentícia', '2023-01-10', '01234-566', 'Avenida Industrial', 'Galpão', 'Setor A', 10155, 'São Paulo', 'SP', 'Jardim Industrial', '(11) 33334-444', 'Entrega apenas dias úteis', 0),
(2, 1, 'vendas@tecnoequip.com.br', 'Tecno Equipamentos ME', '98.765.432/0001-10', '2010-11-22', 'Equipamentos industriais', '2023-02-15', '04567-890', 'Rua das Máquinas', 'Prédio', 'Sala 201', 250, 'Campinas', 'SP', 'Centro', '(19) 2555-6666', 'Fornecedor premium', 0),
(3, 1, 'sac@quimicosa.com.br', 'Químicos Associados S/A', '45.678.912/0001-34', '1985-03-08', 'Produtos químicos', '2023-03-20', '07890-123', 'Estrada do Chemical', 'Complexo', 'Bloco B', 0, 'São Paulo', 'SP', 'Interlagos', '(11) 2777-8888', 'Necessita certificação para compra', 0),
(4, 1, 'contato@embalagensrj.com.br', 'Embalagens Rio Ltda', '76.543.210/0001-56', '2005-07-30', 'Embalagens plásticas', '2023-04-25', '20000-000', 'Rua do Porto', 'Armazém', 'Porto 12', 500, 'Rio de Janeiro', 'RJ', 'Centro', '(21) 3444-5555', 'Prazo de entrega 15 dias', 1),
(5, 1, 'vendas@madeirasul.com.br', 'Madeira Sul Madeireira', '23.456.789/0001-78', '2015-12-05', 'Madeira e derivados', '2023-05-30', '90000-000', 'Avenida das Araucárias', 'Depósito', 'Pátio 3', 750, 'Porto Alegre', 'RS', 'Navegantes', '(51) 3666-7777', 'Trabalham apenas com madeira certificada', 0),
(9, 7, 'guiwg@ohiohioweifeewwq', 'sdassadasds', '23.214.323/4212-32', '0000-00-00', 'Capinhas, peliculas, câmeras', '0000-00-00', '21321-121', '3rwefwe', 'R', 'qweqeqw', 31231, 'Joinville', 'PE', 'eqweqwe', '(22) 33223-2312', 'qeqweqq', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordens_servico`
--

DROP TABLE IF EXISTS `ordens_servico`;
CREATE TABLE IF NOT EXISTS `ordens_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `data_termino` date DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'aberto',
  `observacoes` text COLLATE utf8mb4_general_ci,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ordens_cliente` (`id_cliente`),
  KEY `fk_ordens_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `os_produto`
--

DROP TABLE IF EXISTS `os_produto`;
CREATE TABLE IF NOT EXISTS `os_produto` (
  `id_os_produto` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `id_produto` int NOT NULL,
  `valor_unitario` decimal(10,2) DEFAULT '0.00',
  `valor_total` decimal(10,2) DEFAULT '0.00',
  `quantidade` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_os_produto`),
  KEY `fk_osprod_os` (`id_os`),
  KEY `fk_osprod_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE IF NOT EXISTS `pagamento` (
  `id_pagamento` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `frm_pagamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`),
  KEY `fk_pag_os` (`id_os`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int NOT NULL AUTO_INCREMENT,
  `perfil` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `perfil`) VALUES
(1, 'Administrador'),
(2, 'Atendente'),
(3, 'Técnico'),
(4, 'Financeiro'),
(5, 'Almoxarife');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nome` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aparelho_utilizado` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantidade` int DEFAULT '0',
  `preco` decimal(10,2) DEFAULT NULL,
  `data_registro` date DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `fk_produto_usuario` (`id_usuario`),
  KEY `fk_produto_fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_usuario`, `id_fornecedor`, `tipo`, `nome`, `aparelho_utilizado`, `quantidade`, `preco`, `data_registro`, `descricao`) VALUES
(1, 1, 2, 'Display', 'Tela OLED Samsung S23 Ultra', 'Samsung Galaxy S23 Ultra', 8, 899.90, '2024-03-15', 'Tela Original 6.8\" Dynamic AMOLED 2X 120Hz - Com digitizer'),
(3, 1, 2, 'Cooler', 'Kit Cooler Notebook Dell G15', 'Dell G15 Gaming', 6, 149.90, '2024-04-10', 'Ventoinha + dissipador de calor + pasta térmica premium'),
(4, 1, 3, 'Placa', 'Placa Principal TV LG OLED C3', 'LG OLED 55\" C3', 4, 1299.90, '2024-04-15', 'Placa mãe principal - Modelo EAX69085803'),
(5, 1, 3, 'Fonte', 'Fonte Chaveada TV Samsung', 'Samsung QLED 65\"', 10, 249.90, '2024-04-20', 'Fonte 120W - Modelo BN44-00999A'),
(6, 1, 1, 'Componente', 'Conector USB-C Samsung', 'Samsung Galaxy系列', 25, 29.90, '2024-05-05', 'Conector de carga flex cable - Originel'),
(7, 1, 2, 'Pasta', 'Pasta Térmica Arctic MX-6', 'Notebooks/Consoles', 30, 39.90, '2024-05-10', 'Pasta térmica premium 4g - Condutividade 10.6W/mK'),
(8, 1, 2, 'Sensor', 'Sensor Temperatura Brastemp', 'Brastemp Frost Free', 8, 89.90, '2024-05-12', 'Sensor NTC 10K - Para refrigeradores'),
(9, 1, 4, 'Material', 'Espuma Assento Sofá 28D', 'Sofás 3 lugares', 16, 59.90, '2024-05-15', 'Espuma densidade 28D - 50x50x10cm'),
(10, 1, 2, 'Peça', 'Câmera Traseira Samsung S23', 'Samsung Galaxy S23', 9, 199.90, '2024-05-18', 'Módulo câmera 50MP OIS - Original'),
(11, 1, 2, 'Teclado', 'Teclado Dell Inspiron', 'Dell Inspiron系列', 4, 129.90, '2024-05-20', 'Teclado completo ABNT2 - Com touchpad'),
(12, 1, 3, 'LED', 'Fita LED TV Backlight', 'TVs LED 55\"-65\"', 18, 49.90, '2024-05-22', 'Fita LED 120LEDs/m - 5V - Branco Quente'),
(13, 1, 2, 'Componente', 'Compressor Embraco 1/4HP', 'Geladeiras Frost Free', 2, 899.90, '2024-05-25', 'Compressor 1/4HP - Modelo VEMT10K - Nove'),
(14, 1, 1, 'Microfone', 'Microfone Samsung', 'Samsung Galaxy系列', 12, 39.90, '2024-05-28', 'Módulo microfone inferior - Compatível S20-S23'),
(15, 1, 2, 'Memória', 'RAM 8GB DDR4 3200MHz', 'Notebooks', 8, 199.90, '2024-06-01', 'Memória SODIMM 8GB DDR4 3200MHz - Kingston'),
(16, 1, 2, 'Display', 'Tela iPhone 15 Pro Max', 'iPhone 15 Pro Max', 5, 1099.90, '2024-06-05', 'Tela Original 6.7\" Super Retina XDR - Com True Tone'),
(17, 1, 3, 'Placa', 'Placa Xbox Series X', 'Xbox Series X', 5, 599.90, '2024-06-08', 'Placa mãe principal - Modelo 1882A'),
(18, 1, 2, 'Ventoinha', 'Cooler PlayStation 5', 'PlayStation 5', 8, 79.90, '2024-06-12', 'Ventoinha de refrigeração - Original Sony'),
(19, 1, 1, 'Flex', 'Flex Cable Volume Samsung', 'Samsung Galaxy系列', 15, 24.90, '2024-06-15', 'Cabo flex botões volume/power - Compatível'),
(20, 1, 2, 'SSD', 'SSD NVMe 1TB Samsung', 'Notebooks/PCs', 4, 399.90, '2024-06-18', 'SSD NVMe PCIe 4.0 1TB - 7000MB/s - 980 Pro'),
(21, 1, 1, 'Peça', 'Placa de Vídeo NVIDIA RTX 3060', 'Computadores Gaming e Workstations', 7, 1899.90, '0000-00-00', 'Placa de vídeo NVIDIA GeForce RTX 3060 12GB GDDR6 com ray tracing');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos_os`
--

DROP TABLE IF EXISTS `servicos_os`;
CREATE TABLE IF NOT EXISTS `servicos_os` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_equipamento` int NOT NULL,
  `tipo_servico` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_servicos_equipamento` (`id_equipamento`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `id_perfil` int NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_cad` date DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `sexo` enum('M','F') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cep` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logradouro` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(18) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inativo` tinyint DEFAULT '0',
  `senha_temporaria` tinyint DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `fk_usuario_perfil` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_perfil`, `nome`, `cpf`, `username`, `email`, `senha`, `data_cad`, `data_nasc`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `inativo`, `senha_temporaria`) VALUES
(1, 1, 'Pedro Gabriel Leal Costa', '053.615.340-05', 'admin.pedro', 'pedro_gabriel@gmail.com', '$2y$10$/CGsx3Lw3nJ.U4/VawEJ6OfLfGjlU37zSTBrNbFrNamVkt6N6FkAC', '2025-09-04', '2008-05-30', 'M', '72472-476', 'Rua asfaltada', NULL, NULL, 1391, 'Joinville', 'SC', 'Jardim Iririu', '(47) 98472-8108', 0, 0),
(2, 2, 'Maria Santos', '987.654.321-00', 'maria.santos', 'maria.santos@empresa.com', '$2y$10$sR9cT8uV7wX5yZ4pQ2nM6L', '2023-02-10', '1990-07-12', 'F', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', 'SP', 'Bela Vista', '(11) 98888-5678', 0, 0),
(3, 3, 'Carlos Oliveira', '456.789.123-00', 'carlos.oliveira', 'carlos.oliveira@empresa.com', '$2y$10$6OMMGHN8dASk58q5z3744uestlKnv64uM0nNfL2Pzm9aU/UNttGaC', '2023-03-20', '1988-11-05', 'M', '07890-123', 'Rua Augusta', 'Sala', 'Sala 302', 789, 'São Paulo', 'SP', 'Consolação', '(11) 97777-9012', 0, 0),
(4, 4, 'Ana Costa', '321.654.987-00', 'ana.costa', 'ana.costa@empresa.com', '$2y$10$hfG7IFiYbwPfTCtqoPxLZuLdI8SjcPxjXQkAjKBoYYIdZLJZf5uea', '2023-04-05', '1992-05-18', 'F', '02345-678', 'Praça da Sé', 'Loja', 'Fundos', 101, 'São Paulo', 'SP', 'Sé', '(11) 96666-3456', 1, 1),
(5, 3, 'Pedro Almeida', '654.321.987-00', 'pedro.almeida', 'pedro.almeida@empresa.com', '$2y$10$vU2fW1xY0z8b7cS5qN9rM6O', '2023-05-12', '1987-12-25', 'M', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', 'SP', 'Jardins', '(11) 95555-7890', 1, 1),
(6, 1, 'Helena Lopes', '123.456.789-98', 'admin.helena', 'helena_lopes@gmail.com', '$2y$10$rQZ8bW7cT9hLmN6vX5pJ3O', '2023-01-15', '2008-03-12', NULL, '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', 123, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(7, 1, 'Eduardo Reinert', '123.456.789-00', 'admin.eduardo', 'eduardo_reinert@gmail.com', '$2y$10$UAUtMkyxnfnOxyVt6/M6/.gqX9ekbr66jgIufWU96GYYFMklG2hZG', '2023-01-15', '2009-08-13', 'M', '75757-572', 'Rua das Flores', 'Casa', 'Apto 101', 123456, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(8, 5, 'Roberto', '321.654.875-43', 'roberto.leal', 'roberto@gmail.com', '$2y$10$x8zuFb1aJYYz4BEGLYOxHeDJN48QMDL.G2.HIJYvbrAXpQQRWSkDC', '2025-09-07', '2003-07-10', 'M', '35264-564', 'Rua de asfalto', 'R', 'Sobrado', 123, 'Joinville', 'SC', 'Iririu', '(47) 91465-4655', 0, 0),
(9, 1, 'Tatiane Vieira', '321.865.165-89', 'admin.tati', 'tatiane@gmail.com', '$2y$10$IctlVKGNtug30Blg3LLQRezOYxcFIyd2GptLFdwZgmS3JlQG1lSn6', '2025-09-07', '2009-06-23', 'F', '46546-456', 'Rua de asfalto', 'R', 'Casa de dois an', 1970, 'Joinville', 'SC', 'Jardim Iririu', '(47) 98430-3837', 0, 0);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `equipamentos_os`
--
ALTER TABLE `equipamentos_os`
  ADD CONSTRAINT `fk_equipamentos_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ordens_servico`
--
ALTER TABLE `ordens_servico`
  ADD CONSTRAINT `fk_ordens_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ordens_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `os_produto`
--
ALTER TABLE `os_produto`
  ADD CONSTRAINT `fk_osprod_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_osprod_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_pag_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produto_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produto_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `servicos_os`
--
ALTER TABLE `servicos_os`
  ADD CONSTRAINT `fk_servicos_equipamento` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos_os` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
