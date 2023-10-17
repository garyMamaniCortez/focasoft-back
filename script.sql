-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: focasoft
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.22.04.1

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
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `fecha_ini` date NOT NULL,
  `tipo` enum('reclutamiento','taller_de_entrenamiento','competencia_de_entrenamiento','clasificatorio_interno','competencia') NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `afiche` mediumblob,
  `id_formulario` int DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` date DEFAULT NULL,
  `requisitos` varchar(1000) DEFAULT NULL,
  `premios` varchar(1000) DEFAULT NULL,
  `patrocinadores` varchar(1000) DEFAULT NULL,
  `contactos` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_formulario` (`id_formulario`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,'Título del evento','2023-08-05','taller_de_entrenamiento','Descripción del evento',NULL,NULL,'2023-10-12 09:23:03','2023-10-12 09:23:03',NULL,NULL,NULL,NULL,NULL),(2,'Evento competitivo','2023-04-05','taller_de_entrenamiento','Descripción del evento a toda madre',NULL,NULL,'2023-10-12 09:23:03','2023-10-12 09:23:03',NULL,NULL,NULL,NULL,NULL),(3,'Evento a toda leche de programacion','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,1,'2023-10-16 00:15:16','2023-10-12 13:26:41',NULL,'Ser la ostia',NULL,NULL,NULL),(4,'Evento a toda madre de programacion','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,NULL,'2023-10-16 00:11:07','2023-10-16 00:11:07',NULL,NULL,NULL,NULL,NULL),(5,'Evento a toda madre de programacionn','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,NULL,'2023-10-16 23:03:44','2023-10-16 23:03:44',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulario`
--

DROP TABLE IF EXISTS `formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` tinyint(1) NOT NULL,
  `apellidos` tinyint(1) NOT NULL,
  `fecha_nacimiento` tinyint(1) NOT NULL,
  `correo_electronico` tinyint(1) NOT NULL,
  `numero_celular` tinyint(1) NOT NULL,
  `carrera` tinyint(1) DEFAULT NULL,
  `talla_polera` tinyint(1) DEFAULT NULL,
  `carnet_identidad` tinyint(1) DEFAULT NULL,
  `codigo_sis_o_institucion` tinyint(1) DEFAULT NULL,
  `semestre` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario`
--

LOCK TABLES `formulario` WRITE;
/*!40000 ALTER TABLE `formulario` DISABLE KEYS */;
INSERT INTO `formulario` VALUES (1,1,1,1,1,1,1,1,1,1,1,'2023-10-12 16:43:14','2023-10-12 12:04:11'),(2,1,1,1,1,1,1,0,0,1,1,'2023-10-12 16:22:43','2023-10-12 16:22:43'),(3,1,1,1,1,1,0,0,0,0,0,'2023-10-12 16:39:05','2023-10-12 16:39:05');
/*!40000 ALTER TABLE `formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participante` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `numero_celular` varchar(20) NOT NULL,
  `carrera` varchar(255) DEFAULT NULL,
  `talla_polera` varchar(20) DEFAULT NULL,
  `carnet_identidad` varchar(20) DEFAULT NULL,
  `codigo_sis_o_institucion` varchar(20) DEFAULT NULL,
  `semestre` int DEFAULT NULL,
  `id_formulario` int NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_formulario` (`id_formulario`),
  CONSTRAINT `participante_ibfk_1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,'gary','mamani','2001-10-22','garymamani12@gmail.com','65385951','Sistemas',NULL,NULL,NULL,NULL,1,'2023-10-13 13:52:04','2023-10-13 13:50:58');
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-16 20:13:06
