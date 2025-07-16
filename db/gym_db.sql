-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gym_db
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,1,'2025-07-10 23:06:08','2025-07-10 23:07:14','2025-07-10');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_plans`
--

DROP TABLE IF EXISTS `member_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `start_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `plan_id` (`plan_id`),
  CONSTRAINT `member_plans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `member_plans_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_plans`
--

LOCK TABLES `member_plans` WRITE;
/*!40000 ALTER TABLE `member_plans` DISABLE KEYS */;
INSERT INTO `member_plans` VALUES (1,1,1,'2025-07-18','2025-07-19'),(3,3,1,'2025-07-11','2025-07-12'),(4,1,1,'2025-07-10','2025-07-11'),(5,3,1,'2025-07-10','2025-07-11'),(6,3,1,'2025-07-10','2025-07-11'),(7,3,1,'2025-07-10','2025-07-11'),(8,3,1,'2025-07-10','2025-07-11'),(9,3,1,'2025-07-10','2025-07-11'),(10,3,1,'2025-07-10','2025-07-11'),(11,3,1,'2025-07-10','2025-07-11'),(12,3,1,'2025-07-11','2025-07-12');
/*!40000 ALTER TABLE `member_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_trainers`
--

DROP TABLE IF EXISTS `member_trainers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_trainers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `trainer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `trainer_id` (`trainer_id`),
  CONSTRAINT `member_trainers_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `member_trainers_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_trainers`
--

LOCK TABLES `member_trainers` WRITE;
/*!40000 ALTER TABLE `member_trainers` DISABLE KEYS */;
INSERT INTO `member_trainers` VALUES (1,1,2),(2,2,3),(3,3,3);
/*!40000 ALTER TABLE `member_trainers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `health_conditions` text,
  `fitness_goals` text,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Shahikant More','shashi@gmail.com','2222222222','2025-07-10','Shivaji Nagar, Pune 411003, Maharashtra, India','3333333333','Asthama ','Win WWE',NULL,'2025-07-10 11:30:07'),(2,'Shashikant More','shashi@gmail.com','2222222222','2025-07-10','','3333333333','Hair Fall','Gain 16kg in next 6 months',NULL,'2025-07-10 12:28:40'),(3,'Sahil','sahil@gmail.com','1111111111','2025-07-10','ABC Chowk, Narayan Peth, Pune','3333333333','Hair Fall','Gain 116 kg in next 11 months','$2y$10$8z.dbtVi2f5d7MtjPpBjjuMz9U4IK4ks4UFwtyIzTrISknJMzTOpy','2025-07-10 18:21:09');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_plans`
--

DROP TABLE IF EXISTS `membership_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(100) NOT NULL,
  `duration` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_plans`
--

LOCK TABLES `membership_plans` WRITE;
/*!40000 ALTER TABLE `membership_plans` DISABLE KEYS */;
INSERT INTO `membership_plans` VALUES (1,'Monthly',1,999.00,'Magical Weight loss','2025-07-10 11:40:06');
/*!40000 ALTER TABLE `membership_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'weight loss',999.00,'2025-07-18','2025-07-26','UPI','NA','2025-07-10 12:40:11'),(2,3,'Monthly',999.00,'2025-07-10','2025-07-11','','','2025-07-10 19:03:16'),(3,3,'Monthly',999.00,'2025-07-10','2025-07-11','','','2025-07-10 19:03:26'),(4,3,'Monthly',999.00,'2025-07-10','2025-07-11','Cash','','2025-07-10 19:04:50'),(5,3,'Monthly',999.00,'2025-07-11','2025-07-12','UPI','','2025-07-11 05:20:23');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainer_schedule`
--

DROP TABLE IF EXISTS `trainer_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trainer_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trainer_id` int NOT NULL,
  `member_id` int NOT NULL,
  `session_date` date NOT NULL,
  `session_time` time NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `trainer_id` (`trainer_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `trainer_schedule_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `trainer_schedule_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainer_schedule`
--

LOCK TABLES `trainer_schedule` WRITE;
/*!40000 ALTER TABLE `trainer_schedule` DISABLE KEYS */;
INSERT INTO `trainer_schedule` VALUES (1,2,1,'2025-07-10','18:49:00','Weight Loss','2025-07-10 12:21:39'),(2,2,1,'2025-07-10','18:51:00','Weight Loss','2025-07-10 12:22:09'),(3,3,2,'2025-07-11','20:01:00','XYZ','2025-07-10 12:31:08'),(4,3,3,'2025-07-12','01:45:00','','2025-07-10 19:14:06');
/*!40000 ALTER TABLE `trainer_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','trainer','member') NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `specialization` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Name','admin@example.com','$2y$10$.3lRs4kfkskSG43A3ER34ugyExdzqtWSNVlVTyhWU.4c/Oi.WkJDS','admin',NULL,NULL,'2025-07-11 01:51:10','Yoga','8275540085'),(2,'Chetan','chetan@gmail.com','$2y$10$2VaVdN0GIWSUnCGn9XRJaOViMM8I6ZrSFLpMwj87m5dk9VQBL9.JC','trainer',NULL,NULL,'2025-07-10 11:22:13','Pushups','9898787867'),(3,'sarang','sarang@gmail.com','$2y$10$.8q8FYxAhZ6qXIFDCWpW2OCsnwaYCa72rYd8l5PY3pcrXzvUXYGna','trainer',NULL,NULL,'2025-07-10 12:27:02',NULL,NULL);
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

-- Dump completed on 2025-07-11 11:08:11
