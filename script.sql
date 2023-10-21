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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,'Título del evento','2023-08-05','taller_de_entrenamiento','Descripción del evento',NULL,NULL,'2023-10-12 09:23:03','2023-10-12 09:23:03',NULL,NULL,NULL,NULL,NULL),(2,'Evento competitivo','2023-04-05','taller_de_entrenamiento','Descripción del evento a toda madre',NULL,NULL,'2023-10-12 09:23:03','2023-10-12 09:23:03',NULL,NULL,NULL,NULL,NULL),(3,'Evento a toda leche de programacion','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,1,'2023-10-20 23:34:14','2023-10-12 13:26:41',NULL,'Ser la ostia','texto1,texto2,texto3',NULL,'contacto1,contacto2,contacto3,contacto4'),(4,'Evento a toda madre de programacion','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,NULL,'2023-10-16 00:11:07','2023-10-16 00:11:07',NULL,NULL,NULL,NULL,NULL),(5,'Evento a toda madre de programacionn','2023-10-30','clasificatorio_interno','Evento que te hara poner los pelos de punta',NULL,NULL,'2023-10-16 23:03:44','2023-10-16 23:03:44',NULL,NULL,NULL,NULL,NULL),(6,'Evento de progra','2023-10-30','clasificatorio_interno','Evento a toda madre',NULL,NULL,'2023-10-17 02:00:33','2023-10-17 02:00:33',NULL,NULL,NULL,NULL,NULL),(7,'Evento de programa','2023-10-30','clasificatorio_interno','Evento a toda madre',_binary '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',NULL,'2023-10-17 02:03:58','2023-10-17 02:03:58',NULL,NULL,NULL,NULL,NULL),(8,'cup ss 2023','2023-12-13','competencia_de_entrenamiento','copa interna ss',NULL,NULL,'2023-10-18 12:46:27','2023-10-18 12:46:27',NULL,'1 ser estudiante de ss 2 tener menos de 24  a dic del 2023 3 ser estudiante de informatica','1 medallas al 3/4 de competidores 2 certificados de sitio','assure digital true jala','70789898 7078965 4435247');
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
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario`
--

LOCK TABLES `formulario` WRITE;
/*!40000 ALTER TABLE `formulario` DISABLE KEYS */;
INSERT INTO `formulario` VALUES (1,1,1,1,1,1,1,1,1,1,1,'2023-10-12 16:43:14','2023-10-12 12:04:11'),(2,1,1,1,1,1,1,0,0,1,1,'2023-10-12 16:22:43','2023-10-12 16:22:43'),(3,1,1,1,1,1,0,0,0,0,0,'2023-10-12 16:39:05','2023-10-12 16:39:05'),(4,1,1,1,1,1,0,0,0,0,0,'2023-10-18 01:42:30','2023-10-18 01:42:30'),(5,1,1,1,1,1,0,0,0,0,0,'2023-10-18 01:43:35','2023-10-18 01:43:35'),(6,1,1,1,1,1,1,0,0,0,0,'2023-10-18 01:43:55','2023-10-18 01:43:55');
/*!40000 ALTER TABLE `formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,'gary','mamani','2001-10-22','garymamani12@gmail.com','65385951','Sistemas',NULL,NULL,NULL,NULL,1,'2023-10-13 13:52:04','2023-10-13 13:50:58'),(2,'gary','mamani','2023-10-12','garymamani12@gmail.com','65385951','Sistemas','M','885258','201900403',7,1,'2023-10-18 04:01:46','2023-10-18 04:01:46');
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'john doe','john.doe@example.com',NULL,'$2y$10$foQfFbXcAKbRZC/cKAFMpO1ENt5fu7MVzIrd6cec9AhWuQFEoODHq',NULL,'2023-10-21 18:29:06','2023-10-21 18:29:06');
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

-- Dump completed on 2023-10-21 10:37:24
