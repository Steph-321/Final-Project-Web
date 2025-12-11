-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 09:41 AM
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
(1, 5, 490.00, '2025-12-11 08:30:15', 'Purple Yam Cake', 'Round', 1, 490.00, 540.00),
(2, 5, 340.00, '2025-12-11 08:42:23', 'Purple Yam Cake (Tincan)', 'Tincan Round', 1, 340.00, 390.00),
(3, 5, 610.00, '2025-12-11 08:44:11', 'Purple Yam Cake', 'Medium', 1, 610.00, 660.00),
(4, 5, 490.00, '2025-12-11 09:08:26', 'Purple Yam Cake', 'Round', 1, 490.00, 540.00),
(5, 5, 3680.00, '2025-12-11 09:24:37', 'Purple Yam Cake', 'Large', 2, 1840.00, 3730.00),
(6, 5, 490.00, '2025-12-11 09:25:26', 'Purple Yam Cake', 'Heart', 1, 490.00, 540.00),
(7, 5, 920.00, '2025-12-11 09:38:31', 'Purple Yam Cake', 'Large', 1, 920.00, 970.00);

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
(5, 'butiti@gmail.com', '$2y$10$b0JhJS/tAZcaaKzpV2friOpU6n7T.Q4egq325K505Jvl2w7pAFe.u', 'rfsfsdw', 'siyaaa', '0913124423');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
