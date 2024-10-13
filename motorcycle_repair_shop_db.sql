-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 05:46 PM
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
-- Database: `motorcycle_repair_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `ref_num` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `to_repair` text NOT NULL,
  `shop_id` int(11) NOT NULL,
  `tech_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `agreement` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=pending,2=appointed,3=finished',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `ref_num`, `user_id`, `fname`, `lname`, `birthdate`, `gender`, `phone_number`, `street`, `city`, `to_repair`, `shop_id`, `tech_id`, `date`, `time`, `agreement`, `status`, `created_at`, `updated_at`) VALUES
(1, '0', 1, 'rogine', 'bawiga', '2024-10-11', 'Male', '90911230912', 'Baod, Bantayan, Cebu, Philippines', 'Cebu', 'Motorcycle: tires, rims', 1, 4, '2024-10-11', '18:46:00', 1, 2, '2024-10-11 10:46:22', '2024-10-13 15:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `owner_id`, `name`, `street`, `city`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Shop Wise', 'Street 1', 'Fighter', 1, '2024-10-11 06:32:27', '2024-10-12 17:28:30'),
(3, 3, 'One Punch', 'Bulacao', 'Pardo', 1, '2024-10-12 17:31:16', '2024-10-12 17:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `tech_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `tech_id`, `shop_id`, `created_at`, `updated_at`) VALUES
(3, 4, 3, '2024-10-13 14:30:47', '2024-10-13 14:43:50'),
(4, 4, 1, '2024-10-13 14:39:45', '2024-10-13 14:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 4 COMMENT '1 = admin, 2 = owner, 3= technician, 4 = user',
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `verification`, `type`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 'rogine', 'roginemy', 'bawigarogine02@gmail.com', '$2y$10$Ma5FlZoSjAxh0uxcPSnLpeDWILpSFP3UIZF0zhiIeGS4J9pEKRkci', NULL, 4, '101752161670be5605de6c', '2024-10-11 12:33:22', '2024-10-13 15:21:04'),
(2, 'admin', 'admin1@2024', 'admin1@gmail.com', '$2y$10$ybSSuJ0f9APLUNxTd5L/YuqLe6Y1gtwOrbkr6.VgB0SO.PLgIS50W', NULL, 1, '802492030670aa64c2d806', '2024-10-12 14:49:03', '2024-10-12 16:39:40'),
(3, 'Owner One', 'owner1', 'owner1@gmail.com', '$2y$10$LfsYPwqBZucbYBxqIUoXB.8L4IYnCEFyigy9SIqKhgvhR6wwT1aIq', NULL, 2, '25553471670bb572305c2', '2024-10-12 16:37:44', '2024-10-13 11:56:34'),
(4, 'technician1', 'technician1', 'technician1@gmail.com', '$2y$10$TrmAXkp3mJE/I6Xal1WWpOrn1PupIqgzFoFkmGv98fMTFdmbz2IpO', NULL, 3, '682893928670bb4b954bfe', '2024-10-12 16:38:23', '2024-10-13 11:53:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
