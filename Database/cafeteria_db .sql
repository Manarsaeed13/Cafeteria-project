-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260526.9a43c2e222
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2026 at 01:00 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafeteria_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`) VALUES
(1, 'Americano'),
(2, 'Mojito'),
(3, 'Macchiato'),
(4, 'Frappe'),
(5, 'Hot Coffee'),
(6, 'Hot Tea'),
(7, 'Espresso'),
(8, 'Flat White'),
(9, 'Juice'),
(10, 'Latte'),
(11, 'Lemon Mint'),
(12, 'Matcha'),
(13, 'Milkshake'),
(14, 'Juice'),
(15, 'Mojito'),
(16, 'Juice'),
(17, 'Water'),
(18, 'Soft Drink');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int NOT NULL,
  `User_id` int NOT NULL,
  `Room_id` int NOT NULL,
  `Notes` text COLLATE utf8mb4_general_ci,
  `Total_price` decimal(10,2) NOT NULL,
  `Status` enum('processing','out_for_delivery','done','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'processing',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `User_id`, `Room_id`, `Notes`, `Total_price`, `Status`, `created_at`) VALUES
(1, 1, 1, '', 25.00, 'done', '2026-06-17 15:21:30'),
(2, 1, 1, '', 20.00, 'done', '2026-06-17 15:36:57'),
(3, 1, 1, '', 20.00, 'done', '2026-06-17 15:37:26'),
(4, 1, 1, '', 10.00, 'done', '2026-06-17 15:40:26'),
(5, 1, 1, 'with ice', 94.00, 'done', '2026-06-17 16:06:44'),
(6, 1, 1, '', 25.00, 'done', '2026-06-17 16:09:19'),
(7, 1, 1, '', 58.00, 'processing', '2026-06-17 16:11:01'),
(8, 3, 2, '', 60.00, 'processing', '2026-06-17 23:03:11'),
(9, 8, 2, '', 43.00, 'processing', '2026-06-17 23:12:34'),
(10, 8, 2, '', 22.00, 'processing', '2026-06-17 23:15:12'),
(11, 5, 2, '', 54.00, 'processing', '2026-06-17 23:20:41'),
(12, 6, 2, '', 43.00, 'processing', '2026-06-17 23:22:10'),
(13, 3, 2, '', 25.00, 'processing', '2026-06-17 23:26:36'),
(14, 5, 2, '', 70.00, 'processing', '2026-06-17 23:27:18'),
(15, 5, 2, '', 58.00, 'done', '2026-06-17 23:39:47'),
(16, 5, 2, '', 60.00, 'done', '2026-06-17 23:45:37'),
(17, 3, 3, 'no suger', 45.00, 'done', '2026-06-18 12:21:52'),
(18, 5, 2, '', 100.00, 'processing', '2026-06-18 15:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 1, 25.00),
(2, 2, 18, 1, 20.00),
(3, 3, 18, 1, 20.00),
(4, 4, 17, 1, 10.00),
(5, 5, 7, 1, 22.00),
(6, 5, 8, 1, 32.00),
(7, 5, 9, 1, 30.00),
(8, 5, 17, 1, 10.00),
(9, 6, 1, 1, 25.00),
(10, 7, 1, 1, 25.00),
(11, 7, 5, 1, 18.00),
(12, 7, 6, 1, 15.00),
(13, 8, 1, 1, 25.00),
(14, 8, 2, 1, 35.00),
(15, 9, 4, 1, 43.00),
(16, 10, 7, 1, 22.00),
(17, 11, 7, 1, 22.00),
(18, 11, 8, 1, 32.00),
(19, 12, 4, 1, 43.00),
(20, 13, 1, 1, 25.00),
(21, 14, 2, 2, 35.00),
(22, 15, 1, 1, 25.00),
(23, 15, 5, 1, 18.00),
(24, 15, 6, 1, 15.00),
(25, 16, 2, 1, 35.00),
(26, 16, 6, 1, 15.00),
(27, 16, 17, 1, 10.00),
(28, 17, 6, 3, 15.00),
(29, 18, 2, 1, 35.00),
(30, 18, 4, 1, 43.00),
(31, 18, 7, 1, 22.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `Code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `Image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Is_available` tinyint(1) NOT NULL DEFAULT '1',
  `Category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `Name`, `Price`, `Image`, `Is_available`, `Category_id`) VALUES
(1, 'Americano', 25.00, 'images/Americano.jpeg', 1, 1),
(2, 'Berry Mojito', 35.00, 'images/Berry mojito.jpeg', 1, 2),
(3, 'Caramel Macchiato', 40.00, 'images/Caramel macchiato.jpeg', 1, 3),
(4, 'Chocolate Frappe', 43.00, 'images/Chocolate frappe.jpeg', 1, 4),
(5, 'Hot Coffee', 18.00, 'images/Coffee.jpg', 1, 5),
(6, 'Hot Tea', 15.00, 'images/Hot Tea.jpeg', 1, 6),
(7, 'Espresso', 22.00, 'images/Espresso.jpeg', 1, 7),
(8, 'Flat White', 32.00, 'images/Flat white.jpeg', 1, 8),
(9, 'Guava Juice', 30.00, 'images/Guava juice.jpeg', 1, 9),
(10, 'Hazelnut Latte', 38.00, 'images/Hazelnut latte.jpeg', 1, 10),
(11, 'Lemon Mint', 32.00, 'images/lemon mint.jpeg', 1, 11),
(12, 'Matcha Latte', 45.00, 'images/Matcha Latte.jpeg', 1, 12),
(13, 'Lotus Milkshake', 48.00, 'images/Lotus Milkshake.jpeg', 1, 13),
(14, 'Mango Juice', 32.00, 'images/Mango Juice.jpeg', 1, 14),
(15, 'Passion Fruit Mojito', 37.00, 'images/Passion Fruit Mojito.jpeg', 1, 15),
(16, 'Strawberry Juice', 33.00, 'images/Strawberry Juice.jpeg', 1, 16),
(17, 'Water', 10.00, 'images/Water.jpeg', 1, 17),
(18, 'Cola', 20.00, 'images/Cola.jpeg', 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `ID` int NOT NULL,
  `Room_number` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`ID`, `Room_number`) VALUES
(1, '101'),
(2, '102'),
(3, '103'),
(4, '104');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `E-mail` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Profile_picture` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'images/default_avatar.png',
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `Ext` int NOT NULL,
  `Room_ID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `E-mail`, `Password`, `Profile_picture`, `role`, `Ext`, `Room_ID`) VALUES
(1, 'Ahmed Mohamed', 'Ahmed@gmail.com', '$2y$12$REPLACE_THIS_WITH_A_REAL_BCRYPT_HASH_OF_THE_PASSWORD___', 'images/Boy1.jpeg', 'user', 12, 1),
(2, 'manar saeed', 'manarsaeed445@gmail.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'images/Girl1.jpeg', 'admin', 0, NULL),
(3, 'Mariam Ali', 'mariam@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYgi7B7DoKa', 'images\\Girl1.jpeg', 'user', 11, 3),
(5, 'Malak Khaled', 'malak@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYgi7B7DoKa', 'images\\Girl2.jpeg', 'user', 13, 2),
(6, 'Merna malek', 'merna@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYgi7B7DoKa', 'images\\Girl1.jpeg', 'user', 14, 4),
(8, 'Marina Ashraf', 'marina@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYgi7B7DoKa', 'images\\Girl1.jpeg', 'user', 15, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_orders_user` (`User_id`),
  ADD KEY `idx_orders_room` (`Room_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_products_category` (`Category_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `E-mail` (`E-mail`),
  ADD KEY `Room_id_fk` (`Room_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_room` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`User_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`Category_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_room` FOREIGN KEY (`Room_ID`) REFERENCES `rooms` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
