-- Criar tabela de perfis
DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil` (
  `id_perfil` INT NOT NULL AUTO_INCREMENT,
  `perfil` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO perfil (`perfil`) VALUES
  ('Administrador'),
  ('Atendente'),
  ('Técnico'),
  ('Financeiro');

-- Usuários
DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_perfil` INT NOT NULL,
  `nome` VARCHAR(50) NOT NULL,
  `cpf` VARCHAR(15) UNIQUE,
  `username` VARCHAR(30) UNIQUE NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `data_cad` DATE DEFAULT NULL,
  `data_nasc` DATE DEFAULT NULL,
  `foto_usuario` LONGBLOB DEFAULT NULL,
  `sexo` ENUM('M','F','O'),
  `inativo` TINYINT,
  `senha_temporaria` TINYINT,
  PRIMARY KEY (`id_usuario`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cliente
DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `email` VARCHAR(100),
  `nome` VARCHAR(40),
  `observacao` VARCHAR(255),
  `data_nasc` DATE DEFAULT NULL,
  `sexo` ENUM('M','F','O'),
  `foto_cliente` LONGBLOB DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cliente físico
DROP TABLE IF EXISTS `cliente_fisico`;

CREATE TABLE `cliente_fisico` (
  `id_cliente` INT NOT NULL,
  `cpf` VARCHAR(15) UNIQUE NOT NULL,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_fisico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cliente jurídico
DROP TABLE IF EXISTS `juridico`;

CREATE TABLE `juridico` (
  `id_cliente` INT NOT NULL,
  `cnpj` VARCHAR(18) UNIQUE NOT NULL,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_juridico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Fornecedor
DROP TABLE IF EXISTS `fornecedor`;

CREATE TABLE `fornecedor` (
  `id_fornecedor` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) UNIQUE,
  `razao_social` VARCHAR(50) NOT NULL,
  `cnpj` VARCHAR(20) UNIQUE,
  `data_fundacao` date,
  `produto_fornecido` VARCHAR(100),
  `data_cad` DATE DEFAULT NULL,
  `foto_fornecedor` LONGBLOB DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Peças
DROP TABLE IF EXISTS `pecas`;

CREATE TABLE `pecas` (
  `id_pecas` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(50),
  `nome` VARCHAR(50),
  `aparelho_utilizado` VARCHAR(50),
  `quantidade` INT DEFAULT 0,
  `preco` DECIMAL(10, 2) DEFAULT NULL,
  `data_registro` DATE DEFAULT NULL,
  `descricao` TEXT,
  `status` ENUM('em estoque','fora de estoque','em manutenção','reservada'),
  `imagem_peca` LONGBLOB DEFAULT NULL,
  `numero_serie` VARCHAR(50) UNIQUE,
  PRIMARY KEY (`id_pecas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ordem de Serviço
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
  `defeito_rlt` VARCHAR(255),
  `condicao` VARCHAR(100),
  `observacoes` TEXT,
  `fabricante` VARCHAR(50),
  PRIMARY KEY (`id_os`),
  CONSTRAINT `fk_os_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_os_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Nota Fiscal
DROP TABLE IF EXISTS `nf`;

CREATE TABLE `nf` (
  `id_nf` INT NOT NULL AUTO_INCREMENT,
  `id_os` INT NOT NULL,
  `id_cliente` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `valor_unit` DECIMAL(10, 2),
  `valor_total` DECIMAL(10, 2),
  `frm_pagamento` VARCHAR(50),
  `data_emissao` DATE DEFAULT NULL,
  `status` VARCHAR(30),
  `numero_nf` VARCHAR(50) UNIQUE,
  `observacoes` TEXT,
  PRIMARY KEY (`id_nf`),
  CONSTRAINT `fk_nf_os` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`) ON DELETE CASCADE,
  CONSTRAINT `fk_nf_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_nf_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Endereços
CREATE TABLE `endereco_cliente` (
  `id_endereco_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_endereco_cliente`),
  CONSTRAINT `fk_endereco_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `endereco_fornecedor` (
  `id_endereco_fornecedor` INT NOT NULL AUTO_INCREMENT,
  `id_fornecedor` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo_construcao` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_endereco_fornecedor`),
  CONSTRAINT `fk_endereco_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `endereco_usuario` (
  `id_endereco_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo_rua` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_endereco_usuario`),
  CONSTRAINT `fk_endereco_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Telefones
CREATE TABLE `telefone_cliente` (
  `id_tel_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_tel_cliente`),
  CONSTRAINT `fk_tel_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `telefone_fornecedor` (
  `id_tel_fornecedor` INT NOT NULL AUTO_INCREMENT,
  `id_fornecedor` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_tel_fornecedor`),
  CONSTRAINT `fk_tel_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `telefone_usuario` (
  `id_tel_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_tel_usuario`),
  CONSTRAINT `fk_tel_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Relacionamentos muitos-para-muitos
CREATE TABLE `for_pc` (
  `id_pecas` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  PRIMARY KEY (`id_pecas`, `id_fornecedor`),
  CONSTRAINT `fk_forpc_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  CONSTRAINT `fk_forpc_pecas` FOREIGN KEY (`id_pecas`) REFERENCES `pecas` (`id_pecas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `us_os` (
  `id_usuario` int NOT NULL,
  `id_os` int NOT NULL,
  PRIMARY KEY (`id_usuario`, `id_os`),
  CONSTRAINT `fk_usos_os` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`) ON DELETE CASCADE,
  CONSTRAINT `fk_usos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estoque
CREATE TABLE `estoque` (
  `id_usuario` int NOT NULL,
  `id_pecas` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `nome_peca` VARCHAR(255),
  `data_cadastro` date,
  `quantidade` int(150) NOT NULL,
  `valor_unitario` varchar(255) NOT NULL, 
  `descricao` VARCHAR(255),
  `imagem_peca` LONGBLOB DEFAULT NULL, 
  PRIMARY KEY (`id_usuario`, `id_pecas`, `id_fornecedor`),
  CONSTRAINT `fk_estoque_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `fk_estoque_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  CONSTRAINT `fk_estoque_peca` FOREIGN KEY (`id_pecas`) REFERENCES `pecas` (`id_pecas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Inserir usuário admin
INSERT INTO `usuario` (
  `id_usuario`,
  `id_perfil`,
  `nome`,
  `cpf`,
  `username`,
  `email`,
  `senha`,
  `data_cad`,
  `data_nasc`,
  `foto_usuario`,
  `sexo`,
  `senha_temporaria`
)
VALUES
(
  1,
  1,
  'Pedro Gabriel Leal Costa',
  '05361534005',
  'admin.pedro',
  'pedro_gabriel@gmail.com',
  '12345678',
  '2025-08-26',
  '2008-05-30',
  NULL,
  'M',
  0
);
