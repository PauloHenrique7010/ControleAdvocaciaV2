-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: controle_advocacia
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `advogado`
--

DROP TABLE IF EXISTS `advogado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advogado` (
  `cod_advogado` int NOT NULL AUTO_INCREMENT,
  `nome_advogado` varchar(100) DEFAULT NULL,
  `oab` varchar(10) DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_advogado`)
) ENGINE=InnoDB AUTO_INCREMENT=3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advogado`
--

LOCK TABLES `advogado` WRITE;
/*!40000 ALTER TABLE `advogado` DISABLE KEYS */;
INSERT INTO `advogado` VALUES (1,'Taiz',NULL,'2020-06-14 15:01:07',NULL),(2,'Paulo',NULL,'2020-06-14 15:01:18',NULL);
/*!40000 ALTER TABLE `advogado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banco` (
  `cod_banco` int NOT NULL AUTO_INCREMENT,
  `codigo_banco` int DEFAULT NULL,
  `nome_banco` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_banco`)
) ENGINE=InnoDB AUTO_INCREMENT=7;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
INSERT INTO `banco` VALUES (1,0,'Não Informado'),(2,33,'Santander'),(3,104,'Caixa'),(4,341,'Itaú'),(5,260,'NuBank'),(6,550,'Banco Andromeda');
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `cod_cliente` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `cpf` varchar(20) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cod_nacionalidade` int NOT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `cod_estado_civil` int NOT NULL,
  `cod_profissao` int NOT NULL,
  `cod_orgao_classe` int NOT NULL,
  `cep` varchar(10) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `nome_pai` varchar(100) NOT NULL,
  `nome_mae` varchar(100) NOT NULL,
  `cod_banco` int NOT NULL,
  `num_agencia` varchar(20) NOT NULL,
  `num_conta` varchar(20) NOT NULL,
  `cod_tipo_conta` int NOT NULL,
  `descricao_cliente` text NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  `files` text NOT NULL,
  PRIMARY KEY (`cod_cliente`),
  KEY `cod_estado_civil` (`cod_estado_civil`),
  KEY `cod_nacionalidade` (`cod_nacionalidade`),
  KEY `cod_profissao` (`cod_profissao`),
  KEY `cod_orgao_classe` (`cod_orgao_classe`),
  KEY `cod_banco` (`cod_banco`),
  KEY `cod_tipo_conta` (`cod_tipo_conta`),
  CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`cod_estado_civil`) REFERENCES `estado_civil` (`cod_estado_civil`),
  CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`cod_nacionalidade`) REFERENCES `nacionalidade` (`cod_nacionalidade`),
  CONSTRAINT `cliente_ibfk_3` FOREIGN KEY (`cod_profissao`) REFERENCES `profissoes` (`cod_profissao`),
  CONSTRAINT `cliente_ibfk_4` FOREIGN KEY (`cod_orgao_classe`) REFERENCES `orgao_classe` (`cod_orgao_classe`),
  CONSTRAINT `cliente_ibfk_5` FOREIGN KEY (`cod_banco`) REFERENCES `banco` (`cod_banco`),
  CONSTRAINT `cliente_ibfk_6` FOREIGN KEY (`cod_tipo_conta`) REFERENCES `tipo_conta_banco` (`cod_tipo_conta`)
) ENGINE=InnoDB AUTO_INCREMENT=13;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Paulo Henrique da Silva','','',1,'',1,1,1,'','1','','','','','','','',1,'','',1,'&lt;blockquote&gt;&lt;p&gt;fsdfafdfdsfdsfsdf&lt;span style=&quot;background-color: rgb(255, 255, 0);&quot;&gt;sdf&lt;u&gt;dsfsdfsfsfsdfsfd fsdsfdsf&lt;/u&gt;&lt;/span&gt;ffdsfs&lt;/p&gt;&lt;/blockquote&gt;&lt;h1&gt;seu pai&lt;br&gt;&lt;/h1&gt;&lt;p&gt;dfsfsdf&lt;br&gt;&lt;/p&gt;','2000-05-03','2020-07-10 18:30:25',NULL,''),(10,'Rodrigo alonso g','402.799.268-71','',1,'',1,1,1,'','1','','','','','','','',1,'','',1,'',NULL,'2020-11-06 21:39:52',NULL,'');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_telefone`
--

DROP TABLE IF EXISTS `cliente_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente_telefone` (
  `cod_cliente_telefone` int NOT NULL AUTO_INCREMENT,
  `cod_cliente` int DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod_cliente_telefone`),
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `cliente_telefone_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`cod_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=23;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_telefone`
--

LOCK TABLES `cliente_telefone` WRITE;
/*!40000 ALTER TABLE `cliente_telefone` DISABLE KEYS */;
INSERT INTO `cliente_telefone` VALUES (7,1,'(12) 98109-6148'),(8,1,'(12) 3021-8662'),(22,10,'(76) 87687-6876');
/*!40000 ALTER TABLE `cliente_telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competencias`
--

DROP TABLE IF EXISTS `competencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competencias` (
  `cod_competencia` int NOT NULL AUTO_INCREMENT,
  `nome_competencia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=11;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competencias`
--

LOCK TABLES `competencias` WRITE;
/*!40000 ALTER TABLE `competencias` DISABLE KEYS */;
INSERT INTO `competencias` VALUES (1,'Cível'),(2,'Família e Sucessões'),(3,'Registros Públicos'),(4,'Infância e Juventude Cível'),(5,'Acidente do Trabalho'),(6,'Juizado Especial Cível'),(7,'Criminal'),(8,'Juizado Especial Criminal'),(9,'Júri'),(10,'Execução Criminal');
/*!40000 ALTER TABLE `competencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_civil`
--

DROP TABLE IF EXISTS `estado_civil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_civil` (
  `cod_estado_civil` int NOT NULL AUTO_INCREMENT,
  `nome_estado_civil` varchar(50) DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_estado_civil`)
) ENGINE=InnoDB AUTO_INCREMENT=8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_civil`
--

LOCK TABLES `estado_civil` WRITE;
/*!40000 ALTER TABLE `estado_civil` DISABLE KEYS */;
INSERT INTO `estado_civil` VALUES (1,'Não informado',NULL,NULL),(2,'Casado(a)',NULL,NULL),(3,'Divorciado(a)',NULL,NULL),(4,'Solteiro(a)',NULL,NULL);
/*!40000 ALTER TABLE `estado_civil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pagamento`
--

DROP TABLE IF EXISTS `forma_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pagamento` (
  `cod_forma_pagamento` int NOT NULL AUTO_INCREMENT,
  `nome_forma_pagamento` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_forma_pagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pagamento`
--

LOCK TABLES `forma_pagamento` WRITE;
/*!40000 ALTER TABLE `forma_pagamento` DISABLE KEYS */;
INSERT INTO `forma_pagamento` VALUES (1,'Dinheiro'),(2,'Cartao');
/*!40000 ALTER TABLE `forma_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foros`
--

DROP TABLE IF EXISTS `foros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foros` (
  `cod_foro` int NOT NULL AUTO_INCREMENT,
  `nome_foro` varchar(50) DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_foro`)
) ENGINE=InnoDB AUTO_INCREMENT=19;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foros`
--

LOCK TABLES `foros` WRITE;
/*!40000 ALTER TABLE `foros` DISABLE KEYS */;
INSERT INTO `foros` VALUES (1,'Foro de São José dos Campos',NULL,NULL),(2,'Foro Regional I - Santana',NULL,NULL),(3,'Foro Regional II - Santo Amaro',NULL,NULL),(4,'Foro Regional III - Jabaquara',NULL,NULL),(5,'Foro Regional IV - Lapa',NULL,NULL),(6,'Foro Regional V - São Miguel Paulista',NULL,NULL),(7,'Foro Regional VI - Penha de França',NULL,NULL),(8,'Foro Regional VII - Itaquera',NULL,NULL),(9,'Foro Regional VIII - Tatuapé',NULL,NULL),(10,'Foro Regional IX - Vila Prudente',NULL,NULL),(11,'Foro Regional X - Ipiranga',NULL,NULL),(12,'Foro Regional XI - Pinheiros',NULL,NULL),(13,'Foro das Execuções Fiscais Estaduais',NULL,NULL),(14,'Foro Especial da Infância e Juventude',NULL,NULL),(15,'Foro Central Juizados Especiais Cíveis',NULL,NULL),(16,'São Paulo',NULL,NULL),(18,'Foro de Presidente prudente',NULL,NULL);
/*!40000 ALTER TABLE `foros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nacionalidade`
--

DROP TABLE IF EXISTS `nacionalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nacionalidade` (
  `cod_nacionalidade` int NOT NULL AUTO_INCREMENT,
  `nome_nacionalidade` varchar(100) DEFAULT NULL,
  `nacionalidade_feminina` varchar(100) DEFAULT NULL,
  `nacionalidade_masculino` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_nacionalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=6;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nacionalidade`
--

LOCK TABLES `nacionalidade` WRITE;
/*!40000 ALTER TABLE `nacionalidade` DISABLE KEYS */;
INSERT INTO `nacionalidade` VALUES (1,'Não informado','Não informada','Não informado'),(2,'Argentina','Argentina','Argentino'),(4,'China',NULL,NULL),(5,'Brasil','Brasileira','Brasileiro');
/*!40000 ALTER TABLE `nacionalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgao_classe`
--

DROP TABLE IF EXISTS `orgao_classe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orgao_classe` (
  `cod_orgao_classe` int NOT NULL AUTO_INCREMENT,
  `nome_orgao_classe` varchar(100) DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_orgao_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=6;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgao_classe`
--

LOCK TABLES `orgao_classe` WRITE;
/*!40000 ALTER TABLE `orgao_classe` DISABLE KEYS */;
INSERT INTO `orgao_classe` VALUES (1,'Não informado',NULL,NULL),(2,'OAB',NULL,NULL);
/*!40000 ALTER TABLE `orgao_classe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processo`
--

DROP TABLE IF EXISTS `processo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `processo` (
  `cod_processo` int NOT NULL AUTO_INCREMENT,
  `numero_processo` varchar(100) DEFAULT NULL,
  `grau_peticionamento` int DEFAULT NULL,
  `tipo_acao` int DEFAULT NULL,
  `cod_foro` int DEFAULT NULL,
  `cod_competencia` int DEFAULT NULL,
  `classe_processo` varchar(100) DEFAULT NULL,
  `dependencia` tinyint(1) DEFAULT '0',
  `segredo_justica` tinyint(1) DEFAULT '0',
  `gratuidade_justica` tinyint(1) DEFAULT '0',
  `preso` tinyint(1) DEFAULT '0',
  `liberdade_provisoria` tinyint(1) DEFAULT '0',
  `valor_acao` decimal(12,2) DEFAULT NULL,
  `data_distribuicao` date DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  `assunto_principal` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_processo`)
) ENGINE=InnoDB AUTO_INCREMENT=5;;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processo`
--

LOCK TABLES `processo` WRITE;
/*!40000 ALTER TABLE `processo` DISABLE KEYS */;
INSERT INTO `processo` VALUES (1,NULL,2,3,1,1,'fasdfads',0,1,0,0,0,0.00,'0000-00-00','2020-06-14 14:15:25',NULL,'4234432'),(2,NULL,1,3,1,2,'classe processo',1,1,1,1,1,100.00,'2000-01-01','2020-06-14 14:17:12',NULL,'assunto principal');
/*!40000 ALTER TABLE `processo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profissoes`
--

DROP TABLE IF EXISTS `profissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profissoes` (
  `cod_profissao` int NOT NULL AUTO_INCREMENT,
  `nome_profissao` varchar(100) DEFAULT NULL,
  `data_criado` datetime DEFAULT NULL,
  `data_atualizado` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_profissao`)
) ENGINE=InnoDB AUTO_INCREMENT=10;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profissoes`
--

LOCK TABLES `profissoes` WRITE;
/*!40000 ALTER TABLE `profissoes` DISABLE KEYS */;
INSERT INTO `profissoes` VALUES (1,'Não informado',NULL,NULL),(2,'Professor(a)',NULL,NULL),(3,'Advogado(a)',NULL,NULL),(4,'Cozinheiro(a)','2020-04-28 23:01:36',NULL);
/*!40000 ALTER TABLE `profissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relacao_foros_competencias`
--

DROP TABLE IF EXISTS `relacao_foros_competencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relacao_foros_competencias` (
  `cod_relacao` int NOT NULL AUTO_INCREMENT,
  `cod_foro` int DEFAULT NULL,
  `cod_competencia` int DEFAULT NULL,
  PRIMARY KEY (`cod_relacao`),
  KEY `cod_foro` (`cod_foro`),
  KEY `cod_competencia` (`cod_competencia`),
  CONSTRAINT `relacao_foros_competencias_ibfk_1` FOREIGN KEY (`cod_foro`) REFERENCES `foros` (`cod_foro`),
  CONSTRAINT `relacao_foros_competencias_ibfk_2` FOREIGN KEY (`cod_competencia`) REFERENCES `competencias` (`cod_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=11;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relacao_foros_competencias`
--

LOCK TABLES `relacao_foros_competencias` WRITE;
/*!40000 ALTER TABLE `relacao_foros_competencias` DISABLE KEYS */;
INSERT INTO `relacao_foros_competencias` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,5,1),(9,5,2),(10,5,4);
/*!40000 ALTER TABLE `relacao_foros_competencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relacao_orgao_classe_profissoes`
--

DROP TABLE IF EXISTS `relacao_orgao_classe_profissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relacao_orgao_classe_profissoes` (
  `cod_relacao` int NOT NULL AUTO_INCREMENT,
  `cod_orgao_classe` int DEFAULT NULL,
  `cod_profissao` int DEFAULT NULL,
  PRIMARY KEY (`cod_relacao`)
) ENGINE=InnoDB AUTO_INCREMENT=2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relacao_orgao_classe_profissoes`
--

LOCK TABLES `relacao_orgao_classe_profissoes` WRITE;
/*!40000 ALTER TABLE `relacao_orgao_classe_profissoes` DISABLE KEYS */;
INSERT INTO `relacao_orgao_classe_profissoes` VALUES (1,1,1);
/*!40000 ALTER TABLE `relacao_orgao_classe_profissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico` (
  `cod_servico` int NOT NULL AUTO_INCREMENT,
  `data_criado` datetime DEFAULT NULL,
  `cod_tipo_servico` int DEFAULT NULL,
  `cod_tipo_processo` int DEFAULT NULL,
  `cod_tipo_acao` int DEFAULT NULL,
  `valor_servico` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`cod_servico`),
  KEY `cod_tipo_processo` (`cod_tipo_processo`),
  KEY `cod_tipo_acao` (`cod_tipo_acao`),
  KEY `cod_tipo_servico` (`cod_tipo_servico`),
  CONSTRAINT `servico_ibfk_1` FOREIGN KEY (`cod_tipo_processo`) REFERENCES `tipo_processo` (`cod_tipo_processo`),
  CONSTRAINT `servico_ibfk_2` FOREIGN KEY (`cod_tipo_acao`) REFERENCES `tipo_acao` (`cod_tipo_acao`),
  CONSTRAINT `servico_ibfk_3` FOREIGN KEY (`cod_tipo_servico`) REFERENCES `tipo_servico` (`cod_tipo_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=25;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico`
--

LOCK TABLES `servico` WRITE;
/*!40000 ALTER TABLE `servico` DISABLE KEYS */;
INSERT INTO `servico` VALUES (18,'2020-11-11 08:55:34',1,1,2,200.00),(24,'2020-11-11 13:10:43',2,1,2,100.00);
/*!40000 ALTER TABLE `servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico_pagamento`
--

DROP TABLE IF EXISTS `servico_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico_pagamento` (
  `cod_servico_pagamento` int NOT NULL AUTO_INCREMENT,
  `cod_servico` int DEFAULT NULL,
  `numero_parcela` int DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `valor_parcela` decimal(12,2) DEFAULT NULL,
  `cod_forma_pagamento` int DEFAULT NULL,
  `data_pago` date DEFAULT NULL,
  PRIMARY KEY (`cod_servico_pagamento`),
  KEY `cod_forma_pagamento` (`cod_forma_pagamento`),
  KEY `cod_servico` (`cod_servico`),
  CONSTRAINT `servico_pagamento_ibfk_1` FOREIGN KEY (`cod_forma_pagamento`) REFERENCES `forma_pagamento` (`cod_forma_pagamento`),
  CONSTRAINT `servico_pagamento_ibfk_2` FOREIGN KEY (`cod_servico`) REFERENCES `servico` (`cod_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=59;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico_pagamento`
--

LOCK TABLES `servico_pagamento` WRITE;
/*!40000 ALTER TABLE `servico_pagamento` DISABLE KEYS */;
INSERT INTO `servico_pagamento` VALUES (45,18,1,'0000-00-00',100.00,1,NULL),(46,18,2,'0000-00-00',100.00,1,NULL),(57,24,1,'2020-11-11',50.00,1,NULL),(58,24,2,'2020-12-11',50.00,1,NULL);
/*!40000 ALTER TABLE `servico_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico_parte`
--

DROP TABLE IF EXISTS `servico_parte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico_parte` (
  `cod_servico_parte` int NOT NULL AUTO_INCREMENT,
  `cod_parte` int DEFAULT NULL,
  `nome_parte` varchar(50) DEFAULT NULL,
  `cod_servico` int DEFAULT NULL,
  PRIMARY KEY (`cod_servico_parte`),
  KEY `cod_servico` (`cod_servico`),
  CONSTRAINT `servico_parte_ibfk_1` FOREIGN KEY (`cod_servico`) REFERENCES `servico` (`cod_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=14;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico_parte`
--

LOCK TABLES `servico_parte` WRITE;
/*!40000 ALTER TABLE `servico_parte` DISABLE KEYS */;
INSERT INTO `servico_parte` VALUES (5,1,'Paulo Henrique da Silva',18),(6,10,'Rodrigo alonso g',18),(13,1,'Paulo Henrique da Silva',24);
/*!40000 ALTER TABLE `servico_parte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_acao`
--

DROP TABLE IF EXISTS `tipo_acao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_acao` (
  `cod_tipo_acao` int NOT NULL AUTO_INCREMENT,
  `nome_tipo_acao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_acao`)
) ENGINE=InnoDB AUTO_INCREMENT=3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_acao`
--

LOCK TABLES `tipo_acao` WRITE;
/*!40000 ALTER TABLE `tipo_acao` DISABLE KEYS */;
INSERT INTO `tipo_acao` VALUES (1,'Alimentos'),(2,'Declaratoria');
/*!40000 ALTER TABLE `tipo_acao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_conta_banco`
--

DROP TABLE IF EXISTS `tipo_conta_banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_conta_banco` (
  `cod_tipo_conta` int NOT NULL AUTO_INCREMENT,
  `nome_tipo_conta` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_conta`)
) ENGINE=InnoDB AUTO_INCREMENT=4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_conta_banco`
--

LOCK TABLES `tipo_conta_banco` WRITE;
/*!40000 ALTER TABLE `tipo_conta_banco` DISABLE KEYS */;
INSERT INTO `tipo_conta_banco` VALUES (1,'Não informado'),(2,'Conta-corrente'),(3,'Conta Poupança');
/*!40000 ALTER TABLE `tipo_conta_banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_processo`
--

DROP TABLE IF EXISTS `tipo_processo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_processo` (
  `cod_tipo_processo` int NOT NULL AUTO_INCREMENT,
  `nome_tipo_processo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_processo`)
) ENGINE=InnoDB AUTO_INCREMENT=3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_processo`
--

LOCK TABLES `tipo_processo` WRITE;
/*!40000 ALTER TABLE `tipo_processo` DISABLE KEYS */;
INSERT INTO `tipo_processo` VALUES (1,'Cívil'),(2,'Fazenda Pública');
/*!40000 ALTER TABLE `tipo_processo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_servico`
--

DROP TABLE IF EXISTS `tipo_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_servico` (
  `cod_tipo_servico` int NOT NULL AUTO_INCREMENT,
  `nome_tipo_servico` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_servico`
--

LOCK TABLES `tipo_servico` WRITE;
/*!40000 ALTER TABLE `tipo_servico` DISABLE KEYS */;
INSERT INTO `tipo_servico` VALUES (1,'Consulta Juridica'),(2,'Assessoria Juridica');
/*!40000 ALTER TABLE `tipo_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_escavador`
--

DROP TABLE IF EXISTS `token_escavador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `token_escavador` (
  `access_token` text,
  `refresh_token` text
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_escavador`
--

LOCK TABLES `token_escavador` WRITE;
/*!40000 ALTER TABLE `token_escavador` DISABLE KEYS */;
INSERT INTO `token_escavador` VALUES ('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE0N2E2NDAzYzFkMzQxMTc0ZjQ5Y2I3Yzg5Y2I3NjJhMmEyMWYxMWY2YmU2MTk4ZWQ1NGFjYzJkMzM4MjE4NTg3NjkxZTU1ZTkxMTFiYWZhIn0.eyJhdWQiOiIzIiwianRpIjoiMTQ3YTY0MDNjMWQzNDExNzRmNDljYjdjODljYjc2MmEyYTIxZjExZjZiZTYxOThlZDU0YWNjMmQzMzgyMTg1ODc2OTFlNTVlOTExMWJhZmEiLCJpYXQiOjE2MDM5Nzc0NzEsIm5iZiI6MTYwMzk3NzQ3MSwiZXhwIjoxOTE5NTEwMjcxLCJzdWIiOiI4Njc0ODYiLCJzY29wZXMiOlsidXNlcl9hcGkiXX0.wPWJs5v7MFqJ3nL-6alCi35Cr9UurRC3mT7CoF6JNPWTPCX-TSrr-EQAicA_AcwN_kmOPfL6KYrd5_HPLjqpi9oBtZeeKpYngRsY-7E6s3vaeFnuFb81pQsdijbzNqttpNfYp5XfAFIlnDAb2wDuNGQ0Za1k2MNxC6hRw3FfWobUX2ZVR_qoyhZ77nbCcCYUPAqZGNdui71cApZlU5n7K9SYhlLVamwEDLoy5LZ4mCw4J3UdNOM6815c4B3xbmkL_R-uOT6wboAuacvknL113u31babPxI1nwbZFk7OjjrZPJY2h4RjGPAcvfiDagLBPM8eal1xvurcvdOkCZUuQHJcXnUHV2ZpfTRuTI94V_4BCqmK9GdGzUzM97w193lUe5g8fHN7GoXK_ZbK5P-lT3iLDNOK_7IrzqOuTmvUK_OEaZjCVEDDBDl4ysoi6uh4bVmQX0GkrV1OzIbbKr_TsfqFYFSJzeFCKf-olBdlGWOjU1hFNoCEHd8S9EdnIfGTSnjL3axLdMmUGYnswMFDf5K47oC81oEP_I-xsrbxi5y3dbgzxn-7y_owWfVpGEUgy20zkq64UNXQXL3hHkDRssDr5lG1MMyEu_nGgMSv8tZph9mgz0jWVqlb_R4t0wGP75AqjYr1Le05JWtGmvwNWIWX2cJe7dJ01TINC__PT30Y','def502000794e8043d73d7aa9b464773a55f2ddf1a10f891ff279b548d800620a596a9d1497d07db8d17aaecd9485c9a07cd284680e9a9e8ce0a67b52b1719c6541f4bcb4c28ab6b7a1bb28eeffd77e6da27cd6d921b704a5db88fc8c4d6b9d308a9a14fc54adcbf94ffdbae630d06cc34c0c4264b62d58bcc5131ffb9eb1a6aca8ff6821b3795d5c5426cb30807a4af2cb4e1046a41f0c8e067bf76f208078af1d09ab7a5be5400f4d4a423d7470f8aa7567dfb63e74f88b50361ee2a067f89ddd476c805043ae893646421f8b7d6d784f00114bfad6eb66d3f2a6774680d875cf409af57deb1918fd9f796ddf1f198c15c722847f32bd6d450511b3f750dd0e47fb80379bc9a5e0efbb4e11d96fcc567ffc66b690a91b77bd0f95f6700ada86edd873be556a15e08ce24dc48734b69a988b30491c4c5358d036f9b506d53a8e26873798f583a44156476b5539b9cd4c34f18bb44395665de1a27ea132559c302755877259506cbebc5a9de3b5961c6');
/*!40000 ALTER TABLE `token_escavador` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-11 13:42:31
