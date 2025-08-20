-- Criar tabela de perfis
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id_perfil` INT NOT NULL AUTO_INCREMENT,
  `perfil` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert into perfil values
( 'Administrador'),
( 'Atendente'),
( 'Técnico'),
( 'Financeiro');

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_perfil` INT NOT NULL,
  `nome` VARCHAR(50) NOT NULL,
  `cpf` VARCHAR(15) UNIQUE,
  `username` VARCHAR(30) UNIQUE NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `rg` VARCHAR(12) UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `data_cad` DATE DEFAULT NULL,
  `data_nasc` DATE DEFAULT NULL,
  `foto_usuario` LONGBLOB DEFAULT NULL,
  `sexo` CHAR(1) CHECK (`sexo` IN ('M','F','O')),
  `senha_temporaria` TINYINT,
  PRIMARY KEY (`id_usuario`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `email` VARCHAR(100),
  `nome` VARCHAR(40),
  `observacao` VARCHAR(255),
  `data_nasc` DATE DEFAULT NULL,
  `sexo` CHAR(1) CHECK (`sexo` IN ('M','F','O')),
  `foto_cliente` LONGBLOB DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `cliente_fisico`;
CREATE TABLE `cliente_fisico` (
  `id_cliente` INT NOT NULL,
  `cpf` VARCHAR(15) UNIQUE NOT NULL,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_fisico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `juridico`;
CREATE TABLE `juridico` (
  `id_cliente` INT NOT NULL,
  `cnpj` VARCHAR(18) UNIQUE NOT NULL,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_juridico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela fornecedor sem referência a adm
DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE `fornecedor` (
  `id_fornecedor` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) UNIQUE,
  `nome` VARCHAR(50) NOT NULL,
  `cnpj` VARCHAR(20) UNIQUE,
  `data_fundacao` date,
  `produto_fornecido` VARCHAR(100),
  `data_cad` DATE DEFAULT NULL,
  `foto_fornecedor` LONGBLOB DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela pecas
DROP TABLE IF EXISTS `pecas`;
CREATE TABLE `pecas` (
  `id_pecas` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(50),
  `nome` VARCHAR(50),
  `aparelho_utilizado` VARCHAR(50),
  `quantidade` INT DEFAULT 0,
  `preco` DECIMAL(10,2) DEFAULT NULL,
  `data_registro` DATE DEFAULT NULL,
  `descricao` TEXT,
  `status` VARCHAR(20) CHECK (`status` IN ('em estoque','fora de estoque','em manutenção','reservada')),
  `id_fornecedor` INT DEFAULT NULL,
  `imagem_peca` LONGBLOB DEFAULT NULL,
  `numero_serie` VARCHAR(50) UNIQUE,
  PRIMARY KEY (`id_pecas`),
  KEY `fk_fornecedor_peca` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor_peca` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela os
DROP TABLE IF EXISTS `os`;
CREATE TABLE `os` (
  `id_os` INT NOT NULL AUTO_INCREMENT,
  `id_cliente` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `num_serie` VARCHAR(50) UNIQUE NOT NULL,
  `data_abertura` DATE DEFAULT NULL,
  `data_termino` DATE DEFAULT NULL,
  `modelo` VARCHAR(50),
  `num_aparelho` VARCHAR(50),
  `acessorios` VARCHAR(255),
  `defeito_rlt` VARCHAR(255),
  `condicao` VARCHAR(100),
  `observacoes` TEXT,
  `fabricante` VARCHAR(50),
  PRIMARY KEY (`id_os`),
  KEY `os_ibfk_1` (`id_cliente`),
  KEY `os_ibfk_2` (`id_usuario`),
  CONSTRAINT `os_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `os_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela nf
DROP TABLE IF EXISTS `nf`;
CREATE TABLE `nf` (
  `id_nf` INT NOT NULL AUTO_INCREMENT,
  `id_os` INT NOT NULL,
  `id_cliente` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `valor_unit` DECIMAL(10,2),
  `valor_total` DECIMAL(10,2),
  `frm_pagamento` VARCHAR(50),
  `data_emissao` DATE DEFAULT NULL,
  `status` VARCHAR(30),
  `numero_nf` VARCHAR(50) UNIQUE,
  `observacoes` TEXT,
  PRIMARY KEY (`id_nf`),
  KEY `fk_os_nf` (`id_os`),
  KEY `fk_cliente_nf` (`id_cliente`),
  KEY `fk_usuario_nf` (`id_usuario`),
  CONSTRAINT `fk_cliente_nf` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_os_nf` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`) ON DELETE CASCADE,
  CONSTRAINT `fk_usuario_nf` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Endereços
CREATE TABLE `endereco_cliente` (
  `id_cliente` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `endereco_fornecedor` (
  `id_fornecedor` int NOT NULL auto_increment,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo_construcao` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  CONSTRAINT `fk_fornecedor_endereco` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `endereco_usuario` (
  `id_usuario` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo_rua` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Telefones
CREATE TABLE `telefone_cliente` (
  `id_cliente` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `telefone_fornecedor` (
  `id_fornecedor` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_fornecedor_telefone` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `telefone_usuario` (
  `id_usuario` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `for_pc` (
  `id_pecas` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  PRIMARY KEY (`id_pecas`,`id_fornecedor`),
  KEY `fk_fornecedor` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  CONSTRAINT `fk_pecas` FOREIGN KEY (`id_pecas`) REFERENCES `pecas` (`id_pecas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `us_os` (
  `id_usuario` int NOT NULL,
  `id_os` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_os`),
  KEY `fk_os_usuario` (`id_os`),
  CONSTRAINT `fk_os_usuario` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`) ON DELETE CASCADE,
  CONSTRAINT `fk_usuario_os` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
