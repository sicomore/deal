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
  `dispo` varchar(10) NOT NULL DEFAULT 'active',
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `code_postal` char(5) NOT NULL,
  `membre_id` int(10) unsigned NOT NULL,
  `categorie_id` int(10) unsigned DEFAULT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_annonce_membre_idx` (`membre_id`),
  KEY `fk_annonce_region_idx` (`region_id`),
  KEY `fk_annonce_categorie_idx` (`categorie_id`),
  CONSTRAINT `fk_annonce_membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_annonce_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annonce`
--

LOCK TABLES `annonce` WRITE;
/*!40000 ALTER TABLE `annonce` DISABLE KEYS */;
INSERT INTO `annonce` VALUES (20,'active','Pull élan',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque i','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',55,'26fac6db20dcad22a5b5ed80bb5bda91.jpg','Paris','122-130 Rue de la Convention','75015',4,10,8,'2018-01-11 01:15:30'),(21,'active','Mitaines',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',11,'91c54ef40e95d69b035e0448350ec673.jpg','Paris','95 Avenue Parmentier','75011',4,10,8,'2018-01-23 01:15:47'),(22,'active','Chapeau haut de forme',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',234,'d0bdd79bbb79dcdb94e990be24f819ef.jpg','Chilly-Mazarin','Rue de l\'École','91380',31,11,4,'2018-01-25 23:38:34'),(23,'active','Voiture',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',54300,'980aea52acd392f0543d5b80705d213c.jpg','Bordeaux','38-36 Cours Pasteur','33000',31,6,9,'2018-01-30 23:39:20'),(24,'active','Appartement Grand Luxe',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',1435660,'30f3c9a5a857a72f2d39be7a8f19ad9b.jpg','Nantes','Rue des Hauts Pavés','44000',31,3,7,'2018-02-01 23:40:05'),(26,'active','Télévision HD 4K',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',98,'d23718e7daedad5d0c53d1a66e06fff3.jpg','Marseille','2-12 Boulevard Jeanne d\'Arc','13005',31,7,13,'2018-02-05 00:10:55'),(27,'active','Téléphone ultra-moderne',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',45,'d78b3793db44800aa5ebd3a210b570c1.jpg','Toulouse','2-56 Rue Pierre d\'Aragon','31200',31,7,7,'2018-02-14 10:01:58'),(28,'active','Jupe \"Tube\" rouge',' Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.\n','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',45,'ac788b2c1d23c3e39b110045cd27b25a.jpg','Strasbourg','6a Quai Turckheim','67000',31,4,6,'2018-02-17 21:21:52'),(29,'active','Chapeau de The Mask','Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',567,'0b0630eeeedc5d2ba344303c69c23508.jpg','Toulouse','49-37 Rue de la Sainte-Famille','31200',33,7,11,'2018-02-17 21:30:31'),(30,'active','Superbes gants maculés','Quaeque, ut ea vina, quae vetustatem ferunt, esse debet suavissima; verumque illud est, quod dicitur, multos modios salis simul edendos esse, ut amicitiae munus expletum sit.','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',778,'a126c5bcc405349ac430618ac34ca931.jpg','Caen','12 Rue d\'Hastings','14000',33,9,9,'2018-02-17 21:42:34'),(31,'active','Pantalon vintage','qsbmdf qmosn maozib efmoibegmiebm gfbemoi bgzmiejbfglzi','Pellentesque gravida dui id turpis tincidunt mollis. Nulla facilisi. Etiam quis enim lorem. Duis lobortis diam et dolor accumsan, nec fermentum urna scelerisque. Nulla aliquet tortor sed risus facilisis bibendum. Nulla facilisi. Suspendisse semper rutrum sapien vel cursus. Sed id urna dolor. Cras id ex ac lectus ornare bibendum ac nec enim. Fusce fringilla ornare erat, vitae congue sem consequat vitae. Nullam finibus iaculis sodales. Aliquam interdum interdum tellus sit amet rhoncus. Phasellus sed ante consequat, ornare ex ac, porttitor libero. Suspendisse laoreet metus libero, sit amet vulputate turpis pellentesque vel. ',123,'1feac6958dbc00f7764a0dcdf4230980.jpg','Nimes','1 rue fulton','30000',3,8,11,'2018-03-01 22:32:22');
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
INSERT INTO `categorie` VALUES (1,'Emplois','Offres d\'emploi'),(2,'Immobilier','Ventes, Locations, Colocations, Bureaux, Logement'),(3,'Vacances','Camping, Hotels, Hôtes'),(4,'Multimedia','Jeux vidéos, Informatique, Image, Son, Téléphones'),(5,'Loisirs','Films, Musique, Livres'),(6,'Matériel','Outillage, Fournitures de bureau, Matériel agricole'),(7,'Services','Prestations de services, Événements'),(9,'Maison','Ameublement, Electroménager, Bricolage, Jardinage'),(10,'Vêtements','Jean, Chemise, Robe, Chaussure'),(11,'Autres','Divers et d\'été');
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
  `membre_id` int(10) unsigned DEFAULT NULL,
  `annonce_id` int(10) unsigned NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_commentaire_membre_idx` (`membre_id`),
  KEY `fk_commentaire_annonce_idx` (`annonce_id`),
  CONSTRAINT `fk_commentaire_annonce` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaire_membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
INSERT INTO `commentaire` VALUES (1,'lmjdmq sdfqm sdbf^o^qosbdfmiqsbd mqksn dfpqb s^d fpqisbdf piqjsbdf piqbsdjf',31,27,'2018-02-15 12:17:40'),(2,'q d^s^qpdf^qns dnmqns pdibfqp pmqiosbd fmbqsmdfb qpisubdfqisubdf',31,27,'2018-02-15 12:17:57'),(3,' kqjbs dmfjn msldb^fmqbsmdbfjmqozbe^f qm bdgfqsdmoifb qpsidf',31,22,'2018-02-15 13:13:10'),(4,'ndm lqfn mlqskn ml kqmsldknf mqlksnm djbfmqk jsbdpf',31,22,'2018-02-15 13:13:23'),(20,'je réponds au commentaire',31,27,'2018-02-15 17:20:56'),(21,'mmmmmfmmdmlmdkfmksqjf qslkdmlqkhsdglkhqdljkfghs',4,21,'2018-02-17 20:49:51'),(22,'mmmmmfmmdmlmdkfmksqjf qslkdmlqkhsdglkhqdljkfghs',4,21,'2018-02-17 20:51:35'),(23,'trsè très joli\r\ncommentaire laissé par momo à lolo',33,28,'2018-02-17 21:50:51'),(28,'encore un commentraire laissé par Z 31',31,28,'2018-02-17 22:03:16'),(29,'je relaisse un commentaire',33,28,'2018-02-17 22:29:00'),(30,'azetvarta erth hsfh',33,28,'2018-02-17 22:32:16'),(31,'je suis Z 31 et je réponds au commentaire',31,28,'2018-02-17 22:36:46'),(32,'Trsè beau chapeau',31,29,'2018-02-17 22:59:02'),(33,'tes de réponse au commentaire',33,27,'2018-02-19 23:27:49'),(34,'c\'est vraiment nase comme appart !!!',31,24,'2018-02-24 15:46:52'),(35,'commentaire laissé par lolo 37',37,28,'2018-02-26 01:08:41'),(36,'commentaire de lolo 37',37,29,'2018-02-26 01:17:04'),(37,'commentaire pour l\'annonce de zz de la part de lolo',37,27,'2018-02-26 01:48:51'),(38,'Très vieille TV !!',37,26,'2018-03-04 20:02:47'),(39,'lolo 37 laisse un commentaire sur annonce zz 31',37,23,'2018-03-04 21:47:12'),(40,'MErci pour ce commentaire (laissé par zz)',31,23,'2018-03-04 21:50:05'),(41,'commentaire de zz sur l\'annonce de ZOZO',31,31,'2018-03-04 21:52:17'),(42,'question de lolo pour l\'annonce de zozo',37,31,'2018-03-04 21:58:37'),(43,'question pour momo par lolo',37,30,'2018-03-04 22:00:20'),(44,'question de zz pour l\'annonce2 de momo',31,30,'2018-03-04 22:07:51'),(205,'mhqsld foalizbefolazhbeflqizbe flbez flqzjbe flqsjbdflqjsdbf',31,31,'2018-03-10 01:41:54'),(206,'45453452345 mlqksjdf mqlskj',31,31,'2018-03-10 01:43:30'),(207,'commentaire de lolo pour l\'annonce de ZOZO',37,31,'2018-03-10 22:18:28'),(208,'Je suis momo et je réponds au commentaire de lolo',33,29,'2018-03-11 02:23:36'),(209,'tentative comment ajax',31,27,'2018-03-11 04:01:43'),(210,'tentaive encore jaax',31,28,'2018-03-11 05:05:13'),(211,'réponse',31,26,'2018-03-11 07:11:21'),(212,'Soleo saepe ante oculos ponere, idque libenter crebris usurpare sermonibus, omnis nostrorum imperatorum, omnis exterarum gentium potentissimorumque populorum,',4,26,'2018-03-11 10:12:21'),(213,'omnis clarissimorum regum res gestas, cum tuis nec contentionum magnitudine nec',33,26,'2018-03-11 11:12:21'),(214,'vero disiunctissimas terras citius passibus cuiusquam potuisse peragrari, quam tuis',37,28,'2018-03-11 12:22:21'),(215,'magnitudine nec numero proeliorum nec varietate regionum nec celeritate',9,27,'2018-03-11 12:25:21'),(216,'nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper',15,28,'2018-03-11 12:28:21'),(217,'Sed fruatur sane hoc solacio atque hanc insignem ignominiam, quoniam uni praeter se inusta sit, putet esse leviorem, dum',36,27,'2018-03-11 12:30:21'),(218,'Novitates autem si spem adferunt, ut tamquam in herbis non fallacibus fructus appareat, non sunt illae quidem repudiandae, vetustas tamen suo loco conservanda;',44,20,'2018-03-11 12:34:21'),(219,'animal, sed in iis etiam quae sunt inanima, consuetudo valet, cum locis ipsis delectemur',36,30,'2018-03-11 12:35:21');
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre`
--

LOCK TABLES `membre` WRITE;
/*!40000 ALTER TABLE `membre` DISABLE KEYS */;
INSERT INTO `membre` VALUES (3,'M.','zozo','$2y$10$hYt8xcR5f0cX.WkDaGRyYecr6CdGodyZxVCtAKV/GYXwrFmMglrh.','Zoletane','Zorba','123423452','gfzegrz@gsegze.gt','user','2018-02-09 11:28:59'),(4,'Mme','jojo','$2y$10$PtKFCXM4s0.6OUHa/kC0xOIcJxI4UyjPn1hP69AahzSwW3j/mDL8m','Guiliguili','Josiane','2232 554','rezaraze@qsdfqsdf.fr','user','2018-02-09 11:37:30'),(9,'M.','zaza','$2y$10$zAJNtmHkMT5Oe1/o3Y/KVuvhXrUJMhWHWVc0HNQQ4QhLO7kKBEU1K','zaza','zaza','61546441325','zaza@zaza.com','user','2018-02-13 09:55:17'),(15,'M.','Minou','$2y$10$MS4jCmANFkcnB8FKQDzIwujwoQVQYbhIbmYJzNkl/OrNmcGyLkKM.','Mimonpulalenver','Roger','73278563','bzyz@gsdfgdsf.gdf','admin','2018-02-13 16:26:54'),(16,'M.','mister','$2y$10$squNP9bXAPKWhOlu/MiW..i0w1CxClVkCOiu8jtGFmXM8eBWd5/Uq','Karambar','Lolotte','7567863','ZZZZZZZZzes@drfgszdrfghs.gt','admin','2018-02-13 16:46:14'),(31,'Mme','zz','$2y$10$YBhADLrfQtpcKHQkp4BloOTpnaKSJC8Xwp3MyrQ1HIDezMHlW6AP.','Zimbous','Zaz','35435','dfkqdhfjs@qdsfqsd.fr','admin','2018-02-14 11:48:54'),(33,'Mme','momo','$2y$10$dDykJHWrGkm8oM3VOFAeI.yqL8e38SbkAiU4InGVkrWAA41tZnvo.','Mobilut','Monique','2345234652','qsmdofqsdf@sdgszgzer.ki','user','2018-02-17 18:08:33'),(36,'Mme','yplus','$2y$10$WvCPWw2JktpRumxAVoxVreinxCJC.44RMzoCY7gaLLcS.9Wn7/NsK','Plusqueterrible','Yvan','12341234','dgsergs@zegzsg.ghy','user','2018-02-20 22:11:21'),(37,'Mme','lolo','$2y$10$PgAy7BdQlhqPebMgFAiCvumnojczAGhXMav/s49xvJerFLEeqb/r2','Lobart','Laurence','123412345','qsdfqsdgf@dgqsdfg.gt','admin','2018-02-20 22:48:08'),(38,'Mme','Chka','$2y$10$BjtDKBmu3a50KWrFkw6tNukvTmsEHgjRHto8BIQRunYvFG1K5p.wy','Dede','Baba','1342345325','dedebaba@chka.com','user','2018-02-24 15:44:08'),(44,'Mme','hihi','$2y$10$4yGog/ghCqFQyGY1I48Q3.qwkhoTh.wspWufSP3YL32Je.d/W9aTq','Hilary','Hilton','12341234','qsdf@qsdfqsdf.fr','user','2018-03-08 00:31:41');
/*!40000 ALTER TABLE `membre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `civilite` enum('M.','Mme') NOT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `nom` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `sujet` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,'M.','Oliko','Zouzou','qsldkfjhq@qdsfqqsd.hy','Demande de remb','mlqksdjf^qsh  pqosihd fpqihs  fpqishd pfq sbdfbqpsd fbqmbkmk qbsldfb qlbsdmfbqmsdkbfqlkjbsdf','2018-03-08 19:31:38'),(2,'M.','Jean','Dubois','qsdfqsdf@sqsdfq.lo','Demande renseignements','qsmdkljm mqnmkh  qs mfonqps dbfp qsdpof qoms dfq smdhfmazbepif','2018-03-10 20:41:26'),(19,'M.','Jean','Dubois','qsdfqsdf@sqsdfq.lo','Demande renseignements','qsmdkljm mqnmkh  qs mfonqps dbfp qsdpof qoms dfq smdhfmazbepif','2018-03-10 21:28:58'),(20,'M.','Jean','Dubois','qsdfqsdf@sqsdfq.lo','Demande renseignements','qsmdkljm mqnmkh  qs mfonqps dbfp qsdpof qoms dfq smdhfmazbepif','2018-03-10 21:32:41'),(21,'M.','Jean','Dubois','qsdfqsdf@sqsdfq.lo','Demande renseignements','qsmdkljm mqnmkh  qs mfonqps dbfp qsdpof qoms dfq smdhfmazbepif','2018-03-10 21:32:49');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
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
  `membre_id1` int(10) unsigned DEFAULT NULL,
  `membre_id2` int(10) unsigned DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_note_membre1_idx` (`membre_id1`),
  KEY `fk_note_membre2_idx` (`membre_id2`),
  CONSTRAINT `fk_notes_membre2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (3,4,'qsvbqdfgqe a ergzerg',31,4,'2018-02-17 21:04:02'),(4,1,'gsdgsfgherth',33,31,'2018-02-18 18:09:01'),(11,4,'turtyurtyurtyu',33,4,'2018-02-18 19:33:52'),(12,5,'jjjksqjdflqksdjlfqjk',3,4,'2018-02-19 19:35:34'),(13,5,'ppppsdofodpp qmosdufpoqshdp fqs',4,31,'2018-02-20 19:38:09'),(14,5,'ooooooooooooooooo',9,31,'2018-02-20 19:45:52'),(15,4,'ppppppppppp',8,31,'2018-02-20 19:48:52'),(16,3,'Pas mal',31,33,'2018-02-20 22:59:12'),(17,2,'c\'est nul !',38,31,'2018-02-21 15:46:52'),(18,2,'sqdmlj osdhfp iqbsifd qib sbfdiubq',4,15,'2018-02-21 22:59:12'),(19,4,'opjspod hpqisupifugqs idgfb iuqbsd if',3,9,'2018-02-22 12:59:12'),(20,5,'hsoopaihep pihpaoinpo afpiejgfeogrhp eiug',9,15,'2018-02-22 20:59:12'),(21,3,'moihiph napzpeifhazp ifpaizubhf',31,15,'2018-02-22 22:59:12'),(22,1,'jhdpoihazpoij^ pohp qsihpziho epfoa if',33,37,'2018-02-23 01:59:12'),(24,5,'iqdosihp ihpaziehfpaz ôfahipihaqpi',8,37,'2018-02-23 22:09:12'),(25,3,'uihze paizhp oaizhpef apiubef',16,15,'2018-02-23 22:34:12'),(26,2,'zer azeraztz zer zertzeryzertyzetvdfvsd ',3,16,'2018-02-25 08:59:54'),(27,1,'fqs qsdg erze hztrhz',15,3,'2018-02-25 09:32:34'),(28,5,'avis de zz sur zozo',31,3,'2018-03-10 00:06:13'),(29,3,'JE laisse un avis en tant que lolo',37,3,'2018-03-10 23:10:50');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagination`
--

DROP TABLE IF EXISTS `pagination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagination` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `items` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagination`
--

LOCK TABLES `pagination` WRITE;
/*!40000 ALTER TABLE `pagination` DISABLE KEYS */;
INSERT INTO `pagination` VALUES (1,'1'),(2,'2'),(3,'3'),(4,'4'),(5,'5'),(6,'6'),(7,'7'),(8,'8'),(9,'9'),(10,'10'),(11,'11'),(12,'12'),(13,'13'),(14,'14'),(15,'15'),(16,'16'),(17,'17'),(18,'18'),(19,'19'),(20,'20');
/*!40000 ALTER TABLE `pagination` ENABLE KEYS */;
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

--
-- Table structure for table `tri`
--

DROP TABLE IF EXISTS `tri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tri` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tri` varchar(45) NOT NULL,
  `options` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tri`
--

LOCK TABLES `tri` WRITE;
/*!40000 ALTER TABLE `tri` DISABLE KEYS */;
INSERT INTO `tri` VALUES (1,'a.id desc','les plus récentes'),(2,'a.id','les plus anciennes'),(3,'c.titre','catégories croissantes'),(4,'c.titre desc','catégories décroissantes'),(5,'a.prix','prix croissants'),(6,'a.prix desc','prix décroissants');
/*!40000 ALTER TABLE `tri` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-11 16:41:51
