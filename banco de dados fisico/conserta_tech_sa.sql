-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/09/2025 às 21:46
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
(1, 1, 'maria.silva@email.com', NULL, 'Maria Silva', 'Cliente preferencial', '1985-03-15', '2023-01-10', 'F', '01234-567', 'Rua das Flores', 'Casa', 'Apto 102', 123, 'São Paulo', '(11) 99999-1234', 'SP', 'Centro', 0),
(2, 1, 'joao.santos@email.com', NULL, 'João Santos', NULL, '1990-07-22', '2023-02-15', 'M', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', '(11) 98888-5678', 'SP', 'Bela Vista', 0),
(3, 1, 'ana.oliveira@email.com', NULL, 'Ana Oliveira', 'Entregar apenas à noite', '0000-00-00', '2023-03-20', 'F', '07890-123', 'Rua Augusta', 'Loja', 'Sala 3', 789, 'São Paulo', '(11) 97777-9012', 'SP', 'Consolação', 1),
(4, 1, 'carlos.rodrigues@email.com', NULL, 'Carlos Rodrigues', 'Cliente desde 2022', '0000-00-00', '2023-04-25', 'M', '02345-678', 'Praça da Sé', 'Casa', 'Fundos', 101, 'São Paulo', '(11) 96666-3456', 'SP', 'Sé', 0),
(5, 1, 'juliana.lima@email.com', NULL, 'Juliana Lima', NULL, '1995-05-18', '2023-05-30', 'F', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', '(11) 95555-7890', 'SP', 'Jardins', 0),
(6, 7, 'eduardo@eduardofdf', NULL, 'Eduardo Borsato Reinert', NULL, '2009-08-31', '2025-09-03', 'M', '45454-35', 'gsdfsdfs', 'R', 'sdfsf', 234324, 're', '(47) 99916-4144', 'PR', 'dffsf', 0),
(7, 7, 'eduardo@eduardofdf', NULL, 'Eduardo Borsato Reinert', NULL, '2009-08-31', '2025-09-03', 'M', '45454-35', 'gsdfsdfs', 'R', 'sdfsf', 234324, 're', '(47) 99916-4144', 'PR', 'dffsf', 1),
(8, 7, 'eduardo@eduardo234', NULL, 'Eduardo Borsato Reinert', NULL, '2009-08-31', '2025-09-04', 'F', '34243-242', 'rwerwerwer', 'R', 'sdfsdf', 2147483647, 'dsdfsdf', '(23) 43423-4234', 'PE', 'fsdfsdfsdf', 1),
(9, 3, 'uihuiehu@weiooesadsa', NULL, 'Eduardo Borsato Reinert', '', '2009-09-02', '2025-09-04', 'F', '23424-223', 'erwerwer', 'R', 'rwrwrwe', 343424234, 'erwerwrwer', '(47) 99916-2234', 'PR', 'rwrwrw', 1);

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
(18, 8, 'sdfsf', 'sdfdsfds', 'fsfsdfsd', 'fsfdf', 'fsfsf', 'sdfsdf'),
(19, 9, 'fsdfsdfsdf', 'fsfsf', 'sdfsdf', 'sdfsdf', 'sdfsd', 'fsdfsdfs'),
(21, 11, 'rtyryr', 'tyryrt', 'rtyrty', 'yryrty', 'hghgfh', 'ry');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `nome_peca` varchar(255) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `id_fornecedor`, `nome_peca`, `data_cadastro`, `quantidade`, `valor_unitario`, `descricao`) VALUES
(1, 1, 2, 'Bateria Original Samsung S23', '2024-03-15', 15, 89.90, 'Bateria Li-Po 3900mAh para Samsung Galaxy S23 - Original'),
(2, 1, 2, 'Display OLED Samsung S23', '2024-03-20', 8, 299.90, 'Tela OLED 6.1\" Dynamic AMOLED 2X - Original Samsung'),
(3, 3, 2, 'Cooler Notebook Dell G15', '2024-04-10', 12, 120.00, 'Ventoinha de refrigeração para notebook Dell Gamer G15'),
(4, 5, 3, 'Placa Principal TV LG 55\"', '2024-04-15', 5, 350.00, 'Placa mãe para Smart TV LG 55\" 4K UHD - Modelo 55UN7300'),
(5, 5, 3, 'Fonte Chaveada TV LED', '2024-04-20', 10, 180.00, 'Fonte de alimentação para TV LED 55\" - 120W'),
(6, 1, 1, 'Conector USB-C Samsung', '2024-05-05', 25, 15.00, 'Conector de carga USB-C para smartphones Samsung'),
(7, 3, 2, 'Pasta Térmica Premium', '2024-05-10', 30, 25.00, 'Pasta térmica Arctic MX-6 - Alta condutividade'),
(8, 2, 2, 'Sensor de Temperatura Geladeira', '2024-05-12', 8, 65.00, 'Sensor NTC para geladeiras Brastemp e Consul'),
(9, 4, 4, 'Espuma Densidade 28D', '2024-05-15', 20, 45.00, 'Espuma para assentos de sofá - Densidade 28D'),
(10, 1, 2, 'Câmera Traseira Samsung S23', '2024-05-18', 6, 150.00, 'Módulo de câmera traseira 50MP para Galaxy S23'),
(11, 3, 2, 'Teclado Notebook Dell', '2024-05-20', 4, 85.00, 'Teclado completo para notebook Dell Inspiron'),
(12, 5, 3, 'LED Strip TV Backlight', '2024-05-22', 15, 35.00, 'Fita LED para backlight de TV LED 55\"'),
(13, 2, 2, 'Compressor Geladeira 1/4HP', '2024-05-25', 3, 850.00, 'Compressor embraco 1/4HP para geladeiras frost free'),
(14, 1, 1, 'Microfone Samsung S23', '2024-05-28', 10, 28.00, 'Módulo de microfone inferior para Galaxy S23'),
(15, 3, 2, 'Memória RAM 8GB DDR4', '2024-06-01', 7, 180.00, 'Memória RAM 8GB DDR4 3200MHz para notebooks'),
(17, 16, 2, NULL, '2025-09-04', -1, 1099.90, 'Saída para OS 8 - fsfdfs'),
(18, 13, 2, NULL, '2025-09-04', -1, 899.90, 'Saída para OS 9 - sdfsfs');

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

INSERT INTO `fornecedor` (`id_fornecedor`, `email`, `razao_social`, `cnpj`, `data_fundacao`, `produto_fornecido`, `data_cad`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `observacoes`, `inativo`) VALUES
(1, 'contato@alimentosbrasil.com.br', 'Alimentos Brasil Ltda', '12.345.678/0001-90', '1998-05-15', 'Matéria-prima alimentícia', '2023-01-10', '01234-567', 'Avenida Industrial', 'Galpão', 'Setor A', 1000, 'São Paulo', 'SP', 'Jardim Industrial', '(11) 3333-4444', 'Entrega apenas dias úteis', 0),
(2, 'vendas@tecnoequip.com.br', 'Tecno Equipamentos ME', '98.765.432/0001-10', '2010-11-22', 'Equipamentos industriais', '2023-02-15', '04567-890', 'Rua das Máquinas', 'Prédio', 'Sala 201', 250, 'Campinas', 'SP', 'Centro', '(19) 2555-6666', 'Fornecedor premium', 0),
(3, 'sac@quimicosa.com.br', 'Químicos Associados S/A', '45.678.912/0001-34', '1985-03-08', 'Produtos químicos', '2023-03-20', '07890-123', 'Estrada do Chemical', 'Complexo', 'Bloco B', 0, 'São Paulo', 'SP', 'Interlagos', '(11) 2777-8888', 'Necessita certificação para compra', 1),
(4, 'contato@embalagensrj.com.br', 'Embalagens Rio Ltda', '76.543.210/0001-56', '2005-07-30', 'Embalagens plásticas', '2023-04-25', '20000-000', 'Rua do Porto', 'Armazém', 'Porto 12', 500, 'Rio de Janeiro', 'RJ', 'Centro', '(21) 3444-5555', 'Prazo de entrega 15 dias', 0),
(5, 'vendas@madeirasul.com.br', 'Madeira Sul Madeireira', '23.456.789/0001-78', '2015-12-05', 'Madeira e derivados', '2023-05-30', '90000-000', 'Avenida das Araucárias', 'Depósito', 'Pátio 3', 750, 'Porto Alegre', 'RS', 'Navegantes', '(51) 3666-7777', 'Trabalham apenas com madeira certificada', 0);

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
(8, 4, 3, '2025-09-04', 'Concluído', 'fsdfsdfsd', '2025-09-04 17:02:32'),
(9, 4, 3, '2025-09-16', 'Concluído', 'sdsdfsdfsdf', '2025-09-04 17:12:25'),
(11, 2, 3, '2025-09-04', 'Pendente', 'yryryry', '2025-09-04 17:38:04');

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
(8, 8, 16, 1099.90, 1099.90, 1),
(9, 9, 13, 899.90, 899.90, 1),
(11, 11, 16, 1099.90, 1099.90, 1);

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
(1, 8, 323.00, 'Dinheiro', '2025-09-04', 'Concluído'),
(2, 9, 333.00, 'Transferência', '2025-09-04', 'Concluído');

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
(1, 1, 2, 'Display', 'Tela OLED Samsung S23 Ultra', 'Samsung Galaxy S23 Ultra', 8, 899.90, '2024-03-15', 'Tela Original 6.8\" Dynamic AMOLED 2X 120Hz - Com digitizer'),
(2, 1, 2, 'Bateria', 'Bateria Original iPhone 15 Pro Max', 'iPhone 15 Pro Max', 12, 289.90, '2024-03-20', 'Bateria Li-Ion 4441mAh - Original Apple - Inclui cola'),
(3, 1, 2, 'Cooler', 'Kit Cooler Notebook Dell G15', 'Dell G15 Gaming', 6, 149.90, '2024-04-10', 'Ventoinha + dissipador de calor + pasta térmica premium'),
(4, 1, 3, 'Placa', 'Placa Principal TV LG OLED C3', 'LG OLED 55\" C3', 4, 1299.90, '2024-04-15', 'Placa mãe principal - Modelo EAX69085803'),
(5, 1, 3, 'Fonte', 'Fonte Chaveada TV Samsung', 'Samsung QLED 65\"', 10, 249.90, '2024-04-20', 'Fonte 120W - Modelo BN44-00999A'),
(6, 1, 1, 'Conector', 'Conector USB-C Samsung', 'Samsung Galaxy系列', 25, 29.90, '2024-05-05', 'Conector de carga flex cable - Original'),
(7, 1, 2, 'Pasta', 'Pasta Térmica Arctic MX-6', 'Notebooks/Consoles', 30, 39.90, '2024-05-10', 'Pasta térmica premium 4g - Condutividade 10.6W/mK'),
(8, 1, 2, 'Sensor', 'Sensor Temperatura Brastemp', 'Brastemp Frost Free', 8, 89.90, '2024-05-12', 'Sensor NTC 10K - Para refrigeradores'),
(9, 1, 4, 'Espuma', 'Espuma Assento Sofá 28D', 'Sofás 3 lugares', 15, 59.90, '2024-05-15', 'Espuma densidade 28D - 50x50x10cm'),
(10, 1, 2, 'Câmera', 'Câmera Traseira Samsung S23', 'Samsung Galaxy S23', 6, 199.90, '2024-05-18', 'Módulo câmera 50MP OIS - Original'),
(11, 1, 2, 'Teclado', 'Teclado Dell Inspiron', 'Dell Inspiron系列', 4, 129.90, '2024-05-20', 'Teclado completo ABNT2 - Com touchpad'),
(12, 1, 3, 'LED', 'Fita LED TV Backlight', 'TVs LED 55\"-65\"', 18, 49.90, '2024-05-22', 'Fita LED 120LEDs/m - 5V - Branco Quente'),
(13, 1, 2, 'Compressor', 'Compressor Embraco 1/4HP', 'Geladeiras Frost Free', 2, 899.90, '2024-05-25', 'Compressor 1/4HP - Modelo VEMT10K - Novo'),
(14, 1, 1, 'Microfone', 'Microfone Samsung', 'Samsung Galaxy系列', 12, 39.90, '2024-05-28', 'Módulo microfone inferior - Compatível S20-S23'),
(15, 1, 2, 'Memória', 'RAM 8GB DDR4 3200MHz', 'Notebooks', 9, 199.90, '2024-06-01', 'Memória SODIMM 8GB DDR4 3200MHz - Kingston'),
(16, 1, 2, 'Display', 'Tela iPhone 15 Pro Max', 'iPhone 15 Pro Max', 5, 1099.90, '2024-06-05', 'Tela Original 6.7\" Super Retina XDR - Com True Tone'),
(17, 1, 3, 'Placa', 'Placa Xbox Series X', 'Xbox Series X', 5, 599.90, '2024-06-08', 'Placa mãe principal - Modelo 1882A'),
(18, 1, 2, 'Ventoinha', 'Cooler PlayStation 5', 'PlayStation 5', 8, 79.90, '2024-06-12', 'Ventoinha de refrigeração - Original Sony'),
(19, 1, 1, 'Flex', 'Flex Cable Volume Samsung', 'Samsung Galaxy系列', 15, 24.90, '2024-06-15', 'Cabo flex botões volume/power - Compatível'),
(20, 1, 2, 'SSD', 'SSD NVMe 1TB Samsung', 'Notebooks/PCs', 6, 399.90, '2024-06-18', 'SSD NVMe PCIe 4.0 1TB - 7000MB/s - 980 Pro'),
(21, 1, 1, 'Peça', 'Placa de Vídeo NVIDIA RTX 3060', 'Computadores Gaming e Workstations', 8, 1899.90, '0000-00-00', 'Placa de vídeo NVIDIA GeForce RTX 3060 12GB GDDR6 com ray tracing');

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
(8, 18, 'fsfsd', 'fsfdfs', 323.00),
(9, 19, 'dfsf', 'sdfsfs', 333.00),
(11, 21, 'hfhf', 'hytryt', 56.00);

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
  `sexo` enum('M','F','O') DEFAULT NULL,
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
(1, 1, 'Pedro Gabriel Leal Costa', '05361534005', 'admin.pedro', 'pedro_gabriel@gmail.com', '$2y$10$DCRmenhZ7WpPVDkyV7m67OHkMtAsmp1JxDtfXJrFdmXxeweSYoMZq', '2025-09-04', '2008-05-30', 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(2, 2, 'Maria Santos', '987.654.321-00', 'maria.santos', 'maria.santos@empresa.com', '$2y$10$sR9cT8uV7wX5yZ4pQ2nM6L', '2023-02-10', '1990-07-12', 'F', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', 456, 'São Paulo', 'SP', 'Bela Vista', '(11) 98888-5678', 0, 0),
(3, 3, 'Carlos Oliveira', '456.789.123-00', 'carlos.oliveira', 'carlos.oliveira@empresa.com', '$2y$10$tS0dU9vW8x6z5aQ3oN7pK4M', '2023-03-20', '1988-11-05', 'M', '07890-123', 'Rua Augusta', 'Sala', 'Sala 302', 789, 'São Paulo', 'SP', 'Consolação', '(11) 97777-9012', 0, 0),
(4, 4, 'Ana Costa', '321.654.987-00', 'ana.costa', 'ana.costa@empresa.com', '$2y$10$hfG7IFiYbwPfTCtqoPxLZuLdI8SjcPxjXQkAjKBoYYIdZLJZf5uea', '2023-04-05', '1992-05-18', 'F', '02345-678', 'Praça da Sé', 'Loja', 'Fundos', 101, 'São Paulo', 'SP', 'Sé', '(11) 96666-3456', 1, 1),
(5, 3, 'Pedro Almeida', '654.321.987-00', 'pedro.almeida', 'pedro.almeida@empresa.com', '$2y$10$vU2fW1xY0z8b7cS5qN9rM6O', '2023-05-12', '1987-12-25', 'M', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', 200, 'São Paulo', 'SP', 'Jardins', '(11) 95555-7890', 1, 1),
(6, 1, 'João Silva', '123.456.789-98', 'joao.silva', 'joao.silva@empresa.com', '$2y$10$rQZ8bW7cT9hLmN6vX5pJ3O', '2023-01-15', '1985-03-20', 'M', '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', 123, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(7, 1, 'Admin', '123.456.789-00', 'ADM.ADM', 'admin@admin', '$2y$10$HRalC.XPdOQHcmIKwDI/IeRmNJuRRaGaBhN8Ma4vXt977nXsp07QW', '2023-01-15', '1985-03-20', 'M', '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', 123, 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0);

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
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `fk_estoque_fornecedor` (`id_fornecedor`),
  ADD KEY `fk_estoque_produto` (`id_produto`);

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `equipamentos_os`
--
ALTER TABLE `equipamentos_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `ordens_servico`
--
ALTER TABLE `ordens_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `os_produto`
--
ALTER TABLE `os_produto`
  MODIFY `id_os_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `servicos_os`
--
ALTER TABLE `servicos_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `fk_estoque_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_estoque_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE;

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
