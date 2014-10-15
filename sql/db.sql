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
  `stack` text
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
  `only_authenticated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `only_uid` int(11) unsigned NOT NULL DEFAULT '0',
  `only_gid` int(11) unsigned NOT NULL DEFAULT '0'
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
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `proxy`
--
ALTER TABLE `proxy`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
