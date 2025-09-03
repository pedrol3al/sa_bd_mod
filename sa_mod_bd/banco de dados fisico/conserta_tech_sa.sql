-- Criar tabela de perfis
DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil` (
  `id_perfil` INT NOT NULL AUTO_INCREMENT,
  `perfil` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `perfil` (`perfil`) VALUES
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
  `sexo` ENUM('M','F','O'),
  `cep` VARCHAR(10) DEFAULT NULL,
  `logradouro` VARCHAR(80) DEFAULT NULL,
  `tipo` VARCHAR(20) DEFAULT NULL,
  `complemento` VARCHAR(15) DEFAULT NULL,
  `numero` INT DEFAULT NULL,
  `cidade` VARCHAR(30) DEFAULT NULL,
  `uf` VARCHAR(2) DEFAULT NULL,
  `bairro` VARCHAR(20) DEFAULT NULL,
  `telefone` VARCHAR(18) DEFAULT NULL,
  `inativo` TINYINT DEFAULT 0,
  `senha_temporaria` TINYINT DEFAULT 0,
  PRIMARY KEY (`id_usuario`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cliente
DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `email` VARCHAR(100),
   `cpf` VARCHAR(18) DEFAULT NULL,
  `nome` VARCHAR(40),
  `observacao` VARCHAR(255),
  `data_nasc` DATE DEFAULT NULL,
  `data_cad` DATE DEFAULT NULL,
  `sexo` ENUM('M','F'),
  `cep` VARCHAR(10) DEFAULT NULL,
  `logradouro` VARCHAR(80) DEFAULT NULL,
  `tipo` VARCHAR(20) DEFAULT NULL,
  `complemento` VARCHAR(15) DEFAULT NULL,
  `numero` INT DEFAULT NULL,
  `cidade` VARCHAR(30) DEFAULT NULL,
  `telefone` VARCHAR(18) DEFAULT NULL,
  `uf` VARCHAR(2) DEFAULT NULL,
  `bairro` VARCHAR(20) DEFAULT NULL,
  `inativo` TINYINT DEFAULT 0,
  PRIMARY KEY (`id_cliente`),
  CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Fornecedor
DROP TABLE IF EXISTS `fornecedor`;

CREATE TABLE `fornecedor` (
  `id_fornecedor` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) UNIQUE,
  `razao_social` VARCHAR(50) NOT NULL,
  `cnpj` VARCHAR(20) UNIQUE,
  `data_fundacao` DATE,
  `produto_fornecido` VARCHAR(100),
  `data_cad` DATE DEFAULT NULL,
  `cep` VARCHAR(10) DEFAULT NULL,
  `logradouro` VARCHAR(80) DEFAULT NULL,
  `tipo` VARCHAR(20) DEFAULT NULL,
  `complemento` VARCHAR(15) DEFAULT NULL,
  `numero` INT DEFAULT NULL,
  `cidade` VARCHAR(30) DEFAULT NULL,
  `uf` VARCHAR(2) DEFAULT NULL,
  `bairro` VARCHAR(20) DEFAULT NULL,
  `telefone` VARCHAR(18) DEFAULT NULL,
  `observacoes` VARCHAR(255),
  `inativo` TINYINT DEFAULT 0,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Produto
DROP TABLE IF EXISTS `produto`;

CREATE TABLE `produto` (
  `id_produto` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `tipo` VARCHAR(50),
  `nome` VARCHAR(50),
  `aparelho_utilizado` VARCHAR(50),
  `quantidade` INT DEFAULT 0,
  `preco` DECIMAL(10,2) DEFAULT NULL,
  `data_registro` DATE DEFAULT NULL,
  `descricao` VARCHAR(255),
  PRIMARY KEY (`id_produto`),
  CONSTRAINT `fk_produto_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tipo de serviço
DROP TABLE IF EXISTS `tipo_servico`;

CREATE TABLE `tipo_servico` (
  `id_tipo_servico` INT NOT NULL AUTO_INCREMENT,
  `tipo_servico` VARCHAR(255),
  `valor_servico` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_tipo_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ordem de Serviço (Tabela principal)
DROP TABLE IF EXISTS `ordens_servico`;

CREATE TABLE `ordens_servico` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_cliente` INT NOT NULL,
    `id_usuario` INT NOT NULL,
    `data_termino` DATE,
    `status` VARCHAR(20) DEFAULT 'aberto',
    `observacoes` TEXT,
    `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ordens_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
    CONSTRAINT `fk_ordens_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Equipamentos da OS
DROP TABLE IF EXISTS `equipamentos_os`;

CREATE TABLE `equipamentos_os` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_os` INT NOT NULL,
    `fabricante` VARCHAR(100),
    `modelo` VARCHAR(100),
    `num_serie` VARCHAR(50),
    `num_aparelho` VARCHAR(50),
    `defeito_reclamado` TEXT,
    `condicao` TEXT,
    CONSTRAINT `fk_equipamentos_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Serviços dos equipamentos
DROP TABLE IF EXISTS `servicos_os`;

CREATE TABLE `servicos_os` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_equipamento` INT NOT NULL,
    `tipo_servico` VARCHAR(50),
    `descricao` TEXT,
    `valor` DECIMAL(10,2),
    CONSTRAINT `fk_servicos_equipamento` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos_os` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Pagamento
DROP TABLE IF EXISTS `pagamento`;

CREATE TABLE `pagamento` (
  `id_pagamento` INT NOT NULL AUTO_INCREMENT,
  `id_os` INT NOT NULL,
  `valor_total` DECIMAL(10,2),
  `frm_pagamento` VARCHAR(50),
  `data_pagamento` DATE,
  `status` VARCHAR(30),
  PRIMARY KEY (`id_pagamento`),
  CONSTRAINT `fk_pag_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estoque
DROP TABLE IF EXISTS `estoque`;

CREATE TABLE `estoque` (
  `id_estoque` INT NOT NULL AUTO_INCREMENT,
  `id_produto` INT NOT NULL,
  `id_fornecedor` INT NOT NULL,
  `nome_peca` VARCHAR(255),
  `data_cadastro` DATE,
  `quantidade` INT NOT NULL,
  `valor_unitario` DECIMAL(10,2) NOT NULL,
  `descricao` VARCHAR(255),
  PRIMARY KEY (`id_estoque`),
  CONSTRAINT `fk_estoque_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE CASCADE,
  CONSTRAINT `fk_estoque_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Relação OS x Produto
DROP TABLE IF EXISTS `os_produto`;

CREATE TABLE `os_produto` (
  `id_os_produto` INT NOT NULL AUTO_INCREMENT,
  `id_os` INT NOT NULL,
  `id_produto` INT NOT NULL,
  `quantidade` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_os_produto`),
  CONSTRAINT `fk_osprod_os` FOREIGN KEY (`id_os`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_osprod_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserção do usuário admin
INSERT INTO `usuario` (
  `id_perfil`,
  `nome`,
  `cpf`,
  `username`,
  `email`,
  `senha`,
  `data_cad`,
  `data_nasc`,
  `sexo`,
  `senha_temporaria`
) VALUES (
  1,
  'Pedro Gabriel Leal Costa',
  '05361534005',
  'admin.pedro',
  'pedro_gabriel@gmail.com',
  '12345678',
  CURDATE(),
  '2008-05-30',
  'M',
  0
);

-- Inserir alguns tipos de serviço
INSERT INTO `tipo_servico` (`tipo_servico`, `valor_servico`) VALUES
  ('Manutenção Preventiva', 80.00),
  ('Manutenção Corretiva', 120.00),
  ('Limpeza Interna', 60.00),
  ('Troca de Peças', 150.00),
  ('Diagnóstico', 40.00);