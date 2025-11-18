-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 07:23 AM
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
-- Database: `lakeshow_grocer`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(30) DEFAULT NULL,
  `status` enum('Active','Deleted') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `status`) VALUES
(1, 'Fresh Vegetable', 'Active'),
(2, 'Chilled and Frozen', 'Active'),
(3, 'Snacks', 'Active'),
(4, 'Bakery', 'Active'),
(5, 'Beverages', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cus_ID` int(11) NOT NULL,
  `Cus_Code` varchar(20) DEFAULT NULL,
  `Cus_Name` varchar(30) DEFAULT NULL,
  `Cus_Email` varchar(40) DEFAULT NULL,
  `Cus_Phone` varchar(15) DEFAULT NULL,
  `Cus_Password` varchar(255) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'customer',
  `Security_Question` varchar(255) DEFAULT NULL,
  `Security_Answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cus_ID`, `Cus_Code`, `Cus_Name`, `Cus_Email`, `Cus_Phone`, `Cus_Password`, `Created_At`, `Updated_At`, `role`, `Security_Question`, `Security_Answer`) VALUES
(17, 'CS2500003', 'Yvonne Tey Hui Xuan', 'yvonnetey423@gmail.com', '01111160116', '$2y$10$oLDl8Zb4BXpsZzaKNh4e2eKfdsip2mRDDWgaUnJgU1VfR.cOpooma', '2025-05-29 15:37:46', '2025-05-29 15:37:46', 'customer', 'What is your favorite color?', 'black'),
(22, 'CS2500004', 'Lim Yi Xin', '1221205977@student.mmu.edu.my', '01111160116', '$2y$10$uXXSEvF4uSPegOiFQj5GPOVO8KFcyQ6P/BSQk9w1ViDWkkfHYJuGa', '2025-05-29 15:56:10', '2025-05-29 15:56:10', 'customer', 'What is your favorite color?', '$2y$10$9/J08kObrntJWYJmcfZKSOQfQ0CUriQugmcIu2ELqBKNvB7qxXxs2'),
(27, 'CS2500006', 'Cha Aik Hong', 'aikhongcha@gmail.com', '01111160116', '$2y$10$eCqc6LZ1s60xL/q7rePjTeIpIeVPw7Vitwp3/u2iDJcHNHCgclyIW', '2025-05-30 00:44:20', '2025-05-30 00:44:20', 'customer', 'What is your favorite color?', '$2y$10$TLfDybR2YZM4sHUxR2cf.OKJncr1ndk09ToiDZG1bOlTDuo0RrKMS'),
(31, 'CS2500007', 'Nicholas Chong', 'nicholaskai73@gmail.com', '01111160116', '$2y$10$IYuGKHCbbxtirifmm5KX.e4wR.u7PR0.nRUmwqCtQGgB6jRjHfJF.', '2025-05-30 02:21:39', '2025-06-08 14:23:09', 'customer', 'What is your favorite color?', '$2y$10$1o5WmzBYQ2P.rmOWnHXTmeRc/5eJIBNm9hlwW0VfXrM.ebqfURISS');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Order_ID` int(11) NOT NULL,
  `Cus_ID` int(11) DEFAULT NULL,
  `Address_ID` int(11) DEFAULT NULL,
  `Order_Date` date DEFAULT NULL,
  `Total_Price` decimal(10,2) DEFAULT NULL,
  `Payment_Status` enum('Completed') NOT NULL,
  `Delivery_Status` enum('Processing','Packing','Shipped','Delivered') NOT NULL DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Order_ID`, `Cus_ID`, `Address_ID`, `Order_Date`, `Total_Price`, `Payment_Status`, `Delivery_Status`) VALUES
(30, 31, 5, '2025-06-06', 33.90, 'Completed', 'Processing'),
(31, 31, 5, '2025-06-06', 84.70, 'Completed', 'Processing'),
(32, 31, 6, '2025-06-06', 114.50, 'Completed', 'Processing'),
(34, 31, 5, '2025-06-07', 106.60, 'Completed', 'Processing'),
(35, 31, 5, '2025-06-07', 128.50, 'Completed', 'Processing'),
(36, 31, 5, '2025-06-07', 33.90, 'Completed', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `Order_Details_ID` int(11) NOT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Product_Price` decimal(10,2) DEFAULT NULL,
  `Promo_ID` varchar(10) DEFAULT NULL,
  `Cus_ID` int(11) DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`Order_Details_ID`, `Product_ID`, `Quantity`, `Product_Price`, `Promo_ID`, `Cus_ID`, `Order_ID`) VALUES
(9, 2, 1, 28.90, NULL, 31, 26),
(10, 2, 1, 28.90, NULL, 31, 30),
(11, 1, 1, 21.90, NULL, 31, 31),
(12, 2, 2, 28.90, NULL, 31, 31),
(13, 1, 5, 21.90, NULL, 31, 32),
(14, 2, 2, 28.90, NULL, 31, 34),
(15, 1, 2, 21.90, NULL, 31, 34),
(16, 2, 2, 28.90, NULL, 31, 35),
(17, 1, 3, 21.90, NULL, 31, 35),
(18, 2, 1, 28.90, NULL, 31, 36),
(19, 2, 1, 28.90, NULL, NULL, NULL),
(20, 1, 1, 21.90, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(40) DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Product_Picture` text DEFAULT NULL,
  `Product_Price` decimal(10,2) DEFAULT NULL,
  `Product_Stock` int(11) DEFAULT NULL,
  `Product_Description` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `Dis_Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Product_Name`, `Category_ID`, `Product_Picture`, `Product_Price`, `Product_Stock`, `Product_Description`, `status`, `Dis_Price`) VALUES
(1, 'Blueberry Driscolls (200g)', 1, 'driscollbluberries.webp', 21.90, 747, 'Big sized with rich flavor and sweetness as high as 90-100%, these berries are the best batch in season and not to be missed when in season! Country of Origin: Australia Nutrition facts: Great Source of Vitamin A, B-complex, C & E, Flavonoids, Potassium, Manganese and Copper.', 'Active', NULL),
(2, 'Kyoho Grape (500 g)', 1, 'kyohograpes.jpg', 28.90, 9, 'Kyoho grapes are large, dark maroon to black and thick-skinned grapes that offer a sweet flavor. This grape is actually large enough to peel, which makes it very popular among those who love to eat peeled grapes. Weight per box : 500g', 'Active', NULL),
(3, 'Mamee Monster', 3, 'mameemonster.webp', 4.50, 200, 'Crunchy noodle snack loved by kids and adults. Enjoy straight from the pack or sprinkle seasoning for extra flavor.', 'Active', NULL),
(4, 'Mee Sedap', 3, NULL, 44.00, 6, '', 'Active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cus_ID`),
  ADD UNIQUE KEY `Cus_Code` (`Cus_Code`),
  ADD UNIQUE KEY `uc_customer_email` (`Cus_Email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`),
  ADD KEY `Address_ID` (`Address_ID`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`Order_Details_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `FK_OrderDetails_Customer` (`Cus_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cus_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `Order_Details_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`Cus_ID`) REFERENCES `customer` (`Cus_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`Address_ID`) REFERENCES `address` (`Address_ID`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_OrderDetails_Customer` FOREIGN KEY (`Cus_ID`) REFERENCES `customer` (`Cus_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
