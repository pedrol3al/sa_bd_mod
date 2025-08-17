
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: conserta_tech_sa
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm` (
  `id_adm` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(12) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `foto_adm` longblob default null, 
  PRIMARY KEY (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda` (
  `id_agenda` int NOT NULL AUTO_INCREMENT,
  `data_agenda` date NOT NULL,
  `id_os` int NOT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `fk_os` (`id_os`),
  CONSTRAINT `fk_os` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
   `foto_cliente` longblob default null, 
  PRIMARY KEY (`id_cliente`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `cliente_fisico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente_fisico` (
  `id_cliente` int NOT NULL,
  `cpf` varchar(15) NOT NULL,
  KEY `fk_cliente_fisico` (`id_cliente`),
  CONSTRAINT `fk_cliente_fisico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `endereco_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_adm` (
  `id_adm` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  CONSTRAINT `fk_adm_endereco` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `endereco_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `endereco_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_fornecedor` (
  `id_fornecedor` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  CONSTRAINT `fk_fornecedor_endereco` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `endereco_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_usuario` (
 `id_usuario` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `for_pc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `for_pc` (
  `id_pecas` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  PRIMARY KEY (`id_pecas`,`id_fornecedor`),
  KEY `fk_fornecedor` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`),
  CONSTRAINT `fk_pecas` FOREIGN KEY (`id_pecas`) REFERENCES `pecas` (`id_pecas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `id_fornecedor` int NOT NULL,
  `id_adm` int NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `fornece` varchar(50) DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
   `foto_fornecedor` longblob default null, 
  PRIMARY KEY (`id_fornecedor`),
  KEY `fk_adm_fornecedor` (`id_adm`),
  CONSTRAINT `fk_adm_fornecedor` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `juridico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `juridico` (
  `id_cliente` int NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `cnpj` (`cnpj`),
  CONSTRAINT `fk_cliente_juridico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `nf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nf` (
  `id_nf` int NOT NULL,
  `id_os` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `valor_unit` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `frm_pagamento` varchar(30) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `numero_nf` varchar(20) DEFAULT NULL,
  `observacoes` text,
  PRIMARY KEY (`id_nf`),
  KEY `fk_os_nf` (`id_os`),
  KEY `fk_cliente_nf` (`id_cliente`),
  KEY `fk_usuario_nf` (`id_usuario`),
  CONSTRAINT `fk_cliente_nf` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_os_nf` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`),
  CONSTRAINT `fk_usuario_nf` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `os`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `os` (
  `id_os` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `num_serie` int NOT NULL,
  `data_abertura` date DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `modelo` varchar(40) DEFAULT NULL,
  `num_aparelho` int DEFAULT NULL,
  `acessorios` varchar(100) DEFAULT NULL,
  `defeito_rlt` varchar(40) DEFAULT NULL,
  `condicao` varchar(50) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `fabricante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_os`),
  KEY `os_ibfk_1` (`id_cliente`),
  KEY `os_ibfk_2` (`id_usuario`),
  CONSTRAINT `os_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `os_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `pecas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pecas` (
  `id_pecas` int NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `aparelho_utilizado` varchar(30) DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `preco` int DEFAULT NULL,
  `data_registro` date DEFAULT NULL,
  `descricao` text,
  `status` enum('em estoque','fora de estoque','em manutenção','reservada') DEFAULT 'em estoque',
  `id_fornecedor` int DEFAULT NULL,
   `imagem_peca` longblob default null, 
  `numero_serie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pecas`),
  KEY `fk_fornecedor_peca` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor_peca` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `telefone_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_adm` (
  `id_adm` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_adm_telefone` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `telefone_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_cliente` (
  `id_cliente` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `telefone_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_fornecedor` (
  `id_fornecedor` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_fornecedor_telefone` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `telefone_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_usuario` (
  `id_usuario` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `us_os`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `us_os` (
  `id_usuario` int NOT NULL,
  `id_os` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_os`),
  KEY `fk_os_usuario` (`id_os`),
  CONSTRAINT `fk_os_usuario` FOREIGN KEY (`id_os`) REFERENCES `os` (`id_os`),
  CONSTRAINT `fk_usuario_os` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `id_adm` int NOT NULL,
  `nome_usuario` varchar(50) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `senha` varchar(12) DEFAULT NULL,
  `data_cad` varchar(10) DEFAULT NULL,
  `data_nasc` varchar(10) DEFAULT NULL,
   `foto_usuario` longblob default null, 
  `sexo` enum('M','F') DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_adm` (`id_adm`),
  CONSTRAINT `fk_adm` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-09 13:56:16
