-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 06:51 PM
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
-- Database: `stardust`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', '123123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `toy_size` varchar(255) DEFAULT NULL,
  `embroid` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `font` varchar(255) DEFAULT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_email`, `item_id`, `quantity`, `toy_size`, `embroid`, `color`, `font`, `price`) VALUES
(32, 'grace@email.com', 43, 5, 'medium', 'withoutemb', '', '', 1195);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `img_prev1` varchar(255) NOT NULL,
  `img_prev2` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `typeoftoy` varchar(255) NOT NULL,
  `shipsFrom` varchar(255) NOT NULL,
  `totalQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `img`, `img_prev1`, `img_prev2`, `title`, `rating`, `price`, `category`, `typeoftoy`, `shipsFrom`, `totalQty`) VALUES
(2, '6729aa3fe4955_smiski yoga.png', '', '', 'Smiski Yoga', 4.5, 119.00, 'smiski', 'smiski', '12', 6),
(3, 'smiski sit.png', '', '', 'Smiski Sit', 4.5, 119.00, 'smiski', 'smiski', '12 November 2024', 0),
(7, 'angel-cat.png', '', '', 'Sonny Angels Tuxedo', 4.5, 149.00, 'sonny', 'sonny', '12 November 2024', 0),
(11, 'cali-new.png', '', '', 'Sonny Angels Calico Cat', 4.5, 119.00, 'new', 'sonny', '12 November 2024', 0),
(12, 'gray-new.png', '', '', 'Sonny Angels Silver Tabby', 4.5, 119.00, 'new', 'sonny', '12 November 2024', 0),
(13, 'white-new.png', '', '', 'Sonny Angels White Cat', 4.5, 119.00, 'new', 'sonny', '12 November 2024', 3),
(14, 'siamese-new.png', '', '', 'Sonny Angels Siamese Cat', 4.5, 119.00, 'new', 'sonny', '12 November 2024', 0),
(15, '6729a8a2c70ce_reindeer-trending.png', '672ce11552369_ROM2R_2__90723-removebg-preview.png', '672ce115526e0_ROM2R_3__07825-removebg-preview.png', 'Jellycat Reindeer', 4.7, 129.00, 'trending', 'jelly', '12', 0),
(16, '6729aa4e3412c_snowman-trending.png', '672ce64240eac_SWM3J_2__28995-removebg-preview.png', '672ce642410da_SWM3J_3__58351-removebg-preview.png', 'Jellycat Snowman', 4.8, 159.00, 'trending', 'jelly', '12', 0),
(17, 'cookie-trending.png', '672ce073db598_A6GTC_2__57348-removebg-preview.png', '672ce073db7e5_A6GTC_3__69331-removebg-preview.png', 'Jellycat Cookie', 4.8, 159.00, 'trending', 'jelly', '12', 5),
(31, '6729aa2d8b0d2_smiskisecret.png', '', '', 'Smiski Yoga Pair', 4.5, 119.00, 'smiski', 'smiski', '12', 5),
(35, '672a74de248b5_BAS3FUD__64502-removebg-preview.png', '672ce71e7acee_BAS3FUD_1__51941-removebg-preview.png', '672ce71e7b290_BAS3FUD_2__52090-removebg-preview.png', 'Jellycat Fudge', 4.5, 129.00, 'jelly', 'jelly', '12', 5),
(36, '6729d25831c03_BAS3MOSS__94649-removebg-preview.png', '672ce3d665034_BAS3MOSS_3__81514-removebg-preview.png', '672ce3f80c8f9_BAS3MOSS_3_1024x1024_2x-removebg-preview (1).png', 'Jellycat Moss', 4.5, 129.00, 'jelly', 'jelly', '12', 4),
(37, '6729d2e365c9b_6e93e31ae72f4a29af3a967359357d2f-removebg-preview 1.png', '', '', 'Smiski Lotus', 4.7, 119.00, 'smiski', 'smiski', '12', 6),
(38, '6729d2fd2bda7_856b41a0867a8c85a84730eeb905146b-removebg-preview 1.png', '', '', 'Smiski Meow', 4.5, 129.00, 'smiski', 'smiski', '12', 1),
(43, '672b1ba987b0f_scarlet.png', '672cdf5a8152a_BAS3SCA_2__84569-removebg-preview.png', '672cdf5a818d3_BAS3SCA_3__29585-removebg-preview.png', 'Jellycat Clifford', 5, 239.00, 'jelly', 'jelly', '12', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `embroid` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `font` varchar(50) DEFAULT NULL,
  `stripe_payment_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` double NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_email`, `item_id`, `quantity`, `price`, `embroid`, `color`, `font`, `stripe_payment_id`, `created_at`, `totalAmount`, `status`) VALUES
(7, 'grace@email.com', 15, 2, 129.00, 'withoutemb', NULL, NULL, 'pi_3QHQbQEEn0kU8TJT1rCatbGv', '2024-11-04 13:45:58', 258, 'Packed'),
(8, 'grace@email.com', 11, 2, 119.00, NULL, NULL, NULL, 'pi_3QHQbQEEn0kU8TJT1rCatbGv', '2024-11-04 13:45:58', 496, 'Packed'),
(9, 'grace@email.com', 6, 1, 159.00, 'withemb', 'Blue', 'Arial', 'pi_3QHQjxEEn0kU8TJT1PoKzNTE', '2024-11-04 13:54:47', 159, 'Packed'),
(12, 'grace@email.com', 16, 1, 159.00, 'withoutemb', '', '', 'pi_3QHhVzEEn0kU8TJT0KndN07N', '2024-11-05 07:49:30', 159, 'Awaiting'),
(13, 'grace@email.com', 32, 2, 129.00, 'withemb', 'Pearl', 'Hobo', 'pi_3QHhXxEEn0kU8TJT1vBDyFDu', '2024-11-05 07:51:32', 258, 'Awaiting'),
(15, 'grace@email.com', 43, 1, 119.00, 'withemb', 'Bubblegum', 'Chancery', 'pi_3QIMF0EEn0kU8TJT1By5to6v', '2024-11-07 03:18:42', 119, 'Packed'),
(16, 'dxrshx101@gmail.com', 43, 1, 239.00, 'withoutemb', '', '', 'pi_3QIZXLEEn0kU8TJT0elTieUu', '2024-11-07 17:30:30', 239, 'Awaiting');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `embroid` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `font` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `reset_token`, `token_expiry`, `address`) VALUES
(1, 'Darshanaa Naresh', 'dxrshx101@gmail.com', '123123', '0165360830', NULL, NULL, 'I-Suria Block 3-7-5 Medan Kampung Relau 1 Bayan Baru, Pulau Pinang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
