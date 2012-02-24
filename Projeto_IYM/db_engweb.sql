-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2012 at 07:06 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_engweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoriadoc`
--

CREATE TABLE IF NOT EXISTS `categoriadoc` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categoriadoc`
--

INSERT INTO `categoriadoc` (`oid`, `descricao`) VALUES
(1, 'SI'),
(2, 'ACS'),
(3, 'LEI'),
(10, 'Futebol');

-- --------------------------------------------------------

--
-- Table structure for table `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
  `iddoc` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `datacriacao` datetime DEFAULT NULL,
  `datamodificacao` datetime DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `public` bit(1) DEFAULT NULL,
  `categoriadoc_oid` int(11) DEFAULT NULL,
  `user_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddoc`),
  KEY `fk_documento_categoriadoc` (`categoriadoc_oid`),
  KEY `fk_documento_user` (`user_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `documento`
--

INSERT INTO `documento` (`iddoc`, `titulo`, `path_file`, `datacriacao`, `datamodificacao`, `keywords`, `public`, `categoriadoc_oid`, `user_oid`) VALUES
(63, 'Bases de dados, Aprendizagem e Extracção de Conhecimento', 'documentos/DOC63_USER1.html', '2012-02-23 14:12:50', '2012-02-23 16:27:05', 'extracção de conhecimento', '1', 1, 1),
(64, 'Multi-agent programming - Electronic Market 1st Assignment - Gaia Methodology: Analysis and Design', 'documentos/DOC64_USER1.html', '2012-02-23 14:21:39', '2012-02-23 16:27:18', 'sistemas multi agentes metodologia gaia', '1', 1, 1),
(65, 'Trabalho prático nº2 (YACC) - Processamento de linguagens', 'documentos/DOC65_USER12.html', '2012-02-23 14:26:30', '2012-02-23 18:42:03', 'yacc logoliss flex', NULL, 3, 12),
(66, 'Extensão à Programação em Lógica e Conhecimento Imperfeito  2º Segmento', 'documentos/DOC66_USER12.html', '2012-02-23 14:29:00', '2012-02-23 18:48:49', 'Sistemas de Representação de Conhecimento e Raciocínio', '0', 3, 12),
(67, 'Ordem da jarreteira', 'documentos/DOC67_USER12.html', '2012-02-23 16:31:12', '2012-02-23 18:05:42', 'ordem jarreteira', '1', 3, 12),
(74, 'Futebol Clube do Porto', 'documentos/DOC68_USER13.html', '2012-02-23 18:09:48', '2012-02-23 18:09:48', 'Futebol Clube do Porto pinto da costa vitor pereira', NULL, 10, 13);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(255) DEFAULT NULL,
  `module_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `fk_group_module` (`module_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`oid`, `groupname`, `module_oid`) VALUES
(1, 'Administrador', NULL),
(2, 'Utilizador', NULL),
(3, 'Bloqueado', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_module`
--

CREATE TABLE IF NOT EXISTS `group_module` (
  `group_oid` int(11) NOT NULL,
  `module_oid` int(11) NOT NULL,
  PRIMARY KEY (`group_oid`,`module_oid`),
  KEY `fk_group_module_group` (`group_oid`),
  KEY `fk_group_module_module` (`module_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `oid` int(11) NOT NULL,
  `moduleid` varchar(255) DEFAULT NULL,
  `modulename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `group_oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `fk_user_group` (`group_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`oid`, `username`, `password`, `email`, `group_oid`) VALUES
(1, 'joaol', 'joaol', 'john1338@gmail.com', 1),
(12, 'joaofernandesx', 'sapinhos', 'joaofernandesx@gmail.com', 2),
(13, 'luisRosa', 'luisRosa', 'luisalerta@hotmail.com', 2),
(14, 'drhouse', 'drhouse', 'house@MD.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_oid` int(11) NOT NULL,
  `group_oid` int(11) NOT NULL,
  PRIMARY KEY (`user_oid`,`group_oid`),
  KEY `fk_user_group_user` (`user_oid`),
  KEY `fk_user_group_group` (`group_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `fk_documento_categoriadoc` FOREIGN KEY (`categoriadoc_oid`) REFERENCES `categoriadoc` (`oid`),
  ADD CONSTRAINT `fk_documento_user` FOREIGN KEY (`user_oid`) REFERENCES `user` (`oid`);

--
-- Constraints for table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `fk_group_module` FOREIGN KEY (`module_oid`) REFERENCES `module` (`oid`);

--
-- Constraints for table `group_module`
--
ALTER TABLE `group_module`
  ADD CONSTRAINT `fk_group_module_group` FOREIGN KEY (`group_oid`) REFERENCES `group` (`oid`),
  ADD CONSTRAINT `fk_group_module_module` FOREIGN KEY (`module_oid`) REFERENCES `module` (`oid`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_group` FOREIGN KEY (`group_oid`) REFERENCES `group` (`oid`);

--
-- Constraints for table `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_user_group_group` FOREIGN KEY (`group_oid`) REFERENCES `group` (`oid`),
  ADD CONSTRAINT `fk_user_group_user` FOREIGN KEY (`user_oid`) REFERENCES `user` (`oid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
