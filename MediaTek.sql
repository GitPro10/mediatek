-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 03, 2021 at 09:28 AM
-- Server version: 5.6.38
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MediaTek`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment-id` char(20) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `comment` char(150) NOT NULL,
  `post-id` char(20) DEFAULT NULL,
  `email` char(255) NOT NULL,
  `userid` char(15) NOT NULL,
  `comment-time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `author-id` char(15) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `email` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `profile-picture` text,
  `join-time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post-id` char(20) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` char(250) NOT NULL,
  `article` text NOT NULL,
  `author-id` char(15) DEFAULT NULL,
  `author-name` varchar(20) NOT NULL,
  `author-email` char(255) NOT NULL,
  `post-time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `reply-id` char(20) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `reply-message` char(150) NOT NULL,
  `comment-id` char(20) DEFAULT NULL,
  `userid` char(15) NOT NULL,
  `reply-time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
