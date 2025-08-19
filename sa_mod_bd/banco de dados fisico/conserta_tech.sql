-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/08/2025 às 21:35
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
-- Banco de dados: `conserta_tech`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adm`
--

CREATE TABLE `adm` (
  `id_adm` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `data_cad` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `username` varchar(40) NOT NULL,
  `foto_adm` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL CHECK (`sexo` in ('M','F','O')),
  `foto_cliente` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente_fisico`
--

CREATE TABLE `cliente_fisico` (
  `id_cliente` int(11) NOT NULL,
  `cpf` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco_adm`
--

CREATE TABLE `endereco_adm` (
  `id_adm` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco_cliente`
--

CREATE TABLE `endereco_cliente` (
  `id_cliente` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco_fornecedor`
--

CREATE TABLE `endereco_fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco_usuario`
--

CREATE TABLE `endereco_usuario` (
  `id_usuario` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nome` varchar(50) NOT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `fornece` varchar(50) DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `foto_fornecedor` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `for_pc`
--

CREATE TABLE `for_pc` (
  `id_pecas` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `juridico`
--

CREATE TABLE `juridico` (
  `id_cliente` int(11) NOT NULL,
  `cnpj` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nf`
--

CREATE TABLE `nf` (
  `id_nf` int(11) NOT NULL,
  `id_os` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor_unit` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `frm_pagamento` varchar(50) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `numero_nf` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `os`
--

CREATE TABLE `os` (
  `id_os` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `num_serie` varchar(50) NOT NULL,
  `data_abertura` date DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `num_aparelho` varchar(50) DEFAULT NULL,
  `acessorios` varchar(255) DEFAULT NULL,
  `defeito_rlt` varchar(255) DEFAULT NULL,
  `condicao` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `fabricante` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pecas`
--

CREATE TABLE `pecas` (
  `id_pecas` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `aparelho_utilizado` varchar(50) DEFAULT NULL,
  `quantidade` int(11) DEFAULT 0,
  `preco` decimal(10,2) DEFAULT NULL,
  `data_registro` date DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL CHECK (`status` in ('em estoque','fora de estoque','em manutenção','reservada')),
  `id_fornecedor` int(11) DEFAULT NULL,
  `imagem_peca` longblob DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nome_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nome_perfil`) VALUES
(1, 'administrador'),
(2, 'atendente'),
(3, 'tecnico'),
(4, 'financeiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone_adm`
--

CREATE TABLE `telefone_adm` (
  `id_adm` int(11) NOT NULL,
  `telefone` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone_cliente`
--

CREATE TABLE `telefone_cliente` (
  `id_cliente` int(11) NOT NULL,
  `telefone` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone_fornecedor`
--

CREATE TABLE `telefone_fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `telefone` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone_usuario`
--

CREATE TABLE `telefone_usuario` (
  `id_usuario` int(11) NOT NULL,
  `telefone` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cad` date DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `foto_usuario` longblob DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL CHECK (`sexo` in ('M','F','O')),
  `senha_temporaria` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `us_os`
--

CREATE TABLE `us_os` (
  `id_usuario` int(11) NOT NULL,
  `id_os` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id_adm`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_adm_perfil` (`id_perfil`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Índices de tabela `cliente_fisico`
--
ALTER TABLE `cliente_fisico`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `endereco_adm`
--
ALTER TABLE `endereco_adm`
  ADD KEY `fk_adm_endereco` (`id_adm`);

--
-- Índices de tabela `endereco_cliente`
--
ALTER TABLE `endereco_cliente`
  ADD KEY `fk_cliente_endereco` (`id_cliente`);

--
-- Índices de tabela `endereco_fornecedor`
--
ALTER TABLE `endereco_fornecedor`
  ADD KEY `fk_fornecedor_endereco` (`id_fornecedor`);

--
-- Índices de tabela `endereco_usuario`
--
ALTER TABLE `endereco_usuario`
  ADD KEY `fk_usuario_endereco` (`id_usuario`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD KEY `fk_adm_fornecedor` (`id_adm`);

--
-- Índices de tabela `for_pc`
--
ALTER TABLE `for_pc`
  ADD PRIMARY KEY (`id_pecas`,`id_fornecedor`),
  ADD KEY `fk_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `juridico`
--
ALTER TABLE `juridico`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `nf`
--
ALTER TABLE `nf`
  ADD PRIMARY KEY (`id_nf`),
  ADD UNIQUE KEY `numero_nf` (`numero_nf`),
  ADD KEY `fk_os_nf` (`id_os`),
  ADD KEY `fk_cliente_nf` (`id_cliente`),
  ADD KEY `fk_usuario_nf` (`id_usuario`);

--
-- Índices de tabela `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`id_os`),
  ADD UNIQUE KEY `num_serie` (`num_serie`),
  ADD KEY `os_ibfk_1` (`id_cliente`),
  ADD KEY `os_ibfk_2` (`id_usuario`);

--
-- Índices de tabela `pecas`
--
ALTER TABLE `pecas`
  ADD PRIMARY KEY (`id_pecas`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`),
  ADD KEY `fk_fornecedor_peca` (`id_fornecedor`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `telefone_adm`
--
ALTER TABLE `telefone_adm`
  ADD KEY `fk_adm_telefone` (`id_adm`);

--
-- Índices de tabela `telefone_cliente`
--
ALTER TABLE `telefone_cliente`
  ADD KEY `fk_cliente_telefone` (`id_cliente`);

--
-- Índices de tabela `telefone_fornecedor`
--
ALTER TABLE `telefone_fornecedor`
  ADD KEY `fk_fornecedor_telefone` (`id_fornecedor`);

--
-- Índices de tabela `telefone_usuario`
--
ALTER TABLE `telefone_usuario`
  ADD KEY `fk_usuario_telefone` (`id_usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `rg` (`rg`),
  ADD KEY `fk_adm` (`id_adm`),
  ADD KEY `fk_usuario_perfil` (`id_perfil`);

--
-- Índices de tabela `us_os`
--
ALTER TABLE `us_os`
  ADD PRIMARY KEY (`id_usuario`,`id_os`),
  ADD KEY `fk_os_usuario` (`id_os`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nf`
--
ALTER TABLE `nf`
  MODIFY `id_nf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `os`
--
ALTER TABLE `os`
  MODIFY `id_os` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pecas`
--
ALTER TABLE `pecas`
  MODIFY `id_pecas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `adm`
--
ALTER TABLE `adm`
  ADD CONSTRAINT `fk_adm_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `cliente_fisico`
--
ALTER TABLE `cliente_fisico`
  ADD CONSTRAINT `fk_cliente_fisico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Restrições para tabelas `endereco_adm`
--
ALTER TABLE `endereco_adm`
  ADD CONSTRAINT `fk_adm_endereco` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`);

--
-- Restrições para tabelas `endereco_cliente`
--
ALTER TABLE `endereco_cliente`
  ADD CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Restrições para tabelas `endereco_fornecedor`
--
ALTER TABLE `endereco_fornecedor`
  ADD CONSTRAINT `fk_fornecedor_endereco` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`);

--
-- Restrições para tabelas `endereco_usuario`
--
ALTER TABLE `endereco_usuario`
  ADD CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `fk_adm_fornecedor` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`);

--
-- Restrições para tabelas `for_pc`
--
ALTER TABLE `for_pc`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`),
  ADD CONSTRAINT `fk_pecas` FOREIGN KEY (`id_pecas`) REFERENCES `pecas` (`id_pecas`);

--
-- Restrições para tabelas `juridico`
--
ALTER TABLE `juridico`
  ADD CONSTRAINT `fk_cliente_juridico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Restrições para tabelas `nf`
--
ALTER TABLE `nf`
  ADD CONSTRAINT `fk_cliente_nf` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_os_nf` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`),
  ADD CONSTRAINT `fk_usuario_nf` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `os`
--
ALTER TABLE `os`
  ADD CONSTRAINT `os_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `os_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `pecas`
--
ALTER TABLE `pecas`
  ADD CONSTRAINT `fk_fornecedor_peca` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`);

--
-- Restrições para tabelas `telefone_adm`
--
ALTER TABLE `telefone_adm`
  ADD CONSTRAINT `fk_adm_telefone` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`);

--
-- Restrições para tabelas `telefone_cliente`
--
ALTER TABLE `telefone_cliente`
  ADD CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Restrições para tabelas `telefone_fornecedor`
--
ALTER TABLE `telefone_fornecedor`
  ADD CONSTRAINT `fk_fornecedor_telefone` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`);

--
-- Restrições para tabelas `telefone_usuario`
--
ALTER TABLE `telefone_usuario`
  ADD CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_adm` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`),
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Restrições para tabelas `us_os`
--
ALTER TABLE `us_os`
  ADD CONSTRAINT `fk_os_usuario` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`),
  ADD CONSTRAINT `fk_usuario_os` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
