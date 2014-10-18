-- phpMyAdmin SQL Dump
-- version 4.2.9.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Čtv 09. říj 2014, 20:39
-- Verze serveru: 5.6.12
-- Verze PHP: 5.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `phoenix`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `log_internal`
--

CREATE TABLE IF NOT EXISTS `log_internal` (
`id` int(10) unsigned NOT NULL,
  `ts_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `class` varchar(50) DEFAULT NULL,
  `code` int(11) DEFAULT '0',
  `stack` text,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `log_internal`
--
ALTER TABLE `log_internal`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `log_internal`
--
ALTER TABLE `log_internal`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Struktura tabulky `proxy`
--

CREATE TABLE IF NOT EXISTS `proxy` (
`id` int(10) unsigned NOT NULL,
  `token` varchar(100) NOT NULL,
  `valid_from` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid_to` datetime DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `only_authenticated` tinyint(1) unsigned DEFAULT NULL,
  `only_uid` int(11) unsigned DEFAULT NULL,
  `only_gid` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `proxy`
--
ALTER TABLE `proxy`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `token` (`token`,`valid_from`,`valid_to`);
--
-- AUTO_INCREMENT pro tabulku `proxy`
--
ALTER TABLE `proxy`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`uid` int(10) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(64) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `ts_insert` timestamp NULL DEFAULT NULL,
  `ts_last_login` datetime DEFAULT NULL,
  `renew_token` char(64) DEFAULT NULL,
  `renew_valid_to` timestamp NULL DEFAULT NULL,
  `language` tinyint(3) DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Klíče pro tabulku `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`uid`), ADD UNIQUE KEY `email_UNIQUE` (`email`);
 
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Struktura tabulky `ucr`
--

CREATE TABLE IF NOT EXISTS `ucr` (
`id` int(10) unsigned NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `token` char(64) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `user_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `valid_to` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro tabulku `ucr`
--
ALTER TABLE `ucr`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pro tabulku `ucr`
--
ALTER TABLE `ucr`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Struktura tabulky `log_activity`
--

CREATE TABLE IF NOT EXISTS `log_activity` (
`id` int(11) NOT NULL,
  `user_uid` int(10) unsigned NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `ts_insert` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro tabulku `log_activity`
--
ALTER TABLE `log_activity`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_system_log_activity_user_idx` (`user_uid`);

--
-- AUTO_INCREMENT pro tabulku `log_activity`
--
ALTER TABLE `log_activity`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
