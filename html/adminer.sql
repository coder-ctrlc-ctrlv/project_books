-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `authors` (`id`, `author`) VALUES
(2,	'Франц Кафка'),
(3,	'Энтони Бёрджесс'),
(4,	'Дж. К. Роулинг'),
(5,	'Стивен Кинг'),
(7,	'А. Г. Мерзляк'),
(8,	'М. С. Якир'),
(9,	'В. Б. Полонский');

DROP TABLE IF EXISTS `authors_and_books`;
CREATE TABLE `authors_and_books` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `id_author` int(15) NOT NULL,
  `id_book` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_author` (`id_author`),
  KEY `id_book` (`id_book`),
  CONSTRAINT `authors_and_books_ibfk_5` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `authors_and_books_ibfk_6` FOREIGN KEY (`id_book`) REFERENCES `books` (`ID_Book`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `authors_and_books` (`id`, `id_author`, `id_book`) VALUES
(1,	5,	5),
(2,	5,	6),
(3,	4,	7),
(4,	3,	8),
(6,	2,	9),
(7,	7,	12),
(8,	8,	12),
(9,	9,	12);

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name_book` varchar(50) NOT NULL,
  `date_of_writing` int(4) NOT NULL,
  `book_size` varchar(20) NOT NULL,
  `age_limit` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `books` (`id`, `name_book`, `date_of_writing`, `book_size`, `age_limit`) VALUES
(5,	'Оно',	1986,	'1530 стр.',	'16+'),
(6,	'Зелёная миля',	1996,	'420 стр.',	'16+'),
(7,	'Гарри Поттер и Кубок огня',	2000,	'660 стр.',	'6+'),
(8,	'Заводной апельсин',	1962,	'200 стр.',	'16+'),
(9,	'Превращение',	1915,	'70 стр.',	'0+'),
(12,	'Геометрия. 7 класс',	2016,	'394 стр.',	'0+');

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `genres` (`id`, `genre`) VALUES
(9,	'Мистика'),
(10,	'Ужасы'),
(11,	'Современная зарубежная литература'),
(12,	'Зарубежное фэнтези'),
(13,	'Книги про волшебников'),
(14,	'Социальная фантастика'),
(15,	'Зарубежная классика'),
(16,	'Литература 20 века'),
(18,	'Школьная программа');

DROP TABLE IF EXISTS `genres_and_books`;
CREATE TABLE `genres_and_books` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `id_book` int(15) NOT NULL,
  `id_genre` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_book` (`id_book`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genres_and_books_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`ID_Book`) ON DELETE CASCADE,
  CONSTRAINT `genres_and_books_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `genres_and_books` (`id`, `id_book`, `id_genre`) VALUES
(1,	5,	9),
(2,	5,	10),
(3,	6,	9),
(4,	6,	11),
(5,	7,	12),
(6,	7,	13),
(7,	8,	14),
(8,	8,	15),
(9,	9,	15),
(10,	9,	16),
(11,	12,	18);

DROP TABLE IF EXISTS `libraries`;
CREATE TABLE `libraries` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name_library` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `libraries` (`id`, `name_library`) VALUES
(6,	'Библиотека№1'),
(7,	'Библиотека№2'),
(8,	'Библиотека№3'),
(9,	'Библиотека №4'),
(10,	'Библиотека№5');

DROP TABLE IF EXISTS `libraries_and_books`;
CREATE TABLE `libraries_and_books` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `id_book` int(15) NOT NULL,
  `id_library` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_library` (`id_library`),
  KEY `id_book` (`id_book`),
  CONSTRAINT `libraries_and_books_ibfk_2` FOREIGN KEY (`id_library`) REFERENCES `libraries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `libraries_and_books_ibfk_3` FOREIGN KEY (`id_book`) REFERENCES `books` (`ID_Book`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `libraries_and_books` (`id`, `id_book`, `id_library`) VALUES
(1,	5,	8),
(2,	6,	6),
(3,	6,	7),
(4,	7,	6),
(5,	7,	7),
(6,	7,	8),
(7,	7,	9),
(8,	8,	7),
(9,	8,	9),
(10,	8,	10),
(11,	9,	9),
(12,	9,	10),
(13,	12,	10);

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `id_book` int(15) NOT NULL,
  `author_review` varchar(255) NOT NULL,
  `rating` int(2) NOT NULL,
  `text` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_book` (`id_book`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`ID_Book`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`ID_Book`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reviews` (`id`, `id_book`, `author_review`, `rating`, `text`) VALUES
(2,	5,	'gavrikova13',	10,	'Это сногсшибательная книга, читается на одном дыхании. Она вытаскивает наши детские страхи из подсознания. Манера написания заставляет пережить события книги вместе с героями '),
(3,	6,	'kenzoo',	7,	'Легко и интересно читается. '),
(4,	7,	'volovikova.ev',	9,	'Самая лучшая книга которою я читал из истории Гарри Потера всем рекомендую почитать эту книгу'),
(5,	8,	'mrdarkofficial',	10,	'Очень глубокая книга ,наполненная большим смыслом.Для меня это книга самая любимая из всей художественной литературы. Читать обязательно всем, шедевр от Энтони Берджесса'),
(6,	9,	'nadya-geld',	8,	'\"Превращение\" с первых строк заинтриговало и я не смогла остановиться!'),
(7,	9,	'helqa290781',	3,	'Не затянуло, весьма нудновато'),
(8,	5,	'egor.voronkov',	10,	'Великолепная книга! Лучшая из написанных Стивеном Кингом'),
(9,	12,	'super.arabo',	7,	'Покупайте , не задумываясь. Keep calm and learn geometry'),
(10,	5,	'snow',	7,	'Отличная книга'),
(11,	5,	'snow1',	9,	'Замечательно'),
(12,	5,	'snow 2 ',	6,	'Не очень понравилась'),
(13,	5,	'snow354',	10,	'комментарий'),
(14,	5,	'ergreg',	6,	'еще комментарий'),
(15,	5,	'vitrigtr',	7,	'comment'),
(16,	5,	'comm',	9,	'comm'),
(17,	5,	'book',	10,	'nice'),
(18,	5,	'hi',	8,	'good'),
(19,	5,	'comment12314',	10,	'здесь комментарий'),
(20,	6,	'trereev',	10,	'Замечательная книга замечательного автора!'),
(21,	6,	'dfgggggg',	10,	'Здесь отзыв написан');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1,	'admin',	'email@asd.ru',	'11223344');

-- 2018-08-27 12:29:37
