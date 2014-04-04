-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mtmcontest
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.13.10.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BALANCE`
--

DROP TABLE IF EXISTS `BALANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BALANCE` (
  `ACCT` char(12) NOT NULL,
  `BALANCE` decimal(7,2) NOT NULL,
  PRIMARY KEY (`ACCT`),
  CONSTRAINT `BALANCE_ibfk_1` FOREIGN KEY (`ACCT`) REFERENCES `CUSTOMER` (`ACCT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BALANCE`
--

LOCK TABLES `BALANCE` WRITE;
/*!40000 ALTER TABLE `BALANCE` DISABLE KEYS */;
INSERT INTO `BALANCE` VALUES ('000000000000',25.52),('111111111111',99999.99),('222222222222',70455.00),('235235235235',229.00),('256256956956',0.00),('333333333333',99999.99),('444444444444',99999.99),('555555555555',29414.00);
/*!40000 ALTER TABLE `BALANCE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CUSTOMER`
--

DROP TABLE IF EXISTS `CUSTOMER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CUSTOMER` (
  `ACCT` char(12) NOT NULL,
  `STATUS` char(1) NOT NULL,
  `FN` char(35) NOT NULL,
  `LN` char(35) NOT NULL,
  `ADDR` char(35) NOT NULL,
  `CITY` char(35) NOT NULL,
  `STATE` char(2) NOT NULL,
  PRIMARY KEY (`ACCT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CUSTOMER`
--

LOCK TABLES `CUSTOMER` WRITE;
/*!40000 ALTER TABLE `CUSTOMER` DISABLE KEYS */;
INSERT INTO `CUSTOMER` VALUES ('000000000000','A','Test','Test','1234 Madison Avenuesss','New York','Ne'),('111111111111','A','Test','Test','1234 Madison Avenue','New York','Ne'),('222222222222','A','Test','Test','1234 Madison Avenue','New York','Ne'),('235235235235','A','test','test','test','test','te'),('256256956956','A','ook','campbuit','pro','sfsdf','KS'),('333333333333','A','Test','Test','1234 Madison Avenue','New York','Ne'),('444444444444','A','Test','Test','1234 Madison Avenue','New York','Ne'),('555555555555','A','Test','Test','1234 Madison Avenue','New York','Ne');
/*!40000 ALTER TABLE `CUSTOMER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PIN`
--

DROP TABLE IF EXISTS `PIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PIN` (
  `ACCT` char(12) NOT NULL,
  `PIN` char(4) NOT NULL,
  PRIMARY KEY (`ACCT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PIN`
--

LOCK TABLES `PIN` WRITE;
/*!40000 ALTER TABLE `PIN` DISABLE KEYS */;
/*!40000 ALTER TABLE `PIN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TRANS`
--

DROP TABLE IF EXISTS `TRANS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TRANS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCT` char(12) NOT NULL,
  `AMOUNT` decimal(7,2) NOT NULL,
  `TRNTYPE` char(1) NOT NULL,
  `TIME_START` datetime NOT NULL,
  `TIME_END` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TRANS`
--

LOCK TABLES `TRANS` WRITE;
/*!40000 ALTER TABLE `TRANS` DISABLE KEYS */;
INSERT INTO `TRANS` VALUES (6,'235235235235',2.00,'D','2014-04-02 13:56:57','2014-04-02 13:56:57'),(7,'235235235235',-3.00,'W','2014-04-02 13:57:00','2014-04-02 13:57:00');
/*!40000 ALTER TABLE `TRANS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `SALT` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `ROLE` varchar(255) NOT NULL,
  `CUSTOMER` char(12) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` VALUES (7,'Mort','$2y$15$8683f9137f0e4814cafc1u4UgNUsrcGKxM0Y/UNjh5ubr/l05JDUa','8683f9137f0e4814cafc177594a2ea48','mort.cruel@gmail.com','ROLE_ADMIN','111111111111'),(8,'customer','$2y$15$d3c59b9f9b243263833e3u5q/0Edfbo74WsPApTkjS7RMqr.cHplW','d3c59b9f9b243263833e33628c8992dd','aaron.call@est.fib.upc.edu','ROLE_CUSTOMER','235235235235'),(9,'prova','$2y$15$037d0e9b8a10ac437792du0rE3biEfEvpqdd5CXFc4cabxNVfu6N2','037d0e9b8a10ac437792d2b73afb5bba','prova@consumerlab.es','ROLE_ADMIN',NULL),(12,'256256956956','$2y$15$404de1a4e277a9c58b48ceDZ1.ll02YLh88fIOaPANqaMH4MpIeja','404de1a4e277a9c58b48ce73e29738eb','mort.cruel@gmail.com','ROLE_CUSTOMER','256256956956');
/*!40000 ALTER TABLE `USERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-04 11:03:35
