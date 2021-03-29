-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 29 2021 г., 18:41
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `media_tracks`
--

CREATE TABLE `media_tracks` (
  `id` int(11) NOT NULL,
  `sc_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `genre` varchar(256) NOT NULL,
  `duration` int(11) NOT NULL,
  `release_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `media_tracks`
--
ALTER TABLE `media_tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `media_tracks`
--
ALTER TABLE `media_tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `media_tracks`
--
ALTER TABLE `media_tracks`
  ADD CONSTRAINT `media_tracks_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `media_artists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
