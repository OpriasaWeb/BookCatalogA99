-- phpMyAdmin SQL Dump
-- version 5.2.2-dev+20231218.fdb7583f7c
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 12:02 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookcatalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_catalog`
--

CREATE TABLE `book_catalog` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(250) NOT NULL,
  `book_isbn` int(11) NOT NULL,
  `author` varchar(200) NOT NULL,
  `publisher` varchar(200) NOT NULL,
  `year_published` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_catalog`
--

INSERT INTO `book_catalog` (`book_id`, `book_title`, `book_isbn`, `author`, `publisher`, `year_published`, `category_id`, `date_updated`, `status`) VALUES
(15, 'Defender 110', 3441, 'Land Rover', 'Europe Times', '2024-03-20 19:32:52', 3, '2024-03-20 22:55:45', 1),
(16, 'qweepeetwwee', 2147483647, 'qweqweqweee', 'qweqweqwe', '2024-03-20 19:33:50', 4, '2024-03-20 23:18:52', 1),
(17, 'Harreyh', 546623, 'Radiance', 'New York Times', '2024-03-20 21:34:31', 3, NULL, 1),
(18, 'qwe', 234, 'qwe', '234', '2024-03-20 23:21:31', 2, NULL, 1),
(19, '234', 0, '234', 'qwe', '2024-03-20 23:21:38', 3, NULL, 2),
(20, '234', 234, '2342', '234', '2024-03-20 23:21:45', 2, NULL, 2),
(21, 'qwe', 0, '234', 'qweqwe', '2024-03-20 23:21:53', 3, '2024-03-20 23:25:49', 2),
(22, 'weqwe', 0, 'qweqwe', 'qweqwe', '2024-03-20 23:21:59', 2, NULL, 1),
(23, 'qweqwe', 111, 'qweqw', 'eqweqwe', '2024-03-20 23:22:10', 4, '2024-03-20 23:45:04', 2),
(24, '234234', 0, '2134324', 'qweqwe', '2024-03-20 23:22:16', 3, NULL, 1),
(25, 'qweqwe', 234234, 'qweqwe', '234234', '2024-03-20 23:22:22', 2, NULL, 2),
(26, 'Check', 23443, 'qweqwe', '234234', '2024-03-20 23:22:40', 3, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_catalog`
--
ALTER TABLE `book_catalog`
  ADD PRIMARY KEY (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_catalog`
--
ALTER TABLE `book_catalog`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
