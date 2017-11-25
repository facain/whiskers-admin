-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2017 at 02:59 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whiskers`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `block_number` int(11) NOT NULL,
  `street` varchar(50) NOT NULL,
  `barangay` varchar(20) NOT NULL,
  `city` varchar(26) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `block_number`, `street`, `barangay`, `city`) VALUES
(1, 5, 'Bohol', 'Labangon', 'Cebu'),
(28, 2, 'Martin de Porres', 'Basak', 'Lapu-Lapu'),
(29, 50, 'Bag-ong dan', 'Yati', 'Liloan');

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE `breed` (
  `breed_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `breed_name` varchar(26) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `breed`
--

INSERT INTO `breed` (`breed_id`, `pet_id`, `breed_name`) VALUES
(5, 1, 'Daschund'),
(6, 1, 'Corgi'),
(7, 2, 'Munchkin'),
(8, 2, 'Persian ');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(20) NOT NULL,
  `image_path` varchar(50) NOT NULL,
  `image_type` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `image_name`, `image_path`, `image_type`) VALUES
(1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `pet_id` int(11) NOT NULL,
  `pet_type` varchar(26) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`pet_id`, `pet_type`) VALUES
(1, 'Dog'),
(2, 'Cat');

-- --------------------------------------------------------

--
-- Table structure for table `pet_entry`
--

CREATE TABLE `pet_entry` (
  `pet_entry_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `pet_info_id` int(11) NOT NULL,
  `pet_entry_status` enum('ACTIVE','INACTIVE') NOT NULL,
  `pet_entry_date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_type` enum('FREE ADOPTION','SELL') NOT NULL,
  `pet_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pet_info`
--

CREATE TABLE `pet_info` (
  `pet_info_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `pet_image_id` int(11) NOT NULL,
  `pet_status` enum('AVAILABLE','UNAVAILABLE') NOT NULL,
  `pet_name` varchar(26) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('FEMALE','MALE') NOT NULL,
  `vaccination_status` enum('YES','NO') NOT NULL,
  `pet_card_status` enum('YES','NO') NOT NULL,
  `fur_color` varchar(16) NOT NULL,
  `eye_color` varchar(16) NOT NULL,
  `pet_additional_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `pet_entry_id` int(11) NOT NULL,
  `transaction_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agreement` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL DEFAULT '1',
  `address_id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `user_type` enum('NORMAL','ADMIN') NOT NULL,
  `user_status` enum('ACTIVE','BLOCKED') NOT NULL DEFAULT 'ACTIVE',
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(26) NOT NULL,
  `last_name` varchar(26) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `image_id`, `address_id`, `username`, `user_type`, `user_status`, `date_registered`, `first_name`, `last_name`, `contact_number`, `email`, `password`) VALUES
(1, 1, 1, 'admin', 'ADMIN', 'ACTIVE', '2017-11-16 23:58:37', 'Virgil', 'Domalaoco', '09565378244', 'vjldomalaoco@gmail.com', 'admin'),
(30, 1, 28, 'facain', 'NORMAL', 'ACTIVE', '2017-11-24 20:23:05', 'Frances', 'Acain', '09271214569', 'acainf@gmail.com', 'qwerty'),
(31, 1, 29, 'erynvin', 'NORMAL', 'ACTIVE', '2017-11-24 20:35:10', 'Eryn Vinnice', 'Regner', '09333304574', 'erynvinnice@gmail.com', 'qwe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`breed_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_entry`
--
ALTER TABLE `pet_entry`
  ADD PRIMARY KEY (`pet_entry_id`),
  ADD KEY `pet_info_id` (`pet_info_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `pet_info`
--
ALTER TABLE `pet_info`
  ADD PRIMARY KEY (`pet_info_id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `pet_image_id` (`pet_image_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `pet_entry_id` (`pet_entry_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `address_id` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `breed`
--
ALTER TABLE `breed`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pet_entry`
--
ALTER TABLE `pet_entry`
  MODIFY `pet_entry_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pet_info`
--
ALTER TABLE `pet_info`
  MODIFY `pet_info_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `breed`
--
ALTER TABLE `breed`
  ADD CONSTRAINT `breed_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`);

--
-- Constraints for table `pet_entry`
--
ALTER TABLE `pet_entry`
  ADD CONSTRAINT `pet_entry_ibfk_1` FOREIGN KEY (`pet_info_id`) REFERENCES `pet_info` (`pet_info_id`),
  ADD CONSTRAINT `pet_entry_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `pet_info`
--
ALTER TABLE `pet_info`
  ADD CONSTRAINT `pet_info_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  ADD CONSTRAINT `pet_info_ibfk_2` FOREIGN KEY (`pet_image_id`) REFERENCES `image` (`image_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`pet_entry_id`) REFERENCES `pet_entry` (`pet_entry_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `image` (`image_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
