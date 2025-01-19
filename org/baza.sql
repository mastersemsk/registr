-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 17 2025 г., 11:32
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `baza`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activities`
--

CREATE TABLE `activities` (
  `id` int NOT NULL,
  `activitie` varchar(200) NOT NULL,
  `activities_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `activities`
--

INSERT INTO `activities` (`id`, `activitie`, `activities_id`) VALUES
(1, 'Еда', NULL),
(2, 'Автомобили', NULL),
(3, 'Мебель', NULL),
(4, 'Стройматериалы', NULL),
(5, 'Мясная продукция', 1),
(6, 'Молочная продукция', 1),
(7, 'Грузовые', 2),
(8, 'Легковые', 2),
(9, 'Молоко', 6),
(10, 'Офисная мебель', 3),
(11, 'Запчасти', 8),
(12, 'Аксессуары', 8),
(13, 'Сметана', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `buildings`
--

CREATE TABLE `buildings` (
  `id` int NOT NULL,
  `address` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lat` decimal(7,4) NOT NULL,
  `lng` decimal(7,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `buildings`
--

INSERT INTO `buildings` (`id`, `address`, `lat`, `lng`) VALUES
(1, 'г. Зеленоград, ул. Ленина 1', '55.9785', '37.1733'),
(2, 'г. Зеленоград, ул. Советская 2А', '55.9785', '37.1727'),
(3, 'Новосибирск, ул. Блюхера, 32/1', '23.5640', '56.7890'),
(4, 'Красноярск, ул. Силевина 105 офис 33', '11.5653', '67.9807'),
(5, 'Краснодар, Ленина 4', '45.0249', '38.9611'),
(6, 'Краснодар, Ленина 2, офис 5 ', '45.0253', '38.9605');

-- --------------------------------------------------------

--
-- Структура таблицы `organizations`
--

CREATE TABLE `organizations` (
  `id` int NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phones` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `buildings_id` int UNSIGNED NOT NULL COMMENT 'id таблицы buildings'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT=' карточка организации ';

--
-- Дамп данных таблицы `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `phones`, `buildings_id`) VALUES
(1, 'ООО Молочник', '+7 (985) 046-50-40', 1),
(2, 'ООО Тесла', '2341216, 3451111, 8885467', 3),
(3, 'ИП Коромысло', '6755632, 3439087', 2),
(4, 'ООО Машина', '5673245, 8984522', 5),
(5, 'Столовая', '7860933', 6),
(6, 'ООО Всем Еда', '232-65-12', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `organizations_activities`
--

CREATE TABLE `organizations_activities` (
  `id` int NOT NULL,
  `organizations_id` int NOT NULL,
  `activities_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `organizations_activities`
--

INSERT INTO `organizations_activities` (`id`, `organizations_id`, `activities_id`) VALUES
(1, 1, 5),
(2, 1, 6),
(3, 2, 3),
(4, 3, 10),
(5, 4, 12),
(6, 4, 11),
(7, 5, 9),
(8, 5, 13),
(9, 6, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `organizations_activities`
--
ALTER TABLE `organizations_activities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `organizations_activities`
--
ALTER TABLE `organizations_activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
