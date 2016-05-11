-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2016 at 11:00 AM
-- Server version: 5.7.12-log
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mess_board_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mes_categories`
--

CREATE TABLE `mes_categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_categories`
--

INSERT INTO `mes_categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Транспорт', 0),
(2, 'Интернет', 0),
(3, 'Дом', 0),
(4, 'Сад и Огород', 0),
(5, 'Автомобили', 1),
(6, 'Мото', 1),
(7, 'Компьютеры', 2),
(8, 'Игры', 2),
(9, 'Мебель', 3),
(10, 'Сантехника', 3),
(11, 'Инструмент', 4),
(12, 'Стройматериалы', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mes_post`
--

CREATE TABLE `mes_post` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_categories` tinyint(4) NOT NULL,
  `id_razd` tinyint(4) NOT NULL,
  `town` varchar(255) NOT NULL,
  `img` varchar(50) NOT NULL,
  `confirm` enum('0','1') NOT NULL DEFAULT '0',
  `time_over` int(11) NOT NULL,
  `is_actual` enum('0','1') NOT NULL DEFAULT '1',
  `price` tinyint(10) NOT NULL,
  `img_s` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_post`
--

INSERT INTO `mes_post` (`id`, `title`, `text`, `date`, `id_user`, `id_categories`, `id_razd`, `town`, `img`, `confirm`, `time_over`, `is_actual`, `price`, `img_s`) VALUES
(28, 'Маздав', 'fhfghgfh', 1462820928, 6, 5, 1, 'Одесса', 'Auto_Mazda_Mazda_Potenza_006547_.jpg', '1', 1464670583, '1', 127, '28_0.jpg|28_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mes_priv`
--

CREATE TABLE `mes_priv` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_priv`
--

INSERT INTO `mes_priv` (`id`, `name`) VALUES
(1, 'ADD_MESS'),
(2, 'MODER_MESS'),
(3, 'DEL_MESS'),
(4, 'RETIME_MESS'),
(5, 'EDIT_MESS'),
(6, 'ADD_CAT'),
(7, 'VIEW_ADMIN'),
(8, 'EDIT_US');

-- --------------------------------------------------------

--
-- Table structure for table `mes_razd`
--

CREATE TABLE `mes_razd` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_razd`
--

INSERT INTO `mes_razd` (`id`, `name`) VALUES
(1, 'Предложение'),
(2, 'Спрос');

-- --------------------------------------------------------

--
-- Table structure for table `mes_role`
--

CREATE TABLE `mes_role` (
  `id` tinyint(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_role`
--

INSERT INTO `mes_role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'user'),
(4, 'ban');

-- --------------------------------------------------------

--
-- Table structure for table `mes_role_priv`
--

CREATE TABLE `mes_role_priv` (
  `id_role` tinyint(4) NOT NULL,
  `id_priv` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_role_priv`
--

INSERT INTO `mes_role_priv` (`id_role`, `id_priv`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `mes_users`
--

CREATE TABLE `mes_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `confirm` enum('0','1') NOT NULL DEFAULT '0',
  `sess` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` tinyint(4) NOT NULL DEFAULT '3'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mes_users`
--

INSERT INTO `mes_users` (`user_id`, `login`, `password`, `name`, `hash`, `confirm`, `sess`, `email`, `id_role`) VALUES
(6, 'onnocym', 'f8d07a83fff06d61529d83cf7d3fc6c6', 'Aleksey', '662ad098fa8fbabb0993f4d2e8f5d18c', '1', '3c7f02d1802448d9137289c37320f122', 'atarapugin@gmail.com', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mes_categories`
--
ALTER TABLE `mes_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mes_post`
--
ALTER TABLE `mes_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);
ALTER TABLE `mes_post` ADD FULLTEXT KEY `fulltext` (`title`,`text`);

--
-- Indexes for table `mes_priv`
--
ALTER TABLE `mes_priv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mes_razd`
--
ALTER TABLE `mes_razd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mes_role`
--
ALTER TABLE `mes_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mes_users`
--
ALTER TABLE `mes_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mes_categories`
--
ALTER TABLE `mes_categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `mes_post`
--
ALTER TABLE `mes_post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `mes_priv`
--
ALTER TABLE `mes_priv`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mes_razd`
--
ALTER TABLE `mes_razd`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mes_role`
--
ALTER TABLE `mes_role`
  MODIFY `id` tinyint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mes_users`
--
ALTER TABLE `mes_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
