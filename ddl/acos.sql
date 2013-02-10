-- MySQL dump 10.13  Distrib 5.5.27, for Linux (x86_64)
--
-- Host: localhost    Database: teslacollection_com
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,104),(2,1,NULL,NULL,'ArticlePages',2,11),(3,2,NULL,NULL,'index',3,4),(4,2,NULL,NULL,'view',5,6),(5,2,NULL,NULL,'view_thumbnail',7,8),(6,2,NULL,NULL,'getAll',9,10),(7,1,NULL,NULL,'Articles',12,19),(8,7,NULL,NULL,'index',13,14),(9,7,NULL,NULL,'search',15,16),(10,7,NULL,NULL,'getAll',17,18),(11,1,NULL,NULL,'Authors',20,25),(12,11,NULL,NULL,'index',21,22),(13,11,NULL,NULL,'getAll',23,24),(14,1,NULL,NULL,'Pages',26,31),(15,14,NULL,NULL,'display',27,28),(16,14,NULL,NULL,'getAll',29,30),(17,1,NULL,NULL,'Publications',32,37),(18,17,NULL,NULL,'index',33,34),(19,17,NULL,NULL,'getAll',35,36),(20,1,NULL,NULL,'Subjects',38,43),(21,20,NULL,NULL,'index',39,40),(22,20,NULL,NULL,'getAll',41,42),(23,1,NULL,NULL,'Users',44,51),(24,23,NULL,NULL,'login',45,46),(25,23,NULL,NULL,'logout',47,48),(26,23,NULL,NULL,'getAll',49,50),(27,1,NULL,NULL,'AclExtras',52,53),(28,1,NULL,NULL,'Admin',54,103),(29,28,NULL,NULL,'Articles',55,62),(30,29,NULL,NULL,'index',56,57),(31,29,NULL,NULL,'search',58,59),(32,29,NULL,NULL,'getAll',60,61),(33,28,NULL,NULL,'Authors',63,68),(34,33,NULL,NULL,'index',64,65),(35,33,NULL,NULL,'getAll',66,67),(36,28,NULL,NULL,'Groups',69,76),(37,36,NULL,NULL,'saveAll',70,71),(38,36,NULL,NULL,'delete',72,73),(39,36,NULL,NULL,'getAll',74,75),(40,28,NULL,NULL,'Pages',77,82),(41,40,NULL,NULL,'display',78,79),(42,40,NULL,NULL,'getAll',80,81),(43,28,NULL,NULL,'Publications',83,88),(44,43,NULL,NULL,'index',84,85),(45,43,NULL,NULL,'getAll',86,87),(46,28,NULL,NULL,'Subjects',89,94),(47,46,NULL,NULL,'index',90,91),(48,46,NULL,NULL,'getAll',92,93),(49,28,NULL,NULL,'Users',95,102),(50,49,NULL,NULL,'login',96,97),(51,49,NULL,NULL,'logout',98,99),(52,49,NULL,NULL,'getAll',100,101);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-10 14:16:46
