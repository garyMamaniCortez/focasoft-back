-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: focasoft
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
  `contactos` varchar(1000) DEFAULT NULL,
  `equipo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `evento_ibfk_1` (`id_formulario`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,'Evento a toda leche de programacion','2023-11-30','taller_de_entrenamiento','Evento que te hara poner los pelos de punta',NULL,4,'2023-11-23 20:17:29','2023-11-08 16:44:25',NULL,'Ser la ostia','texto1,texto2,texto3','contacto1,contacto2,contacto3,contacto4',0),(2,'Clasificatorio interno individuales San Simon','2023-11-29','clasificatorio_interno','Evento interno a toda madre',NULL,3,'2023-11-23 20:16:38','2023-11-15 02:57:00',NULL,NULL,NULL,NULL,1),(3,'competencia','2023-11-30','competencia_de_entrenamiento','hjuytfjj',NULL,NULL,'2023-11-29 14:01:47','2023-11-29 13:44:46',NULL,'uno','',NULL,0),(4,'Taller de entrenamiento a las clasificatorios ICPC','2024-11-29','taller_de_entrenamiento','Taller de entrenamiento en algoritmos para preparar a los estudiantes para las competencias ICPC',NULL,NULL,'2023-11-29 17:15:14','2023-11-29 17:15:14',NULL,NULL,NULL,NULL,0),(5,'Taller de entrenamiento a las clasificatorios ICPC 2024','2024-11-29','taller_de_entrenamiento','Taller de entrenamiento en algoritmos para preparar a los estudiantes para las competencias ICPC',NULL,NULL,'2023-11-29 17:15:36','2023-11-29 17:15:36',NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulario`
--

DROP TABLE IF EXISTS `formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_evento` int NOT NULL,
  `preguntas` text NOT NULL,
  `obligatorias` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `formulario_ibfk_1` (`id_evento`),
  CONSTRAINT `formulario_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario`
--

LOCK TABLES `formulario` WRITE;
/*!40000 ALTER TABLE `formulario` DISABLE KEYS */;
INSERT INTO `formulario` VALUES (3,2,'8','1','2023-11-23 20:16:38','2023-11-23 20:16:38'),(4,1,'1,9,10,11','1,1,0,0','2023-11-23 20:55:30','2023-11-23 20:17:29');
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
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,'2023-11-09 22:29:57','2023-11-09 22:29:57'),(2,'2023-11-09 22:31:50','2023-11-09 22:31:50'),(3,'2023-11-09 22:32:41','2023-11-09 22:32:41'),(4,'2023-11-09 22:35:01','2023-11-09 22:35:01'),(5,'2023-11-09 22:39:02','2023-11-09 22:39:02'),(6,'2023-11-09 22:42:57','2023-11-09 22:42:57'),(7,'2023-11-09 22:44:19','2023-11-09 22:44:19'),(8,'2023-11-09 22:46:02','2023-11-09 22:46:02'),(9,'2023-11-09 22:47:34','2023-11-09 22:47:34'),(10,'2023-11-09 22:48:30','2023-11-09 22:48:30'),(11,'2023-11-09 22:50:22','2023-11-09 22:50:22'),(12,'2023-11-09 22:53:24','2023-11-09 22:53:24'),(13,'2023-11-09 22:55:30','2023-11-09 22:55:30'),(14,'2023-11-09 22:56:37','2023-11-09 22:56:37'),(15,'2023-11-09 22:58:25','2023-11-09 22:58:25'),(16,'2023-11-09 22:59:05','2023-11-09 22:59:05'),(17,'2023-11-09 22:59:26','2023-11-09 22:59:26'),(18,'2023-11-09 22:59:48','2023-11-09 22:59:48'),(19,'2023-11-09 23:00:19','2023-11-09 23:00:19'),(20,'2023-11-09 23:01:31','2023-11-09 23:01:31'),(21,'2023-11-09 23:07:20','2023-11-09 23:07:20'),(22,'2023-11-09 23:07:50','2023-11-09 23:07:50'),(23,'2023-11-09 23:09:45','2023-11-09 23:09:45'),(24,'2023-11-09 23:10:36','2023-11-09 23:10:36'),(25,'2023-11-09 23:10:59','2023-11-09 23:10:59'),(26,'2023-11-09 23:14:15','2023-11-09 23:14:15'),(27,'2023-11-09 23:18:14','2023-11-09 23:18:14'),(28,'2023-11-10 01:03:40','2023-11-10 01:03:40'),(29,'2023-11-10 22:14:36','2023-11-10 22:14:36'),(30,'2023-11-10 22:43:27','2023-11-10 22:43:27'),(31,'2023-11-10 22:46:35','2023-11-10 22:46:35'),(32,'2023-11-10 22:49:39','2023-11-10 22:49:39'),(33,'2023-11-10 22:52:13','2023-11-10 22:52:13'),(34,'2023-11-10 22:53:06','2023-11-10 22:53:06'),(35,'2023-11-10 22:53:52','2023-11-10 22:53:52'),(36,'2023-11-10 22:54:45','2023-11-10 22:54:45'),(37,'2023-11-10 22:55:13','2023-11-10 22:55:13'),(38,'2023-11-10 22:55:36','2023-11-10 22:55:36'),(39,'2023-11-10 22:55:58','2023-11-10 22:55:58'),(40,'2023-11-10 22:56:46','2023-11-10 22:56:46'),(41,'2023-11-10 22:57:02','2023-11-10 22:57:02'),(42,'2023-11-10 22:57:31','2023-11-10 22:57:31'),(43,'2023-11-29 01:35:21','2023-11-29 01:35:21'),(44,'2023-11-29 01:37:06','2023-11-29 01:37:06'),(45,'2023-11-29 01:37:23','2023-11-29 01:37:23'),(46,'2023-11-29 01:37:36','2023-11-29 01:37:36'),(47,'2023-11-29 01:39:08','2023-11-29 01:39:08'),(48,'2023-11-29 01:39:16','2023-11-29 01:39:16'),(49,'2023-11-29 01:39:25','2023-11-29 01:39:25'),(50,'2023-11-29 01:39:48','2023-11-29 01:39:48'),(51,'2023-11-29 01:40:29','2023-11-29 01:40:29'),(52,'2023-11-29 01:41:01','2023-11-29 01:41:01'),(53,'2023-11-29 01:41:16','2023-11-29 01:41:16'),(54,'2023-11-29 01:41:26','2023-11-29 01:41:26'),(55,'2023-11-29 01:41:56','2023-11-29 01:41:56'),(56,'2023-11-29 03:32:10','2023-11-29 03:32:10'),(57,'2023-11-29 03:32:34','2023-11-29 03:32:34'),(58,'2023-11-29 03:32:57','2023-11-29 03:32:57'),(59,'2023-11-29 03:39:34','2023-11-29 03:39:34'),(60,'2023-11-30 13:04:29','2023-11-30 13:04:29'),(61,'2023-11-30 13:04:46','2023-11-30 13:04:46'),(62,'2023-11-30 13:05:04','2023-11-30 13:05:04'),(63,'2023-11-30 13:05:23','2023-11-30 13:05:23'),(64,'2023-11-30 13:26:52','2023-11-30 13:26:52'),(65,'2023-11-30 13:27:13','2023-11-30 13:27:13'),(66,'2023-11-30 13:27:23','2023-11-30 13:27:23');
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patrocinador`
--

DROP TABLE IF EXISTS `patrocinador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrocinador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinador`
--

LOCK TABLES `patrocinador` WRITE;
/*!40000 ALTER TABLE `patrocinador` DISABLE KEYS */;
INSERT INTO `patrocinador` VALUES (1,'Unosquare','2023-11-08 16:44:46','2023-11-08 16:44:46'),(2,'Nice','2023-11-08 16:44:46','2023-11-08 16:44:46'),(3,'JalaSoft','2023-11-08 16:44:46','2023-11-08 16:44:46'),(4,'Encora','2023-11-08 16:44:46','2023-11-08 16:44:46'),(5,'AssureSoft','2023-11-08 16:44:47','2023-11-08 16:44:47');
/*!40000 ALTER TABLE `patrocinador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patrocinador_evento`
--

DROP TABLE IF EXISTS `patrocinador_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrocinador_evento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_evento` int NOT NULL,
  `id_patrocinador` int NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patrocinador_evento_ibfk_1` (`id_evento`),
  KEY `patrocinador_evento_ibfk_2` (`id_patrocinador`),
  CONSTRAINT `patrocinador_evento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`),
  CONSTRAINT `patrocinador_evento_ibfk_2` FOREIGN KEY (`id_patrocinador`) REFERENCES `patrocinador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patrocinador_evento`
--

LOCK TABLES `patrocinador_evento` WRITE;
/*!40000 ALTER TABLE `patrocinador_evento` DISABLE KEYS */;
INSERT INTO `patrocinador_evento` VALUES (1,1,1,'2023-11-08 16:44:47','2023-11-08 16:44:47'),(2,1,2,'2023-11-08 16:44:47','2023-11-08 16:44:47'),(3,1,3,'2023-11-08 16:44:47','2023-11-08 16:44:47'),(4,1,4,'2023-11-08 16:44:48','2023-11-08 16:44:48'),(5,1,5,'2023-11-08 16:44:48','2023-11-08 16:44:48'),(6,3,1,'2023-11-29 13:44:46','2023-11-29 13:44:46');
/*!40000 ALTER TABLE `patrocinador_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pregunta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `texto_pregunta` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `obligatorio` tinyint(1) NOT NULL,
  `opciones` varchar(1000) DEFAULT NULL,
  `equipo` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta`
--

LOCK TABLES `pregunta` WRITE;
/*!40000 ALTER TABLE `pregunta` DISABLE KEYS */;
INSERT INTO `pregunta` VALUES (1,'Nombres','nombre',1,NULL,0,'2023-11-08 21:43:15','2023-11-08 21:43:15'),(2,'Apellidos','nombre',1,NULL,0,'2023-11-08 21:43:54','2023-11-08 21:43:54'),(3,'Fecha de Nacimiento','fecha_AFA',1,NULL,0,'2023-11-08 21:46:58','2023-11-08 21:46:58'),(4,'Correo Electronico','email',1,NULL,0,'2023-11-08 21:47:55','2023-11-08 21:47:55'),(5,'Numero Celular','telefono',1,NULL,0,'2023-11-08 21:48:50','2023-11-08 21:48:50'),(6,'Codigo SIS','texto',0,NULL,0,'2023-11-09 01:53:30','2023-11-09 01:53:30'),(7,'Talla Polera','texto',0,NULL,0,'2023-11-09 02:45:28','2023-11-09 02:45:28'),(8,'Nombre Equipo','texto',0,NULL,1,'2023-11-15 03:03:52','2023-11-15 03:03:52'),(9,'Carrera','texto',0,NULL,0,'2023-11-23 20:17:28','2023-11-23 20:17:28'),(10,'Ciudad','texto',0,NULL,0,'2023-11-23 20:19:46','2023-11-23 20:19:46'),(11,'Pais','texto',0,NULL,0,'2023-11-23 20:20:20','2023-11-23 20:20:20');
/*!40000 ALTER TABLE `pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuesta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_participante` int NOT NULL,
  `id_formulario` int NOT NULL,
  `datos_respuesta` text,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `respuesta_ibfk_1` (`id_participante`),
  KEY `respuesta_ibfk_2` (`id_formulario`),
  CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`id_participante`) REFERENCES `participante` (`id`),
  CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuesta`
--

LOCK TABLES `respuesta` WRITE;
/*!40000 ALTER TABLE `respuesta` DISABLE KEYS */;
INSERT INTO `respuesta` VALUES (1,27,1,'Gary,Mamani,22-10-2001,20194002,M','2023-11-09 23:18:14','2023-11-09 23:18:14'),(2,28,1,'Luis,Rosales,03-11-2000,20195202,M','2023-11-10 01:03:40','2023-11-10 01:03:40'),(3,30,1,'Nath1,Garcia,2000-10-10,20194292,S','2023-11-10 22:43:27','2023-11-10 22:43:27'),(4,31,1,'Nath1,Garcia,2000-10-10,20194292,S','2023-11-10 22:46:35','2023-11-10 22:46:35'),(5,32,1,'Nath1,Garcia,2000-10-10,20194292,S','2023-11-10 22:49:39','2023-11-10 22:49:39'),(6,33,1,'Nath1,Garcia,2000-10-10,20194292,S','2023-11-10 22:52:13','2023-11-10 22:52:13'),(7,34,1,'Nath1,Garcia,2000-10-10,20194292,S','2023-11-10 22:53:06','2023-11-10 22:53:06'),(8,38,1,'Nath,Garcia,2000-10-10,20194292,S','2023-11-10 22:55:37','2023-11-10 22:55:37'),(9,41,1,'Nath,Garcia,2000-10-10,20194292,S','2023-11-10 22:57:03','2023-11-10 22:57:03'),(10,58,3,'Dinamita','2023-11-29 03:32:57','2023-11-29 03:32:57'),(11,59,3,'Equipo Alpha','2023-11-29 03:39:34','2023-11-29 03:39:34'),(12,62,4,'Gary Mamani,Sistemas,Cochabamba,Bolivia','2023-11-30 13:05:04','2023-11-30 13:05:04'),(13,63,4,'Gary Mamani,Sistemas,Cochabamba,Bolivia','2023-11-30 13:05:24','2023-11-30 13:05:24'),(14,64,4,'Luis Rosales,Sistemas,Cochabamba,Bolivia','2023-11-30 13:26:53','2023-11-30 13:26:53'),(15,65,4,'Nathaly Garcia,Informatica,Cochabamba,Bolivia','2023-11-30 13:27:13','2023-11-30 13:27:13'),(16,66,4,'Adrian Camara,Informatica,Cochabamba,Bolivia','2023-11-30 13:27:23','2023-11-30 13:27:23');
/*!40000 ALTER TABLE `respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-30  9:29:04
