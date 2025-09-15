-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/09/2025 às 22:02
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
-- Banco de dados: `conserta_tech_sa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf` varchar(18) DEFAULT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  `inativo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_usuario`, `email`, `cpf`, `nome`, `observacao`, `data_nasc`, `data_cad`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `telefone`, `uf`, `bairro`, `inativo`) VALUES
(1, 1, 'maria.silva@email.com', '12345678901', 'Maria Silva', 'Cliente preferencial', '1985-03-15', '2023-01-10', 'F', '01234-567', 'Rua das Flores', 'Casa', 'Apto 102', 123, 'São Paulo', '(11) 99999-1234', 'SP', 'Centro', 0),
(2, 1, 'joao.santos@email.com', '23456789012', 'João Santos', NULL, '1990-07-22', '2023-02-15', 'M', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', '(11) 98888-5678', 'SP', 'Bela Vista', 0),
(3, 1, 'ana.oliveira@email.com', '34567890123', 'Ana Oliveira', 'Entregar apenas de dia', '2000-09-06', '2023-03-20', 'F', '07897-757', 'Rua Augusto', 'Loja', 'Sala 3', 789, 'São Paulo', '(11) 97777-9013', 'SC', 'Consolação', 1),
(4, 1, 'carlos.rodrigues@email.com', '45678901234', 'Carlos Rodrigues', 'Cliente desde 2022', '2006-09-14', '2023-04-25', 'M', '02345-678', 'Praça da Sé', 'Casa', 'Fundos', 101, 'São Paulo', '(11) 96666-3456', 'SP', 'Sé', 1),
(5, 1, 'juliana.lima@email.com', '56789012345', 'Juliana Lima', NULL, '1995-05-18', '2023-05-30', 'F', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', '(11) 95555-7890', 'SP', 'Jardins', 0),
(6, 1, 'carla.oliveira@email.com', '678.901.234-56', 'Carla Oliveira', 'Cliente fidelidade', '1992-08-12', '2023-06-10', 'F', '03456-789', 'Rua das Palmeiras', 'Apartamento', 'Apto 302', 300, 'São Paulo', '(11) 94444-1234', 'SP', 'Vila Madalena', 0),
(7, 1, 'ricardo.santos@email.com', '789.012.345-67', 'Ricardo Santos', NULL, '1988-11-25', '2023-07-15', 'M', '04567-890', 'Avenida Brigadeiro Faria Lima', 'Apartamento', 'Apto 501', 1500, 'São Paulo', '(11) 93333-5678', 'SP', 'Itaim Bibi', 0),
(8, 1, 'fernanda.costa@email.com', '890.123.456-78', 'Fernanda Costa', 'Entregar após 18h', '1995-03-18', '2023-08-20', 'F', '05678-901', 'Rua Augusta', 'Loja', 'Sala 5', 789, 'São Paulo', '(11) 92222-9012', 'SP', 'Consolação', 0),
(9, 1, 'paulo.rodrigues@email.com', '901.234.567-89', 'Paulo Rodrigues', 'Cliente desde 2021', '1980-12-05', '2023-09-25', 'M', '06789-012', 'Alameda Santos', 'Apartamento', 'Apto 1201', 200, 'São Paulo', '(11) 91111-3456', 'SP', 'Jardim Paulista', 0),
(10, 1, 'amanda.lima@email.com', '012.345.678-90', 'Amanda Lima', NULL, '1998-07-30', '2023-10-30', 'F', '07890-123', 'Rua Oscar Freire', 'Apartamento', 'Apto 801', 350, 'São Paulo', '(11) 98888-7890', 'SP', 'Jardins', 0),
(11, 1, 'marcos.silva@email.com', '123.456.789-01', 'Marcos Silva', 'Prefere contato por WhatsApp', '1991-04-22', '2023-11-05', 'M', '08901-234', 'Rua da Consolação', 'Casa', 'Fundos', 450, 'São Paulo', '(11) 97777-1234', 'SP', 'Consolação', 0),
(12, 1, 'juliana.oliveira@email.com', '234.567.890-12', 'Juliana Oliveira', 'Cliente premium', '1987-09-15', '2023-12-10', 'F', '09012-345', 'Avenida Paulista', 'Apartamento', 'Apto 1502', 2100, 'São Paulo', '(11) 96666-5678', 'SP', 'Bela Vista', 0),
(13, 1, 'roberto.santos@email.com', '345.678.901-23', 'Roberto Santos', NULL, '1993-01-08', '2024-01-15', 'M', '10123-456', 'Rua Haddock Lobo', 'Apartamento', 'Apto 602', 800, 'São Paulo', '(11) 95555-9012', 'SP', 'Cerqueira César', 0),
(14, 1, 'patricia.costa@email.com', '456.789.012-34', 'Patricia Costa', 'Não ligar após 21h', '1985-06-20', '2024-02-20', 'F', '11234-567', 'Rua Frei Caneca', 'Loja', 'Sala 10', 600, 'São Paulo', '(11) 94444-3456', 'SP', 'Consolação', 0),
(15, 1, 'felipe.rodrigues@email.com', '567.890.123-45', 'Felipe Rodrigues', 'Cliente corporativo', '1979-02-14', '2024-03-25', 'M', '12345-678', 'Alameda Jaú', 'Apartamento', 'Apto 301', 950, 'São Paulo', '(11) 93333-7890', 'SP', 'Jardim Paulista', 0),
(16, 1, 'larissa.lima@email.com', '678.901.234-56', 'Larissa Lima', NULL, '1996-10-03', '2024-04-30', 'F', '13456-789', 'Rua Bela Cintra', 'Apartamento', 'Apto 402', 1100, 'São Paulo', '(11) 92222-1234', 'SP', 'Consolação', 0),
(17, 1, 'gabriel.silva@email.com', '789.012.345-67', 'Gabriel Silva', 'Estudante - desconto', '2000-05-17', '2024-05-05', 'M', '14567-890', 'Rua Augusta', 'Casa', 'Frente', 120, 'São Paulo', '(11) 91111-5678', 'SP', 'Consolação', 0),
(18, 1, 'vanessa.oliveira@email.com', '890.123.456-78', 'Vanessa Oliveira', 'Cliente fidelidade', '1994-08-28', '2024-06-10', 'F', '15678-901', 'Avenida Rebouças', 'Apartamento', 'Apto 701', 1300, 'São Paulo', '(11) 98888-9012', 'SP', 'Pinheiros', 0),
(19, 1, 'daniel.santos@email.com', '901.234.567-89', 'Daniel Santos', NULL, '1983-03-12', '2024-07-15', 'M', '16789-012', 'Rua dos Pinheiros', 'Apartamento', 'Apto 202', 1400, 'São Paulo', '(11) 97777-3456', 'SP', 'Pinheiros', 0),
(20, 1, 'camila.costa@email.com', '012.345.678-90', 'Camila Costa', 'Entregar apenas finais de semana', '1997-11-07', '2024-08-20', 'F', '17890-123', 'Rua Artur de Azevedo', 'Apartamento', 'Apto 901', 1500, 'São Paulo', '(11) 96666-7890', 'SP', 'Pinheiros', 0),
(21, 1, 'rafael.rodrigues@email.com', '123.456.789-01', 'Rafael Rodrigues', 'Cliente VIP', '1989-07-24', '2024-09-25', 'M', '18901-234', 'Rua Estados Unidos', 'Apartamento', 'Apto 502', 1600, 'São Paulo', '(11) 95555-1234', 'SP', 'Jardim América', 0),
(22, 1, 'tatiane.lima@email.com', '234.567.890-12', 'Tatiane Lima', NULL, '1992-12-19', '2024-10-30', 'F', '19012-345', 'Alameda Santos', 'Apartamento', 'Apto 1101', 1700, 'São Paulo', '(11) 94444-5678', 'SP', 'Jardim Paulista', 0),
(23, 1, 'leonardo.silva@email.com', '345.678.901-23', 'Leonardo Silva', 'Não enviar SMS', '1986-04-02', '2024-11-05', 'M', '20123-456', 'Rua Oscar Freire', 'Loja', 'Sala 3', 1800, 'São Paulo', '(11) 93333-9012', 'SP', 'Jardins', 0),
(24, 1, 'bruna.oliveira@email.com', '456.789.012-34', 'Bruna Oliveira', 'Cliente desde 2020', '1999-09-15', '2024-12-10', 'F', '21234-567', 'Avenida Europa', 'Apartamento', 'Apto 601', 1900, 'São Paulo', '(11) 92222-3456', 'SP', 'Jardim Europa', 0),
(25, 1, 'thiago.santos@email.com', '567.890.123-45', 'Thiago Santos', NULL, '1984-01-28', '2025-01-15', 'M', '22345-678', 'Rua Gomes de Carvalho', 'Apartamento', 'Apto 801', 2000, 'São Paulo', '(11) 91111-7890', 'SP', 'Vila Olímpia', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamentos_os`
--

CREATE TABLE `equipamentos_os` (
  `id` int(11) NOT NULL,
  `id_os` int(11) NOT NULL,
  `fabricante` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `num_serie` varchar(50) DEFAULT NULL,
  `num_aparelho` varchar(50) DEFAULT NULL,
  `defeito_reclamado` text DEFAULT NULL,
  `condicao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `equipamentos_os`
--

INSERT INTO `equipamentos_os` (`id`, `id_os`, `fabricante`, `modelo`, `num_serie`, `num_aparelho`, `defeito_reclamado`, `condicao`) VALUES
(32, 22, 'apple', 'iphone 14', '5445323', '878543', 'tela trincada', 'tela trincada'),
(53, 48, 'Samsung', 'Galaxy S23 Ultra', 'SN100000001', 'IMEI100000001', 'Defeito relatado para ordem 1', 'Condição do equipamento para ordem 1'),
(54, 49, 'Apple', 'iPhone 15 Pro Max', 'SN100000002', 'IMEI100000002', 'Defeito relatado para ordem 2', 'Condição do equipamento para ordem 2'),
(55, 50, 'Dell', 'Inspiron 15 5000', 'SN100000003', 'IMEI100000003', 'Defeito relatado para ordem 3', 'Condição do equipamento para ordem 3'),
(56, 51, 'LG', 'OLED 55C3', 'SN100000004', 'IMEI100000004', 'Defeito relatado para ordem 4', 'Condição do equipamento para ordem 4'),
(57, 52, 'Samsung', 'QLED 65Q80C', 'SN100000005', 'IMEI100000005', 'Defeito relatado para ordem 5', 'Condição do equipamento para ordem 5'),
(58, 53, 'Sony', 'PlayStation 5', 'SN100000006', 'IMEI100000006', 'Defeito relatado para ordem 6', 'Condição do equipamento para ordem 6'),
(59, 54, 'Microsoft', 'Xbox Series X', 'SN100000007', 'IMEI100000007', 'Defeito relatado para ordem 7', 'Condição do equipamento para ordem 7'),
(60, 55, 'Brastemp', 'Frost Free 375L', 'SN100000008', 'IMEI100000008', 'Defeito relatado para ordem 8', 'Condição do equipamento para ordem 8'),
(61, 56, 'Samsung', 'Galaxy S22', 'SN100000009', 'IMEI100000009', 'Defeito relatado para ordem 9', 'Condição do equipamento para ordem 9'),
(62, 57, 'Apple', 'MacBook Pro 13\"', 'SN100000010', 'IMEI100000010', 'Defeito relatado para ordem 10', 'Condição do equipamento para ordem 10'),
(63, 58, 'Dell', 'G15 Gaming', 'SN100000011', 'IMEI100000011', 'Defeito relatado para ordem 11', 'Condição do equipamento para ordem 11'),
(64, 59, 'Samsung', 'Galaxy Z Fold4', 'SN100000012', 'IMEI100000012', 'Defeito relatado para ordem 12', 'Condição do equipamento para ordem 12'),
(65, 60, 'Apple', 'iPad Pro 12.9\"', 'SN100000013', 'IMEI100000013', 'Defeito relatado para ordem 13', 'Condição do equipamento para ordem 13'),
(66, 61, 'LG', 'WashTower', 'SN100000014', 'IMEI100000014', 'Defeito relatado para ordem 14', 'Condição do equipamento para ordem 14'),
(67, 62, 'Sony', 'WH-1000XM4', 'SN100000015', 'IMEI100000015', 'Defeito relatado para ordem 15', 'Condição do equipamento para ordem 15'),
(68, 63, 'Microsoft', 'Surface Laptop 4', 'SN100000016', 'IMEI100000016', 'Defeito relatado para ordem 16', 'Condição do equipamento para ordem 16'),
(69, 64, 'Samsung', 'Galaxy Watch 6', 'SN100000017', 'IMEI100000017', 'Defeito relatado para ordem 17', 'Condição do equipamento para ordem 17'),
(70, 65, 'Apple', 'AirPods Pro', 'SN100000018', 'IMEI100000018', 'Defeito relatado para ordem 18', 'Condição do equipamento para ordem 18'),
(71, 66, 'Dell', 'XPS 13', 'SN100000019', 'IMEI100000019', 'Defeito relatado para ordem 19', 'Condição do equipamento para ordem 19'),
(72, 67, 'Samsung', 'The Frame 55\"', 'SN100000020', 'IMEI100000020', 'Defeito relatado para ordem 20', 'Condição do equipamento para ordem 20'),
(73, 68, 'Motorola', 'Moto G Power', 'SN200000001', 'IMEI200000001', 'Não carrega', 'Bateria descarregada'),
(74, 69, 'Sony', 'Xperia 1 III', 'SN200000002', 'IMEI200000002', 'Tela quebrada', 'Display danificado'),
(75, 70, 'Apple', 'iPhone 13', 'SN200000003', 'IMEI200000003', 'Não liga', 'Problema na placa mãe'),
(76, 71, 'Samsung', 'Galaxy A54', 'SN200000004', 'IMEI200000004', 'Áudio não funciona', 'Alto-falante danificado'),
(93, 88, 'apple', 'iphone 14', '5445323', '878543', 'tela', 'tela');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `razao_social` varchar(50) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `data_fundacao` date DEFAULT NULL,
  `produto_fornecido` varchar(100) DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `inativo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id_fornecedor`, `id_usuario`, `email`, `razao_social`, `cnpj`, `data_fundacao`, `produto_fornecido`, `data_cad`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `observacoes`, `inativo`) VALUES
(1, 1, 'contato@alimentosbrasil.com.br', 'Alimentos Brasil Ltda', '12.345.678/0001-90', '1998-05-15', 'Matéria-prima alimentícia', '2023-01-10', '01234-566', 'Avenida Industrial', 'Galpão', 'Setor A', 10155, 'São Paulo', 'SP', 'Jardim Industrial', '(11) 33334-444', 'Entrega apenas dias úteis', 0),
(2, 1, 'vendas@tecnoequip.com.br', 'Tecno Equipamentos ME', '98.765.432/0001-10', '2010-11-22', 'Equipamentos industriais', '2023-02-15', '04567-890', 'Rua das Máquinas', 'Prédio', 'Sala 201', 250, 'Campinas', 'SP', 'Centro', '(19) 2555-6666', 'Fornecedor premium', 0),
(3, 1, 'sac@quimicosa.com.br', 'Químicos Associados S/A', '45.678.912/0001-34', '1985-03-08', 'Produtos químicos', '2023-03-20', '07890-123', 'Estrada do Chemical', 'Complexo', 'Bloco B', 0, 'São Paulo', 'SP', 'Interlagos', '(11) 2777-8888', 'Necessita certificação para compra', 0),
(4, 1, 'contato@embalagensrj.com.br', 'Embalagens Rio Ltda', '76.543.210/0001-56', '2005-07-30', 'Embalagens plásticas', '2023-04-25', '20000-000', 'Rua do Porto', 'Armazém', 'Porto 12', 500, 'Rio de Janeiro', 'RJ', 'Centro', '(21) 3444-5555', 'Prazo de entrega 15 dias', 0),
(5, 1, 'vendas@madeirasul.com.br', 'Madeira Sul Madeireira', '23.456.789/0001-78', '2015-12-05', 'Madeira e derivados', '2023-05-30', '90000-000', 'Avenida das Araucárias', 'Depósito', 'Pátio 3', 750, 'Porto Alegre', 'RS', 'Navegantes', '(51) 3666-7777', 'Trabalham apenas com madeira certificada', 0),
(9, 7, 'guiwg@ohiohioweifeewwq', 'sdassadasds', '23.214.323/4212-32', '0000-00-00', 'Capinhas, peliculas, câmeras', '0000-00-00', '21321-121', '3rwefwe', 'R', 'qweqeqw', 31231, 'Joinville', 'PE', 'eqweqwe', '(22) 33223-2312', 'qeqweqq', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordens_servico`
--

CREATE TABLE `ordens_servico` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_termino` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'aberto',
  `observacoes` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordens_servico`
--

INSERT INTO `ordens_servico` (`id`, `id_cliente`, `id_usuario`, `data_termino`, `status`, `observacoes`, `data_criacao`) VALUES
(22, 5, 3, '2025-09-25', 'Concluído', '.', '2025-09-15 17:43:49'),
(48, 1, 3, '2025-09-16', 'Concluído', 'Observação para ordem 1', '2025-08-27 18:19:02'),
(49, 1, 2, NULL, 'Concluído', 'Observação para ordem 2', '2025-08-28 18:19:02'),
(50, 1, 3, '2025-09-18', 'Concluído', 'Observação para ordem 3', '2025-08-29 18:19:02'),
(51, 1, 5, NULL, 'Concluído', 'Observação para ordem 4', '2025-08-30 18:19:02'),
(52, 1, 3, '2025-09-20', 'Concluído', 'Observação para ordem 5', '2025-08-31 18:19:02'),
(53, 2, 2, NULL, 'Concluído', 'Observação para ordem 6', '2025-09-01 18:19:02'),
(54, 2, 3, '2025-09-22', 'Concluído', 'Observação para ordem 7', '2025-09-02 18:19:02'),
(55, 2, 5, NULL, 'Concluído', 'Observação para ordem 8', '2025-09-03 18:19:02'),
(56, 2, 3, '2025-09-24', 'Concluído', 'Observação para ordem 9', '2025-09-04 18:19:02'),
(57, 2, 2, NULL, 'Concluído', 'Observação para ordem 10', '2025-09-05 18:19:02'),
(58, 5, 3, '2025-09-26', 'Concluído', 'Observação para ordem 11', '2025-09-06 18:19:02'),
(59, 5, 5, NULL, 'Concluído', 'Observação para ordem 12', '2025-09-07 18:19:02'),
(60, 5, 3, '2025-09-28', 'Concluído', 'Observação para ordem 13', '2025-09-08 18:19:02'),
(61, 5, 2, NULL, 'Concluído', 'Observação para ordem 14', '2025-09-09 18:19:02'),
(62, 5, 3, '2025-09-30', 'Concluído', 'Observação para ordem 15', '2025-09-10 18:19:02'),
(63, 5, 5, NULL, 'Concluído', 'Observação para ordem 16', '2025-09-11 18:19:02'),
(64, 1, 3, '2025-10-02', 'Concluído', 'Observação para ordem 17', '2025-09-12 18:19:02'),
(65, 1, 2, NULL, 'Concluído', 'Observação para ordem 18', '2025-09-13 18:19:02'),
(66, 1, 3, '2025-10-04', 'Concluído', 'Observação para ordem 19', '2025-09-14 18:19:02'),
(67, 2, 5, NULL, 'Concluído', 'Observação para ordem 20', '2025-09-15 18:19:02'),
(68, 3, 3, '2025-02-15', 'Concluído', 'OS criada há 7 meses', '2024-02-15 13:30:00'),
(69, 3, 2, '2025-03-20', 'Concluído', 'OS criada há 6 meses', '2024-03-20 17:45:00'),
(70, 4, 5, '2025-01-10', 'Concluído', 'OS criada há 8 meses', '2024-01-10 12:15:00'),
(71, 4, 3, '2025-04-05', 'Concluído', 'OS criada há 5 meses', '2024-04-05 19:20:00'),
(88, 19, 11, '2025-09-30', 'Concluído', '.', '2025-09-15 18:53:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `os_produto`
--

CREATE TABLE `os_produto` (
  `id_os_produto` int(11) NOT NULL,
  `id_os` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) DEFAULT 0.00,
  `valor_total` decimal(10,2) DEFAULT 0.00,
  `quantidade` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `os_produto`
--

INSERT INTO `os_produto` (`id_os_produto`, `id_os`, `id_produto`, `valor_unitario`, `valor_total`, `quantidade`) VALUES
(18, 22, 16, 1099.90, 1099.90, 1),
(19, 48, 1, 899.90, 899.90, 1),
(20, 51, 4, 1299.90, 1299.90, 1),
(21, 54, 7, 39.90, 39.90, 1),
(22, 57, 10, 199.90, 199.90, 1),
(23, 60, 13, 899.90, 899.90, 1),
(24, 63, 16, 1099.90, 1099.90, 1),
(25, 66, 19, 24.90, 24.90, 1),
(26, 68, 3, 149.90, 149.90, 1),
(27, 69, 16, 1099.90, 1099.90, 1),
(28, 70, 7, 39.90, 39.90, 1),
(29, 71, 10, 199.90, 199.90, 1),
(46, 88, 16, 1099.90, 1099.90, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_os` int(11) NOT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `frm_pagamento` varchar(50) DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`id_pagamento`, `id_os`, `valor_total`, `frm_pagamento`, `data_pagamento`, `status`) VALUES
(24, 67, 650.00, 'Boleto', '2025-09-15', 'Concluído'),
(25, 66, 630.00, 'Boleto', '2025-09-15', 'Concluído'),
(26, 64, 590.00, 'Boleto', '2025-09-15', 'Concluído'),
(27, 63, 570.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(28, 62, 650.00, 'PIX', '2025-09-15', 'Concluído'),
(29, 60, 590.00, 'Boleto', '2025-09-15', 'Concluído'),
(30, 59, 560.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(31, 58, 530.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(32, 56, 510.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(33, 55, 470.00, 'Cartão de Crédito', '2025-09-15', 'Concluído'),
(34, 54, 430.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(35, 52, 350.00, 'Boleto', '2025-09-15', 'Concluído'),
(36, 51, 300.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(37, 50, 250.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(38, 48, 150.00, 'Cartão de Crédito', '2025-09-15', 'Concluído'),
(39, 49, 200.00, 'Transferência', '2025-09-15', 'Concluído'),
(40, 22, 250.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(41, 65, 610.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(42, 61, 620.00, 'Transferência', '2025-09-15', 'Concluído'),
(43, 57, 550.00, 'Transferência', '2025-09-15', 'Concluído'),
(44, 53, 390.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(68, 71, 120.00, 'Cartão de Débito', '2025-09-15', 'Concluído'),
(76, 69, 350.00, 'Dinheiro', '2025-09-15', 'Concluído'),
(79, 68, 180.00, 'Cartão de Crédito', '2025-09-15', 'Concluído'),
(81, 70, 420.00, 'Cartão de Crédito', '2025-09-15', 'Concluído'),
(85, 88, 500.00, 'Boleto', '2025-09-15', 'Concluído');

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `aparelho_utilizado` varchar(50) DEFAULT NULL,
  `quantidade` int(11) DEFAULT 0,
  `preco` decimal(10,2) DEFAULT NULL,
  `data_registro` date DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_usuario`, `id_fornecedor`, `tipo`, `nome`, `aparelho_utilizado`, `quantidade`, `preco`, `data_registro`, `descricao`) VALUES
(1, 1, 2, 'Display', 'Tela OLED Samsung S23 Ultra', 'Samsung Galaxy S23 Ultra', 7, 899.90, '2024-03-15', 'Tela Original 6.8\" Dynamic AMOLED 2X 120Hz - Com digitizer'),
(3, 1, 2, 'Cooler', 'Kit Cooler Notebook Dell G15', 'Dell G15 Gaming', 6, 149.90, '2024-04-10', 'Ventoinha + dissipador de calor + pasta térmica premium'),
(4, 1, 3, 'Placa', 'Placa Principal TV LG OLED C3', 'LG OLED 55\" C3', 4, 1299.90, '2024-04-15', 'Placa mãe principal - Modelo EAX69085803'),
(5, 1, 3, 'Fonte', 'Fonte Chaveada TV Samsung', 'Samsung QLED 65\"', 10, 249.90, '2024-04-20', 'Fonte 120W - Modelo BN44-00999A'),
(6, 1, 1, 'Componente', 'Conector USB-C Samsung', 'Samsung Galaxy系列', 24, 29.90, '2024-05-05', 'Conector de carga flex cable - Originel'),
(7, 1, 2, 'Pasta', 'Pasta Térmica Arctic MX-6', 'Notebooks/Consoles', 30, 39.90, '2024-05-10', 'Pasta térmica premium 4g - Condutividade 10.6W/mK'),
(8, 1, 2, 'Sensor', 'Sensor Temperatura Brastemp', 'Brastemp Frost Free', 8, 89.90, '2024-05-12', 'Sensor NTC 10K - Para refrigeradores'),
(9, 1, 4, 'Material', 'Espuma Assento Sofá 28D', 'Sofás 3 lugares', 16, 59.90, '2024-05-15', 'Espuma densidade 28D - 50x50x10cm'),
(10, 1, 2, 'Peça', 'Câmera Traseira Samsung S23', 'Samsung Galaxy S23', 9, 199.90, '2024-05-18', 'Módulo câmera 50MP OIS - Original'),
(11, 1, 2, 'Teclado', 'Teclado Dell Inspiron', 'Dell Inspiron系列', 4, 129.90, '2024-05-20', 'Teclado completo ABNT2 - Com touchpad'),
(12, 1, 3, 'LED', 'Fita LED TV Backlight', 'TVs LED 55\"-65\"', 18, 49.90, '2024-05-22', 'Fita LED 120LEDs/m - 5V - Branco Quente'),
(13, 1, 2, 'Componente', 'Compressor Embraco 1/4HP', 'Geladeiras Frost Free', 2, 899.90, '2024-05-25', 'Compressor 1/4HP - Modelo VEMT10K - Nove'),
(14, 1, 1, 'Microfone', 'Microfone Samsung', 'Samsung Galaxy系列', 12, 39.90, '2024-05-28', 'Módulo microfone inferior - Compatível S20-S23'),
(15, 1, 2, 'Memória', 'RAM 8GB DDR4 3200MHz', 'Notebooks', 8, 199.90, '2024-06-01', 'Memória SODIMM 8GB DDR4 3200MHz - Kingston'),
(16, 1, 2, 'Display', 'Tela iPhone 15 Pro Max', 'iPhone 15 Pro Max', 3, 1099.90, '2024-06-05', 'Tela Original 6.7\" Super Retina XDR - Com True Tone'),
(17, 1, 3, 'Placa', 'Placa Xbox Series X', 'Xbox Series X', 5, 599.90, '2024-06-08', 'Placa mãe principal - Modelo 1882A'),
(18, 1, 2, 'Ventoinha', 'Cooler PlayStation 5', 'PlayStation 5', 8, 79.90, '2024-06-12', 'Ventoinha de refrigeração - Original Sony'),
(19, 1, 1, 'Flex', 'Flex Cable Volume Samsung', 'Samsung Galaxy系列', 15, 24.90, '2024-06-15', 'Cabo flex botões volume/power - Compatível'),
(20, 1, 2, 'SSD', 'SSD NVMe 1TB Samsung', 'Notebooks/PCs', 4, 399.90, '2024-06-18', 'SSD NVMe PCIe 4.0 1TB - 7000MB/s - 980 Pro'),
(21, 1, 1, 'Peça', 'Placa de Vídeo NVIDIA RTX 3060', 'Computadores Gaming e Workstations', 7, 1899.90, '0000-00-00', 'Placa de vídeo NVIDIA GeForce RTX 3060 12GB GDDR6 com ray tracing');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos_os`
--

CREATE TABLE `servicos_os` (
  `id` int(11) NOT NULL,
  `id_equipamento` int(11) NOT NULL,
  `tipo_servico` varchar(50) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos_os`
--

INSERT INTO `servicos_os` (`id`, `id_equipamento`, `tipo_servico`, `descricao`, `valor`) VALUES
(24, 32, 'troca de tela', 'troca de tela superficial', 250.00),
(25, 53, 'Troca de Tela', 'Descrição do serviço para ordem 1', 150.00),
(26, 54, 'Troca de Bateria', 'Descrição do serviço para ordem 2', 200.00),
(27, 55, 'Limpeza e Manutenção', 'Descrição do serviço para ordem 3', 250.00),
(28, 56, 'Troca de Placa', 'Descrição do serviço para ordem 4', 300.00),
(29, 57, 'Troca de Tela', 'Descrição do serviço para ordem 5', 350.00),
(30, 58, 'Reparo Componente', 'Descrição do serviço para ordem 6', 390.00),
(31, 59, 'Limpeza e Manutenção', 'Descrição do serviço para ordem 7', 430.00),
(32, 60, 'Troca de Placa', 'Descrição do serviço para ordem 8', 470.00),
(33, 61, 'Troca de Bateria', 'Descrição do serviço para ordem 9', 510.00),
(34, 62, 'Reparo Componente', 'Descrição do serviço para ordem 10', 550.00),
(35, 63, 'Limpeza e Manutenção', 'Descrição do serviço para ordem 11', 530.00),
(36, 64, 'Diagnóstico e Reparo', 'Descrição do serviço para ordem 12', 560.00),
(37, 65, 'Troca de Bateria', 'Descrição do serviço para ordem 13', 590.00),
(38, 66, 'Reparo Componente', 'Descrição do serviço para ordem 14', 620.00),
(39, 67, 'Diagnóstico e Reparo', 'Descrição do serviço para ordem 15', 650.00),
(40, 68, 'Troca de Tela', 'Descrição do serviço para ordem 16', 570.00),
(41, 69, 'Troca de Bateria', 'Descrição do serviço para ordem 17', 590.00),
(42, 70, 'Reparo Componente', 'Descrição do serviço para ordem 18', 610.00),
(43, 71, 'Troca de Bateria', 'Descrição do serviço para ordem 19', 630.00),
(44, 72, 'Diagnóstico e Reparo', 'Descrição do serviço para ordem 20', 650.00),
(45, 73, 'Troca de Bateria', 'Substituição da bateria original', 180.00),
(46, 74, 'Troca de Tela', 'Substituição do display original', 350.00),
(47, 75, 'Reparo na Placa Mãe', 'Reparo do circuito de energia', 420.00),
(48, 76, 'Troca de Alto-falante', 'Substituição do módulo de áudio', 120.00),
(65, 93, 'troca de tela', 'troca de tela superficial', 500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cad` date DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  `inativo` tinyint(4) DEFAULT 0,
  `senha_temporaria` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_perfil`, `nome`, `cpf`, `username`, `email`, `senha`, `data_cad`, `data_nasc`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `inativo`, `senha_temporaria`) VALUES
(1, 1, 'Pedro Gabriel Leal Costa', '053.615.340-05', 'admin.pedro', 'pedro_gabriel@gmail.com', '$2y$10$/CGsx3Lw3nJ.U4/VawEJ6OfLfGjlU37zSTBrNbFrNamVkt6N6FkAC', '2025-09-04', '2008-05-30', 'M', '72472-476', 'Rua asfaltada', NULL, NULL, 1391, 'Joinville', 'SC', 'Jardim Iririu', '(47) 98472-8108', 0, 0),
(2, 2, 'Maria Santos', '987.654.321-00', 'maria.santos', 'maria.santos@empresa.com', '$2y$10$sR9cT8uV7wX5yZ4pQ2nM6L', '2023-02-10', '1990-07-12', 'F', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', 'SP', 'Bela Vista', '(11) 98888-5678', 0, 0),
(3, 3, 'Carlos Oliveira', '456.789.123-00', 'carlos.oliveira', 'carlos.oliveira@empresa.com', '$2y$10$6OMMGHN8dASk58q5z3744uestlKnv64uM0nNfL2Pzm9aU/UNttGaC', '2023-03-20', '1988-11-05', 'M', '07890-123', 'Rua Augusta', 'Sala', 'Sala 302', 789, 'São Paulo', 'SP', 'Consolação', '(11) 97777-9012', 0, 0),
(4, 4, 'Ana Costa', '321.654.987-00', 'ana.costa', 'ana.costa@empresa.com', '$2y$10$hfG7IFiYbwPfTCtqoPxLZuLdI8SjcPxjXQkAjKBoYYIdZLJZf5uea', '2023-04-05', '1992-05-18', 'F', '02345-678', 'Praça da Sé', 'Loja', 'Fundos', 101, 'São Paulo', 'SP', 'Sé', '(11) 96666-3456', 1, 1),
(5, 3, 'Pedro Almeida', '654.321.987-00', 'pedro.almeida', 'pedro.almeida@empresa.com', '$2y$10$vU2fW1xY0z8b7cS5qN9rM6O', '2023-05-12', '1987-12-25', 'M', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', 'SP', 'Jardins', '(11) 95555-7890', 1, 1),
(6, 1, 'Helena Lopes', '123.456.789-98', 'admin.helena', 'helena_lopes@gmail.com', '$2y$10$rQZ8bW7cT9hLmN6vX5pJ3O', '2023-01-15', '2008-03-12', 'F', '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', 123, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(7, 1, 'Eduardo Reinert', '123.456.789-00', 'admin.eduardo', 'eduardo_reinert@gmail.com', '$2y$10$UAUtMkyxnfnOxyVt6/M6/.gqX9ekbr66jgIufWU96GYYFMklG2hZG', '2023-01-15', '2009-08-13', 'M', '75757-572', 'Rua das Flores', 'Casa', 'Apto 101', 123456, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(8, 5, 'Roberto', '321.654.875-43', 'roberto.leal', 'roberto@gmail.com', '$2y$10$x8zuFb1aJYYz4BEGLYOxHeDJN48QMDL.G2.HIJYvbrAXpQQRWSkDC', '2025-09-07', '2003-07-10', 'M', '35264-564', 'Rua de asfalto', 'R', 'Sobrado', 123, 'Joinville', 'SC', 'Iririu', '(47) 91465-4655', 0, 0),
(9, 1, 'Tatiane Vieira', '321.865.165-89', 'admin.tati', 'tatiane@gmail.com', '$2y$10$IctlVKGNtug30Blg3LLQRezOYxcFIyd2GptLFdwZgmS3JlQG1lSn6', '2025-09-07', '2009-06-23', 'F', '46546-456', 'Rua de asfalto', 'R', 'Casa de dois an', 1970, 'Joinville', 'SC', 'Jardim Iririu', '(47) 98430-3837', 0, 0),
(10, 1, 'admininstrador', '123.654.984-65', 'admin', 'admin@admin', '$2y$10$YshzEiLBqoKR9.P9qsfw4.hho6jLJ/EGnLdtWl/7ntEK2JtQ2dZBq', '2025-09-08', '1980-09-18', 'M', '32424-324', 'Rua de asfalto', 'R', 'Sobrado', 13213, 'Joinville', 'SC', 'Iririu', '(47) 95453-2164', 0, 0),
(11, 3, 'Carlos Eduardo Martins', '123.456.789-11', 'carlos.tec', 'carlos.martins@consortech.com.br', '$2y$10$6OMMGHN8dASk58q5z3744uestlKnv64uM0nNfL2Pzm9aU/UNttGaC', '2024-01-15', '1990-05-20', 'M', '04567-890', 'Rua das Tecnologias', 'Casa', 'Fundos', 123, 'São Paulo', 'SP', 'Vila Olímpia', '(11) 97777-8888', 0, 0),
(12, 3, 'Ana Carolina Silva', '234.567.890-22', 'ana.tec', 'ana.silva@consortech.com.br', '$2y$10$hfG7IFiYbwPfTCtqoPxLZuLdI8SjcPxjXQkAjKBoYYIdZLJZf5uea', '2024-02-20', '1988-09-12', 'F', '05678-901', 'Avenida dos Inventores', 'Apartamento', 'Apto 302', 456, 'São Paulo', 'SP', 'Itaim Bibi', '(11) 96666-7777', 0, 0),
(13, 3, 'Ricardo Oliveira Santos', '345.678.901-33', 'ricardo.tec', 'ricardo.santos@consortech.com.br', '$2y$10$vU2fW1xY0z8b7cS5qN9rM6O', '2024-03-10', '1992-03-25', 'M', '06789-012', 'Praça das Inovações', 'Casa', 'Sobrado', 789, 'São Paulo', 'SP', 'Pinheiros', '(11) 95555-6666', 0, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fk_cliente_usuario` (`id_usuario`);

--
-- Índices de tabela `equipamentos_os`
--
ALTER TABLE `equipamentos_os`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipamentos_os` (`id_os`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `ordens_servico`
--
ALTER TABLE `ordens_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordens_cliente` (`id_cliente`),
  ADD KEY `fk_ordens_usuario` (`id_usuario`);

--
-- Índices de tabela `os_produto`
--
ALTER TABLE `os_produto`
  ADD PRIMARY KEY (`id_os_produto`),
  ADD KEY `fk_osprod_os` (`id_os`),
  ADD KEY `fk_osprod_produto` (`id_produto`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `fk_pag_os` (`id_os`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `fk_produto_usuario` (`id_usuario`),
  ADD KEY `fk_produto_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `servicos_os`
--
ALTER TABLE `servicos_os`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicos_equipamento` (`id_equipamento`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `fk_usuario_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `equipamentos_os`
--
ALTER TABLE `equipamentos_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `ordens_servico`
--
ALTER TABLE `ordens_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `os_produto`
--
ALTER TABLE `os_produto`
  MODIFY `id_os_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `servicos_os`
--
ALTER TABLE `servicos_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
