-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 01:11 PM
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
-- Database: `purpleyam_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `product_name` varchar(255) DEFAULT NULL,
  `variant` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `order_date`, `product_name`, `variant`, `quantity`, `unit_price`, `grand_total`) VALUES
(1, 5, 575.00, '2025-12-11 12:08:12', 'Ube Creamcheese Bars', 'Slice', 5, 115.00, 625.00),
(2, 5, 92.00, '2025-12-11 12:57:14', 'Ube Creamcheese Bars', 'Slice', 2, 46.00, 142.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `contact`) VALUES
(1, 'abreganamaryrose@gmail.com', '$2y$10$F4H4SGlujlmeFAuY59P/ouVPPUS58c7BDAd2E4mUAZlkjzQIo71wO', 'Mary Rose ', 'Abregana', '09942238270'),
(2, 'abreganamarykate@gmail.com', '$2y$10$O/eJv.2KEluh1noLK/oPNOBEXyKb7SmK3TpprAhs3hvOMGTTtlvmq', 'Erilyn', 'Abregana', '09876724235'),
(3, 'panie@gmail.com', '$2y$10$AqlzSsAwzDWnAKK2HPBZveyeNeDg8zZjsLFWy9zrHkWzg0oOt1McS', 'Panie', 'Ong', '09876724235'),
(4, 'abreganamhike@gmail.com', '$2y$10$laoRUC5DXciWD9jp6.EDKeomzf/NulUYmHtXx9WN.zn3daGrEuVX.', 'Mhike ', 'Abregana', '09942238272'),
(5, 'butiti@gmail.com', '$2y$10$b0JhJS/tAZcaaKzpV2friOpU6n7T.Q4egq325K505Jvl2w7pAFe.u', 'paniee', 'JKJBHJB', '0913124423');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
