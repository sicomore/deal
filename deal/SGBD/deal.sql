CREATE DATABASE  IF NOT EXISTS `deal` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `deal`;
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
-- Table structure for table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annonce` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `code_postal` char(5) NOT NULL,
  `membre_id` int(10) unsigned NOT NULL,
  `categorie_id` int(10) unsigned NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_annonce_membre_idx` (`membre_id`),
  KEY `fk_annonce_categorie_idx` (`categorie_id`),
  KEY `fk_annonce_region_idx` (`region_id`),
  CONSTRAINT `fk_annonce_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_annonce_membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_annonce_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annonce`
--

LOCK TABLES `annonce` WRITE;
/*!40000 ALTER TABLE `annonce` DISABLE KEYS */;
INSERT INTO `annonce` VALUES (20,'Pull élan','u§uèir  ruktikltui;ruyestrjy zs','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',55,'26fac6db20dcad22a5b5ed80bb5bda91.jpg','Paris','122-130 Rue de la Convention','75015',4,10,8,'2018-01-11 01:15:30'),(21,'Mitaines','u§uèir  ruktikltui;ruyestrjy zs','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',11,'91c54ef40e95d69b035e0448350ec673.jpg','Paris','95 Avenue Parmentier','75011',4,10,8,'2018-01-23 01:15:47'),(22,'CHapeau','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',234,'d0bdd79bbb79dcdb94e990be24f819ef.jpg','Chilly-Mazarin','Rue de l\'École','91380',17,11,4,'2018-01-25 23:38:34'),(23,'Voiture','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',54300,'980aea52acd392f0543d5b80705d213c.jpg','Bordeaux','38-36 Cours Pasteur','33000',17,6,9,'2018-01-30 23:39:20'),(24,'Appartement','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',1435660,'30f3c9a5a857a72f2d39be7a8f19ad9b.jpg','Nantes','Rue des Hauts Pavés','44000',17,3,7,'2018-02-01 23:40:05'),(26,'Télévision','rtrzet e rtzert','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',98,'d23718e7daedad5d0c53d1a66e06fff3.jpg','Marseille','2-12 Boulevard Jeanne d\'Arc','13005',17,7,13,'2018-02-05 00:10:55'),(27,'Téléphone','essai','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',45,'d78b3793db44800aa5ebd3a210b570c1.jpg','Toulouse','2-56 Rue Pierre d\'Aragon','31200',17,7,7,'2018-02-14 10:01:58'),(28,'annonce laissé par lolo 17','qsmldf qùsd^foiqghsd ^gioqsmfô','mq sdfôqbsdmiofq^osdfoqsdgqomishd fhazeôifaoiehgmqfgmoi',45,'ac788b2c1d23c3e39b110045cd27b25a.jpg','Strasbourg','6a Quai Turckheim','67000',17,4,6,'2018-02-17 21:21:52'),(29,'annonce laissée par momo 33','dqsf qhsg','sd fheth,yetyjeytrj etyj  z rjzr jzyrtj zyj zryj zrth sz',567,'0b0630eeeedc5d2ba344303c69c23508.jpg','Toulouse','49-37 Rue de la Sainte-Famille','31200',33,7,11,'2018-02-17 21:30:31'),(30,'annonce2 laissée par momo','dlfkldskmfkqsmldkfmqlskml','mqlskhd qsopdighqosihgp oqmihae piu',778,'a126c5bcc405349ac430618ac34ca931.jpg','Caen','12 Rue d\'Hastings','14000',33,9,9,'2018-02-17 21:42:34');
/*!40000 ALTER TABLE `annonce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `mots_cles` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Emplois','Offres d\'emploi'),(2,'Véhicules','Voitures, Motos, Bateaux, Vélos, Équipement'),(3,'Immobilier','Ventes, Locations, Colocations, Bureaux, Logement'),(4,'Vacances','Camping, Hotels, Hôtes'),(5,'Multimedia','Jeux vidéos, Informatique, Image, Son, Téléphones'),(6,'Loisirs','Films, Musique, Livres'),(7,'Matériel','Outillage, Fournitures de bureau, Matériel agricole'),(8,'Services','Prestations de services, Événements'),(9,'Maison','Ameublement, Electroménager, Bricolage, Jardinage'),(10,'Vêtements','Jean, Chemise, Robe, Chaussure'),(11,'Autres','Divers et d\'été');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commentaire` text NOT NULL,
  `membre_id` int(10) unsigned NOT NULL,
  `annonce_id` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_commentaire_membre_idx` (`membre_id`),
  KEY `fk_commentaire_annonce_idx` (`annonce_id`),
  CONSTRAINT `fk_commentaire_annonce` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaire_membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
INSERT INTO `commentaire` VALUES (1,'rrrrrrr',17,27,'2018-02-15 12:17:40'),(2,'h !è(!çmy !udeutkd',17,27,'2018-02-15 12:17:57'),(3,'test commentaire',17,22,'2018-02-15 13:13:10'),(4,'dmlfkghmq mqohds gpoamg',17,22,'2018-02-15 13:13:23'),(20,'commentaire de id 17 lolo',17,27,'2018-02-15 17:20:56'),(21,'mmmmmfmmdmlmdkfmksqjf qslkdmlqkhsdglkhqdljkfghs',4,21,'2018-02-17 20:49:51'),(22,'mmmmmfmmdmlmdkfmksqjf qslkdmlqkhsdglkhqdljkfghs',4,21,'2018-02-17 20:51:35'),(23,'trsè très joli\r\ncommentaire laissé par momo à lolo',33,28,'2018-02-17 21:50:51'),(28,'encore un commentraire ',33,28,'2018-02-17 22:03:16'),(29,'je relaisse un commentaire',33,28,'2018-02-17 22:29:00'),(30,'azetvarta erth hsfh',33,28,'2018-02-17 22:32:16'),(31,'je suis lolo et je réponds au commentaire',17,28,'2018-02-17 22:36:46'),(32,'Trsè beau chapeau',17,29,'2018-02-17 22:59:02');
/*!40000 ALTER TABLE `commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membre`
--

DROP TABLE IF EXISTS `membre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membre` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `civilite` enum('M.','Mme') NOT NULL,
  `pseudo` varchar(45) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo_UNIQUE` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre`
--

LOCK TABLES `membre` WRITE;
/*!40000 ALTER TABLE `membre` DISABLE KEYS */;
INSERT INTO `membre` VALUES (3,'Mme','zozo','$2y$10$liB5bg/87nxSQR3zjGS.HuGy6vcTww3SuG/rdPrpOltAg5kPUHAgm','zozo','rrrrrrr','615 46 441325','zozo@zaza.com','user','2018-02-09 11:28:59'),(4,'M.','tttttt','$2y$10$ZcBhVA3wcYsop2I2si8XDu4crBEolduLNVZxi6uuS0jDWhzfWCTn2','ttttttt','mlkjkljm lkjghljg','2232554','rezaraze@qsdfqsdf.fr','admin','2018-02-09 11:37:30'),(6,'Mme','qqqqqqqqqqqq','$2y$10$JfGHaNyO00vOhhjJtgoI2u7BgB/N0euD4gsnnBU03UfF.qNTKv/9.','q q  q q q q  q','ooooooooo','611325','dfdfdfdfdfd@zaza.com','admin','2018-02-09 19:18:51'),(8,'M.','azerazer','$2y$10$p3GIAX.vSj/tdGu9BX6n.O124gFhwGYvpYVdcUViUveAvZHT7m2/O','azer','uuiopuoipuio','6441325','azer@azer.com','user','2018-02-13 09:49:51'),(9,'M.','zaza','$2y$10$zAJNtmHkMT5Oe1/o3Y/KVuvhXrUJMhWHWVc0HNQQ4QhLO7kKBEU1K','zaza','zaza','61546441325','zaza@zaza.com','admin','2018-02-13 09:55:17'),(15,'M.','v\'areybrtyazqn(\"','$2y$10$MS4jCmANFkcnB8FKQDzIwujwoQVQYbhIbmYJzNkl/OrNmcGyLkKM.','(\'b-z(\'yz(\'-è\"z(\'','\'(byè(\"_u\'n-èi','73278563','bzyz@gsdfgdsf.gdf','admin','2018-02-13 16:26:54'),(16,'M.','mister','$2y$10$squNP9bXAPKWhOlu/MiW..i0w1CxClVkCOiu8jtGFmXM8eBWd5/Uq','nggsdsdgsgsdfg','vvgzerghzhz  zh zh','7567863','edrgzes@drfgszdrfghs.gt','user','2018-02-13 16:46:14'),(17,'M.','lolo','$2y$10$FgXiElXI3IJe9ymJZdfIaur1C..k2Ed1jel384.LOPa/TzgYvzw6q','lolo','lolo','2534543654','kqsjhflkqs@jqhsldkfhjlqjs.fr','admin','2018-02-13 16:54:03'),(31,'Mme','z','$2y$10$c3lVclEwJbNQwChThYcrKeznowTttx4So3I6poQZ7VqysWflkfbpG','z','z','35435','dfkqdhfjs@qdsfqsd.fr','admin','2018-02-14 11:48:54'),(32,'Mme','zz','$2y$10$V6hOzWQ6Z8qlB6VlY1vaN.dUaLNzM.blqk0/vg8KI4zQL3SjmK3Oy','z','z','35454','dfsgsdfg@dfgsdfg.ggt','admin','2018-02-14 11:51:14'),(33,'Mme','momo','$2y$10$fQ9Cgk1R8i/kQOctPuVKOeaOin7QTzYEvE9..4VQiFTP/XO0rDJSi','momo','momo','21342345435','qsdfgqs@qsdgfqsdf.fr','user','2018-02-17 18:08:33');
/*!40000 ALTER TABLE `membre` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2018-02-18 21:54:05
