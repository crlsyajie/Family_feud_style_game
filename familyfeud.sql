-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:81
-- Generation Time: Oct 04, 2024 at 05:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: familyfeud
--
CREATE DATABASE IF NOT EXISTS familyfeud DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE familyfeud;

-- --------------------------------------------------------

--
-- Table structure for table scores
--

DROP TABLE IF EXISTS scores;
CREATE TABLE scores (
  id int(11) NOT NULL,
  player1_score int(11) DEFAULT NULL,
  player2_score int(11) DEFAULT NULL,
  player1_name varchar(100) DEFAULT NULL,
  player2_name varchar(100) DEFAULT NULL,
  created_at datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table scores
--

INSERT INTO scores (id, player1_score, player2_score, player1_name, player2_name, created_at) VALUES
(1, 0, 50, NULL, NULL, '2024-10-04 11:23:35'),
(2, 50, 0, 'Dog', 'Cat', '2024-10-04 11:23:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table scores
--
ALTER TABLE scores
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table scores
--
ALTER TABLE scores
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;