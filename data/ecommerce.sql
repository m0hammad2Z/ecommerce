-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 11:38 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorys`
--

CREATE TABLE `categorys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorys`
--

INSERT INTO `categorys` (`id`, `name`, `isDeleted`) VALUES
(1, 'Category 1', 0),
(2, 'Soccer', 0),
(3, 'Tennis', 0),
(4, 'Basketball', 0),
(5, 'Pilates', 0);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `productId`, `path`, `isDeleted`) VALUES
(1, 1, 'uploads/1_todo (2).png', 0),
(2, 1, 'uploads/1_RegiterBackground3.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `categoryId`, `stock`, `isDeleted`) VALUES
(1, 'Product A', 200, 'This product A', 1, 300, 0),
(22, 'Soccer Ball', 20.99, 'High-quality soccer ball for professional play', 1, 50, 0),
(23, 'Tennis Racket', 59.99, 'Lightweight racket for powerful shots', 2, 30, 0),
(24, 'Basketball', 24.99, 'Indoor/outdoor basketball for all surfaces', 3, 40, 0),
(25, 'Running Shoes', 79.99, 'Comfortable and durable running shoes', 4, 25, 0),
(26, 'Hiking Boots', 89.99, 'Waterproof hiking boots for outdoor adventures', 1, 15, 0),
(27, 'Table Tennis Paddle', 34.99, 'Professional-grade table tennis paddle', 2, 25, 0),
(28, 'Table Tennis Paddle', 34.99, 'Professional-grade table tennis paddle', 1, 25, 0),
(29, 'Badminton Shuttlecocks', 12.99, 'Feathered shuttlecocks for badminton', 5, 40, 0),
(30, 'Baseball Glove', 45.99, 'Leather baseball glove for fielding', 5, 20, 0),
(31, 'Climbing Harness', 74.99, 'Safety harness for rock climbing', 4, 10, 0),
(32, 'Surfboard', 299.99, 'Beginner-friendly surfboard for surfing', 1, 5, 0),
(33, 'Weightlifting Gloves', 19.99, 'Padded gloves for weightlifting', 2, 30, 0),
(34, 'Treadmill', 499.99, 'Electric treadmill for indoor running', 1, 8, 0),
(35, 'Snowboard', 179.99, 'Snowboard for winter sports enthusiasts', 2, 12, 0),
(36, 'Pilates Ball', 14.99, 'Inflatable ball for Pilates exercises', 3, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `totalPrice` float DEFAULT NULL,
  `orders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`orders`)),
  `status` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `userId`, `totalPrice`, `orders`, `status`, `isDeleted`) VALUES
(1, 1, 3000, '[{\"userId\":1,\"productId\":1,\"quantity\":1,\"price\":30,\"notes\":\"note a\"}]', 'pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`, `mobile`, `isDeleted`) VALUES
(1, 'Admin', 'admin@eco.com', '25d55ad283aa400af464c76d713c07ad', 'admin', '12345678', '0799999999', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorys`
--
ALTER TABLE `categorys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_10` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_11` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_12` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_13` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_14` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_15` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_16` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_17` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_18` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_19` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_20` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_21` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_22` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_23` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_24` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_4` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_5` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_6` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_7` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_8` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `images_ibfk_9` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_10` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_11` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_12` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_13` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_14` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_15` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_16` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_17` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_18` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_19` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_20` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_21` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_22` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_23` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_24` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_25` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_26` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_27` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_28` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_29` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_30` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_31` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_32` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_33` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_34` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_35` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_36` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_37` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_38` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_39` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_40` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_41` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_42` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_43` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_44` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_45` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_46` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_47` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_48` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_49` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_5` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_50` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_51` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_52` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_53` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_54` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_55` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_56` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_57` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_58` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_59` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_6` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_60` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_61` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_62` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_63` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_64` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_65` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_66` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_67` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_68` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_69` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_7` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_70` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_71` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_72` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_73` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_74` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_75` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_76` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_77` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_78` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_79` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_8` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_80` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_81` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_82` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_83` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_84` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_85` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_86` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `products_ibfk_9` FOREIGN KEY (`categoryId`) REFERENCES `categorys` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_10` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_11` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_12` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_13` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_14` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_15` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_16` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_17` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_18` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_19` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_20` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_21` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_22` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_23` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_24` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_25` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_26` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_27` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_5` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_6` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_7` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_8` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_9` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
