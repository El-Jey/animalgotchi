-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.6.4-MariaDB-1:10.6.4+maria~focal - mariadb.org binary distribution
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных animalgotchi
CREATE DATABASE IF NOT EXISTS `animalgotchi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `animalgotchi`;

-- Дамп структуры для таблица animalgotchi.animal_kinds
CREATE TABLE IF NOT EXISTS `animal_kinds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kind_ru` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_size` double unsigned NOT NULL DEFAULT 0,
  `max_age` int(3) unsigned NOT NULL,
  `growth_factor` double unsigned NOT NULL,
  `default_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы animalgotchi.animal_kinds: ~5 rows (приблизительно)
DELETE FROM `animal_kinds`;
/*!40000 ALTER TABLE `animal_kinds` DISABLE KEYS */;
INSERT INTO `animal_kinds` (`id`, `kind_ru`, `kind_en`, `max_size`, `max_age`, `growth_factor`, `default_image`, `available`) VALUES
	(1, 'Кот', 'Cat', 33, 7, 4.7, 'assets/images/animals/cat.svg', 1),
	(2, 'Собака', 'Dog', 51, 10, 5.1, 'assets/images/animals/dog.svg', 1),
	(3, 'Голубь', 'Pigeon', 12, 4, 3, 'assets/images/animals/pigeon.svg', 1),
	(4, 'Ночная Фурия', 'Night Fury', 90, 25, 3.6, 'assets/images/animals/night_fury.svg', 1),
	(5, 'Питон', 'Python', 77, 17, 4.5, 'assets/images/animals/python.svg', 0);
/*!40000 ALTER TABLE `animal_kinds` ENABLE KEYS */;

-- Дамп структуры для таблица animalgotchi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы animalgotchi.users: ~0 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`) VALUES
	(1, 'frolov93oleg@gmail.com', 'Олег', 'Фролов', '12345');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дамп структуры для таблица animalgotchi.user_animals
CREATE TABLE IF NOT EXISTS `user_animals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `animal_kind_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_size` int(3) NOT NULL,
  `max_age` int(3) NOT NULL,
  `growth_factor` double NOT NULL,
  `size` double DEFAULT 1,
  `age` int(3) DEFAULT 1,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `animal_kind_id` (`animal_kind_id`) USING BTREE,
  CONSTRAINT `animal_kind_id` FOREIGN KEY (`animal_kind_id`) REFERENCES `animal_kinds` (`id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы animalgotchi.user_animals: ~0 rows (приблизительно)
DELETE FROM `user_animals`;
/*!40000 ALTER TABLE `user_animals` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_animals` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
