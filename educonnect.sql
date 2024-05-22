-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 10:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educonnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `giveaway`
--

CREATE TABLE `giveaway` (
  `submitid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `employed` varchar(10) NOT NULL,
  `reason` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL,
  `position` varchar(20) NOT NULL,
  `interests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `birthday`, `position`, `interests`) VALUES
(2, 'Arion2', 'arion2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Female', '2000-02-22', 'Student', 'Math, Sports'),
(13, 'ADMIN', 'a@a.aa', '0cc175b9c0f1b6a831c399e269772661', 'Male', '1999-01-01', 'Professor', 'None'),
(18, '12', '12@asasasgmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'Male', '2000-12-12', 'Student', 'None'),
(19, '3', '3@asasasgmail.com', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 'Male', '2000-03-03', 'Student', 'None'),
(20, '22', '2@asasasgmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Male', '2002-02-22', 'Student', 'None'),
(21, '1212', '12121@asasasgmail.com', '3c59dc048e8850243be8079a5c74d079', 'Male', '2000-12-12', 'Student', 'None'),
(22, 'LOL', 'arionaa@lol.com', 'aee4bd941f8b4d9e39210c06c44fcb71', 'Male', '2000-09-09', 'Student', 'None'),
(23, 'Arion22', 'a12@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '2006-12-26', 'Student', 'Sports, Science'),
(24, 'Arion', 'a4@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'Male', '2006-12-26', 'Student', 'Sports, Science'),
(25, 'Arion2', 'ar2@gmail.com', '35f4a8d465e6e1edc05f3d8ab658c551', 'Female', '2000-02-22', 'Student', 'Math, Sports'),
(26, '22', '2@assgmail.com', '8db1b09d6cb44d4150b68a5310688024', 'Male', '2002-02-22', 'Student', 'None'),
(27, '1212', 'rand@asasasgmail.com', '0f5aaaf14d9a2d371853e46119abba27', 'Male', '2000-12-12', 'Student', 'None'),
(28, 'HomeTst', 'home@gmail.com', '106a6c241b8797f52e1e77317b96a201', 'Female', '2000-12-21', 'Student', 'Sports, Science'),
(29, 'entoher', 'another@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '1999-02-01', 'Student', 'Math'),
(30, 'Huh', 'huh@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '1990-02-01', 'Student', 'Math, Sports'),
(31, 'interest test', 'test2@gmail.com', 'ad0234829205b9033196ba818f7a872b', 'Male', '2000-02-12', 'Professor', 'Math, Sports, Science'),
(32, 'Arion2', 'a@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '2021-12-21', 'Student', 'Math');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `giveaway`
--
ALTER TABLE `giveaway`
  ADD PRIMARY KEY (`submitid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `giveaway`
--
ALTER TABLE `giveaway`
  MODIFY `submitid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
