-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 04:20 AM
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
-- Database: `book_store1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
  PRIMARY KEY (`admin_id`), -- 设置主键
  UNIQUE KEY `email_unique` (`email`), -- 确保邮箱唯一
  UNIQUE KEY `username_unique` (`admin_name`) -- 确保用户名唯一
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `password`, `email`, `admin_image`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Wong Yung Sin', 'abc123', 'wong.yung.sin@student.mmu.edu.my', 'admin image/wys.jpg', NULL, '2026-01-30 02:23:52', '2026-01-30 02:23:52'),
(2, 'Chung Shin Ru', 'abc123', 'chung.shin.ru@student.mmu.edu.my', 'admin image/csr.jpg', NULL, '2026-01-30 02:37:12', '2026-01-30 02:37:12'),
(3, 'Heng Yu Xuan', 'abc123', 'heng.yu.xuan@student.mmu.edu.my', 'admin image/hyx.jpg', NULL, '2026-01-30 02:37:12', '2026-01-30 02:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `publisher` varchar(150) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `status` enum('available','out_of_stock') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `price`, `stock`, `description`, `publisher`, `language`, `pages`, `image`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Little Woman', 'Alcott, Louisa May', 'A100', 38.50, 10, 'A timeless coming-of-age novel that follows the lives of the four March sisters as they grow up during the American Civil War, exploring themes of family, love, and personal growth.', 'Penguin Classics', 'English', 368, 'product image/fiction/little woman.webp', 1, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(2, 'The Vegetarian', 'Kang, Han', 'A200', 57.20, 4, 'This novel tells the story of a woman who decides to stop eating meat, which triggers a series of unsettling events. A profound exploration of autonomy, identity, and societal expectations.', 'Granta Books', 'English', 208, 'product image/fiction/the vegtarian.jpg', 1, 'available', '2026-01-29 02:18:17', '2026-01-29 23:23:04'),
(3, 'The Handmaid’s Tale', 'Margaret Atwood', 'A300', 35.84, 10, 'A dystopian novel depicting a theocratic society where women are subjugated and used for reproduction, exploring themes of power, resistance, and female agency.', 'Vintage', 'English', 416, 'product image/fiction/the handmaid tale.jpg', 1, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(4, 'Circe', 'Miller, Madeline', 'A400', 27.80, 10, 'A fresh retelling of the myth of Circe, the enchantress from Homer’s Odyssey, highlighting her journey of self-discovery, magic, and empowerment.', 'Bloomsbury', 'English', 393, 'product image/fiction/Circe_(novel)_Madeline_Milller.jpeg', 1, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(5, 'To the Light House', 'Virginia Woolf', 'A500', 44.02, 10, 'A modernist novel that delves into the complexities of time, memory, and human relationships through the lens of a family’s visits to their summer home.', 'Hogarth Press', 'English', 240, 'product image/fiction/to the light house.jpg', 1, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(6, 'A Room of One’s Own', 'Virginia Woolf', 'B100', 31.40, 10, 'An extended essay advocating for women’s intellectual freedom and the necessity of financial independence for female writers and artists.', 'Penguin Classics', 'English', 176, 'product image/non-fiction/a room of one owns.jpg', 2, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(7, 'The Second Sex', 'de Beauvoir, Simone / Borde, Constance (TRN) / Malovany-Chevallier, Sheila (TRN)', 'B200', 48.16, 10, 'A foundational feminist text analyzing women’s historical oppression and challenging the social constructs of gender.', 'Vintage', 'English', 784, 'product image/non-fiction/the secon sex.jpg', 2, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(8, 'Surrounded by Idiots: The Four Types of Human Behavior and How to Effectively Communicate with Each in Business', 'Erikson, Thomas', 'B300', 145.20, 8, 'A practical guide to understanding different personality types and improving communication and collaboration in professional environments.', 'Sceptre', 'English', 368, 'product image/non-fiction/surrounded by Idiot.png', 2, 'available', '2026-01-29 02:18:17', '2026-01-29 23:10:03'),
(9, 'Invisible Woman', 'Perez, Caroline Criado', 'B400', 86.90, 10, 'A compelling examination of the systemic erasure of women from public life and history, advocating for recognition and equality.', 'Abrams Press', 'English', 432, 'product image/non-fiction/invisible woman.jpg', 2, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(10, 'The Beauty Myth', 'Naomi Wolf', 'B500', 27.12, 10, 'An insightful critique of cultural standards of beauty and their impact on women’s lives, challenging societal pressures and myths.', 'Vintage', 'English', 352, 'product image/non-fiction/the beauty myth.webp', 2, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(11, 'English Grammar in Use', 'Murphy, Raymond', 'C100', 98.00, 10, 'A comprehensive grammar reference book that provides clear explanations and practice exercises for English learners at all levels.', 'Cambridge University Press', 'English', 396, 'product image/education/english grammer in use.webp', 3, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(12, 'The Female Body Bible', 'Baz Moffat, Dr Emma Ross, Dr Bella Smith', 'C200', 84.96, 10, 'An authoritative guide to female anatomy, health, and wellness, combining medical knowledge with practical advice.', 'Dorling Kindersley', 'English', 400, 'product image/education/the female body bible.jpg', 3, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(13, 'The Good Virus: The Mysterious Microbes that Rule Our World, Shape Our Health and Can Save Our Future', 'Ireland, Tom', 'C300', 89.90, 10, 'Explores the vital role of microbes in human health and the environment, debunking myths about germs and illness.', 'Oxford University Press', 'English', 320, 'product image/education/the good virus.jpg', 3, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(14, 'Why We Run: A Natural History', 'Heinrich, Bernd', 'C400', 88.91, 10, 'An exploration of human endurance running from evolutionary, physiological, and cultural perspectives.', 'Penguin Press', 'English', 304, 'product image/education/why we run.jpg', 3, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(15, 'Night Magic', 'Henion, Leigh Ann', 'C500', 158.93, 10, 'A captivating novel blending magical realism with a coming-of-age story, exploring identity and destiny.', 'HarperCollins', 'English', 288, 'product image/education/night magic.jpg', 3, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(16, 'Data Analysis with Microsoft Power BI [Paperback]', 'Larson, Brian', 'D100', 207.00, 10, 'A detailed guide to using Microsoft Power BI for data visualization, analytics, and business intelligence.', 'Microsoft Press', 'English', 480, 'product image/technology/data analysis.jpg', 4, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(17, 'SQL Essentials for Dummies', 'Blum, Richard / Taylor, Allen G.', 'D200', 68.91, 10, 'An easy-to-understand introduction to SQL for beginners, covering key concepts and practical queries.', 'O’Reilly Media', 'English', 304, 'product image/technology/SQL essential.jpg', 4, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(18, 'Hacking for Dummies', 'Beaver, Kevin', 'D300', 118.31, 10, 'A beginner-friendly book on ethical hacking, covering tools and techniques for penetration testing.', 'Wiley', 'English', 456, 'product image/technology/Hacking for dummies.jpg', 4, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(19, 'Machine Learning for Hackers', 'Massaron, Luca', 'D400', 240.00, 10, 'A practical guide to machine learning techniques with examples geared towards data scientists and programmers.', 'O’Reilly Media', 'English', 330, 'product image/technology/machine learning for hackers.jpg', 4, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(20, 'HTML & CSS: Design and Build Websites', 'Dackett, Jon', 'D500', 147.95, 10, 'An accessible book covering fundamental concepts of web design, HTML, and CSS with practical projects.', 'Wiley', 'English', 624, 'product image/technology/HTML n CSS.jpg', 4, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(21, 'The Magical Adventures Of Phoebe And Her Unicorn', 'Dana Simpson', 'E100', 34.90, 10, 'A charming children’s fantasy series about friendship and adventure featuring a young girl and her magical unicorn.', 'Andrews McMeel', 'English', 232, 'product image/children/The Magical Adventures Of Phoebe And Her Unicorn.jpg', 5, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(22, 'The Magic Forest', 'Ann Elin Kringlen Ervik', 'E200', 40.97, 10, 'A beautifully illustrated storybook about exploration and wonder in a magical forest.', 'Nosy Crow', 'English', 48, 'product image/children/The magic forest.jpg', 5, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(23, 'Why Rhinos Need Friends', 'Pavla Hanackova', 'E300', 24.90, 10, 'An educational children’s book promoting wildlife conservation and friendship.', 'Albatros Media', 'English', 64, 'product image/children/Why Rhinos need friends.jpg', 5, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(24, 'The House at the End of the Sea', 'Victoria M. Adams', 'E400', 19.90, 10, 'A suspenseful children’s adventure involving mysteries surrounding a seaside house.', 'Walker Books', 'English', 96, 'product image/children/The house at the end of the sea.jpg', 5, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:50'),
(25, 'The Girl Who Built a Spider', 'George Brewington', 'E500', 29.90, 10, 'An imaginative children’s story about creativity, courage, and friendship.', 'Chronicle Books', 'English', 40, 'product image/children/the girl who built a spider.jpg', 5, 'available', '2026-01-29 02:18:17', '2026-01-29 22:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_id`, `status`, `created_at`) VALUES
(1, 'Fiction', NULL, 'active', '2026-01-29 01:34:23'),
(2, 'Non-Fiction', NULL, 'active', '2026-01-29 01:34:23'),
(3, 'Education', NULL, 'active', '2026-01-29 01:34:23'),
(4, 'Technology', NULL, 'active', '2026-01-29 01:34:23'),
(5, 'Children', NULL, 'active', '2026-01-29 01:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Suspended') NOT NULL DEFAULT 'Active',
  `profile_image` varchar(255) DEFAULT NULL
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `registration_date`, `status`, `profile_image`) VALUES
(1, 'Jack', 'jack@gmail.com', '012-3456789', 'Abcde&123456', '2026-01-29 04:59:43', 'Active', 'user image/user1.jpg'),
(2, 'Susan', 'susan@gmail.com', '019-8765432', 'Abcde&123456', '2026-01-29 04:59:43', 'Suspended', 'user image/user2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `customer_address`, `payment_method`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 'yyy', 'yyy@gmail.com', 'hhh', 'PayPal', 68.91, 'shipped', '2026-01-29 23:30:43'),
(2, 'yyy', 'yyy@gmail.com', 'jjj', 'paypal', 38.50, 'pending', '2026-01-29 23:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `book_id`, `quantity`, `price`) VALUES
(1, 1, 17, 1, 68.91),
(2, 2, 1, 1, 38.50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `fk_books_category` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
