-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: deal
-- ------------------------------------------------------
-- Server version	5.6.35

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
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `note` int(1) DEFAULT NULL,
  `avis` text,
  `membre_id1` int(10) unsigned NOT NULL,
  `membre_id2` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_note_membre1_idx` (`membre_id1`),
  KEY `fk_note_membre2_idx` (`membre_id2`),
  CONSTRAINT `fk_notes_membre1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_notes_membre2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,3,'smdflkq qsmldjkflm mlqsjdfm lqhksdfmlqks',6,8,'2018-02-03 23:32:23'),(2,4,'',17,17,'2018-02-17 17:22:04'),(3,4,'qsvbqdfgqe a ergzerg',17,4,'2018-02-17 21:04:02'),(4,0,'gsdgsfgherth',33,17,'2018-02-17 18:09:01'),(11,4,'turtyurtyurtyu',33,4,'2018-02-17 19:33:52'),(12,5,'jjjksqjdflqksdjlfqjk',3,17,'2018-02-17 19:35:34'),(13,5,'ppppsdofodpp qmosdufpoqshdp fqs',4,17,'2018-02-17 19:38:09'),(14,5,'ooooooooooooooooo',6,17,'2018-02-17 19:45:52'),(15,4,'ppppppppppp',8,17,'2018-02-17 19:48:52'),(16,3,'Pas mal',17,33,'2018-02-17 22:59:12');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Auvergne-Rhône-Alpes'),(2,'Bourgogne-Franche-Comte'),(3,'Bretagne'),(4,'Centre-Val de Loire'),(5,'Corse'),(6,'Grand Est'),(7,'Hauts-de-France'),(8,'Ile-de-France'),(9,'Normandie'),(10,'Nouvelle-Aquitaine'),(11,'Occitanie'),(12,'Pays de la Loire'),(13,'Provence-Alpes-Côte d\'Azur');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-18 21:43:11
