-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 03:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(70) NOT NULL,
  `isdone` tinyint(1) NOT NULL,
  `progress` enum('Not Yet Started','In Progress','Pending','Done') NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `isdone`, `progress`, `user_id`, `date`, `description`) VALUES
(27, 'minuman', 0, 'Not Yet Started', 8, '2023-10-24 07:06:41', 'makan lagii'),
(31, 'makan', 0, 'Pending', 8, '2023-10-24 07:40:24', 'udah'),
(32, 'makannnn', 0, 'In Progress', 8, '2023-10-24 07:40:35', 'minum'),
(33, 'apa ya', 0, 'In Progress', 8, '2023-10-24 08:18:20', 'iiiiiiiii'),
(37, 'minuman', 1, 'Done', 7, '2023-10-24 08:30:06', 'iyaaa'),
(38, 'makann', 1, 'Done', 7, '2023-10-24 08:30:17', 'apa ni yaa'),
(40, 'belajar', 0, 'Pending', 7, '2023-10-24 08:30:55', 'susah'),
(41, 'lari', 0, 'Not Yet Started', 7, '2023-10-24 08:31:23', 'iyaa'),
(42, 'minuman', 0, 'Not Yet Started', 7, '2023-10-24 15:06:26', 'susah'),
(47, 'apa ya', 0, 'Not Yet Started', 9, '2023-10-24 15:08:54', 'iyaaa'),
(48, 'belajar', 0, 'Not Yet Started', 9, '2023-10-24 15:08:59', 'susah'),
(49, 'jason', 1, 'Done', 10, '2023-10-24 15:56:45', 'nugas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `gender`) VALUES
(7, 'ravin', 'dra', 'mahesandra23@gmail.com', '$2y$10$14IOMlAb6BBWLDuAGe2pSOzo6SXjTjNXFNU.DAOSXa/ms/Zfjtkuq', 'Laki-laki'),
(8, 'rapin', 'ya', 'rapin@gmail.com', '$2y$10$KLL4EtCCudw.u5CjakfQUetQW4yrbGLJKwvXw/FzAqudpzBr5YtOC', 'Laki-laki'),
(9, 'aaa', 'aaa', 'a@gmail.com', '$2y$10$RhzFkD1tdbVHvMhowFwI4OXrmYMww6U6rh5prU8apjy2MmC44EN86', 'Perempuan'),
(10, 'Alfonsus', 'Christian', 'alfonsusjason01@gmail.com', '$2y$10$A5MegMDd5aZAYKtGMjEj1.m4uX4gl9PRfCKcWnSxoKsx/pYR6O.Cm', 'Laki-laki');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
