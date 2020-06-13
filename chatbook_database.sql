-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2020 at 02:37 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `current_users`
--

CREATE TABLE `current_users` (
  `id` int(11) NOT NULL,
  `receiver` varchar(11) DEFAULT NULL,
  `sender` varchar(11) DEFAULT NULL,
  `message` varchar(50) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_name` varchar(11) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile_no` char(15) DEFAULT NULL,
  `email_id` varchar(30) DEFAULT NULL,
  `dp_src` varchar(20) DEFAULT './defaulticon.webp',
  `verified` int(1) DEFAULT 0,
  `online_status` int(1) DEFAULT 0,
  `bio` varchar(100) DEFAULT NULL,
  `last_active` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `read_messages`
--

CREATE TABLE `read_messages` (
  `id` int(11) NOT NULL,
  `from` varchar(11) NOT NULL,
  `to` varchar(11) NOT NULL,
  `message` varchar(200) DEFAULT NULL,
  `image_src` varchar(30) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) DEFAULT 0,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `unread_messages`
--

CREATE TABLE `unread_messages` (
  `id` int(11) NOT NULL,
  `from` varchar(11) DEFAULT NULL,
  `to` varchar(11) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `image_src` varchar(30) DEFAULT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `status` int(1) DEFAULT NULL,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-
-- Indexes for dumped tables
--

--
-- Indexes for table `current_users`
--
ALTER TABLE `current_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_name`);

--
-- Indexes for table `read_messages`
--
ALTER TABLE `read_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `current_users`
--
ALTER TABLE `current_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `read_messages`
--
ALTER TABLE `read_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `unread_messages`
--
ALTER TABLE `unread_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD CONSTRAINT `unread_messages_ibfk_1` FOREIGN KEY (`from`) REFERENCES `login` (`user_name`),
  ADD CONSTRAINT `unread_messages_ibfk_2` FOREIGN KEY (`to`) REFERENCES `login` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
