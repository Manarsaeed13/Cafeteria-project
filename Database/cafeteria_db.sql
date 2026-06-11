-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260526.9a43c2e222
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2026 at 08:19 PM
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
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int NOT NULL,
  `User_id` int NOT NULL,
  `Room_id` int NOT NULL,
  `Notes` text NOT NULL,
  `Total_price` decimal(10,2) NOT NULL,
  `Status` enum('processing','out_for_delivery','done','cancelled') NOT NULL DEFAULT 'processing',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(150) NOT NULL,
  `Code` int NOT NULL,
  `Created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Is_available` tinyint(1) NOT NULL,
  `Category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `Name`, `Price`, `Image`, `Is_available`, `Category_id`) VALUES
(1, 'Americano', 25.00, 'images/Americano_iced_coffee_in_a_202605292104.jpg', 1, 1),
(2, 'Berry Mojito', 35.00, 'images/Berry_mojito_drink_in_a_202605292106.jpg', 1, 2),
(3, 'Caramel Macchiato', 40.00, 'images/Caramel_macchiato_iced_drink,_isolated_202605292102.jpg', 1, 3),
(4, 'Chocolate Frappe', 43.00, 'images/Chocolate_frappe_with_whipped_cream_202605292107.jpg', 1, 4),
(5, 'Hot Coffee', 18.00, 'images/A_steaming_cup_of_hot_202605292152.jpg', 1, 5),
(6, 'Hot Tea', 15.00, 'images/An_elegant_cup_of_hot_202605292152.jpg', 1, 6),
(7, 'Espresso', 22.00, 'images/Espresso_drink_product_photo,_isolated_202605292046 (1).jpg', 1, 7),
(8, 'Flat White', 32.00, 'images/Flat_white_coffee_drink,_transparent_202605292103 (1).jpg', 1, 8),
(9, 'Guava Juice', 30.00, 'images/Guava_juice_drink_in_a_202605292053.jpg', 1, 9),
(10, 'Hazelnut Latte', 38.00, 'images/Hazelnut_latte_iced_coffee,_transparent_202605292102.jpg', 1, 10),
(11, 'Lemon Mint', 32.00, 'images/Iced_lemon_mint_drink_in_202605292100.jpg', 1, 11),
(12, 'Matcha Latte', 45.00, 'images/Iced_matcha_latte_in_a_202605292106.jpg', 1, 12),
(13, 'Lotus Milkshake', 48.00, 'images/Lotus_milkshake_in_an_elegant_202605292107.jpg', 1, 13),
(14, 'Mango Juice', 32.00, 'images/Mango_juice_in_an_elegant_202605292052.jpg', 1, 14),
(15, 'Passion Fruit Mojito', 37.00, 'images/Passion_fruit_mojito_in_elegant_202605292106.jpg', 1, 15),
(16, 'Strawberry Juice', 33.00, 'images/Strawberry_juice_drink_in_a_202605292053.jpg', 1, 16),
(17, 'Water', 10.00, 'images/A_clear_water_glass_with_202605292200.jpeg', 1, 17),
(18, 'Cola', 20.00, 'images/A_glass_of_cola_with_202605292145.jpg', 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `ID` int NOT NULL,
  `Room_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `Name` varchar(100) NOT NULL,
  `E-mail` varchar(150) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Profile_picture` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `Ext` int NOT NULL,
  `Room_ID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `E-mail`, `Password`, `Profile_picture`, `role`, `Ext`, `Room_ID`) VALUES
(1, 'Ahmed Mohamed', 'Ahmed@gmail.com', '123456##', 'D:Desktop\\Cafeteria-\\images\\Ultra_realistic_studio_portrait,_soft_202605292224', 'user', 123, 100);

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
  ADD KEY `FK` (`User_id`),
  ADD KEY `F_K` (`Room_id`);

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
  ADD KEY `FK` (`Category_id`);

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
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`E-mail`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
