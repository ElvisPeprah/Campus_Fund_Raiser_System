-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 09:45 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_fundraiser`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '1111', '');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `goal` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `purpose` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `name`, `purpose`, `amount`, `contact`, `user_id`) VALUES
(2, 'Jane Smith', 'Library Donation', '50.00', '0540484368', 1),
(6, 'Ebenezer Boakye', 'Schloarship fund', '100.00', '0244567643', 1),
(7, 'Dennis Amankwaa Acquah', 'library fund', '50.00', '0540754868', NULL),
(8, 'paul lamptey', 'Disable support', '250.00', '0245345213', 3),
(9, 'Felix Oppong', 'donation gift', '450.00', '0554567621', NULL),
(10, 'Ernest Oppong', 'scholarship fund', '100.00', '0554567621', NULL),
(11, 'eben', 'book support', '50.00', '0554567621', NULL),
(12, 'Bismark Ahenkorah', 'gift', '50.00', '0245346754', NULL),
(13, 'Paul Lamptey', 'NGO support', '500.00', '0245654312', NULL),
(14, 'Abubakar', 'support', '50.00', '0536781774', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `purpose` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `contact` varchar(56) NOT NULL,
  `transaction_Id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `user_id`, `name`, `email`, `purpose`, `amount`, `contact`, `transaction_Id`, `status`, `payment_status`) VALUES
(1, 2, 'ebenzer', 'yiadomboakye360@gmail.com', 'scholarship fund', '50.00', '0245345672', 1345672, 'success', 'verified'),
(2, 2, 'Boakye', 'yiadomboakye360@gmail.com', 'book', '20.00', '0245123412', 2147483647, 'success', 'verified'),
(3, 4, 'oppong', 'oppongfelix321@gmail.com', 'book fund', '33.00', '0245123412', 2147483647, 'success', 'verified'),
(5, 4, 'oppong', 'oppongfelix321@gmail.com', 'library fund', '4.00', '0245123412', 2147483647, 'success', 'verified'),
(6, 2, 'ebenzer', 'yiadomboakye360@gmail.com', 'scholarship fund', '45.00', '0245345672', 2147483647, 'success', 'verified'),
(7, 2, 'ebenzer', 'yiadomboakye360@gmail.com', 'scholarship fund', '4.00', '0245345672', 2147483647, 'success', 'verified'),
(8, 4, 'oppong', 'oppongfelix321@gmail.com', 'scholarship fund', '3.00', '0245345672', 2147483647, 'success', 'verified'),
(9, 2, 'ebenzer', 'yiadomboakye360@gmail.com', 'project support', '50.00', '0504563421', 10134578, 'success', 'verified'),
(10, 2, 'abu', 'abubakarabdulaziz30@gmail.com', 'scholarship fund', '100.00', '0245345672', 2147483647, 'success', 'verified'),
(11, 2, 'Osman', 'abubakarabdulaziz30@gmail.com', 'funeral', '1000.00', '0245345672', 2147483647, 'success', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('ussd','bank_transfer') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `transaction_type`, `date`) VALUES
(1, 1, '100.00', 'bank_transfer', '2024-08-15 12:00:00'),
(2, 2, '50.00', 'ussd', '2024-08-16 15:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '1111', 'admin'),
(2, 'user1', '1234', 'user'),
(3, 'yiadomboakye360@gmail.com', 'Boakye@1994@1996', 'admin'),
(4, 'boakye', '1994', 'admin'),
(5, 'ernest', '2222', 'admin'),
(7, 'admin@admin', '1994', 'admin'),
(8, 'user2', '1111', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
