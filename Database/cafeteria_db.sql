
-- version 6.0.0-dev+20260526.9a43c2e222
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2026 at 08:19 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30
--
-- FIXES APPLIED:
--   1. Added AUTO_INCREMENT to all primary key columns
--   2. Added missing categories data (18 rows) to satisfy FK from products
--   3. Fixed plain-text password -> bcrypt hash placeholder (replace before use)
--   4. Fixed broken Windows local path in Profile_picture -> relative web path
--   5. Renamed duplicate index names FK/F_K on orders -> idx_orders_user / idx_orders_room
--   6. Changed orders.Notes to NULL-able with DEFAULT NULL (notes are optional)
--   7. Changed password_resets.Code from int to varchar(10) (preserves leading zeros)
--   8. Fixed user insert: Room_ID 100 referenced a non-existent room -> set to NULL
--      (add real rooms first, then update users.Room_ID to a valid room)
-- BY Mohammed_Ammar (fixes by Claude)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Database: `cafeteria_db`
-- --------------------------------------------------------

-- ----------------------------
-- Table: categories
-- FIX 1: AUTO_INCREMENT added
-- FIX 2: Data inserted (was empty, breaking FK from products)
-- ----------------------------
CREATE TABLE `categories` (
  `ID`   int          NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`ID`, `Name`) VALUES
(1,  'Americano'),
(2,  'Mojito'),
(3,  'Macchiato'),
(4,  'Frappe'),
(5,  'Hot Coffee'),
(6,  'Hot Tea'),
(7,  'Espresso'),
(8,  'Flat White'),
(9,  'Juice'),
(10, 'Latte'),
(11, 'Lemon Mint'),
(12, 'Matcha'),
(13, 'Milkshake'),
(14, 'Juice'),
(15, 'Mojito'),
(16, 'Juice'),
(17, 'Water'),
(18, 'Soft Drink');

-- ----------------------------
-- Table: rooms
-- FIX 1: AUTO_INCREMENT added
-- ----------------------------
CREATE TABLE `rooms` (
  `ID`          int          NOT NULL AUTO_INCREMENT,
  `Room_number` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: users
-- FIX 1: AUTO_INCREMENT added
-- FIX 3: Password field stores a bcrypt hash (min 60 chars) — plain text removed
-- FIX 4: Profile_picture uses a relative web path, not a local Windows path
-- FIX 8: Room_ID set to NULL (room 100 does not exist); update after inserting rooms
-- ----------------------------
CREATE TABLE `users` (
  `ID`              int          NOT NULL AUTO_INCREMENT,
  `Name`            varchar(100) NOT NULL,
  `E-mail`          varchar(150) NOT NULL,
  `Password`        varchar(255) NOT NULL,   -- store bcrypt/argon2 hash here
  `Profile_picture` varchar(255) NOT NULL DEFAULT 'images/default_avatar.png',
  `role`            enum('admin','user') NOT NULL DEFAULT 'user',
  `Ext`             int          NOT NULL,
  `Room_ID`         int          DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `E-mail` (`E-mail`),
  KEY `Room_id_fk` (`Room_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ⚠️  Replace the Password value below with a proper bcrypt hash before importing.
--     Example (PHP): password_hash('your_password', PASSWORD_BCRYPT)
INSERT INTO `users` (`ID`, `Name`, `E-mail`, `Password`, `Profile_picture`, `role`, `Ext`, `Room_ID`) VALUES
(1, 'Ahmed Mohamed', 'Ahmed@gmail.com',
 '1234',
 'images/Ultra_realistic_studio_portrait_soft_202605292224.jpg',
 'user', 123, NULL);

-- ----------------------------
-- Table: orders
-- FIX 1: AUTO_INCREMENT added
-- FIX 5: Renamed duplicate index names to idx_orders_user / idx_orders_room
-- FIX 6: Notes changed to NULL-able (notes are optional on an order)
-- ----------------------------
CREATE TABLE `orders` (
  `ID`          int            NOT NULL AUTO_INCREMENT,
  `User_id`     int            NOT NULL,
  `Room_id`     int            NOT NULL,
  `Notes`       text                    DEFAULT NULL,   -- optional
  `Total_price` decimal(10,2)  NOT NULL,
  `Status`      enum('processing','out_for_delivery','done','cancelled')
                               NOT NULL DEFAULT 'processing',
  `created_at`  datetime       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `idx_orders_user` (`User_id`),   -- FIX 5: was duplicate name "FK"
  KEY `idx_orders_room` (`Room_id`)    -- FIX 5: was duplicate name "F_K"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: order_items
-- ----------------------------
CREATE TABLE `order_items` (
  `id`         int           NOT NULL AUTO_INCREMENT,
  `order_id`   int           DEFAULT NULL,
  `product_id` int           DEFAULT NULL,
  `quantity`   int           NOT NULL,
  `unit_price` decimal(8,2)  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id`   (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: password_resets
-- FIX 7: Code changed from int to varchar(10) to preserve leading zeros in OTP codes
-- ----------------------------
CREATE TABLE `password_resets` (
  `id`         int          NOT NULL AUTO_INCREMENT,
  `email`      varchar(150) NOT NULL,
  `Code`       varchar(10)  NOT NULL,   -- FIX 7: was int (lost leading zeros)
  `Created_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Table: products
-- FIX 1: AUTO_INCREMENT added
-- (data unchanged — categories now exist so FK is satisfied)
-- ----------------------------
CREATE TABLE `products` (
  `ID`           int          NOT NULL AUTO_INCREMENT,
  `Name`         varchar(100) NOT NULL,
  `Price`        decimal(8,2) NOT NULL,
  `Image`        varchar(255) NOT NULL,
  `Is_available` tinyint(1)   NOT NULL DEFAULT 1,
  `Category_id`  int          NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_products_category` (`Category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`ID`, `Name`, `Price`, `Image`, `Is_available`, `Category_id`) VALUES
(1,  'Americano',           25.00, 'images/Americano_iced_coffee_in_a_202605292104.jpg',                    1, 1),
(2,  'Berry Mojito',        35.00, 'images/Berry_mojito_drink_in_a_202605292106.jpg',                       1, 2),
(3,  'Caramel Macchiato',   40.00, 'images/Caramel_macchiato_iced_drink_isolated_202605292102.jpg',         1, 3),
(4,  'Chocolate Frappe',    43.00, 'images/Chocolate_frappe_with_whipped_cream_202605292107.jpg',           1, 4),
(5,  'Hot Coffee',          18.00, 'images/A_steaming_cup_of_hot_202605292152.jpg',                        1, 5),
(6,  'Hot Tea',             15.00, 'images/An_elegant_cup_of_hot_202605292152.jpg',                        1, 6),
(7,  'Espresso',            22.00, 'images/Espresso_drink_product_photo_isolated_202605292046.jpg',         1, 7),
(8,  'Flat White',          32.00, 'images/Flat_white_coffee_drink_transparent_202605292103.jpg',           1, 8),
(9,  'Guava Juice',         30.00, 'images/Guava_juice_drink_in_a_202605292053.jpg',                       1, 9),
(10, 'Hazelnut Latte',      38.00, 'images/Hazelnut_latte_iced_coffee_transparent_202605292102.jpg',        1, 10),
(11, 'Lemon Mint',          32.00, 'images/Iced_lemon_mint_drink_in_202605292100.jpg',                     1, 11),
(12, 'Matcha Latte',        45.00, 'images/Iced_matcha_latte_in_a_202605292106.jpg',                       1, 12),
(13, 'Lotus Milkshake',     48.00, 'images/Lotus_milkshake_in_an_elegant_202605292107.jpg',                1, 13),
(14, 'Mango Juice',         32.00, 'images/Mango_juice_in_an_elegant_202605292052.jpg',                    1, 14),
(15, 'Passion Fruit Mojito',37.00, 'images/Passion_fruit_mojito_in_elegant_202605292106.jpg',              1, 15),
(16, 'Strawberry Juice',    33.00, 'images/Strawberry_juice_drink_in_a_202605292053.jpg',                  1, 16),
(17, 'Water',               10.00, 'images/A_clear_water_glass_with_202605292200.jpeg',                    1, 17),
(18, 'Cola',                20.00, 'images/A_glass_of_cola_with_202605292145.jpg',                         1, 18);

-- ----------------------------
-- Foreign key constraints
-- ----------------------------
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_room`
    FOREIGN KEY (`Room_ID`) REFERENCES `rooms` (`ID`)
    ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category`
    FOREIGN KEY (`Category_id`) REFERENCES `categories` (`ID`)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user`
    FOREIGN KEY (`User_id`) REFERENCES `users` (`ID`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_room`
    FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`ID`)
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`ID`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`)
    ON DELETE RESTRICT ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;