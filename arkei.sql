-- phpMyAdmin SQL Dump
-- version 4.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2018 at 12:14 AM
-- Server version: 5.5.25
-- PHP Version: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arkei`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
`id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `hwid` text NOT NULL,
  `system` text NOT NULL,
  `ip` text NOT NULL,
  `country` text NOT NULL,
  `date` text NOT NULL,
  `profile` int(11) NOT NULL,
  `user` text NOT NULL,
  `passwords` text NOT NULL,
  `cc` text NOT NULL,
  `coins` text NOT NULL,
  `files` text NOT NULL,
  `telegram` text NOT NULL,
  `skype` text NOT NULL,
  `steam` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `presets` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `services` text NOT NULL,
  `color` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
`id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `task` text NOT NULL,
  `Count` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `Name`, `task`, `Count`) VALUES
(1, 'Main Profile', 'none;', 64),
(2, 'Two Profile', 'none;', 0),
(3, 'Three Profile', 'none;', 0),
(4, 'Four Profile', 'none;', 0),
(5, 'Five Profile', 'none;', 0),
(6, 'Six Profile', 'none;', 0),
(7, 'Seven Profile', 'none;', 0),
(8, 'Eight Profile', 'none;', 0),
(9, 'Nine Profile', 'none;', 0),
(10, 'Ten Profile', 'none;', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `Name` text NOT NULL,
  `Value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`Name`, `Value`) VALUES
('grub_files', 'txt;log;'),
('saved_passwords', '1'),
('cookies_autocomplete', '1'),
('history', '1'),
('cryptocurrency', '1'),
('skype', '1'),
('steam', '1'),
('telegram', '1'),
('screenshot', '1'),
('grabber', '1'),
('max_size', '150'),
('repeated_reports', '1'),
('self_delete', '1'),
('self_delete', '1');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `Name` text NOT NULL,
  `Value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`Name`, `Value`) VALUES
('all_logs', '0'),
('all_files', '0'),
('errors', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `count` text NOT NULL,
  `success` int(11) NOT NULL,
  `country` text NOT NULL,
  `profile` text NOT NULL,
  `task` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `profile` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `profile`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presets`
--
ALTER TABLE `presets`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `presets`
--
ALTER TABLE `presets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
