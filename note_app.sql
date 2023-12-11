-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 06:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `note_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `encrypted_session_key` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `encrypted_session_key`, `created_at`) VALUES
(13, 20, '123123', 'T04reGNzcC9DaCtJdnhMOHRMOXVBUT09OjpV83mxIomY/CgtQKcEZQxW', 'LCzPIl9wZgftrGsdPD9qAfiwADMeWelSg28XyNHW/Jq42O1aHmw0Q97IRmtDE/Ozv1n7IrIecDXqEOxNRK+FCUqMvxZyW2/tw5Zmu3cRl0Y1T4VqCE3M5DX1UlHiBYdDhBz87OYg3iO1e/eWzSMGWuVydLT/AyohFft/dbRKbyDza/k4zG8dlDSdT4SpQtTiDuh8j3VlimqKs5Q7mxT79952+pmM6d6oStq6/HMEYlKvAa+liT+Bo6wAaxP6rmQ5sMyHWVgu9JVGQtJH0fCkOaH1anBhdAmkEdWBf3bqMkQDJ02DeomLVzSJHU8oBuNv2JbqEQNR4Kp6bind8u78EQ==', '2023-12-11 17:20:59'),
(14, 20, 'wee', 'STFWZGZOdi9aTmFzU1VlMExkZ25XUT09OjpHJppJo4rJxbVSA4cxuz8e', 'FlXt7HBTQHEMLhOP+Ew6MqnBt28aa0laFlronCX1Hc3CMCq7no9fvjXTNFZZqrHOjSsDwfSeVj9eq9zCyu0Xc1z1LNIMxVK2fG3SkiPGezcapFDdsXSwF9yCLzwODc+KkmUrWk137NsggV7bEDTWbGX/XDcSMnqwpvROJ6Buyl2TULBIuLFCFdlROLu5oC1Fb4qIV9z68fDr8E0YANJpm4MJnyRx0D4kcYvBkCMtgZsCb1lKeMC1ocILtwfZUssWOUzvLXBQeXeaL2BVyO4/vBESC+j8AwV4cLcN5JLbhltBfzlP0ZcGbEgmD30dzX3YHIUt4G4/91R2OcX+bHy2xQ==', '2023-12-11 17:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `symmetric_key` varchar(2048) NOT NULL,
  `public_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `symmetric_key`, `public_key`) VALUES
(20, '123', '$2y$10$izRTwZkmQilngxQd/fPVa.MZNKZWx8csBllNvpeOe4qMlGapps4Qy', 'e83ef67c57ea75fa6712f38dc1ac4d056f023d93b8253e9fcd6b1679841ef5f3', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAogwhiANCJmXGNWGrKno9\njMCrXQrnHVYQ+A21WD51ijCjUbqutMubavc3lMAGxTuxslvhQ5Qwvtr8XwYClbWd\nj3mrEEthnpfRckfzqwNaNUzv0q2JojOAe4b7KqYBpeyvcipL5YrnUxuWQ9DmHC4V\nn+L374ZbSyTVp47KGnBbjZKLyWbQtzXQyYrhqzISYoytnMGIGMcdLHIOGb49GixF\noM/2Ckoh2s4saFm6K86h541BdYMK+DIt3yu0KZbsxYBYaNIjs9zTdXIBbKkPQmny\n7rgzseAiRkwD5Le3M2LxSV4ZaCHIwghKP3BTR9svv+9G2fscCly1Z//NZaPu/SwB\nfQIDAQAB\n-----END PUBLIC KEY-----\n\nTimestamp: 657744eb59602');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
