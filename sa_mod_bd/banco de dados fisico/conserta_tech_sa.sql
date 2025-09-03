
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


DROP TABLE IF EXISTS `tipo_servico`;

CREATE TABLE `tipo_servico` (
  `id_tipo_servico` INT NOT NULL AUTO_INCREMENT,
  `tipo_servico` VARCHAR(255),
  `valor_servico` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_tipo_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


DROP TABLE IF EXISTS `servicos_os`;

CREATE TABLE `servicos_os` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_equipamento` INT NOT NULL,
    `tipo_servico` VARCHAR(50),
    `descricao` TEXT,
    `valor` DECIMAL(10,2),
    CONSTRAINT `fk_servicos_equipamento` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos_os` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


INSERT INTO `tipo_servico` (`tipo_servico`, `valor_servico`) VALUES
  ('Manutenção Preventiva', 80.00),
  ('Manutenção Corretiva', 120.00),
  ('Limpeza Interna', 60.00),
  ('Troca de Peças', 150.00),
  ('Diagnóstico', 40.00);


INSERT INTO `cliente`(`id_cliente`, `id_usuario`, `email`, `nome`, `observacao`, `data_nasc`, `data_cad`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `telefone`, `uf`, `bairro`, `inativo`) 
VALUES 
(1, 1, 'maria.silva@email.com', 'Maria Silva', 'Cliente preferencial', '1985-03-15', '2023-01-10', 'F', '01234-567', 'Rua das Flores', 'Casa', 'Apto 102', '123', 'São Paulo', '(11) 99999-1234', 'SP', 'Centro', 0),
(2, 1, 'joao.santos@email.com', 'João Santos', NULL, '1990-07-22', '2023-02-15', 'M', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', '456', 'São Paulo', '(11) 98888-5678', 'SP', 'Bela Vista', 0),
(3, 1, 'ana.oliveira@email.com', 'Ana Oliveira', 'Entregar apenas à noite', '1982-11-05', '2023-03-20', 'F', '07890-123', 'Rua Augusta', 'Loja', 'Sala 3', '789', 'São Paulo', '(11) 97777-9012', 'SP', 'Consolação', 1),
(4, 1, 'carlos.rodrigues@email.com', 'Carlos Rodrigues', 'Cliente desde 2022', '1978-12-30', '2023-04-25', 'M', '02345-678', 'Praça da Sé', 'Casa', 'Fundos', '101', 'São Paulo', '(11) 96666-3456', 'SP', 'Sé', 0),
(5, 1, 'juliana.lima@email.com', 'Juliana Lima', NULL, '1995-05-18', '2023-05-30', 'F', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', '200', 'São Paulo', '(11) 95555-7890', 'SP', 'Jardins', 0);


INSERT INTO `fornecedor`(`id_fornecedor`, `email`, `razao_social`, `cnpj`, `data_fundacao`, `produto_fornecido`, `data_cad`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `observacoes`, `inativo`) 
VALUES 
(1, 'contato@alimentosbrasil.com.br', 'Alimentos Brasil Ltda', '12.345.678/0001-90', '1998-05-15', 'Matéria-prima alimentícia', '2023-01-10', '01234-567', 'Avenida Industrial', 'Galpão', 'Setor A', '1000', 'São Paulo', 'SP', 'Jardim Industrial', '(11) 3333-4444', 'Entrega apenas dias úteis', 0),
(2, 'vendas@tecnoequip.com.br', 'Tecno Equipamentos ME', '98.765.432/0001-10', '2010-11-22', 'Equipamentos industriais', '2023-02-15', '04567-890', 'Rua das Máquinas', 'Prédio', 'Sala 201', '250', 'Campinas', 'SP', 'Centro', '(19) 2555-6666', 'Fornecedor premium', 0),
(3, 'sac@quimicosa.com.br', 'Químicos Associados S/A', '45.678.912/0001-34', '1985-03-08', 'Produtos químicos', '2023-03-20', '07890-123', 'Estrada do Chemical', 'Complexo', 'Bloco B', 's/n', 'São Paulo', 'SP', 'Interlagos', '(11) 2777-8888', 'Necessita certificação para compra', 1),
(4, 'contato@embalagensrj.com.br', 'Embalagens Rio Ltda', '76.543.210/0001-56', '2005-07-30', 'Embalagens plásticas', '2023-04-25', '20000-000', 'Rua do Porto', 'Armazém', 'Porto 12', '500', 'Rio de Janeiro', 'RJ', 'Centro', '(21) 3444-5555', 'Prazo de entrega 15 dias', 0),
(5, 'vendas@madeirasul.com.br', 'Madeira Sul Madeireira', '23.456.789/0001-78', '2015-12-05', 'Madeira e derivados', '2023-05-30', '90000-000', 'Avenida das Araucárias', 'Depósito', 'Pátio 3', '750', 'Porto Alegre', 'RS', 'Navegantes', '(51) 3666-7777', 'Trabalham apenas com madeira certificada', 0);

INSERT INTO `produto`(`id_produto`, `id_usuario`, `tipo`, `nome`, `aparelho_utilizado`, `quantidade`, `preco`, `data_registro`, `descricao`) 
VALUES 
(1, 1, 'Eletrônico', 'Smartphone Galaxy S23', 'Testador de bateria', 50, 2899.90, '2024-01-15', 'Smartphone Android com 256GB, 8GB RAM, câmera tripla 50MP'),
(2, 1, 'Eletrodoméstico', 'Geladeira Frost Free', 'Medidor de temperatura', 25, 3499.00, '2024-02-20', 'Geladeira duplex 440L frost free, inversor, prata'),
(3, 1, 'Informática', 'Notebook Gamer', 'Testador de performance', 15, 5999.99, '2024-03-10', 'Notbook gamer i7, 16GB RAM, RTX 4060, SSD 1TB'),
(4, 1, 'Móvel', 'Sofá 3 Lugares', 'Nenhum', 8, 1999.90, '2024-04-05', 'Sofá 3 lugares retrátil, tecido suede, cinza'),
(5, 1, 'Eletrônico', 'Smart TV 55" 4K', 'Calibrador de cores', 30, 2499.90, '2024-05-12', 'Smart TV LED 55" 4K UHD, Android TV, 3 HDMI');

INSERT INTO `ordens_servico`(`id`, `id_cliente`, `id_usuario`, `data_termino`, `status`, `observacoes`, `data_criacao`) 
VALUES 
(1, 1, 1, '2024-05-10', 'Concluído', 'Manutenção preventiva realizada', '2024-05-08'),
(2, 2, 1, NULL, 'Em andamento', 'Aguardando aprovação do cliente', '2024-05-15'),
(3, 3, 1, '2024-05-20', 'Concluído', 'Serviço de limpeza completo', '2024-05-18'),
(4, 4, 1, NULL, 'Pendente', 'Cliente não trouxe o equipamento', '2024-05-22'),
(5, 5, 1, '2024-05-25', 'Concluído', 'Troca de peças e ajustes finos', '2024-05-23');


INSERT INTO `os_produto`(`id_os_produto`, `id_os`, `id_produto`, `quantidade`) 
VALUES 
(1, 1, 3, 1),  
(2, 1, 1, 2),   
(3, 2, 5, 1),   
(4, 3, 3, 1),  
(5, 4, 4, 3);   

INSERT INTO `estoque`(`id_estoque`, `id_produto`, `id_fornecedor`, `nome_peca`, `data_cadastro`, `quantidade`, `valor_unitario`, `descricao`) 
VALUES 
(1, 1, 2, 'Bateria Smartphone', '2024-03-15', 25, 89.90, 'Bateria original para smartphones Samsung Galaxy S23'),
(2, 3, 2, 'Cooler Notebook Gamer', '2024-04-10', 15, 120.00, 'Cooler para notebook gamer, modelo universal'),
(3, 5, 3, 'Placa Principal TV LED', '2024-02-20', 8, 350.00, 'Placa de circuito para Smart TV LG 55" 4K'),
(4, 1, 1, 'Tela OLED Samsung', '2024-05-05', 12, 299.90, 'Tela OLED original Samsung Galaxy S23'),
(5, 4, 4, 'Espuma para Sofá', '2024-01-30', 20, 45.00, 'Espuma de reposição para sofá 3 lugares');


INSERT INTO `equipamentos_os`(`id`, `id_os`, `fabricante`, `modelo`, `num_serie`, `num_aparelho`, `defeito_reclamado`, `condicao`) 
VALUES 
(1, 1, 'Samsung', 'Galaxy S23', 'SN123456789', 'AP001', 'Tela não funciona', 'Aparelho com arranhões na traseira'),
(2, 1, 'Apple', 'iPhone 15 Pro', 'SN987654321', 'AP002', 'Bateria não carrega', 'Estado de conservação bom'),
(3, 2, 'LG', 'Smart TV 55" 4K', 'SN456789123', 'AP003', 'Não liga', 'TV com poeira acumulada nas entradas'),
(4, 3, 'Dell', 'Notebook Gamer', 'SN321654987', 'AP004', 'Superaquecimento', 'Teclado com teclas desgastadas'),
(5, 4, 'Brastemp', 'Geladeira Frost Free', 'SN789123456', 'AP005', 'Não está gelando', 'Amassado lateral direito');


INSERT INTO `servicos_os`(`id`, `id_equipamento`, `tipo_servico`, `descricao`, `valor`) 
VALUES 
(1, 1, 'Troca de Tela', 'Substituição da tela OLED danificada', 299.90),
(2, 2, 'Troca de Bateria', 'Substituição da bateria com defeito', 89.90),
(3, 3, 'Reparo Elétrico', 'Reparo na placa principal e fonte', 450.00),
(4, 4, 'Manutenção Preventiva', 'Limpeza interna e troca de pasta térmica', 150.00),
(5, 5, 'Troca de Compressor', 'Substituição do compressor defeituoso', 850.00);

INSERT INTO `usuario`(`id_usuario`, `id_perfil`, `nome`, `cpf`, `username`, `email`, `senha`, `data_cad`, `data_nasc`, `sexo`, `cep`, `logradouro`, `tipo`, `complemento`, `numero`, `cidade`, `uf`, `bairro`, `telefone`, `inativo`, `senha_temporaria`) 
VALUES 
(7, 1, 'Admin', '123.456.789-00', 'ADM.ADM', 'admin@admin', '12345', '2023-01-15', '1985-03-20', 'M', '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', '123', 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(6, 1, 'João Silva', '123.456.789-00', 'joao.silva', 'joao.silva@empresa.com', '$2y$10$rQZ8bW7cT9hLmN6vX5pJ3O', '2023-01-15', '1985-03-20', 'M', '01234-567', 'Rua das Flores', 'Casa', 'Apto 101', '123', 'São Paulo', 'SP', 'Centro', '(11) 99999-1234', 0, 0),
(2, 2, 'Maria Santos', '987.654.321-00', 'maria.santos', 'maria.santos@empresa.com', '$2y$10$sR9cT8uV7wX5yZ4pQ2nM6L', '2023-02-10', '1990-07-12', 'F', '04567-890', 'Avenida Paulista', 'Apartamento', 'Bloco B', '456', 'São Paulo', 'SP', 'Bela Vista', '(11) 98888-5678', 0, 0),
(3, 3, 'Carlos Oliveira', '456.789.123-00', 'carlos.oliveira', 'carlos.oliveira@empresa.com', '$2y$10$tS0dU9vW8x6z5aQ3oN7pK4M', '2023-03-20', '1988-11-05', 'M', '07890-123', 'Rua Augusta', 'Sala', 'Sala 302', '789', 'São Paulo', 'SP', 'Consolação', '(11) 97777-9012', 0, 0),
(4, 4, 'Ana Costa', '321.654.987-00', 'ana.costa', 'ana.costa@empresa.com', '$2y$10$uT1eV0wX9y7a6bR4pM8qL5N', '2023-04-05', '1992-05-18', 'F', '02345-678', 'Praça da Sé', 'Loja', 'Fundos', '101', 'São Paulo', 'SP', 'Sé', '(11) 96666-3456', 0, 0),
(5, 3, 'Pedro Almeida', '654.321.987-00', 'pedro.almeida', 'pedro.almeida@empresa.com', '$2y$10$vU2fW1xY0z8b7cS5qN9rM6O', '2023-05-12', '1987-12-25', 'M', '05678-901', 'Rua Oscar Freire', 'Apartamento', 'Apto 1501', '200', 'São Paulo', 'SP', 'Jardins', '(11) 95555-7890', 1, 1);