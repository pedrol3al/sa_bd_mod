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

--
-- Table structure for table `adm`
--

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
  PRIMARY KEY (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm`
--

LOCK TABLES `adm` WRITE;
/*!40000 ALTER TABLE `adm` DISABLE KEYS */;
INSERT INTO `adm` VALUES (1,'Michelle Johnson','2023-12-31','robert48@armstrong-moody.net','@8dbAk!M','tracywarren'),(2,'David Jackson','2024-11-24','mackpamela@gmail.com','(x^7WJto','rbarr'),(3,'Natalie Robinson','2023-09-11','sheilameza@wiggins.info','^8Mya9o6','rebeccasmith'),(4,'Kayla Martinez','2025-03-02','wilsonclifford@gmail.com','1_$594Xh','keithjoseph'),(5,'Jennifer Parks','2023-10-26','samuelbradley@moss.com','*6i&Kr_g','jeffreyjones'),(6,'Adrian Torres','2024-05-23','marksthomas@gmail.com','*y6C8rTd','sarah43'),(7,'Mrs. Sara Wilcox DDS','2024-06-30','olivia09@hotmail.com','!1YnTbh5','timothy39'),(8,'Megan Pacheco','2024-03-07','karenwoods@baker.biz','+N7kaFor','rgarcia'),(9,'Darrell Anderson','2024-07-03','rojasanthony@hotmail.com','^X8N2vwa','shannon75'),(10,'Kim Bridges','2024-04-27','kenneth84@powell.com','!l4NmfVF','robertsroger'),(11,'Joel Schwartz','2024-06-17','jennifer35@klein.biz','*U7Uz2od','henry99'),(12,'Anthony Weiss','2024-03-29','donaldortiz@manning.net','*7BNP4cl','alexanderpaula'),(13,'Anthony Brennan','2024-11-16','penaemily@robinson.org','*&0%I@(p','wrhodes'),(14,'Kathryn Leblanc','2024-02-17','pottsyvonne@lee.com','k#2SVcCr','donnaward'),(15,'Ashley Thompson','2023-06-15','katherinelopez@hotmail.com','&1B77#c+','vwood'),(16,'Ronald Lam','2023-06-04','smithbrittany@yahoo.com','#9eE^IXm','ejones'),(17,'Lindsay Bridges','2025-01-28','lsalazar@patel.com','zA&9BsRF','gregoryhall'),(18,'Emily Rose','2025-03-02','andreamoore@gmail.com','#38YFKur','craig74'),(19,'Valerie Mitchell','2025-01-30','dwalker@hotmail.com','+a7Kp&#t','oreed'),(20,'Ruben Hansen','2023-07-07','madisonrodriguez@dominguez.net','^6^o6gXi','denise14'),(21,'Ricky Douglas','2024-02-24','raymondgilmore@gmail.com','*o0GBa@*','timothybenson'),(22,'William Davis','2024-12-28','sheryl33@gmail.com','_*Kt6Ff#','uturner'),(23,'Lisa Barber','2025-01-25','halldavid@campbell.info','_%0Y6y8r','jessewillis'),(24,'William Brown','2025-01-11','brownjerry@hotmail.com','(3Q(Fni4','patrickfoster'),(25,'Christopher Bell','2023-12-28','zpope@hotmail.com','(%22Jp4f','scott49'),(26,'Angela Diaz MD','2024-07-22','heather76@gmail.com','@^9^Q)y3','moyerscott'),(27,'Jennifer Riley','2023-11-17','kristina92@thomas.com','*9sDucsw','martinezmakayla'),(28,'Joshua Carter MD','2025-01-13','longsteven@hotmail.com','(9P2vPNv','davismicheal'),(29,'Abigail Bowen','2025-01-10','barbaraorr@gmail.com','X*0aO#Hi','shannon18'),(30,'Sarah Jones','2024-12-06','kwalters@gmail.com','*X*2BleY','gabrielle01'),(31,'Curtis Cortez','2023-10-15','djohnson@thompson.net','_@3n0SBy','lynn27'),(32,'Diane Davis','2024-08-16','michaelpowell@wallace.com','(#07GC4s','mbridges'),(33,'Stephanie Gonzalez','2023-08-23','maryschroeder@gmail.com','F%8tIOs2','owenstimothy'),(34,'Christine Owens','2024-08-31','cdixon@leblanc-hughes.com','&6RP4RaC','brandy38'),(35,'Joseph Montes','2024-06-10','rsmith@smith-gray.net','(zRg4P6b','jennifer89'),(36,'Carlos Meyer','2025-03-26','jerrycross@yahoo.com','_K7TyNvI','barrycynthia'),(37,'Holly Reynolds','2025-01-25','robert44@gmail.com','^z@i5WkL','georgesmith'),(38,'Ricardo Deleon','2024-04-04','leerobert@hotmail.com','A+y48QvF','lwood'),(39,'Leon Jones','2024-09-19','daniellepage@wells.com','V_h5IC0j','martha69'),(40,'Michelle Zavala','2024-05-07','kaylaadams@hernandez.com','*8c$Nxeb','mitchellernest'),(41,'David Hurst','2025-01-21','jeffreyjacobson@gmail.com','5U^*z0Bk','bmartin'),(42,'Timothy Taylor','2024-09-12','williammiller@buckley.biz','M#p7InRb','gritter'),(43,'Cynthia Mann DDS','2024-07-07','steven96@yahoo.com','io@m+3Gs','stanley28'),(44,'Misty Gonzalez','2024-07-15','michellemyers@hotmail.com','@P4Uyee&','jerry57'),(45,'Michael Mercer','2024-04-22','brandy71@wise-reynolds.com','g#PQ2IRf','thompsonedwin'),(46,'Alfred Forbes','2024-09-26','allisontyler@coleman.com','+X1NceaR','kleinkathleen'),(47,'Christina Zimmerman','2023-11-08','john01@gmail.com','*1IP+r29','tara55'),(48,'Dillon Parker','2025-04-25','jessica23@weber-miller.info','A)8S(HaA','josephsanchez'),(49,'Michael Fernandez','2024-10-17','jonathan77@contreras.com','*A9CNZo8','jamieholland'),(50,'Jacob Pitts','2025-05-06','paulhuber@hotmail.com','W^Vct6Ko','thomasvang'),(51,'Rebecca Rosales','2023-11-06','jamespatterson@yahoo.com','+x9E!r0I','rowediana'),(52,'Deborah Walker','2025-03-03','benjamin55@smith-warner.com','+*oC9DmD','graythomas'),(53,'Jessica Zhang','2024-06-04','ericmendez@castillo-hartman.info','&3m4B0ka','tamaralopez'),(54,'Michael Hodges','2023-11-19','jamesmccarthy@gmail.com','q_PK1Zbp','ptorres'),(55,'Kerry Morris','2023-07-23','cbrooks@yahoo.com','R7_6XnKm','sototimothy'),(56,'Richard Nelson','2023-06-14','rmoore@gmail.com','4%e!l6Is','qdavis'),(57,'Linda Sellers','2024-02-21','ahernandez@allen.net','!nY7AnFp','jonesmichael'),(58,'Lynn Morgan','2025-03-13','twood@yahoo.com','!@L5KOgw','jessicastephens'),(59,'Jeffrey Washington','2023-11-13','woodwarddonna@anderson.com','_UY3rAHw','josephgreene'),(60,'Ann Kline','2024-04-15','dominicbanks@moore.com','k%y4wCoP','john13');
/*!40000 ALTER TABLE `adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
INSERT INTO `agenda` VALUES (1,'2025-03-15',1),(2,'2025-03-16',2),(3,'2025-03-17',3),(4,'2025-03-18',4),(5,'2025-03-19',5),(6,'2025-03-20',6),(7,'2025-03-21',7),(8,'2025-03-22',8),(9,'2025-03-23',9),(10,'2025-03-24',10),(11,'2025-03-25',11),(12,'2025-03-26',12),(13,'2025-03-27',13),(14,'2025-03-28',14),(15,'2025-03-29',15),(16,'2025-03-30',16),(17,'2025-03-31',17),(18,'2025-04-01',18),(19,'2025-04-02',19),(20,'2025-04-03',20),(21,'2025-04-04',21),(22,'2025-04-05',22),(23,'2025-04-06',23),(24,'2025-04-07',24),(25,'2025-04-08',25),(26,'2025-04-09',26),(27,'2025-04-10',27),(28,'2025-04-11',28),(29,'2025-04-12',29),(30,'2025-04-13',30),(31,'2025-04-14',31),(32,'2025-04-15',32),(33,'2025-04-16',33),(34,'2025-04-17',34),(35,'2025-04-18',35),(36,'2025-04-19',36),(37,'2025-04-20',37),(38,'2025-04-21',38),(39,'2025-04-22',39),(40,'2025-04-23',40),(41,'2025-04-24',41),(42,'2025-04-25',42),(43,'2025-04-26',43),(44,'2025-04-27',44),(45,'2025-04-28',45),(46,'2025-04-29',46),(47,'2025-04-30',47),(48,'2025-05-01',48),(49,'2025-05-02',49),(50,'2025-05-03',50),(51,'2025-05-04',51),(52,'2025-05-05',52),(53,'2025-05-06',53),(54,'2025-05-07',54),(55,'2025-05-08',55),(56,'2025-05-09',56),(57,'2025-05-10',57),(58,'2025-05-11',58),(59,'2025-05-12',59),(60,'2025-05-13',60);
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `cargo` varchar(30) DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,1,'lucas.oliveira@email.com','Lucas Oliveira','Cliente novo','123456789','1990-04-10',NULL,'M'),(2,2,'mariana.costa@email.com','Mariana Costa','Cliente com urgência em atendimento','234567890','1985-08-15',NULL,'F'),(3,3,'joao.silva@email.com','João Silva','Solicitação de reparo em equipamento','345678901','1980-12-20',NULL,'M'),(4,4,'ana.paula@email.com','Ana Paula','Pedido para serviço de manutenção','456789012','1992-03-25',NULL,'F'),(5,5,'pedro.oliveira@email.com','Pedro Oliveira','Necessita de acompanhamento mensal','567890123','1995-02-18',NULL,'M'),(6,6,'carla.souza@email.com','Carla Souza','Cliente com contrato de longo prazo','678901234','1988-11-30',NULL,'F'),(7,7,'rafael.lima@email.com','Rafael Lima','Precisa de suporte técnico remoto','789012345','1991-07-22',NULL,'M'),(8,8,'fernanda.rocha@email.com','Fernanda Rocha','Cliente com necessidades especiais','890123456','1993-06-10',NULL,'F'),(9,9,'diego.mendes@email.com','Diego Mendes','Agendamento de visita técnica','901234567','1987-09-04',NULL,'M'),(10,10,'juliana.martins@email.com','Juliana Martins','Cliente com visita mensal programada','012345678','1990-05-17',NULL,'F'),(11,11,'gustavo.alves@email.com','Gustavo Alves','Solicitação de instalação de sistema','123456789','1986-02-05',NULL,'M'),(12,12,'camila.pires@email.com','Camila Pires','Serviço de instalação pendente','234567890','1994-01-29',NULL,'F'),(13,13,'andre.reis@email.com','André Reis','Cliente precisa de serviço urgente','345678901','1982-10-15',NULL,'M'),(14,14,'patricia.teixeira@email.com','Patrícia Teixeira','Pedido de reparo rápido','456789012','1990-08-12',NULL,'F'),(15,15,'bruno.nascimento@email.com','Bruno Nascimento','Solicitação de serviço de emergência','567890123','1989-11-23',NULL,'M'),(16,16,'laura.gomes@email.com','Laura Gomes','Aguardando peças para reparo','678901234','1991-06-09',NULL,'F'),(17,17,'fabio.cunha@email.com','Fábio Cunha','Cliente com histórico de bons pagamentos','789012345','1985-03-27',NULL,'M'),(18,18,'livia.fernandes@email.com','Lívia Fernandes','Necessita de suporte técnico mensal','890123456','1992-05-20',NULL,'F'),(19,19,'eduardo.batista@email.com','Eduardo Batista','Agendamento de visita técnica','901234567','1993-04-03',NULL,'M'),(20,20,'renata.lima@email.com','Renata Lima','Cliente com necessidades específicas','012345679','1991-08-11',NULL,'F'),(21,1,'marcelo.torres@email.com','Marcelo Torres','Cliente com contrato de longo prazo','123456789','1988-09-22',NULL,'M'),(22,2,'elaine.barbosa@email.com','Elaine Barbosa','Precisa de reparo urgente','234567890','1995-12-15',NULL,'F'),(23,3,'cesar.martins@email.com','César Martins','Agendamento de serviço técnico','345678901','1983-11-30',NULL,'M'),(24,4,'tatiane.prado@email.com','Tatiane Prado','Cliente com pendência de pagamento','456789012','1990-10-05',NULL,'F'),(25,5,'paulo.lima@email.com','Paulo Lima','Necessita de manutenção preventiva','567890123','1994-03-18',NULL,'M'),(26,6,'debora.castro@email.com','Débora Castro','Aguardando confirmação de visita','678901234','1987-05-29',NULL,'F'),(27,7,'roberto.lopes@email.com','Roberto Lopes','Cliente com problemas recorrentes','789012345','1991-02-12',NULL,'M'),(28,8,'sandra.ribeiro@email.com','Sandra Ribeiro','Aguardando peça para reparo','890123456','1984-08-10',NULL,'F'),(29,9,'vinicius.dias@email.com','Vinícius Dias','Visita técnica agendada','901234567','1990-04-03',NULL,'M'),(30,10,'simone.neves@email.com','Simone Neves','Necessita de suporte técnico remoto','012345679','1992-11-13',NULL,'F'),(31,11,'murilo.carvalho@email.com','Murilo Carvalho','Cliente com necessidade de manutenção urgente','123456789','1985-06-21',NULL,'M'),(32,12,'leticia.moura@email.com','Letícia Moura','Aguardando orçamento','234567890','1994-01-10',NULL,'F'),(33,13,'alex.costa@email.com','Alex Costa','Precisa de peças para reparo','345678901','1987-09-18',NULL,'M'),(34,14,'daniela.silva@email.com','Daniela Silva','Solicitação de instalação de equipamentos','456789012','1991-02-20',NULL,'F'),(35,15,'rodrigo.cunha@email.com','Rodrigo Cunha','Precisa de manutenção preventiva','567890123','1986-03-10',NULL,'M'),(36,16,'isabela.souza@email.com','Isabela Souza','Cliente com necessidade de atendimento remoto','678901234','1990-07-17',NULL,'F'),(37,17,'thiago.rocha@email.com','Thiago Rocha','Aguardando serviço de reparo','789012345','1988-01-25',NULL,'M'),(38,18,'priscila.fernandes@email.com','Priscila Fernandes','Solicitação de revisão do sistema','890123456','1992-11-06',NULL,'F'),(39,19,'luciano.ramos@email.com','Luciano Ramos','Cliente com histórico de pagamentos rápidos','901234567','1989-07-28',NULL,'M'),(40,20,'adriana.lima@email.com','Adriana Lima','Reparo pendente para o equipamento','012345679','1994-02-09',NULL,'F'),(41,21,'fernando.monteiro@email.com','Fernando Monteiro','Cliente com urgência para revisão','123456789','1982-09-16',NULL,'M'),(42,22,'cristina.sales@email.com','Cristina Sales','Necessita de manutenção mensal','234567890','1993-10-05',NULL,'F'),(43,23,'igor.azevedo@email.com','Igor Azevedo','Aguardando entrega de peças','345678901','1985-01-17',NULL,'M'),(44,24,'bianca.almeida@email.com','Bianca Almeida','Serviço técnico agendado','456789012','1991-03-02',NULL,'F'),(45,25,'hugo.teixeira@email.com','Hugo Teixeira','Precisa de ajuda para instalação','567890123','1986-06-14',NULL,'M'),(46,26,'marta.assis@email.com','Marta Assis','Cliente com contrato em andamento','678901234','1992-12-25',NULL,'F'),(47,27,'sergio.castro@email.com','Sérgio Castro','Aguardando visita técnica para revisão','789012345','1988-05-06',NULL,'M'),(48,28,'aline.barbosa@email.com','Aline Barbosa','Necessita de manutenção corretiva','890123456','1994-09-11',NULL,'F'),(49,29,'danilo.pereira@email.com','Danilo Pereira','Reparo necessário para equipamento principal','901234567','1990-11-23',NULL,'M'),(50,30,'silvia.faria@email.com','Silvia Faria','Cliente aguardando instalação de sistema','012345679','1987-05-14',NULL,'F'),(51,31,'antonio.rocha@email.com','Antônio Rocha','Aguardando aprovação de orçamento','123456789','1992-07-20',NULL,'M'),(52,32,'beatriz.alves@email.com','Beatriz Alves','Cliente com assistência técnica programada','234567890','1989-12-12',NULL,'F'),(53,33,'cristiano.viana@email.com','Cristiano Viana','Serviço técnico agendado','345678901','1987-04-02',NULL,'M'),(54,34,'daniela.dias@email.com','Daniela Dias','Precisa de serviço de reparo imediato','456789012','1992-10-19',NULL,'F'),(55,35,'marcela.gomes@email.com','Marcela Gomes','Cliente com solicitação de manutenção','567890123','1993-06-30',NULL,'F'),(56,36,'carlos.silva@email.com','Carlos Silva','Precisa de revisão e ajustes no equipamento','678901234','1989-09-05',NULL,'M'),(57,37,'elaine.souza@email.com','Elaine Souza','Aguardando peça para troca','789012345','1990-02-28',NULL,'F'),(58,38,'fabio.rocha@email.com','Fábio Rocha','Necessita de agendamento de manutenção','890123456','1987-07-19',NULL,'M'),(59,39,'amanda.teixeira@email.com','Amanda Teixeira','Reparo solicitado para equipamentos','901234567','1994-01-11',NULL,'F'),(60,40,'julio.cesar@email.com','Julio César','Precisa de revisão do sistema','012345679','1989-04-23',NULL,'M');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_fisico`
--

DROP TABLE IF EXISTS `cliente_fisico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente_fisico` (
  `id_cliente` int NOT NULL,
  `cpf` varchar(15) NOT NULL,
  KEY `fk_cliente_fisico` (`id_cliente`),
  CONSTRAINT `fk_cliente_fisico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_fisico`
--

LOCK TABLES `cliente_fisico` WRITE;
/*!40000 ALTER TABLE `cliente_fisico` DISABLE KEYS */;
INSERT INTO `cliente_fisico` VALUES (1,'123.456.789-00'),(2,'234.567.890-11'),(3,'345.678.901-22'),(4,'456.789.012-33'),(5,'567.890.123-44'),(6,'678.901.234-55'),(7,'789.012.345-66'),(8,'890.123.456-77'),(9,'901.234.567-88'),(10,'012.345.678-99'),(11,'123.456.789-01'),(12,'234.567.890-12'),(13,'345.678.901-23'),(14,'456.789.012-34'),(15,'567.890.123-45'),(16,'678.901.234-56'),(17,'789.012.345-67'),(18,'890.123.456-78'),(19,'901.234.567-89'),(20,'012.345.678-00'),(21,'123.456.789-12'),(22,'234.567.890-23'),(23,'345.678.901-34'),(24,'456.789.012-45'),(25,'567.890.123-56'),(26,'678.901.234-67'),(27,'789.012.345-78'),(28,'890.123.456-89'),(29,'901.234.567-90'),(30,'012.345.678-11'),(31,'123.456.789-23'),(32,'234.567.890-34'),(33,'345.678.901-45'),(34,'456.789.012-56'),(35,'567.890.123-67'),(36,'678.901.234-78'),(37,'789.012.345-89'),(38,'890.123.456-90'),(39,'901.234.567-01'),(40,'012.345.678-22');
/*!40000 ALTER TABLE `cliente_fisico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_adm`
--

DROP TABLE IF EXISTS `endereco_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_adm` (
  `id_endereco` int NOT NULL,
  `id_adm` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_adm_endereco` (`id_adm`),
  CONSTRAINT `fk_adm_endereco` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_adm`
--

LOCK TABLES `endereco_adm` WRITE;
/*!40000 ALTER TABLE `endereco_adm` DISABLE KEYS */;
INSERT INTO `endereco_adm` VALUES (1,1,'01001-001','Rua dos Eletrônicos','Comercial','Sala 101',200,'São Paulo','SP','Centro'),(2,2,'01002-002','Avenida do Tecnologia','Comercial','Loja 102',500,'São Paulo','SP','Vila Progredir'),(3,3,'01003-003','Rua dos Aparelhos','Residencial','Apto 103',350,'São Paulo','SP','Jardim Paulista'),(4,4,'01004-004','Rua da Inovação','Comercial','Loja 104',450,'São Paulo','SP','Vila Nova'),(5,5,'01005-005','Rua dos Chips','Residencial','Casa 105',600,'São Paulo','SP','Mooca'),(6,6,'02006-006','Rua do Circuito','Comercial','Loja 106',700,'São Paulo','SP','Santa Cecília'),(7,7,'02007-007','Rua da Tecnologia','Residencial','Apto 107',800,'São Paulo','SP','Consolação'),(8,8,'03008-008','Rua da Inovação','Comercial','Sala 108',1000,'São Paulo','SP','República'),(9,9,'04009-009','Avenida dos Gadgets','Residencial','Casa 109',1200,'São Paulo','SP','Vila Progredir'),(10,10,'05010-010','Rua da Eletrônica','Comercial','Loja 110',1300,'São Paulo','SP','Bela Vista'),(11,11,'06011-011','Rua do Microchip','Residencial','Apto 111',1400,'São Paulo','SP','Vila Buarque'),(12,12,'07012-012','Rua da Conectividade','Comercial','Loja 112',1500,'São Paulo','SP','Liberdade'),(13,13,'08013-013','Rua do Processador','Residencial','Casa 113',1600,'São Paulo','SP','Itaim Bibi'),(14,14,'09014-014','Avenida da Rede','Comercial','Sala 114',1700,'São Paulo','SP','Jardins'),(15,15,'10015-015','Rua do Circuito Integrado','Residencial','Apto 115',1800,'São Paulo','SP','Pinheiros'),(16,16,'11016-016','Rua do Dispositivo','Comercial','Loja 116',1900,'São Paulo','SP','Alto da Lapa'),(17,17,'12017-017','Rua do Equipamento','Residencial','Casa 117',2000,'São Paulo','SP','Lapa'),(18,18,'13018-018','Rua do Sistema','Comercial','Sala 118',2100,'São Paulo','SP','Morumbi'),(19,19,'14019-019','Avenida da Conexão','Residencial','Apto 119',2200,'São Paulo','SP','Brooklin'),(20,20,'15020-020','Rua da Placa-Mãe','Comercial','Loja 120',2300,'São Paulo','SP','Vila Olímpia'),(21,21,'16021-021','Rua do Cabos','Residencial','Casa 121',2400,'São Paulo','SP','Vila Progredir'),(22,22,'17022-022','Rua do Componentes','Comercial','Loja 122',2500,'São Paulo','SP','Vila Buarque'),(23,23,'18023-023','Avenida do Circuito','Residencial','Apto 123',2600,'São Paulo','SP','Lapa'),(24,24,'19024-024','Rua da Conexão Digital','Comercial','Sala 124',2700,'São Paulo','SP','São João'),(25,25,'20025-025','Rua do Robô','Residencial','Casa 125',2800,'São Paulo','SP','Vila Prudente'),(26,26,'21026-026','Avenida da Rede Social','Comercial','Loja 126',2900,'São Paulo','SP','Santo Amaro'),(27,27,'22027-027','Rua dos Transistores','Residencial','Apto 127',3000,'São Paulo','SP','Pinheiros'),(28,28,'23028-028','Rua da Lógica','Comercial','Loja 128',3100,'São Paulo','SP','Moema'),(29,29,'24029-029','Rua da Rede de Dados','Residencial','Casa 129',3200,'São Paulo','SP','Vila Nivi'),(30,30,'25030-030','Rua da Tecnologia Digital','Comercial','Sala 130',3300,'São Paulo','SP','Vila Progredir'),(31,31,'26031-031','Rua do Transistor','Residencial','Apto 131',3400,'São Paulo','SP','Jardins'),(32,32,'27032-032','Avenida da Inovação','Comercial','Loja 132',3500,'São Paulo','SP','Vila Olimpia'),(33,33,'28033-033','Rua dos Chips Eletrônicos','Residencial','Casa 133',3600,'São Paulo','SP','Campo Belo'),(34,34,'29034-034','Rua da Fiação','Comercial','Sala 134',3700,'São Paulo','SP','Jardins'),(35,35,'30035-035','Rua dos Sensores','Residencial','Apto 135',3800,'São Paulo','SP','Butantã'),(36,36,'31036-036','Rua do Amplificador','Comercial','Loja 136',3900,'São Paulo','SP','Pirituba'),(37,37,'32037-037','Rua do Processador de Dados','Residencial','Casa 137',4000,'São Paulo','SP','Itaim Bibi'),(38,38,'33038-038','Avenida do Equipamento Eletrônico','Comercial','Sala 138',4100,'São Paulo','SP','Vila Progredir'),(39,39,'34039-039','Rua da Tela de LED','Residencial','Apto 139',4200,'São Paulo','SP','Santa Cecília'),(40,40,'35040-040','Rua do Carregador','Comercial','Loja 140',4300,'São Paulo','SP','Tatuapé'),(41,41,'36041-041','Rua da Rede de Comunicação','Residencial','Casa 141',4400,'São Paulo','SP','Lapa'),(42,42,'37042-042','Rua dos Smartphones','Comercial','Sala 142',4500,'São Paulo','SP','Mooca'),(43,43,'38043-043','Rua da Inovação Tecnológica','Residencial','Apto 143',4600,'São Paulo','SP','Pinheiros'),(44,44,'39044-044','Rua do Hardware','Comercial','Loja 144',4700,'São Paulo','SP','Santo Amaro'),(45,45,'40045-045','Avenida da Eletrônica','Residencial','Casa 145',4800,'São Paulo','SP','Vila Olímpia'),(46,46,'41046-046','Rua da Rede Sem Fio','Comercial','Sala 146',4900,'São Paulo','SP','Vila Nivi'),(47,47,'42047-047','Rua do Microprocessador','Residencial','Casa 147',5000,'São Paulo','SP','Vila Progredir'),(48,48,'43048-048','Avenida da Inteligência Artificial','Comercial','Loja 148',5100,'São Paulo','SP','Liberdade'),(49,49,'44049-049','Rua do Painel Solar','Residencial','Apto 149',5200,'São Paulo','SP','Santo Amaro'),(50,50,'45050-050','Rua da Lógica Digital','Comercial','Sala 150',5300,'São Paulo','SP','Pinheiros'),(51,51,'46051-051','Rua do Display de LED','Residencial','Casa 151',5400,'São Paulo','SP','Itaim Bibi'),(52,52,'47052-052','Avenida dos Circuitos','Comercial','Loja 152',5500,'São Paulo','SP','Campo Belo'),(53,53,'48053-053','Rua do Vídeo','Residencial','Apto 153',5600,'São Paulo','SP','Vila Progredir'),(54,54,'49054-054','Rua do Dispositivo de Áudio','Comercial','Sala 154',5700,'São Paulo','SP','Vila Buarque'),(55,55,'50055-055','Rua da Conectividade Digital','Residencial','Casa 155',5800,'São Paulo','SP','Jardins'),(56,56,'51056-056','Avenida da Rede Elétrica','Comercial','Loja 156',5900,'São Paulo','SP','Centro'),(57,57,'52057-057','Rua do Suporte Técnico','Residencial','Apto 157',6000,'São Paulo','SP','Santo Amaro'),(58,58,'53058-058','Rua dos Dispositivos Eletrônicos','Comercial','Loja 158',6100,'São Paulo','SP','Vila Nivi'),(59,59,'54059-059','Rua do Aparelho Digital','Residencial','Casa 159',6200,'São Paulo','SP','Vila Olímpia'),(60,60,'55060-060','Rua do Telefone','Comercial','Sala 160',6300,'São Paulo','SP','Mooca');
/*!40000 ALTER TABLE `endereco_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_cliente`
--

DROP TABLE IF EXISTS `endereco_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_cliente` (
  `id_endereco` int NOT NULL,
  `id_cliente` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_cliente_endereco` (`id_cliente`),
  CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_cliente`
--

LOCK TABLES `endereco_cliente` WRITE;
/*!40000 ALTER TABLE `endereco_cliente` DISABLE KEYS */;
INSERT INTO `endereco_cliente` VALUES (1,1,'12345-678','Rua das Palmeiras','Residencial','Apt 101',123,'São Paulo','SP','Centro'),(2,2,'23456-789','Avenida das Américas','Comercial','Sala 202',456,'Rio de Janeiro','RJ','Botafogo'),(3,3,'34567-890','Rua do Rio de Janeiro','Residencial','Casa 5',789,'Belo Horizonte','MG','Savassi'),(4,4,'45678-901','Rua do Sol','Residencial','Bloco B',101,'Brasília','DF','Asa Norte'),(5,5,'56789-012','Avenida Beira-Mar','Comercial','Loja 301',112,'Porto Alegre','RS','Centro'),(6,6,'67890-123','Rua Dr. Gama Filho','Residencial','Casa 6',223,'Curitiba','PR','Batel'),(7,7,'78901-234','Rua da Aurora','Comercial','Sala 403',334,'Recife','PE','Boa Viagem'),(8,8,'89012-345','Avenida do Parque','Residencial','Apt 301',445,'Fortaleza','CE','Aldeota'),(9,9,'90123-456','Rua Marechal Floriano','Residencial','Casa 7',556,'Salvador','BA','Barra'),(10,10,'01234-567','Avenida Principal','Comercial','Loja 201',667,'Manaus','AM','Centro'),(11,11,'12345-678','Rua Coração de Jesus','Residencial','Bloco C',778,'São Paulo','SP','Itaim Bibi'),(12,12,'23456-789','Rua 7 de Setembro','Comercial','Sala 404',889,'Rio de Janeiro','RJ','Ipanema'),(13,13,'34567-890','Rua do Contorno','Residencial','Casa 8',990,'Belo Horizonte','MG','Lourdes'),(14,14,'45678-901','Avenida Central','Residencial','Apt 102',101,'Brasília','DF','Asa Sul'),(15,15,'56789-012','Rua dos Três Corações','Comercial','Loja 305',213,'Porto Alegre','RS','Moinhos de Vento'),(16,16,'67890-123','Avenida Rio Branco','Residencial','Casa 9',324,'Curitiba','PR','Centro'),(17,17,'78901-234','Rua da Harmonia','Comercial','Sala 505',435,'Recife','PE','Pina'),(18,18,'89012-345','Avenida do Parque','Residencial','Apt 202',546,'Fortaleza','CE','Meireles'),(19,19,'90123-456','Rua Francisco Glicério','Residencial','Casa 10',657,'Salvador','BA','Ondina'),(20,20,'01234-567','Avenida das Nações','Comercial','Loja 406',768,'Manaus','AM','Ponta Negra'),(21,21,'12345-678','Rua das Acácias','Residencial','Bloco D',879,'São Paulo','SP','Moema'),(22,22,'23456-789','Avenida Atlântica','Comercial','Sala 607',980,'Rio de Janeiro','RJ','Leblon'),(23,23,'34567-890','Rua João Pinheiro','Residencial','Casa 11',101,'Belo Horizonte','MG','Funcionários'),(24,24,'45678-901','Avenida JK','Residencial','Apt 103',112,'Brasília','DF','Lago Sul'),(25,25,'56789-012','Rua dos Três Irmãos','Comercial','Loja 502',223,'Porto Alegre','RS','Vila Flores'),(26,26,'67890-123','Rua XV de Novembro','Residencial','Casa 12',334,'Curitiba','PR','Água Verde'),(27,27,'78901-234','Avenida Rui Barbosa','Comercial','Sala 708',445,'Recife','PE','Casa Forte'),(28,28,'89012-345','Rua das Laranjeiras','Residencial','Apt 304',556,'Fortaleza','CE','Cocó'),(29,29,'90123-456','Rua dos Jacarandás','Residencial','Casa 13',667,'Salvador','BA','Graça'),(30,30,'01234-567','Avenida dos Trabalhadores','Comercial','Loja 609',778,'Manaus','AM','Ponta Negra'),(31,31,'12345-678','Rua Barão de Itapetininga','Residencial','Bloco E',889,'São Paulo','SP','Bela Vista'),(32,32,'23456-789','Rua Eduardo Ribeiro','Comercial','Sala 102',990,'Rio de Janeiro','RJ','Copacabana'),(33,33,'34567-890','Rua do Mercado','Residencial','Casa 14',101,'Belo Horizonte','MG','Santo Antônio'),(34,34,'45678-901','Avenida Brasil','Residencial','Apt 104',112,'Brasília','DF','Lago Norte'),(35,35,'56789-012','Rua das Orquídeas','Comercial','Loja 703',223,'Porto Alegre','RS','Petropolis'),(36,36,'67890-123','Rua da Liberdade','Residencial','Casa 15',334,'Curitiba','PR','Cabo Largo'),(37,37,'78901-234','Avenida dos Bandeirantes','Comercial','Sala 806',445,'Recife','PE','Várzea'),(38,38,'89012-345','Rua São Francisco','Residencial','Apt 305',556,'Fortaleza','CE','Joaquim Távora'),(39,39,'90123-456','Rua da Liberdade','Residencial','Casa 16',657,'Salvador','BA','Pituba'),(40,40,'01234-567','Avenida São João','Comercial','Loja 902',768,'Manaus','AM','Adrianópolis'),(41,41,'12345-678','Rua da Alegria','Residencial','Bloco F',879,'São Paulo','SP','Vila Progredior'),(42,42,'23456-789','Rua Independência','Comercial','Sala 103',980,'Rio de Janeiro','RJ','Tijuca'),(43,43,'34567-890','Rua das Flores','Residencial','Casa 17',101,'Belo Horizonte','MG','Anchieta'),(44,44,'45678-901','Avenida Rio de Janeiro','Residencial','Apt 105',112,'Brasília','DF','Plano Piloto'),(45,45,'56789-012','Rua da Montanha','Comercial','Loja 407',223,'Porto Alegre','RS','Vila Jardim'),(46,46,'67890-123','Rua das Águas','Residencial','Casa 18',334,'Curitiba','PR','Hauer'),(47,47,'78901-234','Avenida das Nações Unidas','Comercial','Sala 907',445,'Recife','PE','Aflitos'),(48,48,'89012-345','Rua do Lago','Residencial','Apt 306',556,'Fortaleza','CE','Parangaba'),(49,49,'90123-456','Rua São João','Residencial','Casa 19',667,'Salvador','BA','Vila Laura'),(50,50,'01234-567','Avenida da Paz','Comercial','Loja 508',768,'Manaus','AM','Centro'),(51,51,'12345-678','Rua do Sol Nascente','Residencial','Bloco G',879,'São Paulo','SP','Jardins'),(52,52,'23456-789','Rua dos Verdes Campos','Comercial','Sala 105',980,'Rio de Janeiro','RJ','Barra da Tijuca'),(53,53,'34567-890','Rua das Palmeiras Secas','Residencial','Casa 20',101,'Belo Horizonte','MG','Sion'),(54,54,'45678-901','Avenida 9 de Julho','Residencial','Apt 106',112,'Brasília','DF','Candangolândia'),(55,55,'56789-012','Rua da Esperança','Comercial','Loja 608',223,'Porto Alegre','RS','Rio Branco'),(56,56,'67890-123','Rua das Acácias Verdes','Residencial','Casa 21',334,'Curitiba','PR','Jardim Botânico'),(57,57,'78901-234','Avenida Beira-Rio','Comercial','Sala 907',445,'Recife','PE','Imbiribeira'),(58,58,'89012-345','Rua dos Lírios','Residencial','Apt 307',556,'Fortaleza','CE','São João do Tauape'),(59,59,'90123-456','Rua do Campo Verde','Residencial','Casa 22',667,'Salvador','BA','Caminho das Árvores'),(60,60,'01234-567','Rua dos Ipês','Residencial','Casa 101',778,'Manaus','AM','Vila Buriti');
/*!40000 ALTER TABLE `endereco_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_fornecedor`
--

DROP TABLE IF EXISTS `endereco_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_fornecedor` (
  `id_endereco_fornecedor` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_endereco_fornecedor`),
  KEY `fk_fornecedor_endereco` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor_endereco` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_fornecedor`
--

LOCK TABLES `endereco_fornecedor` WRITE;
/*!40000 ALTER TABLE `endereco_fornecedor` DISABLE KEYS */;
INSERT INTO `endereco_fornecedor` VALUES (1,1,'12345-678','Rua Eletrônica','Comercial','Bloco A',100,'São Paulo','SP','Centro'),(2,2,'98765-432','Avenida Tecnológica','Industrial','Próximo ao portão 3',200,'Campinas','SP','Distrito Industrial'),(3,3,'11223-445','Rua Digital','Residencial','Apartamento 101',150,'Rio de Janeiro','RJ','Copacabana'),(4,4,'33445-678','Avenida Inovação','Comercial','Andar 5',250,'Belo Horizonte','MG','Centro'),(5,5,'55678-890','Rua Circuito','Residencial','Casa 12',300,'Curitiba','PR','Batel'),(6,6,'66789-012','Praça Central','Comercial','Loja 23',350,'Porto Alegre','RS','Centro'),(7,7,'77890-123','Rua dos Inovadores','Residencial','Casa 101',400,'Florianópolis','SC','Centro'),(8,8,'88901-234','Avenida Progresso','Comercial','Pavilhão 4',450,'Salvador','BA','Cajazeiras'),(9,9,'99012-345','Rua Criativa','Comercial','Prédio 5',500,'Fortaleza','CE','Centro'),(10,10,'10123-456','Rua Futuro','Residencial','Apartamento 202',550,'Recife','PE','Boa Viagem'),(11,11,'21234-567','Avenida Eletrônica','Comercial','Sala 303',600,'São José','SC','Centro'),(12,12,'32345-678','Rua Avançada','Residencial','Casa 303',650,'Natal','RN','Ponta Negra'),(13,13,'43456-789','Rua Digitalizada','Comercial','Andar 7',700,'Manaus','AM','Centro'),(14,14,'54567-890','Rua Tecno','Residencial','Apartamento 404',750,'Belém','PA','Cidade Velha'),(15,15,'65678-901','Avenida Futurística','Comercial','Pavilhão 8',800,'Vitória','ES','Centro'),(16,16,'76789-012','Rua Circuito Digital','Residencial','Casa 505',850,'Maceió','AL','Pajuçara'),(17,17,'87890-123','Rua do Futuro','Comercial','Loja 101',900,'João Pessoa','PB','Centro'),(18,18,'98901-234','Avenida de Inovação','Residencial','Casa 606',950,'São Luís','MA','Centro'),(19,19,'10012-345','Rua Tecnológica','Comercial','Prédio 404',1000,'Campo Grande','MS','Centro'),(20,20,'21123-456','Avenida dos Progresso','Residencial','Apartamento 303',1050,'Goiânia','GO','Setor Bueno'),(21,21,'32234-567','Rua da Engenharia','Comercial','Loja 505',1100,'Aracaju','SE','Centro'),(22,22,'43345-678','Rua Criativa Digital','Residencial','Casa 707',1150,'Cuiabá','MT','Centro'),(23,23,'54456-789','Avenida dos Técnicos','Comercial','Sala 808',1200,'Teresina','PI','Centro'),(24,24,'65567-890','Rua dos Especialistas','Residencial','Apartamento 909',1250,'Palmas','TO','Centro'),(25,25,'76678-901','Rua do Conhecimento','Comercial','Pavilhão 10',1300,'Rio Branco','AC','Centro'),(26,26,'87789-012','Avenida da Tecnologia','Residencial','Casa 1010',1350,'Porto Velho','RO','Centro'),(27,27,'98890-123','Rua do Avanço','Comercial','Loja 112',1400,'Macapá','AP','Centro'),(28,28,'10001-234','Avenida de Engenharia','Residencial','Casa 121',1450,'Boa Vista','RR','Centro'),(29,29,'11112-345','Rua de Progresso','Comercial','Sala 123',1500,'Rio Branco','AC','Centro'),(30,30,'12223-456','Rua Futurista','Residencial','Apartamento 131',1550,'Palmas','TO','Plano Diretor'),(31,31,'23334-567','Avenida Científica','Comercial','Pavilhão 132',1600,'Porto Velho','RO','Centro'),(32,32,'34445-678','Rua dos Engenheiros','Residencial','Casa 143',1650,'Macapá','AP','Centro'),(33,33,'45556-789','Avenida Digitalizada','Comercial','Loja 154',1700,'Cuiabá','MT','Centro'),(34,34,'56667-890','Rua de Inovação','Residencial','Casa 165',1750,'Aracaju','SE','Atalaia'),(35,35,'67778-901','Avenida Avançada','Comercial','Andar 176',1800,'Goiânia','GO','Centro'),(36,36,'78889-012','Rua da Transformação','Residencial','Apartamento 187',1850,'Teresina','PI','Centro'),(37,37,'89990-123','Rua do Crescimento','Comercial','Loja 198',1900,'Campo Grande','MS','Centro'),(38,38,'10001-234','Avenida da Criatividade','Residencial','Casa 209',1950,'João Pessoa','PB','Centro'),(39,39,'11112-345','Rua dos Especialistas','Comercial','Pavilhão 210',2000,'São Luís','MA','Centro'),(40,40,'12223-456','Avenida Inovadora','Residencial','Casa 221',2050,'Florianópolis','SC','Centro'),(41,41,'23334-567','Rua do Desenvolvimento','Comercial','Loja 232',2100,'Porto Alegre','RS','Centro'),(42,42,'34445-678','Avenida do Conhecimento','Residencial','Casa 243',2150,'Curitiba','PR','Batel'),(43,43,'45556-789','Rua Avançada','Comercial','Andar 254',2200,'Campinas','SP','Distrito Industrial'),(44,44,'56667-890','Avenida Tecnológica','Residencial','Apartamento 265',2250,'São José','SC','Centro'),(45,45,'67778-901','Rua do Progresso','Comercial','Loja 276',2300,'Natal','RN','Ponta Negra'),(46,46,'78889-012','Avenida dos Avanços','Residencial','Casa 287',2350,'Vitória','ES','Centro'),(47,47,'89990-123','Rua das Inovações','Comercial','Pavilhão 298',2400,'São Paulo','SP','Centro'),(48,48,'10001-234','Avenida Progresso','Residencial','Casa 309',2450,'Belo Horizonte','MG','Centro'),(49,49,'11112-345','Rua Digital','Comercial','Andar 310',2500,'Recife','PE','Boa Viagem'),(50,50,'12223-456','Rua de Transformação','Residencial','Apartamento 321',2550,'Salvador','BA','Cajazeiras'),(51,51,'23334-567','Avenida de Inovação','Comercial','Loja 332',2600,'Fortaleza','CE','Centro'),(52,52,'34445-678','Rua Progresso','Residencial','Casa 343',2650,'Florianópolis','SC','Centro'),(53,53,'45556-789','Rua Criativa','Comercial','Sala 354',2700,'Rio de Janeiro','RJ','Copacabana'),(54,54,'56667-890','Avenida Futuro','Residencial','Casa 365',2750,'Curitiba','PR','Centro'),(55,55,'67778-901','Rua Inovadora','Comercial','Pavilhão 376',2800,'Campinas','SP','Centro'),(56,56,'78889-012','Avenida Avançada','Residencial','Apartamento 387',2850,'Porto Alegre','RS','Centro'),(57,57,'89990-123','Rua do Progresso','Comercial','Loja 398',2900,'Belo Horizonte','MG','Centro'),(58,58,'10001-234','Rua dos Avanços','Residencial','Casa 409',2950,'Recife','PE','Boa Viagem'),(59,59,'11112-345','Avenida dos Engenheiros','Comercial','Andar 410',3000,'São José','SC','Centro'),(60,60,'12223-456','Rua de Tecnologia','Residencial','Apartamento 421',3050,'Vitória','ES','Centro');
/*!40000 ALTER TABLE `endereco_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_usuario`
--

DROP TABLE IF EXISTS `endereco_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_usuario` (
  `id_endereco` int NOT NULL,
  `id_usuario` int NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_usuario_endereco` (`id_usuario`),
  CONSTRAINT `fk_usuario_endereco` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_usuario`
--

LOCK TABLES `endereco_usuario` WRITE;
/*!40000 ALTER TABLE `endereco_usuario` DISABLE KEYS */;
INSERT INTO `endereco_usuario` VALUES (1,1,'01001-001','Rua dos Componentes','Residencial','Apto 101',100,'São Paulo','SP','Centro'),(2,2,'02002-002','Avenida da Inovação','Residencial','Casa 102',200,'São Paulo','SP','Vila Buarque'),(3,3,'03003-003','Rua da Tecnologia','Comercial','Loja 103',300,'São Paulo','SP','Itaim Bibi'),(4,4,'04004-004','Rua do Circuito','Residencial','Apto 104',400,'São Paulo','SP','Liberdade'),(5,5,'05005-005','Avenida dos Processadores','Comercial','Sala 105',500,'São Paulo','SP','Vila Progredir'),(6,6,'06006-006','Rua do Dispositivo','Residencial','Casa 106',600,'São Paulo','SP','Jardins'),(7,7,'07007-007','Rua da Conectividade','Comercial','Loja 107',700,'São Paulo','SP','Moema'),(8,8,'08008-008','Avenida da Rede','Residencial','Apto 108',800,'São Paulo','SP','Vila Olímpia'),(9,9,'09009-009','Rua do Circuito Integrado','Comercial','Sala 109',900,'São Paulo','SP','Vila Nivi'),(10,10,'10010-010','Rua do Chip de Processador','Residencial','Casa 110',1000,'São Paulo','SP','Santo Amaro'),(11,11,'11011-011','Avenida dos Transistores','Comercial','Loja 111',1100,'São Paulo','SP','Campo Belo'),(12,12,'12012-012','Rua dos Sensores','Residencial','Apto 112',1200,'São Paulo','SP','Vila Progredir'),(13,13,'13013-013','Rua do Microchip','Comercial','Sala 113',1300,'São Paulo','SP','Itaim Bibi'),(14,14,'14014-014','Avenida do Processador','Residencial','Casa 114',1400,'São Paulo','SP','Vila Nova'),(15,15,'15015-015','Rua da Eletrônica Digital','Comercial','Loja 115',1500,'São Paulo','SP','Moema'),(16,16,'16016-016','Rua da Lógica','Residencial','Apto 116',1600,'São Paulo','SP','Vila Buarque'),(17,17,'17017-017','Avenida do Display','Comercial','Sala 117',1700,'São Paulo','SP','Vila Prudente'),(18,18,'18018-018','Rua do Sistema','Residencial','Casa 118',1800,'São Paulo','SP','Pinheiros'),(19,19,'19019-019','Rua da Rede de Dados','Comercial','Loja 119',1900,'São Paulo','SP','Vila Olímpia'),(20,20,'20020-020','Avenida do Aparelho','Residencial','Apto 120',2000,'São Paulo','SP','Vila Nivi'),(21,21,'21021-021','Rua do Processador de Áudio','Comercial','Sala 121',2100,'São Paulo','SP','Liberdade'),(22,22,'22022-022','Rua do Circuito de Dados','Residencial','Casa 122',2200,'São Paulo','SP','Campo Belo'),(23,23,'23023-023','Avenida da Lógica Digital','Comercial','Loja 123',2300,'São Paulo','SP','Santo Amaro'),(24,24,'24024-024','Rua do Processador de Memória','Residencial','Apto 124',2400,'São Paulo','SP','Moema'),(25,25,'25025-025','Rua dos Chips Eletrônicos','Comercial','Sala 125',2500,'São Paulo','SP','Vila Nivi'),(26,26,'26026-026','Rua da Placa-Mãe','Residencial','Casa 126',2600,'São Paulo','SP','Vila Olímpia'),(27,27,'27027-027','Avenida do Processador de Dados','Comercial','Loja 127',2700,'São Paulo','SP','Itaim Bibi'),(28,28,'28028-028','Rua do Chip de Comunicação','Residencial','Apto 128',2800,'São Paulo','SP','Vila Nova'),(29,29,'29029-029','Rua da Rede de Conectividade','Comercial','Sala 129',2900,'São Paulo','SP','Bela Vista'),(30,30,'30030-030','Avenida dos Sensores','Residencial','Casa 130',3000,'São Paulo','SP','Jardins'),(31,31,'31031-031','Rua do Sistema Digital','Comercial','Loja 131',3100,'São Paulo','SP','Campo Belo'),(32,32,'32032-032','Rua da Rede de Processamento','Residencial','Apto 132',3200,'São Paulo','SP','Vila Progredir'),(33,33,'33033-033','Avenida da Tecnologia Avançada','Comercial','Sala 133',3300,'São Paulo','SP','Vila Buarque'),(34,34,'34034-034','Rua dos Chips de Processador','Residencial','Casa 134',3400,'São Paulo','SP','Vila Nova'),(35,35,'35035-035','Avenida do Chip de Rede','Comercial','Loja 135',3500,'São Paulo','SP','Vila Olímpia'),(36,36,'36036-036','Rua do Display de Tela','Residencial','Apto 136',3600,'São Paulo','SP','Santo Amaro'),(37,37,'37037-037','Rua do Sistema de Comunicação','Comercial','Sala 137',3700,'São Paulo','SP','Moema'),(38,38,'38038-038','Avenida do Chip Integrado','Residencial','Casa 138',3800,'São Paulo','SP','Liberdade'),(39,39,'39039-039','Rua dos Sensores de Rede','Comercial','Loja 139',3900,'São Paulo','SP','Vila Progredir'),(40,40,'40040-040','Rua da Rede de Chip','Residencial','Apto 140',4000,'São Paulo','SP','Vila Nivi'),(41,41,'41041-041','Rua dos Transistores de Comunicação','Comercial','Sala 141',4100,'São Paulo','SP','Vila Olímpia'),(42,42,'42042-042','Avenida do Processador de Rede','Residencial','Casa 142',4200,'São Paulo','SP','Bela Vista'),(43,43,'43043-043','Rua da Eletrônica Digital Avançada','Comercial','Loja 143',4300,'São Paulo','SP','Vila Progredir'),(44,44,'44044-044','Avenida do Processador de Rede de Dados','Residencial','Casa 144',4400,'São Paulo','SP','Vila Buarque'),(45,45,'45045-045','Rua da Conectividade Avançada','Comercial','Loja 145',4500,'São Paulo','SP','Itaim Bibi'),(46,46,'46046-046','Rua do Sistema Integrado','Residencial','Apto 146',4600,'São Paulo','SP','Moema'),(47,47,'47047-047','Avenida da Comunicação Avançada','Comercial','Sala 147',4700,'São Paulo','SP','Liberdade'),(48,48,'48048-048','Rua do Circuito de Processamento','Residencial','Casa 148',4800,'São Paulo','SP','Vila Nova'),(49,49,'49049-049','Rua da Rede Integrada','Comercial','Loja 149',4900,'São Paulo','SP','Vila Olímpia'),(50,50,'50050-050','Rua do Dispositivo Avançado','Residencial','Apto 150',5000,'São Paulo','SP','Vila Nivi'),(51,51,'51051-051','Avenida do Chip de Computador','Residencial','Apto 151',5100,'São Paulo','SP','Santo Amaro'),(52,52,'52052-052','Rua da Rede Eletrônica','Comercial','Loja 152',5200,'São Paulo','SP','Vila Nivi'),(53,53,'53053-053','Avenida da Placa de Vídeo','Residencial','Casa 153',5300,'São Paulo','SP','Vila Progredir'),(54,54,'54054-054','Rua do Processador de Rede','Comercial','Sala 154',5400,'São Paulo','SP','Bela Vista'),(55,55,'55055-055','Rua dos Sensores de Rede de Dados','Residencial','Apto 155',5500,'São Paulo','SP','Vila Olímpia'),(56,56,'56056-056','Avenida do Sistema de Processamento','Comercial','Loja 156',5600,'São Paulo','SP','Campo Belo'),(57,57,'57057-057','Rua do Circuito Eletrônico','Residencial','Casa 157',5700,'São Paulo','SP','Itaim Bibi'),(58,58,'58058-058','Avenida do Chip de Rede Eletrônica','Comercial','Sala 158',5800,'São Paulo','SP','Liberdade'),(59,59,'59059-059','Rua da Conectividade de Dados','Residencial','Apto 159',5900,'São Paulo','SP','Jardins'),(60,60,'60060-060','Rua do Processador de Comunicação','Comercial','Loja 160',6000,'São Paulo','SP','Vila Nova');
/*!40000 ALTER TABLE `endereco_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_pc`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_pc`
--

LOCK TABLES `for_pc` WRITE;
/*!40000 ALTER TABLE `for_pc` DISABLE KEYS */;
INSERT INTO `for_pc` VALUES (6,1),(12,1),(20,1),(27,1),(36,1),(42,1),(47,1),(58,1),(4,2),(9,2),(17,2),(24,2),(33,2),(41,2),(50,2),(57,2),(1,3),(7,3),(14,3),(22,3),(28,3),(34,3),(43,3),(49,3),(55,3),(3,4),(10,4),(16,4),(23,4),(30,4),(38,4),(45,4),(52,4),(59,4),(2,5),(11,5),(18,5),(26,5),(31,5),(37,5),(44,5),(51,5),(56,5),(5,6),(13,6),(19,6),(25,6),(32,6),(39,6),(46,6),(53,6),(8,7),(15,7),(21,7),(29,7),(35,7),(40,7),(48,7),(54,7),(60,7);
/*!40000 ALTER TABLE `for_pc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

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
  PRIMARY KEY (`id_fornecedor`),
  KEY `fk_adm_fornecedor` (`id_adm`),
  CONSTRAINT `fk_adm_fornecedor` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (1,2,'eletronicosabc@email.com','Eletrônicos ABC','12.345.678/0001-01','Placas de Circuito','2025-03-15'),(2,3,'componentesxyz@email.com','Componentes Eletrônicos','12.345.678/0001-02','Resistores e Capacitores','2025-03-16'),(3,1,'moduloseletricos@email.com','Módulos Elétricos LTDA','12.345.678/0001-03','Módulos de Potência','2025-03-17'),(4,2,'soldagemsolucoes@email.com','Soluções em Soldagem','12.345.678/0001-04','Fios de Solda','2025-03-18'),(5,4,'industriaelectronica@email.com','Indústria Eletrônica Delta','12.345.678/0001-05','Transistores e Diodos','2025-03-19'),(6,5,'fabrica.displays@email.com','Fábrica de Displays','12.345.678/0001-06','Displays LED','2025-03-20'),(7,4,'conectorescabos@email.com','Conectores e Cabos','12.345.678/0001-07','Cabos e Conectores','2025-03-21'),(8,3,'electrodesign@email.com','EletroDesign','12.345.678/0001-08','Fontes de Alimentação','2025-03-22'),(9,1,'eletronicamaster@email.com','Eletrônica Master','12.345.678/0001-09','Placas de Circuito','2025-03-23'),(10,5,'fabricacaoeletronica@email.com','Fabricação Eletrônica Pro','12.345.678/0001-10','Microchips','2025-03-24'),(11,2,'pecasreposicao@email.com','Peças de Reposição Eletrônica','12.345.678/0001-11','Resistores e Capacitores','2025-03-25'),(12,5,'caboflex@email.com','CaboFlex','12.345.678/0001-12','Cabos de Alta Tensão','2025-03-26'),(13,1,'electroparts@email.com','ElectroParts','12.345.678/0001-13','Placas de Circuito','2025-03-27'),(14,3,'bateriaslitio@email.com','Soluções em Baterias','12.345.678/0001-14','Baterias de Litio','2025-03-28'),(15,2,'industriaeletronica@email.com','Indústria de Componentes Eletrônicos','12.345.678/0001-15','Fios de Cobre','2025-03-29'),(16,5,'techsupplies@email.com','Tech Supplies','12.345.678/0001-16','Fontes de Alimentação','2025-03-30'),(17,1,'eletronicaacessivel@email.com','Eletrônica Acessível','12.345.678/0001-17','Peças de Reposição','2025-03-31'),(18,4,'techparts@email.com','TechParts','12.345.678/0001-18','Resistores e Capacitores','2025-04-01'),(19,3,'moduloseletronicos@email.com','Módulos Eletrônicos','12.345.678/0001-19','Microchips','2025-04-02'),(20,2,'eletronicapro@email.com','Eletrônica Pro','12.345.678/0001-20','Displays LCD','2025-04-03'),(21,5,'bateriasenergia@email.com','Baterias e Energia','12.345.678/0001-21','Baterias Recarrregáveis','2025-04-04'),(22,4,'fornecedoresmd@email.com','Fornecedores de SMD','12.345.678/0001-22','Componente SMD','2025-04-05'),(23,1,'componentespro@email.com','Componentes Pro','12.345.678/0001-23','Microchips','2025-04-06'),(24,2,'pecasdeeletronica@email.com','Peças de Eletrônica','12.345.678/0001-24','Placas de Circuito','2025-04-07'),(25,4,'acessorioselec@email.com','Acessórios Eletrônicos','12.345.678/0001-25','Cabos e Adaptadores','2025-04-08'),(26,3,'eletronicasuper@email.com','Eletrônica Super','12.345.678/0001-26','Placas de Circuito','2025-04-09'),(27,2,'digitaltech@email.com','Digital Tech','12.345.678/0001-27','Microchips','2025-04-10'),(28,5,'vibraeletronica@email.com','Vibra Eletrônica','12.345.678/0001-28','Fios de Solda','2025-04-11'),(29,4,'nextelectro@email.com','Next Electro','12.345.678/0001-29','Módulos de Potência','2025-04-12'),(30,1,'solidtech@email.com','Solid Tech','12.345.678/0001-30','Baterias','2025-04-13'),(31,5,'electroncomps@email.com','Electron Comps','12.345.678/0001-31','Resistores e Capacitores','2025-04-14'),(32,2,'techsolutions@email.com','Tech Solutions','12.345.678/0001-32','Fontes de Alimentação','2025-04-15'),(33,1,'electrogrid@email.com','Electro Grid','12.345.678/0001-33','Placas de Circuito','2025-04-16'),(34,4,'fusionparts@email.com','Fusion Parts','12.345.678/0001-34','Fios de Cobre','2025-04-17'),(35,3,'powertech@email.com','Power Tech','12.345.678/0001-35','Fontes de Alimentação','2025-04-18'),(36,2,'newcomponents@email.com','New Components','12.345.678/0001-36','Microchips','2025-04-19'),(37,4,'electronixparts@email.com','Electronix Parts','12.345.678/0001-37','Displays LED','2025-04-20'),(38,1,'microtechparts@email.com','Microtech Parts','12.345.678/0001-38','Placas de Circuito','2025-04-21'),(39,3,'advancedparts@email.com','Advanced Parts','12.345.678/0001-39','Resistores e Capacitores','2025-04-22'),(40,2,'nextgenparts@email.com','NextGen Parts','12.345.678/0001-40','Fios de Solda','2025-04-23'),(41,5,'elitecomponents@email.com','Elite Components','12.345.678/0001-41','Microchips','2025-04-24'),(42,1,'solidcircuit@email.com','Solid Circuit','12.345.678/0001-42','Placas de Circuito','2025-04-25'),(43,2,'circuitplus@email.com','Circuit Plus','12.345.678/0001-43','Componentes Eletrônicos','2025-04-26'),(44,5,'maxelectro@email.com','Max Electro','12.345.678/0001-44','Displays LCD','2025-04-27'),(45,1,'powercircuit@email.com','Power Circuit','12.345.678/0001-45','Fontes de Alimentação','2025-04-28'),(46,4,'eletronicsmart@email.com','Eletrônica Smart','12.345.678/0001-46','Componentes Diversos','2025-04-29'),(47,2,'supercircuito@email.com','Super Circuito','12.345.678/0001-47','Placas de Circuito','2025-04-30'),(48,3,'techwave@email.com','Tech Wave','12.345.678/0001-48','Fontes de Alimentação','2025-05-01'),(49,5,'maxpower@email.com','Max Power','12.345.678/0001-49','Baterias de Alta Capacidade','2025-05-02'),(50,2,'techvalue@email.com','Tech Value','12.345.678/0001-50','Displays LED','2025-05-03'),(51,1,'easycomponents@email.com','Easy Components','12.345.678/0001-51','Placas de Circuito','2025-05-04'),(52,4,'rapidtech@email.com','Rapid Tech','12.345.678/0001-52','Módulos de Potência','2025-05-05'),(53,2,'electronicprime@email.com','Electronic Prime','12.345.678/0001-53','Resistores e Capacitores','2025-05-06'),(54,3,'smartpower@email.com','Smart Power','12.345.678/0001-54','Fontes de Alimentação','2025-05-07'),(55,1,'superelectronica@email.com','Super Eletrônica','12.345.678/0001-55','Peças de Reposição','2025-05-08'),(56,5,'techpartspro@email.com','Tech Parts Pro','12.345.678/0001-56','Microchips','2025-05-09'),(57,3,'quantumcomponents@email.com','Quantum Components','12.345.678/0001-57','Displays LED','2025-05-10'),(58,4,'innovatelectro@email.com','Innovate Electro','12.345.678/0001-58','Módulos de Potência','2025-05-11'),(59,1,'circuitelite@email.com','Circuit Elite','12.345.678/0001-59','Resistores e Capacitores','2025-05-12'),(60,5,'batterymax@email.com','Battery Max','12.345.678/0001-60','Baterias','2025-05-13');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `juridico`
--

DROP TABLE IF EXISTS `juridico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `juridico` (
  `id_cliente` int NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `cnpj` (`cnpj`),
  CONSTRAINT `fk_cliente_juridico` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `juridico`
--

LOCK TABLES `juridico` WRITE;
/*!40000 ALTER TABLE `juridico` DISABLE KEYS */;
INSERT INTO `juridico` VALUES (41,'12.345.678/0001-01'),(52,'12.345.987/0001-12'),(44,'21.234.567/0001-04'),(51,'21.876.543/0001-11'),(49,'32.198.765/0001-09'),(59,'32.876.543/0001-19'),(53,'34.567.876/0001-13'),(43,'34.567.890/0001-03'),(50,'43.210.987/0001-10'),(45,'54.321.098/0001-05'),(60,'54.987.654/0001-20'),(48,'65.432.109/0001-08'),(56,'65.432.321/0001-16'),(47,'76.543.210/0001-07'),(55,'76.543.876/0001-15'),(58,'87.321.654/0001-18'),(54,'87.654.123/0001-14'),(46,'87.654.321/0001-06'),(42,'98.765.432/0001-02'),(57,'98.765.543/0001-17');
/*!40000 ALTER TABLE `juridico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nf`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nf`
--

LOCK TABLES `nf` WRITE;
/*!40000 ALTER TABLE `nf` DISABLE KEYS */;
INSERT INTO `nf` VALUES (1,1,1,1,150.00,150.00,'Boleto','2025-03-15','Pago','NF000001','Sem observações'),(2,2,2,2,200.00,200.00,'Cartão de Crédito','2025-03-16','Pago','NF000002','Produto com garantia estendida'),(3,3,3,3,180.00,180.00,'Dinheiro','2025-03-17','Pendente','NF000003','Instalação agendada para amanhã'),(4,4,4,1,120.00,120.00,'Boleto','2025-03-18','Pago','NF000004','Produto em estoque'),(5,5,5,2,250.00,250.00,'Transferência','2025-03-19','Pendente','NF000005','Produto em trânsito'),(6,6,6,3,220.00,220.00,'Boleto','2025-03-20','Pago','NF000006','Troca de peças realizada'),(7,7,7,2,300.00,300.00,'Cartão de Crédito','2025-03-21','Pago','NF000007','Instalação concluída'),(8,8,8,1,140.00,140.00,'Dinheiro','2025-03-22','Pendente','NF000008','Aguardando retirada do cliente'),(9,9,9,3,110.00,110.00,'Boleto','2025-03-23','Pago','NF000009','Serviço executado com sucesso'),(10,10,10,2,180.00,180.00,'Transferência','2025-03-24','Pendente','NF000010','Em processo de revisão'),(11,11,11,1,150.00,150.00,'Cartão de Crédito','2025-03-25','Pago','NF000011','Produto enviado ao cliente'),(12,12,12,3,210.00,210.00,'Boleto','2025-03-26','Pendente','NF000012','Produto aguardando autorização'),(13,13,13,2,270.00,270.00,'Dinheiro','2025-03-27','Pago','NF000013','Embalagem protegida'),(14,14,14,1,160.00,160.00,'Transferência','2025-03-28','Pago','NF000014','Agendamento realizado para serviço'),(15,15,15,3,230.00,230.00,'Cartão de Crédito','2025-03-29','Pendente','NF000015','Troca de componentes'),(16,16,16,2,200.00,200.00,'Boleto','2025-03-30','Pago','NF000016','Serviço finalizado e entregue'),(17,17,17,1,220.00,220.00,'Dinheiro','2025-03-31','Pendente','NF000017','Produto com problema identificado'),(18,18,18,3,250.00,250.00,'Transferência','2025-04-01','Pago','NF000018','Enviado com sucesso'),(19,19,19,2,140.00,140.00,'Cartão de Crédito','2025-04-02','Pendente','NF000019','Aguardando confirmação de pagamento'),(20,20,20,1,190.00,190.00,'Boleto','2025-04-03','Pago','NF000020','Produto aprovado'),(21,21,21,3,210.00,210.00,'Dinheiro','2025-04-04','Pendente','NF000021','Produto já no estoque'),(22,22,22,2,250.00,250.00,'Transferência','2025-04-05','Pago','NF000022','Pedido aguardando envio'),(23,23,23,1,270.00,270.00,'Cartão de Crédito','2025-04-06','Pendente','NF000023','Ajustes no produto realizados'),(24,24,24,3,180.00,180.00,'Boleto','2025-04-07','Pago','NF000024','Serviço revisado e finalizado'),(25,25,25,2,160.00,160.00,'Dinheiro','2025-04-08','Pendente','NF000025','Aguardando feedback do cliente'),(26,26,26,1,190.00,190.00,'Transferência','2025-04-09','Pago','NF000026','Instalação concluída com sucesso'),(27,27,27,3,240.00,240.00,'Cartão de Crédito','2025-04-10','Pendente','NF000027','Produto sendo enviado para montagem'),(28,28,28,2,210.00,210.00,'Boleto','2025-04-11','Pago','NF000028','Pagamento confirmado'),(29,29,29,1,150.00,150.00,'Dinheiro','2025-04-12','Pendente','NF000029','Embalagem intacta'),(30,30,30,3,220.00,220.00,'Transferência','2025-04-13','Pago','NF000030','Devolução processada'),(31,31,31,2,250.00,250.00,'Cartão de Crédito','2025-04-14','Pendente','NF000031','Produto aguardando pagamento'),(32,32,32,1,180.00,180.00,'Boleto','2025-04-15','Pago','NF000032','Entrega agendada'),(33,33,33,3,210.00,210.00,'Dinheiro','2025-04-16','Pendente','NF000033','Revisão solicitada'),(34,34,34,2,230.00,230.00,'Transferência','2025-04-17','Pago','NF000034','Produto instalado'),(35,35,35,1,190.00,190.00,'Cartão de Crédito','2025-04-18','Pendente','NF000035','Serviço completado'),(36,36,36,3,250.00,250.00,'Boleto','2025-04-19','Pago','NF000036','Aguardando envio'),(37,37,37,2,210.00,210.00,'Dinheiro','2025-04-20','Pendente','NF000037','Produto despachado'),(38,38,38,1,230.00,230.00,'Transferência','2025-04-21','Pago','NF000038','Produto revisado'),(39,39,39,3,180.00,180.00,'Cartão de Crédito','2025-04-22','Pendente','NF000039','Aguardando pagamento'),(40,40,40,2,160.00,160.00,'Boleto','2025-04-23','Pago','NF000040','Pagamento concluído'),(41,41,41,1,250.00,250.00,'Dinheiro','2025-04-24','Pendente','NF000041','Em processo de envio'),(42,42,42,3,230.00,230.00,'Transferência','2025-04-25','Pago','NF000042','Produto agendado'),(43,43,43,2,200.00,200.00,'Cartão de Crédito','2025-04-26','Pendente','NF000043','Aguardando confirmação'),(44,44,44,1,220.00,220.00,'Boleto','2025-04-27','Pago','NF000044','Serviço revisado'),(45,45,45,3,240.00,240.00,'Dinheiro','2025-04-28','Pendente','NF000045','Instalação programada'),(46,46,46,2,250.00,250.00,'Transferência','2025-04-29','Pago','NF000046','Instalação finalizada'),(47,47,47,1,200.00,200.00,'Cartão de Crédito','2025-04-30','Pendente','NF000047','Produto entregue'),(48,48,48,3,220.00,220.00,'Boleto','2025-05-01','Pago','NF000048','Devolução concluída'),(49,49,49,2,190.00,190.00,'Dinheiro','2025-05-02','Pendente','NF000049','Pagamento pendente'),(50,50,50,1,210.00,210.00,'Transferência','2025-05-03','Pago','NF000050','Aguardando confirmação'),(51,51,51,3,180.00,180.00,'Cartão de Crédito','2025-05-04','Pendente','NF000051','Pedido pronto para envio'),(52,52,52,2,250.00,250.00,'Boleto','2025-05-05','Pago','NF000052','Instalação concluída'),(53,53,53,1,220.00,220.00,'Dinheiro','2025-05-06','Pendente','NF000053','Revisão de peças'),(54,54,54,3,230.00,230.00,'Transferência','2025-05-07','Pago','NF000054','Produto de volta em estoque'),(55,55,55,2,210.00,210.00,'Cartão de Crédito','2025-05-08','Pendente','NF000055','Produto esperando pagamento'),(56,56,56,1,250.00,250.00,'Boleto','2025-05-09','Pago','NF000056','Devolução processada'),(57,57,57,3,200.00,200.00,'Dinheiro','2025-05-10','Pendente','NF000057','Embalagem danificada'),(58,58,58,2,220.00,220.00,'Transferência','2025-05-11','Pago','NF000058','Produto aprovado para envio'),(59,59,59,1,180.00,180.00,'Cartão de Crédito','2025-05-12','Pendente','NF000059','Instalação agendada'),(60,60,60,3,240.00,240.00,'Boleto','2025-05-13','Pago','NF000060','Pedido aguardando envio');
/*!40000 ALTER TABLE `nf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `os`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `os`
--

LOCK TABLES `os` WRITE;
/*!40000 ALTER TABLE `os` DISABLE KEYS */;
INSERT INTO `os` VALUES (1,1,4,100001,'2025-01-09','2025-01-18','Razr 5G',2001,'capinha protetora','Wi-Fi não conecta','Alguns riscos na carcaça','Será verificada a placa de rede sem fio e reinstalado o driver.','Motorola'),(2,2,3,100002,'2025-03-27','2025-04-04','Nokia 5.3',2002,'carregador original, capinha protetora','não liga','Corpo com sinais de queda','Será reinstalado o sistema operacional e testada a rede.','Nokia'),(3,3,3,100003,'2025-01-07','2025-01-16','Moto G Power',2003,'carregador generico, cabo USB-C','microfone sem funcionar','Tela com fissuras','Será feita limpeza interna e reinstalação do sistema operacional.','Motorola'),(4,4,3,100004,'2025-02-10','2025-02-17','Nokia 3310',2004,'carregador original, capa protetora','câmera traseira quebrada','Corpo com sinais de queda','Será substituída a câmera danificada por peça nova.','Nokia'),(5,5,2,100005,'2025-01-11','2025-01-17','Xperia 5',2005,'fones de ouvido, cabo USB-C','alto-falante sem som','Carcaça levemente amassada','Será verificado o componente e testado o funcionamento.','Sony'),(6,6,5,100006,'2025-03-02','2025-03-05','Galaxy S21',2006,'carregador original, capinha protetora','display quebrado','Pequenos arranhões na tela','Será substituído o display danificado por peça original.','Samsung'),(7,7,4,100007,'2025-03-23','2025-03-26','Galaxy Note 20',2007,'carregador sem fio, case protetor','não carrega a bateria','Desgaste nas dobradiças','Será substituída a bateria por nova de mesma especificação.','Samsung'),(8,8,5,100008,'2025-04-12','2025-04-18','Galaxy S23',2008,'carregador original, capinha protetora','touchscreen falhando','Leve oxidação nas bordas','Será substituído o display completo (touchscreen) por nova peça.','Samsung'),(9,9,2,100009,'2025-02-05','2025-02-09','OnePlus 11',2009,'carregador original, capinha protetora','não liga','Bateria com desgaste acentuado','Será feito diagnóstico completo e, se necessário, substituição de peças.','OnePlus'),(10,10,3,100010,'2025-05-14','2025-05-18','Pixel 6',2010,'carregador original, capa protetora','Wi-Fi não conecta','Alguns riscos na carcaça','Será verificada a placa de rede sem fio e reinstalado o driver.','Google'),(11,11,5,100011,'2025-01-22','2025-01-28','iPhone 13',2011,'carregador original, capinha em couro','aparelho molhado','Com sujeira acumulada','Será realizada a limpeza interna e reinstalação do sistema operacional.','Apple'),(12,12,1,100012,'2025-06-01','2025-06-03','iPhone 14',2012,'carregador original, capinha protetora','não carrega a bateria','Leve desgaste de bateria','Será substituída a bateria por nova de mesma especificação.','Apple'),(13,13,2,100013,'2025-02-18','2025-02-19','iPhone 15 Pro',2013,'carregador original, capinha protetora','alto-falante sem som','Pequenos arranhões na tela','Será substituído o alto-falante com defeito por um novo original.','Apple'),(14,14,4,100014,'2025-02-25','2025-03-04','OnePlus 9',2014,'carregador sem fio, capinha protetora','câmera frontal com defeito','Tampa traseira arranhada','Será substituída a câmera danificada por peça nova.','OnePlus'),(15,15,5,100015,'2025-03-15','2025-03-17','Google Pixel 7',2015,'carregador original, case protetor','sensor de proximidade não funciona','Carcaça levemente amassada','Será verificado o componente e testado o funcionamento.','Google'),(16,16,1,100016,'2025-04-02','2025-04-10','iPhone SE',2016,'carregador original, capinha','não liga','Sem danos aparentes','Será feita a limpeza interna e reinstalação do sistema operacional.','Apple'),(17,17,4,100017,'2025-04-15','2025-04-20','Moto G9',2017,'carregador generico, capinha protetora','alto-falante sem som','Leve oxidação nas bordas','Será substituído o alto-falante com defeito por um novo original.','Motorola'),(18,18,3,100018,'2025-05-03','2025-05-06','Galaxy Note 20',2018,'carregador sem fio, fones bluetooth','não carrega a bateria','Bateria com desgaste acentuado','Será substituída a bateria por nova de mesma especificação.','Samsung'),(19,19,2,100019,'2025-03-27','2025-04-01','Dell XPS 13',2019,'fonte de alimentação, bolsa para transporte','não inicia o sistema operacional','Teclado com algumas teclas soltas','Será reinstalado o sistema operacional do zero.','Dell'),(20,20,5,100020,'2025-02-10','2025-02-12','HP Pavilion 15',2020,'fonte de alimentação, bolsa para transporte','tela trincada','Tela com fissuras','Será substituída a tela trincada por nova de mesma especificação.','HP'),(21,21,1,100021,'2025-03-05','2025-03-06','HP EliteBook 840',2021,'fonte de alimentação, bolsa para transporte','superaquecimento','Leve sujidade nos ventiladores','Será feita limpeza interna e reinstalação do sistema operacional.','HP'),(22,22,1,100022,'2025-05-07','2025-05-10','Dell Latitude 7420',2022,'fonte de alimentação, bolsa para transporte','não liga','Carcaça levemente amassada','Será reinstalado o sistema operacional do zero.','Dell'),(23,23,4,100023,'2025-04-20','2025-04-23','Lenovo ThinkPad X1 Carbon',2023,'fonte de alimentação, bolsa para transporte','teclado não funciona','Teclado com algumas teclas soltas','Será substituído o teclado defeituoso.','Lenovo'),(24,24,3,100024,'2025-03-11','2025-03-15','MacBook Air M2',2024,'fonte de alimentação, bolsa para transporte','não inicia o sistema operacional','Sem danos aparentes','Será reinstalado o sistema operacional do zero.','Apple'),(25,25,5,100025,'2025-06-10','2025-06-13','Asus ROG Flow Z13',2025,'fonte de alimentação, bolsa para transporte','tela não acende','Tela com fissuras','Será substituída a tela danificada por peça nova.','Asus'),(26,26,4,100026,'2025-01-15','2025-01-18','Xiaomi Mi 11',2026,'carregador original, capinha protetora','não liga','Pequenos arranhões na tela','Será feito diagnóstico completo e, se necessário, substituição de peças.','Xiaomi'),(27,27,5,100027,'2025-04-25','2025-04-29','Xiaomi Mi 10',2027,'carregador original, fones de ouvido','não carrega','Bateria com desgaste acentuado','Será substituída a bateria por nova de mesma especificação.','Xiaomi'),(28,28,1,100028,'2025-01-03','2025-01-07','Motorola Edge+',2028,'carregador original, capa protetora','Wi-Fi não conecta','Sem danos visíveis','Será verificada a placa de rede sem fio e reinstalado o driver.','Motorola'),(29,29,2,100029,'2025-05-08','2025-05-10','iPhone 12',2029,'carregador original, capinha','alto-falante sem som','Tela com fissuras','Será substituído o alto-falante danificado.','Apple'),(30,30,3,100030,'2025-02-22','2025-02-28','Pixel 5',2030,'carregador original, capinha protetora','não liga','Alguns riscos na carcaça','Será feita a limpeza interna e reinstalação do sistema operacional.','Google'),(31,31,4,100031,'2025-01-30','2025-02-04','Samsung A52',2031,'carregador original, fones de ouvido','câmera traseira com defeito','Desgaste nas bordas','Será substituída a câmera traseira por nova.','Samsung'),(32,32,5,100032,'2025-04-17','2025-04-19','Samsung Galaxy S20 FE',2032,'carregador original, case protetor','não carrega','Sem danos visíveis','Será feito diagnóstico e, se necessário, substituição de peças.','Samsung'),(33,33,1,100033,'2025-03-12','2025-03-14','Nokia 8.3',2033,'carregador original, capinha','não liga','Tela com fissuras','Será substituído o display danificado por peça nova.','Nokia'),(34,34,2,100034,'2025-05-20','2025-05-22','iPhone 13 Pro',2034,'carregador original, capinha','não carrega','Bateria com desgaste acentuado','Será substituída a bateria por nova de mesma especificação.','Apple'),(35,35,3,100035,'2025-02-02','2025-02-06','Samsung Galaxy A71',2035,'carregador original, fones de ouvido','alto-falante sem som','Tela com fissuras','Será substituído o alto-falante danificado.','Samsung'),(36,36,4,100036,'2025-01-23','2025-01-25','iPhone XS',2036,'carregador original, capinha protetora','não liga','Alguns riscos na carcaça','Será feita a limpeza interna e reinstalação do sistema operacional.','Apple'),(37,37,5,100037,'2025-02-12','2025-02-15','LG G8',2037,'carregador original, capinha','não conecta à rede Wi-Fi','Desgaste nas bordas','Será verificada a placa de rede sem fio.','LG'),(38,38,1,100038,'2025-03-08','2025-03-13','Vivo V17',2038,'carregador original, capa protetora','não liga','Corpo com sinais de queda','Será feita a limpeza interna e substituição da bateria.','Vivo'),(39,39,2,100039,'2025-05-01','2025-05-04','Redmi Note 10',2039,'carregador original, fones de ouvido','não carrega','Alguns riscos na carcaça','Será substituída a bateria por nova.','Xiaomi'),(40,40,3,100040,'2025-03-10','2025-03-12','Sony Xperia XZ3',2040,'carregador original, capinha','alto-falante sem som','Tela com fissuras','Será substituído o alto-falante danificado.','Sony'),(41,41,4,100041,'2025-04-18','2025-04-21','Pixel 3A',2041,'carregador original, capinha','não conecta ao Wi-Fi','Sem danos visíveis','Será verificado o módulo de Wi-Fi e substituído se necessário.','Google'),(42,42,5,100042,'2025-05-13','2025-05-15','Nokia 5.4',2042,'carregador original, fones de ouvido','não liga','Desgaste nas bordas','Será realizada a limpeza interna e reinstalação do sistema operacional.','Nokia'),(43,43,1,100043,'2025-02-28','2025-03-02','Galaxy A31',2043,'carregador original, capinha protetora','microfone sem funcionar','Leve oxidação nas bordas','Será substituído o microfone danificado.','Samsung'),(44,44,2,100044,'2025-01-30','2025-02-01','iPhone 6S',2044,'carregador original, capinha protetora','não carrega','Tela com fissuras','Será substituída a tela trincada por nova.','Apple'),(45,45,3,100045,'2025-04-22','2025-04-24','Motorola Moto E',2045,'carregador original, capinha','não liga','Carcaça levemente amassada','Será feito diagnóstico e, se necessário, substituição de peças.','Motorola'),(46,46,4,100046,'2025-03-05','2025-03-08','LG Velvet',2046,'carregador original, capinha','Wi-Fi não conecta','Sem danos visíveis','Será verificada a placa de rede sem fio e reinstalado o driver.','LG'),(47,47,5,100047,'2025-02-08','2025-02-12','Redmi Note 9',2047,'carregador original, capinha','não liga','Alguns riscos na carcaça','Será feita a limpeza interna e substituição da bateria.','Xiaomi'),(48,48,1,100048,'2025-04-10','2025-04-13','Samsung A71',2048,'carregador original, fones de ouvido','não liga','Tela com fissuras','Será substituído o display danificado por peça nova.','Samsung'),(49,49,2,100049,'2025-05-11','2025-05-13','Nokia 5.4',2049,'carregador original, fones de ouvido','alto-falante sem som','Leve oxidação nas bordas','Será substituído o alto-falante danificado por um novo original.','Nokia'),(50,50,3,100050,'2025-03-22','2025-03-25','iPhone XR',2050,'carregador original, capinha protetora','não carrega','Sem danos visíveis','Será substituída a bateria por nova de mesma especificação.','Apple'),(51,51,4,100051,'2025-01-19','2025-01-21','Galaxy M31',2051,'carregador original, fones de ouvido','não conecta ao Wi-Fi','Tela com fissuras','Será verificado o módulo de Wi-Fi e substituído se necessário.','Samsung'),(52,52,5,100052,'2025-05-17','2025-05-20','Huawei P40',2052,'carregador original, capa protetora','alto-falante não funciona','Desgaste nas bordas','Será substituído o alto-falante danificado por peça original.','Huawei'),(53,53,1,100053,'2025-04-30','2025-05-02','Vivo V19',2053,'carregador original, fones de ouvido','microfone não funciona','Sem danos visíveis','Será substituído o microfone defeituoso por peça nova.','Vivo'),(54,54,2,100054,'2025-05-15','2025-05-17','Galaxy A12',2054,'carregador original, fones de ouvido','não liga','Tela com fissuras','Será feito diagnóstico e substituição de peças necessárias.','Samsung'),(55,55,3,100055,'2025-04-08','2025-04-10','Xiaomi Redmi 9',2055,'carregador original, capinha protetora','não carrega','Pequenos arranhões na tela','Será substituída a bateria por nova de mesma especificação.','Xiaomi'),(56,56,4,100056,'2025-01-27','2025-01-30','LG G7',2056,'carregador original, fones de ouvido','não carrega','Carcaça levemente amassada','Será substituída a bateria por nova.','LG'),(57,57,5,100057,'2025-02-14','2025-02-18','iPhone XS Max',2057,'carregador original, capinha','não liga','Tela com fissuras','Será substituído o display danificado por peça nova.','Apple'),(58,58,1,100058,'2025-05-23','2025-05-25','Xperia Z5',2058,'carregador original, capinha','Wi-Fi não conecta','Desgaste nas bordas','Será verificada a placa de rede sem fio.','Sony'),(59,59,2,100059,'2025-02-07','2025-02-09','Galaxy A30',2059,'carregador original, capinha','não liga','Carcaça levemente amassada','Será substituída a bateria por nova de mesma especificação.','Samsung'),(60,60,3,100060,'2025-04-27','2025-04-30','iPhone 8',2060,'carregador original, capinha','não carrega','Tela com fissuras','Será feita a limpeza interna e substituição da bateria.','Apple');
/*!40000 ALTER TABLE `os` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pecas`
--

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
  `numero_serie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pecas`),
  KEY `fk_fornecedor_peca` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor_peca` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pecas`
--

LOCK TABLES `pecas` WRITE;
/*!40000 ALTER TABLE `pecas` DISABLE KEYS */;
INSERT INTO `pecas` VALUES (1,'Tela','Tela LCD','Smartphone',100,150,'2025-05-09','Tela LCD para smartphones de 5.5\"','em estoque',1,'A123456789'),(2,'Bateria','Bateria Li-ion','Smartphone',200,50,'2025-05-09','Bateria de íon de lítio para celular','em estoque',2,'B987654321'),(3,'Placa','Placa Mãe','Notebook',50,450,'2025-05-09','Placa mãe para notebooks de 15\"','em estoque',3,'C112233445'),(4,'Teclado','Teclado mecânico','Desktop',30,200,'2025-05-09','Teclado mecânico para desktop','em estoque',4,'D556677889'),(5,'Mouse','Mouse Óptico','Desktop',120,30,'2025-05-09','Mouse óptico USB para desktop','em estoque',5,'E998877665'),(6,'Fonte','Fonte ATX','Desktop',80,100,'2025-05-09','Fonte ATX para desktop','em estoque',1,'F667788990'),(7,'Processador','Intel Core i7','Desktop',40,800,'2025-05-09','Processador Intel Core i7 de 8ª geração','em estoque',3,'G223344556'),(8,'Placa de Vídeo','GTX 1660','Desktop',25,1200,'2025-05-09','Placa de vídeo Nvidia GTX 1660','em estoque',2,'H889977665'),(9,'Memória RAM','8GB DDR4','Desktop',70,100,'2025-05-09','Memória RAM DDR4 8GB','em estoque',4,'I556677443'),(10,'HD','HD 1TB','Desktop',100,150,'2025-05-09','HD de 1TB','em estoque',5,'J223344998'),(11,'Tela','Tela OLED','Smartphone',60,250,'2025-05-09','Tela OLED para smartphones','em manutenção',1,'K998877221'),(12,'Bateria','Bateria Li-polymer','Smartphone',150,60,'2025-05-09','Bateria de polímero de lítio para celular','em estoque',2,'L445566778'),(13,'Placa','Placa Mãe','Desktop',40,350,'2025-05-09','Placa mãe para desktop de alta performance','reservada',3,'M112233445'),(14,'Teclado','Teclado sem fio','Desktop',80,150,'2025-05-09','Teclado sem fio para desktop','fora de estoque',4,'N556677889'),(15,'Mouse','Mouse Gamer','Desktop',100,90,'2025-05-09','Mouse gamer para desktop','em estoque',5,'O998877665'),(16,'Fonte','Fonte 750W','Desktop',50,300,'2025-05-09','Fonte 750W para computadores de alto desempenho','em estoque',1,'P667788990'),(17,'Processador','AMD Ryzen 5','Desktop',60,400,'2025-05-09','Processador AMD Ryzen 5','em manutenção',3,'Q223344556'),(18,'Placa de Vídeo','RTX 3080','Desktop',15,2500,'2025-05-09','Placa de vídeo Nvidia RTX 3080','em estoque',2,'R889977665'),(19,'Memória RAM','16GB DDR4','Desktop',100,180,'2025-05-09','Memória RAM DDR4 16GB','reservada',4,'S556677443'),(20,'HD','HD 2TB','Desktop',80,250,'2025-05-09','HD de 2TB','em estoque',5,'T223344998'),(21,'Tela','Tela LED','Smartphone',90,100,'2025-05-09','Tela LED para celulares','fora de estoque',1,'U998877221'),(22,'Bateria','Bateria Li-ion','Smartphone',120,70,'2025-05-09','Bateria Li-ion para celular','em estoque',2,'V445566778'),(23,'Placa','Placa Mãe','Desktop',30,400,'2025-05-09','Placa mãe para desktop','em manutenção',3,'W112233445'),(24,'Teclado','Teclado mecânico','Desktop',60,120,'2025-05-09','Teclado mecânico para desktop','em estoque',4,'X556677889'),(25,'Mouse','Mouse Óptico','Desktop',130,40,'2025-05-09','Mouse óptico USB','em estoque',5,'Y998877665'),(26,'Fonte','Fonte 600W','Desktop',45,180,'2025-05-09','Fonte 600W para computadores de médio porte','em estoque',1,'Z667788990'),(27,'Processador','Intel Core i5','Desktop',70,300,'2025-05-09','Processador Intel Core i5','em estoque',3,'A223344556'),(28,'Placa de Vídeo','RTX 3070','Desktop',20,2000,'2025-05-09','Placa de vídeo Nvidia RTX 3070','fora de estoque',2,'B889977665'),(29,'Memória RAM','4GB DDR3','Desktop',150,40,'2025-05-09','Memória RAM DDR3 4GB','em estoque',4,'C556677443'),(30,'HD','HD 500GB','Desktop',110,80,'2025-05-09','HD de 500GB','em estoque',5,'D223344998'),(31,'Tela','Tela LED','Smartphone',70,130,'2025-05-09','Tela LED para smartphone','em estoque',1,'E998877221'),(32,'Bateria','Bateria de backup','Smartphone',60,120,'2025-05-09','Bateria de backup','reservada',2,'F445566778'),(33,'Placa','Placa de vídeo','Desktop',20,800,'2025-05-09','Placa de vídeo para desktop','em estoque',3,'G112233445'),(34,'Teclado','Teclado mecânico','Desktop',75,160,'2025-05-09','Teclado mecânico para PC','em manutenção',4,'H556677889'),(35,'Mouse','Mouse Óptico','Desktop',140,60,'2025-05-09','Mouse USB para desktop','em estoque',5,'I998877665'),(36,'Fonte','Fonte 500W','Desktop',60,130,'2025-05-09','Fonte 500W para desktop','fora de estoque',1,'J667788990'),(37,'Processador','Intel i3','Desktop',50,150,'2025-05-09','Processador Intel i3','em estoque',3,'K223344556'),(38,'Placa de Vídeo','GTX 1050','Desktop',40,700,'2025-05-09','Placa de vídeo Nvidia GTX 1050','em estoque',2,'L889977665'),(39,'Memória RAM','8GB DDR3','Desktop',120,90,'2025-05-09','Memória RAM DDR3 8GB','em estoque',4,'M556677443'),(40,'HD','HD 2TB','Desktop',75,230,'2025-05-09','HD de 2TB','em estoque',5,'N223344998'),(41,'Tela','Tela Full HD','Smartphone',100,200,'2025-05-09','Tela Full HD para smartphones','em manutenção',1,'O998877221'),(42,'Bateria','Bateria Li-ion','Smartphone',130,75,'2025-05-09','Bateria Li-ion','em estoque',2,'P445566778'),(43,'Placa','Placa Mãe','Desktop',25,500,'2025-05-09','Placa mãe para desktop','reservada',3,'Q112233445'),(44,'Teclado','Teclado Gamer','Desktop',50,120,'2025-05-09','Teclado Gamer','em estoque',4,'R556677889'),(45,'Mouse','Mouse sem fio','Desktop',110,50,'2025-05-09','Mouse sem fio','em estoque',5,'S998877665'),(46,'Fonte','Fonte 750W','Desktop',35,350,'2025-05-09','Fonte 750W','em estoque',1,'T667788990'),(47,'Processador','Intel Core i9','Desktop',20,1200,'2025-05-09','Processador Intel Core i9','em manutenção',3,'U223344556'),(48,'Placa de Vídeo','RTX 3060','Desktop',30,1800,'2025-05-09','Placa de vídeo Nvidia RTX 3060','em estoque',2,'V889977665'),(49,'Memória RAM','32GB DDR4','Desktop',50,300,'2025-05-09','Memória RAM DDR4 32GB','em estoque',4,'W556677443'),(50,'HD','HD 1TB','Desktop',90,120,'2025-05-09','HD de 1TB','em estoque',5,'X223344998'),(51,'Tela','Tela HD','Smartphone',60,110,'2025-05-09','Tela HD','em estoque',1,'Y998877221'),(52,'Bateria','Bateria Li-ion','Smartphone',90,60,'2025-05-09','Bateria Li-ion','em estoque',2,'Z445566778'),(53,'Placa','Placa de Vídeo','Desktop',10,1000,'2025-05-09','Placa de vídeo para desktop','em estoque',3,'A112233445'),(54,'Teclado','Teclado sem fio','Desktop',45,150,'2025-05-09','Teclado sem fio','em manutenção',4,'B556677889'),(55,'Mouse','Mouse Gamer','Desktop',70,100,'2025-05-09','Mouse Gamer','em estoque',5,'C998877665'),(56,'Fonte','Fonte 550W','Desktop',80,170,'2025-05-09','Fonte 550W','em estoque',1,'D667788990'),(57,'Processador','AMD Ryzen 7','Desktop',40,650,'2025-05-09','Processador AMD Ryzen 7','em estoque',3,'E223344556'),(58,'Placa de Vídeo','GTX 1080','Desktop',30,1800,'2025-05-09','Placa de vídeo Nvidia GTX 1080','em estoque',2,'F889977665'),(59,'Memória RAM','8GB DDR4','Desktop',90,80,'2025-05-09','Memória RAM DDR4 8GB','em estoque',4,'G556677443'),(60,'HD','HD 500GB','Desktop',110,75,'2025-05-09','HD de 500GB','em estoque',5,'H223344998');
/*!40000 ALTER TABLE `pecas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone_adm`
--

DROP TABLE IF EXISTS `telefone_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_adm` (
  `id_telefone` int NOT NULL,
  `id_adm` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_adm_telefone` (`id_adm`),
  CONSTRAINT `fk_adm_telefone` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone_adm`
--

LOCK TABLES `telefone_adm` WRITE;
/*!40000 ALTER TABLE `telefone_adm` DISABLE KEYS */;
INSERT INTO `telefone_adm` VALUES (1,1,'(11) 91234-5678'),(2,2,'(21) 92345-6789'),(3,3,'(31) 93456-7890'),(4,4,'(41) 94567-8901'),(5,5,'(51) 95678-9012'),(6,6,'(61) 96789-0123'),(7,7,'(71) 97890-1234'),(8,8,'(81) 98901-2345'),(9,9,'(91) 99012-3456'),(10,10,'(11) 90123-4567'),(11,11,'(21) 91234-5670'),(12,12,'(31) 92345-6781'),(13,13,'(41) 93456-7892'),(14,14,'(51) 94567-8903'),(15,15,'(61) 95678-9014'),(16,16,'(71) 96789-0125'),(17,17,'(81) 97890-1236'),(18,18,'(91) 98901-2347'),(19,19,'(11) 99012-3458'),(20,20,'(21) 90123-4569'),(21,21,'(31) 91234-5671'),(22,22,'(41) 92345-6782'),(23,23,'(51) 93456-7893'),(24,24,'(61) 94567-8904'),(25,25,'(71) 95678-9015'),(26,26,'(81) 96789-0126'),(27,27,'(91) 97890-1237'),(28,28,'(11) 98901-2348'),(29,29,'(21) 99012-3459'),(30,30,'(31) 90123-4560'),(31,31,'(41) 91234-5672'),(32,32,'(51) 92345-6783'),(33,33,'(61) 93456-7894'),(34,34,'(71) 94567-8905'),(35,35,'(81) 95678-9016'),(36,36,'(91) 96789-0127'),(37,37,'(11) 97890-1238'),(38,38,'(21) 98901-2349'),(39,39,'(31) 99012-3460'),(40,40,'(41) 90123-4571'),(41,41,'(51) 91234-5673'),(42,42,'(61) 92345-6784'),(43,43,'(71) 93456-7895'),(44,44,'(81) 94567-8906'),(45,45,'(91) 95678-9017'),(46,46,'(11) 96789-0128'),(47,47,'(21) 97890-1239'),(48,48,'(31) 98901-2350'),(49,49,'(41) 99012-3461'),(50,50,'(51) 90123-4572'),(51,51,'(61) 91234-5674'),(52,52,'(71) 92345-6785'),(53,53,'(81) 93456-7896'),(54,54,'(91) 94567-8907'),(55,55,'(11) 95678-9018'),(56,56,'(21) 96789-0129'),(57,57,'(31) 97890-1240'),(58,58,'(41) 98901-2351'),(59,59,'(51) 99012-3462'),(60,60,'(61) 90123-4573');
/*!40000 ALTER TABLE `telefone_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone_cliente`
--

DROP TABLE IF EXISTS `telefone_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_cliente` (
  `id_telefone` int NOT NULL,
  `id_cliente` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_cliente_telefone` (`id_cliente`),
  CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone_cliente`
--

LOCK TABLES `telefone_cliente` WRITE;
/*!40000 ALTER TABLE `telefone_cliente` DISABLE KEYS */;
INSERT INTO `telefone_cliente` VALUES (1,1,'(11) 90011-1111'),(2,2,'(21) 90022-2222'),(3,3,'(31) 90033-3333'),(4,4,'(41) 90044-4444'),(5,5,'(51) 90055-5555'),(6,6,'(61) 90066-6666'),(7,7,'(71) 90077-7777'),(8,8,'(81) 90088-8888'),(9,9,'(91) 90099-9999'),(10,10,'(11) 90101-0101'),(11,11,'(21) 90202-0202'),(12,12,'(31) 90303-0303'),(13,13,'(41) 90404-0404'),(14,14,'(51) 90505-0505'),(15,15,'(61) 90606-0606'),(16,16,'(71) 90707-0707'),(17,17,'(81) 90808-0808'),(18,18,'(91) 90909-0909'),(19,19,'(11) 91010-1010'),(20,20,'(21) 91111-1112'),(21,21,'(31) 91212-1212'),(22,22,'(41) 91313-1313'),(23,23,'(51) 91414-1414'),(24,24,'(61) 91515-1515'),(25,25,'(71) 91616-1616'),(26,26,'(81) 91717-1717'),(27,27,'(91) 91818-1818'),(28,28,'(11) 91919-1919'),(29,29,'(21) 92020-2020'),(30,30,'(31) 92121-2121'),(31,31,'(41) 92222-2223'),(32,32,'(51) 92323-2323'),(33,33,'(61) 92424-2424'),(34,34,'(71) 92525-2525'),(35,35,'(81) 92626-2626'),(36,36,'(91) 92727-2727'),(37,37,'(11) 92828-2828'),(38,38,'(21) 92929-2929'),(39,39,'(31) 93030-3030'),(40,40,'(41) 93131-3131'),(41,41,'(51) 93232-3232'),(42,42,'(61) 93333-3334'),(43,43,'(71) 93434-3434'),(44,44,'(81) 93535-3535'),(45,45,'(91) 93636-3636'),(46,46,'(11) 93737-3737'),(47,47,'(21) 93838-3838'),(48,48,'(31) 93939-3939'),(49,49,'(41) 94040-4040'),(50,50,'(51) 94141-4141'),(51,51,'(61) 94242-4242'),(52,52,'(71) 94343-4343'),(53,53,'(81) 94444-4444'),(54,54,'(91) 94545-4545'),(55,55,'(11) 94646-4646'),(56,56,'(21) 94747-4747'),(57,57,'(31) 94848-4848'),(58,58,'(41) 94949-4949'),(59,59,'(51) 95050-5050'),(60,60,'(61) 95151-5151');
/*!40000 ALTER TABLE `telefone_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone_fornecedor`
--

DROP TABLE IF EXISTS `telefone_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_fornecedor` (
  `id_telefone` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_fornecedor_telefone` (`id_fornecedor`),
  CONSTRAINT `fk_fornecedor_telefone` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone_fornecedor`
--

LOCK TABLES `telefone_fornecedor` WRITE;
/*!40000 ALTER TABLE `telefone_fornecedor` DISABLE KEYS */;
INSERT INTO `telefone_fornecedor` VALUES (1,1,'(11) 98765-4321'),(2,2,'(21) 98123-4567'),(3,3,'(31) 98456-7890'),(4,4,'(41) 98876-5432'),(5,5,'(51) 98234-5678'),(6,6,'(61) 98678-1234'),(7,7,'(71) 98111-2233'),(8,8,'(81) 98777-4455'),(9,9,'(91) 98989-6677'),(10,10,'(47) 97777-8888'),(11,11,'(27) 97654-3210'),(12,12,'(67) 97865-4321'),(13,13,'(77) 96543-2109'),(14,14,'(88) 94321-0987'),(15,15,'(99) 93210-9876'),(16,16,'(34) 92109-8765'),(17,17,'(45) 91098-7654'),(18,18,'(54) 90987-6543'),(19,19,'(64) 89876-5432'),(20,20,'(74) 88765-4321'),(21,21,'(84) 87654-3210'),(22,22,'(94) 86543-2109'),(23,23,'(35) 85432-1098'),(24,24,'(55) 84321-0987'),(25,25,'(65) 83210-9876'),(26,26,'(75) 82109-8765'),(27,27,'(85) 81098-7654'),(28,28,'(95) 80987-6543'),(29,29,'(11) 79876-5432'),(30,30,'(21) 78765-4321'),(31,31,'(31) 77654-3210'),(32,32,'(41) 76543-2109'),(33,33,'(51) 75432-1098'),(34,34,'(61) 74321-0987'),(35,35,'(71) 73210-9876'),(36,36,'(81) 72109-8765'),(37,37,'(91) 71098-7654'),(38,38,'(47) 70987-6543'),(39,39,'(27) 69876-5432'),(40,40,'(67) 68765-4321'),(41,41,'(77) 67654-3210'),(42,42,'(88) 66543-2109'),(43,43,'(99) 65432-1098'),(44,44,'(34) 64321-0987'),(45,45,'(45) 63210-9876'),(46,46,'(54) 62109-8765'),(47,47,'(64) 61098-7654'),(48,48,'(74) 60987-6543'),(49,49,'(84) 59876-5432'),(50,50,'(94) 58765-4321'),(51,51,'(35) 57654-3210'),(52,52,'(55) 56543-2109'),(53,53,'(65) 55432-1098'),(54,54,'(75) 54321-0987'),(55,55,'(85) 53210-9876'),(56,56,'(95) 52109-8765'),(57,57,'(11) 51098-7654'),(58,58,'(21) 50987-6543'),(59,59,'(31) 49876-5432'),(60,60,'(41) 48765-4321');
/*!40000 ALTER TABLE `telefone_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone_usuario`
--

DROP TABLE IF EXISTS `telefone_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_usuario` (
  `id_telefone` int NOT NULL,
  `id_usuario` int NOT NULL,
  `telefone` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_usuario_telefone` (`id_usuario`),
  CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone_usuario`
--

LOCK TABLES `telefone_usuario` WRITE;
/*!40000 ALTER TABLE `telefone_usuario` DISABLE KEYS */;
INSERT INTO `telefone_usuario` VALUES (1,1,'(11) 96001-0001'),(2,2,'(21) 96002-0002'),(3,3,'(31) 96003-0003'),(4,4,'(41) 96004-0004'),(5,5,'(51) 96005-0005'),(6,6,'(61) 96006-0006'),(7,7,'(71) 96007-0007'),(8,8,'(81) 96008-0008'),(9,9,'(91) 96009-0009'),(10,10,'(11) 96010-0010'),(11,11,'(21) 96011-0011'),(12,12,'(31) 96012-0012'),(13,13,'(41) 96013-0013'),(14,14,'(51) 96014-0014'),(15,15,'(61) 96015-0015'),(16,16,'(71) 96016-0016'),(17,17,'(81) 96017-0017'),(18,18,'(91) 96018-0018'),(19,19,'(11) 96019-0019'),(20,20,'(21) 96020-0020'),(21,21,'(31) 96021-0021'),(22,22,'(41) 96022-0022'),(23,23,'(51) 96023-0023'),(24,24,'(61) 96024-0024'),(25,25,'(71) 96025-0025'),(26,26,'(81) 96026-0026'),(27,27,'(91) 96027-0027'),(28,28,'(11) 96028-0028'),(29,29,'(21) 96029-0029'),(30,30,'(31) 96030-0030'),(31,31,'(41) 96031-0031'),(32,32,'(51) 96032-0032'),(33,33,'(61) 96033-0033'),(34,34,'(71) 96034-0034'),(35,35,'(81) 96035-0035'),(36,36,'(91) 96036-0036'),(37,37,'(11) 96037-0037'),(38,38,'(21) 96038-0038'),(39,39,'(31) 96039-0039'),(40,40,'(41) 96040-0040'),(41,41,'(51) 96041-0041'),(42,42,'(61) 96042-0042'),(43,43,'(71) 96043-0043'),(44,44,'(81) 96044-0044'),(45,45,'(91) 96045-0045'),(46,46,'(11) 96046-0046'),(47,47,'(21) 96047-0047'),(48,48,'(31) 96048-0048'),(49,49,'(41) 96049-0049'),(50,50,'(51) 96050-0050'),(51,51,'(61) 96051-0051'),(52,52,'(71) 96052-0052'),(53,53,'(81) 96053-0053'),(54,54,'(91) 96054-0054'),(55,55,'(11) 96055-0055'),(56,56,'(21) 96056-0056'),(57,57,'(31) 96057-0057'),(58,58,'(41) 96058-0058'),(59,59,'(51) 96059-0059'),(60,60,'(61) 96060-0060');
/*!40000 ALTER TABLE `telefone_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `us_os`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `us_os`
--

LOCK TABLES `us_os` WRITE;
/*!40000 ALTER TABLE `us_os` DISABLE KEYS */;
INSERT INTO `us_os` VALUES (1,1),(2,2),(1,3),(3,4),(4,5),(5,6),(6,7),(2,8),(7,9),(8,10),(9,11),(10,12),(3,13),(11,14),(12,15),(13,16),(4,17),(14,18),(5,19),(6,20),(15,21),(16,22),(17,23),(7,24),(18,25),(19,26),(8,27),(20,28),(21,29),(22,30),(10,31),(23,32),(24,33),(25,34),(26,35),(27,36),(28,37),(29,38),(30,39),(31,40),(32,41),(33,42),(34,43),(35,44),(36,45),(37,46),(38,47),(39,48),(40,49),(41,50),(42,51),(43,52),(44,53),(45,54),(46,55),(47,56),(48,57),(49,58),(50,59),(51,60);
/*!40000 ALTER TABLE `us_os` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

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
  `sexo` enum('M','F') DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_adm` (`id_adm`),
  CONSTRAINT `fk_adm` FOREIGN KEY (`id_adm`) REFERENCES `adm` (`id_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,9,'Tatiane Pires','413.678.254-83','tatiane.pires','tatiane.pires@email.com','659842130','v8U$wF1pK0','2024-10-12','1990-11-28','F'),(2,16,'Gustavo Lima','532.489.106-87','gustavo.lima','gustavo.lima@email.com','327895674','3QzD0&jWz1','2024-08-18','1983-03-05','M'),(3,10,'Luciana Almeida','583.694.201-54','luciana.almeida','luciana.almeida@email.com','749183265','lT*7FqB9sV','2024-11-30','1987-07-19','F'),(4,2,'Marco Antônio','284.507.743-40','marco.antonio','marco.antonio@email.com','421896730','r!J9K@e2Lp','2024-12-02','1980-12-12','M'),(5,18,'Ana Clara','732.510.653-00','ana.clara','ana.clara@email.com','512763485','A1qP2t#9zY','2024-10-29','1996-02-26','F'),(6,3,'Roberto Souza','356.474.382-62','roberto.souza','roberto.souza@email.com','840156923','sL6$eQv5C7','2024-10-10','1991-04-03','M'),(7,12,'Tatiane Ribeiro','523.747.968-08','tatiane.ribeiro','tatiane.ribeiro@email.com','731946258','T9*ytKm#3N','2024-10-22','1994-08-10','F'),(8,11,'Thiago Costa','926.571.438-30','thiago.costa','thiago.costa@email.com','637214580','sF2D9gZ!X6','2024-09-27','1999-11-02','M'),(9,4,'Marcos Paulo','712.684.819-01','marcos.paulo','marcos.paulo@email.com','358945672','y5Rz^1kQbP','2024-08-01','1985-07-14','M'),(10,5,'Camila Rocha','698.423.750-77','camila.rocha','camila.rocha@email.com','491872035','rB6t%Hq7P0','2024-08-19','1992-03-25','F'),(11,6,'João Silva','357.468.174-21','joao.silva','joao.silva@email.com','964728014','Y#e3Fq!0xL','2024-05-17','1985-07-30','M'),(12,7,'Mariana Costa','213.987.564-20','mariana.costa','mariana.costa@email.com','647893521','9aSdB3oVvQ','2024-06-12','1990-03-11','F'),(13,8,'Carlos Oliveira','519.732.608-97','carlos.oliveira','carlos.oliveira@email.com','794562189','cG2nI8&1Ks','2024-07-09','1982-12-23','M'),(14,9,'Fernanda Souza','432.569.784-02','fernanda.souza','fernanda.souza@email.com','236715409','Fv!9jDxD6z','2024-08-05','1987-05-16','F'),(15,10,'André Almeida','347.286.453-61','andre.almeida','andre.almeida@email.com','892731456','vY2RzR4wH@','2024-09-18','1994-07-29','M'),(16,11,'Juliana Martins','876.432.091-55','juliana.martins','juliana.martins@email.com','756198273','pL1zUwZ2Fy','2024-10-03','1991-02-22','F'),(17,12,'Eduardo Pereira','530.681.290-39','eduardo.pereira','eduardo.pereira@email.com','638512790','qR7!Cw6tZ1','2024-08-30','1983-10-04','M'),(18,13,'Patricia Gomes','295.473.851-14','patricia.gomes','patricia.gomes@email.com','536821409','kY6E#xG3dF','2024-07-25','1989-12-17','F'),(19,14,'Vinícius Rocha','842.973.150-90','vinicius.rocha','vinicius.rocha@email.com','726419803','uW1mH4pQvL','2024-06-22','1992-11-05','M'),(20,15,'Aline Rodrigues','256.982.375-65','aline.rodrigues','aline.rodrigues@email.com','394625871','Lh9tY!xW5u','2024-09-12','1986-09-19','F'),(21,16,'Roberta Silva','468.374.518-80','roberta.silva','roberta.silva@email.com','385763904','7gFzV9v4wL','2024-08-20','1993-06-10','F'),(22,17,'Luiz Fernando','782.594.392-09','luiz.fernando','luiz.fernando@email.com','413850297','j9B!TzO1U6','2024-09-07','1988-08-16','M'),(23,18,'Tatiane Costa','836.581.230-77','tatiane.costa','tatiane.costa@email.com','631478305','9pL#Az1U2W','2024-07-19','1991-11-11','F'),(24,19,'Marcos Lima','473.726.680-43','marcos.lima','marcos.lima@email.com','982657413','sL4#Kz8E6V','2024-05-24','1983-04-22','M'),(25,20,'Jéssica Alves','582.377.689-21','jessica.alves','jessica.alves@email.com','736541890','8cP2tYm!3A','2024-06-18','1995-03-10','F'),(26,21,'Lucas Rocha','742.562.947-23','lucas.rocha','lucas.rocha@email.com','682049157','zG4D3uY1kX','2024-08-04','1987-12-14','M'),(27,22,'Ana Beatriz','312.856.547-09','ana.beatriz','ana.beatriz@email.com','891257403','p9Fq6BzD2S','2024-09-14','1992-05-08','F'),(28,23,'João Pedro','619.587.204-81','joao.pedro','joao.pedro@email.com','563720148','v4sG0k3zRp','2024-07-14','1989-06-18','M'),(29,24,'Priscila Nunes','786.430.875-20','priscila.nunes','priscila.nunes@email.com','482613957','A2jFhR8qO9','2024-06-02','1993-04-23','F'),(30,25,'Renato Santos','569.712.348-96','renato.santos','renato.santos@email.com','923765481','hL1T2V#rXy','2024-08-15','1984-09-25','M'),(31,26,'Isabela Ribeiro','651.920.438-53','isabela.ribeiro','isabela.ribeiro@email.com','745813692','P3gX1N2yT5','2024-09-21','1990-12-01','F'),(32,27,'Gustavo Oliveira','273.942.650-77','gustavo.oliveira','gustavo.oliveira@email.com','849723156','rS6bTz1lV8','2024-05-31','1986-01-10','M'),(33,28,'Camila Ferreira','372.104.567-22','camila.ferreira','camila.ferreira@email.com','649823710','l9Dq!X3bLk','2024-06-10','1994-07-08','F'),(34,29,'Fabio Martins','826.145.379-84','fabio.martins','fabio.martins@email.com','526947310','K2wE#t0m1A','2024-07-22','1981-11-02','M'),(35,30,'Mariana Lima','429.827.365-98','mariana.lima','mariana.lima@email.com','739564182','pV3E9x7rQf','2024-08-17','1989-05-14','F'),(36,31,'Ricardo Costa','418.563.407-20','ricardo.costa','ricardo.costa@email.com','574810923','F5w#Qv3k9N','2024-07-05','1984-10-20','M'),(37,32,'Flávia Ribeiro','522.437.019-03','flavia.ribeiro','flavia.ribeiro@email.com','634820591','A2tF1xX3wP','2024-06-26','1995-09-04','F'),(38,33,'Igor Silva','763.541.308-11','igor.silva','igor.silva@email.com','432098675','9vL2Fm3bTz','2024-09-10','1988-07-02','M'),(39,34,'Tatiane Oliveira','829.413.564-77','tatiane.oliveira','tatiane.oliveira@email.com','639827401','u2Wp4J9wQF','2024-08-23','1990-03-04','F'),(40,35,'Felipe Costa','340.675.854-90','felipe.costa','felipe.costa@email.com','957813642','g7YpR2v4Yz','2024-07-28','1992-04-13','M'),(41,36,'Nathalia Martins','502.463.057-84','nathalia.martins','nathalia.martins@email.com','758190643','t9Pv8rF1Uq','2024-08-13','1994-11-17','F'),(42,37,'Caio Oliveira','192.458.307-20','caio.oliveira','caio.oliveira@email.com','497812365','w5Rg2nF1V#','2024-07-30','1987-02-04','M'),(43,38,'Joana Ferreira','758.953.620-50','joana.ferreira','joana.ferreira@email.com','368479102','pT2W9cP7yX','2024-08-02','1991-05-21','F'),(44,39,'Vitor Hugo','162.379.258-01','vitor.hugo','vitor.hugo@email.com','746251938','b4M7Tz1!Fa','2024-06-06','1985-11-15','M'),(45,40,'Jessica Oliveira','935.618.742-68','jessica.oliveira','jessica.oliveira@email.com','634892105','cB2X9pV4Yz','2024-07-01','1990-08-17','F'),(46,41,'Carlos Eduardo','542.361.874-09','carlos.eduardo','carlos.eduardo@email.com','973124568','mS2!X8wD3Q','2024-08-29','1982-01-25','M'),(47,42,'Mariana Silva','617.348.209-16','mariana.silva','mariana.silva@email.com','548729063','bV1Fw3i!9P','2024-06-04','1995-02-18','F'),(48,43,'Felipe Almeida','193.472.860-01','felipe.almeida','felipe.almeida@email.com','264935081','g7W4tR2oF#','2024-07-12','1988-12-22','M'),(49,44,'Priscila Santos','823.492.741-61','priscila.santos','priscila.santos@email.com','685037491','mP4Wq9u8rN','2024-09-01','1992-04-28','F'),(50,45,'Caio Santos','732.860.492-03','caio.santos','caio.santos@email.com','493825671','rT1!bF3wD8','2024-08-11','1989-10-17','M'),(51,46,'Luana Costa','758.361.258-90','luana.costa','luana.costa@email.com','192736504','sW4rFq8uPz','2024-06-23','1994-01-05','F'),(52,47,'Ricardo Almeida','426.703.951-88','ricardo.almeida','ricardo.almeida@email.com','530947162','oD1mG7vL2p','2024-08-25','1983-09-30','M'),(53,48,'Gabriela Souza','592.748.263-04','gabriela.souza','gabriela.souza@email.com','738294561','hQ7dL0p9bJ','2024-09-04','1990-06-12','F'),(54,49,'Daniel Oliveira','285.561.930-20','daniel.oliveira','daniel.oliveira@email.com','649182347','yH1Vd9pLkW','2024-05-26','1987-12-10','M'),(55,50,'Vanessa Ribeiro','435.659.237-86','vanessa.ribeiro','vanessa.ribeiro@email.com','391876204','aP4OqF6y3X','2024-06-16','1995-02-20','F'),(56,51,'Gustavo Silva','347.892.563-10','gustavo.silva','gustavo.silva@email.com','836251740','tH3qLp1YzV','2024-09-06','1992-03-17','M'),(57,52,'Carla Martins','742.563.821-14','carla.martins','carla.martins@email.com','982416573','vY2eW4fT8H','2024-07-18','1993-11-12','F'),(58,53,'Rodrigo Pereira','628.472.051-33','rodrigo.pereira','rodrigo.pereira@email.com','591830472','sG3A!y9vK1','2024-06-05','1986-10-25','M'),(59,54,'Juliana Nunes','736.817.290-14','juliana.nunes','juliana.nunes@email.com','920487631','pW5Y2z6qF1','2024-09-15','1994-03-02','F'),(60,55,'Fábio Souza','972.184.305-76','fabio.souza','fabio.souza@email.com','481026358','dL2mW8rF4V','2024-08-29','1990-05-18','M');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-09 13:56:16
