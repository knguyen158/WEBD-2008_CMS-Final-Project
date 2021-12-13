-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2021 at 07:20 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Tops', 'Including t-shirts, button-up and all kind of tops '),
(2, 'Skirts', 'Skirts'),
(3, 'Pants', 'Pants'),
(4, 'Underwear', 'Underwear'),
(5, 'Dresses', 'Dresses'),
(6, 'Accessories', 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `name`, `content`, `date_created`) VALUES
(15, 41, 'Sandy Smith', 'Best skirt I have ever had! I wear it for most of the events I&#039;ve been to.', '2021-11-24 14:20:13'),
(16, 41, 'Lilith Young', 'The colour of the skirt is really beautiful and I can&#039;t wait to introduce Green Bean&#039;s products to my friends.', '2021-11-24 14:23:27'),
(17, 41, 'Brandon Flowers', 'My wife just simply loves this skirt.', '2021-11-24 14:26:14'),
(18, 41, 'Nina Simone', 'Can\'t have enough of your products!', '2021-11-26 10:38:53'),
(19, 40, 'Jason Mraz', 'I usually wear it with my cool hat and it rocks', '2021-11-26 10:40:31'),
(27, 1, 'Manny Floyd', 'Beautiful!', '2021-11-28 21:04:18'),
(28, 1, 'Sam Smith', 'Looks great on any of my pants.', '2021-11-28 21:04:39'),
(38, 41, 'asdasd', 'asdasd', '2021-12-07 22:29:58'),
(39, 41, 'test', 'test', '2021-12-07 22:30:27'),
(40, 41, 'test 2', 'test 2', '2021-12-07 22:30:48'),
(41, 41, 'test new', 'test new', '2021-12-07 22:40:33'),
(42, 41, 'test new 1', 'test new 1', '2021-12-07 22:40:52'),
(43, 41, 'Test', 'Test', '2021-12-07 22:52:23'),
(44, 41, 'asdasd', 'asdasd', '2021-12-07 22:53:45'),
(45, 41, 'adsda', 'asdasd', '2021-12-07 22:54:01'),
(46, 41, 'test new', 'test new', '2021-12-07 23:07:09'),
(47, 41, 'testing ', 'testing', '2021-12-07 23:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `customerorder`
--

CREATE TABLE `customerorder` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `order_date` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `product_id`, `image_path`) VALUES
(60, 41, '.\\uploads\\41_resized.jpg'),
(61, 40, '.\\uploads\\40_resized.jpg'),
(62, 39, '.\\uploads\\39_resized.jpg'),
(63, 38, '.\\uploads\\38_resized.jpg'),
(64, 24, '.\\uploads\\24_resized.jpg'),
(65, 1, '.\\uploads\\1_resized.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orderlineitem`
--

CREATE TABLE `orderlineitem` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `produc_price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `price` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `price`, `date_created`) VALUES
(1, 1, 'Lazy Tee', 'Unisex Lazy Tee for all. Easy to wear and to wash, it will not cause you rash or itchy. Ultimate tee for all kind of events and meetings. Using the best material on the market, this purchase will be your best for your budget.', 43.99, '2021-11-08 08:10:01'),
(2, 1, 'Crop top', 'Crop top', 32.49, '2021-11-08 08:12:02'),
(3, 1, 'Swoosh Neck Tee', 'Swoosh Neck Tee', 38, '2021-11-08 08:12:35'),
(4, 1, 'Camo Top', 'Camo Top', 58.99, '2021-11-08 08:13:08'),
(5, 1, 'Unisex Tee', 'Unisex Tee', 35.69, '2021-11-08 08:13:43'),
(6, 1, 'Wool Pullover', 'Wool Pullover', 69.99, '2021-11-08 08:14:15'),
(7, 1, 'Stoic Turtleneck', 'Stoic Turtleneck', 68, '2021-11-08 08:14:53'),
(10, 1, 'Organic Cotton Cardigan', 'Organic Cotton Cardigan', 79.99, '2021-11-08 08:16:34'),
(11, 1, 'V-Neck T-shirt', 'V-Neck T-shirt', 32.49, '2021-11-08 08:17:11'),
(12, 1, 'Striped Long Sleeve', 'Striped Long Sleeve', 45.99, '2021-11-08 08:17:57'),
(24, 5, 'Full Body Dresses', 'Full Body Dresses', 159.99, '2021-11-11 16:03:30'),
(25, 6, 'Wooden Earrings', 'Wooden Earrings', 34.33, '2021-11-11 16:04:01'),
(33, 2, 'Short skirt', 'Short pink skirt', 59.59, '2021-11-14 21:38:22'),
(37, 4, 'Natural Cotton Underwear', 'Natural Cotton Underwear', 59.69, '2021-11-14 21:41:02'),
(38, 6, 'Blue Jeans', 'Blue Jeans', 89.99, '2021-11-14 21:44:33'),
(39, 3, 'Brown Jeans', 'Brown Jeans', 79.99, '2021-11-14 21:53:37'),
(40, 6, 'Nose Rings', 'Nose Rings', 34.49, '2021-11-14 21:54:12'),
(41, 2, 'Pink Skirt', 'Pink Skirt', 68.89, '2021-11-14 21:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(100) NOT NULL,
  `role` char(15) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`name`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customerorder`
--
ALTER TABLE `customerorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orderlineitem`
--
ALTER TABLE `orderlineitem`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `customerorder`
--
ALTER TABLE `customerorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `customerorder`
--
ALTER TABLE `customerorder`
  ADD CONSTRAINT `customerorder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `orderlineitem`
--
ALTER TABLE `orderlineitem`
  ADD CONSTRAINT `orderlineitem_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `orderlineitem_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `customerorder` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
