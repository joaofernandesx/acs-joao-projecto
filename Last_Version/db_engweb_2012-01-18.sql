# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: db_engweb
# Generation Time: 2012-01-18 23:48:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categoriadoc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categoriadoc`;

CREATE TABLE `categoriadoc` (
  `oid` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `categoriadoc` WRITE;
/*!40000 ALTER TABLE `categoriadoc` DISABLE KEYS */;

INSERT INTO `categoriadoc` (`oid`, `descricao`)
VALUES
	(1,'Ciencia'),
	(2,'Arte'),
	(3,'Cultura'),
	(4,'Desporto');

/*!40000 ALTER TABLE `categoriadoc` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table documento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `documento`;

CREATE TABLE `documento` (
  `iddoc` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `datacriacao` date DEFAULT NULL,
  `datamodificacao` date DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `public` bit(1) DEFAULT NULL,
  `categoriadoc_oid` int(11) DEFAULT NULL,
  `user_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddoc`),
  KEY `fk_documento_categoriadoc` (`categoriadoc_oid`),
  KEY `fk_documento_user` (`user_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `documento` WRITE;
/*!40000 ALTER TABLE `documento` DISABLE KEYS */;

INSERT INTO `documento` (`iddoc`, `titulo`, `path_file`, `datacriacao`, `datamodificacao`, `keywords`, `public`, `categoriadoc_oid`, `user_oid`)
VALUES
	(1,'Particula de Deus','particla.pdf',NULL,NULL,'particula',b'0',1,2),
	(4,'teste1','teste.pdf',NULL,NULL,'teste,falcias',b'1',3,1),
	(3,'os sapos','sapos.pdf',NULL,NULL,'sapos',b'0',1,3),
	(5,'Biotecnologia','bio.pdf',NULL,NULL,'biologia,biotecnologia',b'1',1,4),
	(6,'monumentos','monu.pdf',NULL,NULL,'monumentos,portugal',b'1',3,4);

/*!40000 ALTER TABLE `documento` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `oid` int(11) NOT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `module_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `fk_group_module` (`module_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;

INSERT INTO `group` (`oid`, `groupname`, `module_oid`)
VALUES
	(1,'Administrador',1),
	(2,'Utilizador',2);

/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_module`;

CREATE TABLE `group_module` (
  `group_oid` int(11) NOT NULL,
  `module_oid` int(11) NOT NULL,
  PRIMARY KEY (`group_oid`,`module_oid`),
  KEY `fk_group_module_group` (`group_oid`),
  KEY `fk_group_module_module` (`module_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `group_module` WRITE;
/*!40000 ALTER TABLE `group_module` DISABLE KEYS */;

INSERT INTO `group_module` (`group_oid`, `module_oid`)
VALUES
	(1,1),
	(2,2);

/*!40000 ALTER TABLE `group_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `oid` int(11) NOT NULL,
  `moduleid` varchar(255) DEFAULT NULL,
  `modulename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;

INSERT INTO `module` (`oid`, `moduleid`, `modulename`)
VALUES
	(1,'sv3','VistaAdministrador'),
	(2,'sv2','VistaUtilizador'),
	(3,'sv1','VistaPrincipal');

/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `oid` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `group_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `fk_user_group` (`group_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`oid`, `username`, `password`, `email`, `group_oid`)
VALUES
	(1,'admin','admin','joaofernandesx@gmail.com',1),
	(2,'user1','user1','user1@gmail.com',2),
	(3,'user2','user2','user2@gmail.com',2),
	(4,'user3','user3','user3@gmail.com',2);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `user_oid` int(11) NOT NULL,
  `group_oid` int(11) NOT NULL,
  PRIMARY KEY (`user_oid`,`group_oid`),
  KEY `fk_user_group_user` (`user_oid`),
  KEY `fk_user_group_group` (`group_oid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
