-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 07:26 AM
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
-- Database: `javajam`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_details` text NOT NULL,
  `grand_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `order_details`, `grand_total`) VALUES
(3, '2024-10-14 21:56:06', '[{\"id\":\"1\",\"quantity\":\"02\",\"price_per_cup\":\"2.00\",\"subtotal\":4}]', 4.00),
(4, '2024-10-14 21:59:05', '[{\"id\":\"1\",\"quantity\":\"02\",\"price_per_cup\":\"2.00\",\"subtotal\":4},{\"id\":\"2\",\"quantity\":\"5\",\"price_per_cup\":\"2.00\",\"subtotal\":10},{\"id\":\"3\",\"quantity\":\"6\",\"price_per_cup\":\"3.00\",\"subtotal\":18},{\"id\":\"4\",\"quantity\":\"2\",\"price_per_cup\":\"4.75\",\"subtotal\":9.5},{\"id\":\"5\",\"quantity\":\"3\",\"price_per_cup\":\"5.75\",\"subtotal\":17.25}]', 58.75),
(5, '2024-10-14 22:02:32', '[{\"id\":\"1\",\"quantity\":\"02\",\"price_per_cup\":\"3.00\",\"subtotal\":6}]', 6.00),
(6, '2024-10-14 22:03:09', '[{\"id\":\"2\",\"quantity\":5,\"price_per_cup\":\"2.00\",\"subtotal\":10}]', 10.00),
(7, '2024-10-15 10:35:02', '[{\"id\":\"2\",\"quantity\":1,\"price_per_cup\":\"2.00\",\"subtotal\":2},{\"id\":\"4\",\"quantity\":6,\"price_per_cup\":\"4.75\",\"subtotal\":28.5},{\"id\":\"5\",\"quantity\":7,\"price_per_cup\":\"5.75\",\"subtotal\":40.25}]', 70.75),
(8, '2024-10-15 11:13:39', '[{\"id\":\"1\",\"quantity\":1,\"price_per_cup\":\"3.00\",\"subtotal\":3},{\"id\":\"2\",\"quantity\":2,\"price_per_cup\":\"4.00\",\"subtotal\":8},{\"id\":\"3\",\"quantity\":3,\"price_per_cup\":\"5.00\",\"subtotal\":15},{\"id\":\"4\",\"quantity\":4,\"price_per_cup\":\"4.75\",\"subtotal\":19},{\"id\":\"5\",\"quantity\":5,\"price_per_cup\":\"5.75\",\"subtotal\":28.75}]', 73.75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
