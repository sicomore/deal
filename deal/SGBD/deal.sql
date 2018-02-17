GRANT ALL PRIVILEGES ON *.* TO 'qnu76381'@'qnu76381' IDENTIFIED BY PASSWORD '*279CB7BA56F8E95C14FC1E1A5B5A6BB129F270D3' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `qnu76381\_%`.* TO 'qnu76381'@'qnu76381';

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annonce`
--

LOCK TABLES `annonce` WRITE;
/*!40000 ALTER TABLE `annonce` DISABLE KEYS */;
INSERT INTO `annonce` VALUES (20,'Pull élan','u§uèir  ruktikltui;ruyestrjy zs','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',55,'26fac6db20dcad22a5b5ed80bb5bda91.jpg','Paris','122-130 Rue de la Convention','75015',4,10,8,'2018-01-11 01:15:30'),(21,'Mitaines','u§uèir  ruktikltui;ruyestrjy zs','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',11,'91c54ef40e95d69b035e0448350ec673.jpg','Paris','95 Avenue Parmentier','75011',4,10,8,'2018-01-23 01:15:47'),(22,'CHapeau','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',234,'d0bdd79bbb79dcdb94e990be24f819ef.jpg','Chilly-Mazarin','Rue de l\'École','91380',17,11,4,'2018-01-25 23:38:34'),(23,'Voiture','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',54300,'980aea52acd392f0543d5b80705d213c.jpg','Bordeaux','38-36 Cours Pasteur','33000',17,6,9,'2018-01-30 23:39:20'),(24,'Appartement','ezrt e rtzertzertzrtz','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',1435660,'30f3c9a5a857a72f2d39be7a8f19ad9b.jpg','Nantes','Rue des Hauts Pavés','44000',17,3,7,'2018-02-01 23:40:05'),(26,'Télévision','rtrzet e rtzert','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',98,'d23718e7daedad5d0c53d1a66e06fff3.jpg','Marseille','2-12 Boulevard Jeanne d\'Arc','13005',17,7,13,'2018-02-05 00:10:55'),(27,'Téléphone','essai','Exsistit autem hoc loco quaedam quaestio subdifficilis, num quando amici novi, digni amicitia, veteribus sint anteponendi, ut equis vetulis teneros anteponere solemus. Indigna homine dubitatio! Non enim debent esse amicitiarum sicut aliarum rerum satietates; veterrima quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.',45,'d78b3793db44800aa5ebd3a210b570c1.jpg','Toulouse','2-56 Rue Pierre d\'Aragon','31200',17,7,7,'2018-02-14 10:01:58');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
INSERT INTO `commentaire` VALUES (1,'',17,27,'2018-02-15 12:17:40'),(2,'',17,27,'2018-02-15 12:17:57'),(3,'test commentaire',17,22,'2018-02-15 13:13:10'),(4,'test commentaire',17,22,'2018-02-15 13:13:23'),(5,'test commentaire',17,22,'2018-02-15 13:13:46'),(6,'test commentaire',17,22,'2018-02-15 13:13:57'),(7,'test commentaire',17,22,'2018-02-15 14:33:05'),(8,'test commentaire',17,22,'2018-02-15 14:33:57'),(9,'test commentaire',17,22,'2018-02-15 14:34:30'),(10,'test commentaire',17,22,'2018-02-15 14:34:56'),(11,'test commentaire',17,22,'2018-02-15 14:35:36'),(12,'test commentaire',17,22,'2018-02-15 14:36:56'),(13,'test commentaire',17,22,'2018-02-15 14:38:31'),(14,'test commentaire',17,22,'2018-02-15 14:54:04'),(15,'test commentaire',17,22,'2018-02-15 14:54:47'),(16,'test commentaire',17,22,'2018-02-15 14:56:46'),(17,'test commentaire',17,22,'2018-02-15 14:56:57'),(18,'test commentaire',17,22,'2018-02-15 16:08:59'),(19,'test commentaire',17,22,'2018-02-15 16:13:37'),(20,'commentaire de id 17 lolo',17,27,'2018-02-15 17:20:56');
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre`
--

LOCK TABLES `membre` WRITE;
/*!40000 ALTER TABLE `membre` DISABLE KEYS */;
INSERT INTO `membre` VALUES (3,'Mme','zozo','$2y$10$liB5bg/87nxSQR3zjGS.HuGy6vcTww3SuG/rdPrpOltAg5kPUHAgm','zozo','rrrrrrr','615 46 441325','zozo@zaza.com','user','2018-02-09 11:28:59'),(4,'M.','tttttt','$2y$10$ZcBhVA3wcYsop2I2si8XDu4crBEolduLNVZxi6uuS0jDWhzfWCTn2','ttttttt','mlkjkljm lkjghljg','2232554','rezaraze@qsdfqsdf.fr','admin','2018-02-09 11:37:30'),(6,'Mme','qqqqqqqqqqqq','$2y$10$JfGHaNyO00vOhhjJtgoI2u7BgB/N0euD4gsnnBU03UfF.qNTKv/9.','q q  q q q q  q','ooooooooo','611325','dfdfdfdfdfd@zaza.com','admin','2018-02-09 19:18:51'),(8,'M.','azerazer','$2y$10$p3GIAX.vSj/tdGu9BX6n.O124gFhwGYvpYVdcUViUveAvZHT7m2/O','azer','uuiopuoipuio','6441325','azer@azer.com','user','2018-02-13 09:49:51'),(9,'M.','zaza','$2y$10$zAJNtmHkMT5Oe1/o3Y/KVuvhXrUJMhWHWVc0HNQQ4QhLO7kKBEU1K','zaza','zaza','61546441325','zaza@zaza.com','admin','2018-02-13 09:55:17'),(15,'M.','v\'areybrtyazqn(\"','$2y$10$MS4jCmANFkcnB8FKQDzIwujwoQVQYbhIbmYJzNkl/OrNmcGyLkKM.','(\'b-z(\'yz(\'-è\"z(\'','\'(byè(\"_u\'n-èi','73278563','bzyz@gsdfgdsf.gdf','admin','2018-02-13 16:26:54'),(16,'M.','mister','$2y$10$squNP9bXAPKWhOlu/MiW..i0w1CxClVkCOiu8jtGFmXM8eBWd5/Uq','nggsdsdgsgsdfg','vvgzerghzhz  zh zh','7567863','edrgzes@drfgszdrfghs.gt','user','2018-02-13 16:46:14'),(17,'M.','lolo','$2y$10$FgXiElXI3IJe9ymJZdfIaur1C..k2Ed1jel384.LOPa/TzgYvzw6q','lolo','lolo','2534543654','kqsjhflkqs@jqhsldkfhjlqjs.fr','admin','2018-02-13 16:54:03'),(31,'Mme','z','$2y$10$c3lVclEwJbNQwChThYcrKeznowTttx4So3I6poQZ7VqysWflkfbpG','z','z','35435','dfkqdhfjs@qdsfqsd.fr','admin','2018-02-14 11:48:54'),(32,'Mme','zz','$2y$10$V6hOzWQ6Z8qlB6VlY1vaN.dUaLNzM.blqk0/vg8KI4zQL3SjmK3Oy','z','z','35454','dfsgsdfg@dfgsdfg.ggt','admin','2018-02-14 11:51:14');
/*!40000 ALTER TABLE `membre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `note` int(3) NOT NULL,
  `avis` text,
  `membre_id1` int(10) unsigned NOT NULL,
  `membre_id2` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_note_membre1_idx` (`membre_id1`),
  KEY `fk_note_membre2_idx` (`membre_id2`),
  CONSTRAINT `fk_note_membre1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_note_membre2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES (1,3,'smdflkq qsmldjkflm mlqsjdfm lqhksdfmlqks',6,8,'2018-02-03 23:32:23');
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
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

-- Dump completed on 2018-02-17 13:35:22
