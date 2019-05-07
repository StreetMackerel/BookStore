-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2019 at 09:23 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `calcFunds` (IN `getid` INT)  NO SQL
BEGIN
DECLARE value DECIMAL(11);
                    SELECT price INTO value FROM books WHERE id = getid;
                    UPDATE books SET
                        stock = stock+10
                        WHERE id = getid;
                    UPDATE reports SET
                        funds = funds-((value-(value/4))*10);
                        
                    UPDATE reports SET profits =
                    profits + ((value/4)*10);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `author` varchar(50) CHARACTER SET utf8 NOT NULL,
  `isbn` varchar(15) CHARACTER SET utf8 NOT NULL,
  `year` int(4) UNSIGNED NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `cover` varchar(50) NOT NULL DEFAULT 'book_default.png',
  `publisher_id` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `year`, `price`, `cover`, `publisher_id`, `stock`, `active`) VALUES
(3, 'Beginning JavaScript, 5th Edition', 'Jeremy McPeak', '9781118903339', 2015, '40.90', 'uploads/samplebook.jpg', 1, 0, 1),
(4, 'Learning JavaScript, 3rd Edition', 'Ethan Brown', '9781491914915', 2016, '39.99', 'uploads/samplebook2.jpg', 1, 36, 1),
(5, '100 Things Every Designer Needs to Know About', 'Susan Weinschenk', '9780321767530', 2011, '26.31', 'uploads/samplebook3.jpg', 1, 29, 1),
(7, 'HTML5: The Missing Manual, 2nd Edition', 'Matthew MacDonald', '9781449363260', 2014, '34.99', 'uploads/samplebook4.jpg', 1, 19, 1),
(8, 'Stylin&#39; with CSS: A Designer&#39;s Guide, 3rd Edition', 'Charles Wyke-Smith', '9780321858474', 2012, '25.76', 'uploads/samplebook5.jpg', 1, 20, 1),
(9, 'Introducing HTML5, 2nd Edition', 'Bruce Lawson', '9780321784421', 2011, '17.95', 'uploads/samplebook6.jpg', 1, 39, 1),
(10, 'CSS: The Missing Manual, 4th Edition', 'David Sawyer McFarland', '9781491918050', 2015, '35.72', 'uploads/samplebook7.jpg', 1, 28, 1),
(11, 'HTML5 Foundations', 'Matt West', '9781118356555', 2012, '36.50', 'uploads/book_default.png', 2, 19, 0),
(14, 'A Tale of Reading', 'Writey McBookerson', '1234567891023', 1901, '30.00', 'uploads/samplebook8.jpg', 1, 27, 1),
(15, 'Book', 'Bookman', '1234567891011', 1950, '200.00', 'uploads/samplebook9.jpg', 1, 20, 1),
(16, 'The Lord of the Things', 'J.K Tolking', '4444444444444', 1985, '49.99', 'uploads/samplebook10.jpg', 1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `address` varchar(250) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `website` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `address`, `phone`, `email`, `website`) VALUES
(1, 'O Reilly Media', '5 St George&#39;s Rd, Farnham GU9 7LW, UK', '111111111111', 'information@oreilly.com', 'https://www.oreillytesting.com'),
(2, 'John Wiley and Sons test', 'testing my update', '0862120654', 'customer@wiley.com', 'http://www.wiley.com'),
(3, 'Pearson Education', 'testing again', '+442070102000', 'enquiries@pearson.com', 'https://www.pearson.com/');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `funds` decimal(7,2) NOT NULL,
  `profits` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `funds`, `profits`) VALUES
(1, '3986.72', '1624.00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `description`) VALUES
(1, 'admin', 'System administrator'),
(2, 'manager', 'Bookstore manager'),
(3, 'user', 'Bookstore user');

-- --------------------------------------------------------

--
-- Table structure for table `userbook`
--

CREATE TABLE `userbook` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `book_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userbook`
--

INSERT INTO `userbook` (`purchase_id`, `user_id`, `book_id`, `purchase_date`) VALUES
(1, 5, 4, '2019-03-19'),
(2, 6, 7, '2019-03-19'),
(3, 6, 4, '2019-03-19'),
(4, 6, 3, '2019-03-19'),
(5, 6, 3, '2019-03-19'),
(6, 6, 14, '2019-03-19'),
(7, 6, 4, '2019-03-19'),
(8, 6, 3, '2019-03-19'),
(9, 6, 10, '2019-03-22'),
(10, 13, 10, '2019-03-22'),
(11, 6, 14, '2019-03-22'),
(12, 13, 7, '2019-03-22'),
(13, 6, 11, '2019-03-22'),
(14, 6, 4, '2019-03-22'),
(15, 6, 4, '2019-03-22'),
(16, 6, 5, '2019-03-22'),
(17, 16, 14, '2019-03-26'),
(18, 16, 14, '2019-03-26'),
(19, 14, 16, '2019-03-26'),
(20, 14, 9, '2019-03-26'),
(21, 14, 4, '2019-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `active`) VALUES
(5, 'joebloggs', '$2y$10$QpActvcunRU5Lm73smsWmukusnew4kbOX1D0zg/H2hd3sVEl.ky/S', 3, 0),
(6, 'JamesUser', '$2y$10$NnyJoBkicUbkalS9V82Osu401c8GqhNc.qIbxyM5VYnnaAiKEkUzO', 3, 1),
(8, 'JamesAdmin', '$2y$10$1V76J2NsMWaQ39gMlc/NxOUf7/R/J1DVVOol3XNBE8ESCO7pz/uLS', 1, 1),
(13, 'eClank', '$2y$10$kDmTm5eID6aZ7L.P4vD8KONGKxRA1ihyukNmE8ohdoVgnBDx2FRTe', 3, 1),
(14, 'EoinUser', '$2y$10$Q/CvlKPGocWTyUSFp7WRj.KrGV.OSbxZEZeG11xcqflxGur3H7/Vy', 3, 1),
(15, 'JamesManager', '$2y$10$W/6darA/d3mQ23//fB2/mevoHx5Anb1zQomzzO.JhGPfZwLhD5Ytm', 2, 1),
(16, 'Marcus', '$2y$10$dNXycCsvH5MLK63n7bDDVuREEsVt6Ttx.HAXkEvQkNUlL8OACyLWu', 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_publisher_id` (`publisher_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userbook`
--
ALTER TABLE `userbook`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userbook`
--
ALTER TABLE `userbook`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `book_publisher_fk` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`);

--
-- Constraints for table `userbook`
--
ALTER TABLE `userbook`
  ADD CONSTRAINT `userbook_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userbook_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_table_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
