-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2022 at 06:03 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `busbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticketbooking`
--

CREATE TABLE `ticketbooking` (
  `id` int(11) NOT NULL,
  `leaving_from` varchar(255) NOT NULL,
  `going_to` varchar(255) NOT NULL,
  `full_name` varchar(10) NOT NULL,
  `no_of_seats` int(10) NOT NULL,
  `date` date NOT NULL,
  `mobile_no` int(50) NOT NULL,
  `email` varchar(10) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticketbooking`
--

INSERT INTO `ticketbooking` (`id`, `leaving_from`, `going_to`, `full_name`, `no_of_seats`, `date`, `mobile_no`, `email`, `remarks`) VALUES
(1, '', '', 'Anup Tacha', 5, '0000-00-00', 2147483647, 'anuptacham', 'something is something'),
(3, 'Biratnagar', 'kathmandu', 'ujwal jjj', 1, '2022-06-22', 34828282, 'sas@gmail.', 'sadn'),
(4, 'Biratnagar', 'Butwal', 'asgaa jahg', 2, '2022-06-24', 358358383, 'ssaaa@gmai', 'ggasg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ticketbooking`
--
ALTER TABLE `ticketbooking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ticketbooking`
--
ALTER TABLE `ticketbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
