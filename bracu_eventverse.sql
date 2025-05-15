-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 06:05 PM
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
-- Database: `bracu_eventverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `total_budget` int(11) NOT NULL DEFAULT 0,
  `status` enum('approved','canceled','pending') NOT NULL DEFAULT 'pending',
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `event_id`, `booking_id`, `total_budget`, `status`, `timestamp`) VALUES
(13, 24, 'BUCC122', 195660, 'approved', '2025-05-13 21:13:04'),
(19, 30, 'fcbu101', 0, 'approved', '2025-05-15 13:03:01'),
(20, 31, 'robu101', 75000, 'approved', '2025-05-15 13:21:29'),
(21, 32, 'BUCC121', 0, 'approved', '2025-05-15 13:26:20'),
(22, 33, 'BUCC123', 0, 'approved', '2025-05-15 13:30:06'),
(23, 34, 'Bizbee', 50000, 'approved', '2025-05-15 14:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `budget_items`
--

CREATE TABLE `budget_items` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `item_catagory` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_items`
--

INSERT INTO `budget_items` (`id`, `event_id`, `budget_id`, `quantity`, `unit_price`, `total_price`, `item_catagory`, `timestamp`) VALUES
(18, 24, 13, 200, 70, 14000, 'Water Bottle,Jucie,Jersey', '2025-05-13 21:15:33'),
(20, 24, 13, 23, 20, 460, 'Water Bottle,Jucie,Jersey', '2025-05-15 08:09:23'),
(21, 24, 13, 30, 40, 1200, 'Food', '2025-05-15 08:09:37'),
(23, 31, 20, 500, 150, 75000, 'Food', '2025-05-15 13:21:48'),
(24, 24, 13, 600, 300, 180000, 'Food,T-shirt,Certificate', '2025-05-15 13:27:15'),
(25, 34, 23, 100, 500, 50000, 'Trophy', '2025-05-15 14:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `certificate_url` varchar(255) DEFAULT NULL,
  `issued_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `club_type` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `advisor` varchar(255) DEFAULT NULL,
  `founded_date` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `total_member` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `description`, `logo_url`, `club_type`, `phone_number`, `facebook`, `youtube`, `website`, `advisor`, `founded_date`, `email`, `total_member`, `admin_id`) VALUES
(2, 'BUCC', 'A community for tech enthusiasts from BRAC University, where we explore the latest advancements in computer science and technology.', 'uploads/club_logo_6825a5de180359.67377891.jpg', 'Academic', '01231485645', '', '', 'https://www.bracucc.org/', 'Annajiat Alim Rasel', '2001-01-01', 'bucc@gmail.com', 1500, 7),
(3, 'BUAC', '', 'uploads/club_logo_68209ed6a94df2.27075357.jpg', 'Non-Academic', '', '', '', '', '', '2020-01-01', 'buac@gmail.com', 0, 10),
(4, 'Biz-Bee', 'No. 1 Bussiness Club in BRACU', 'uploads/club_logo_6820d9d7b6fcc6.71670023.jpg', 'Academic ', '', '', '', '', '', '2001-01-01', 'bizbee@gmail.com', 0, 11),
(5, 'BUIGC', 'Indoor Sports Club', 'uploads/club_logo_6820da45ab78c9.02661693.jpg', 'Sports', '', '', '', '', '', '', 'buigc@gmail.com', 0, 12),
(6, 'FCBU', 'Football Club of BRACU', 'uploads/club_logo_6820da7f7014a5.63252210.jpg', 'Sports', '', '', '', '', '', '', 'fcbu@gmail.com', 0, 13),
(7, 'BRACU Monon', '', 'uploads/club_logo_68255439aa7818.66158649.jpg', 'Non-Academic', '', '', '', '', '', '2010-01-01', '', 0, 15),
(8, 'BULDF', 'No.1 Leadership Club in BRACU', 'uploads/club_logo_68258ceb526d81.80988181.jpg', 'Social', '0123456', '', '', '', 'Ishtiak Molla', '2018-01-01', 'buldf@gmail.com', 500, 22),
(9, 'ROBU', 'Robotics Club of BRACU', 'uploads/club_logo_6825935e250b15.32278909.jpg', 'Academic', '', '', '', '', '', '', 'robu@gmail.com', 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `event_type` enum('technical','cultural','academic','social','sports') DEFAULT NULL,
  `time_slot` varchar(255) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `club_name` varchar(255) NOT NULL,
  `club_email` varchar(255) NOT NULL,
  `thumbnail` text DEFAULT NULL,
  `room_no` varchar(255) DEFAULT NULL,
  `status` enum('draft','pending','approved','cancelled') NOT NULL DEFAULT 'pending',
  `organizer_id` int(11) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `details`, `event_type`, `time_slot`, `booking_id`, `club_name`, `club_email`, `thumbnail`, `room_no`, `status`, `organizer_id`, `club_id`, `department_id`, `created_at`) VALUES
(24, 'Ada Lovelace Mindstorm 1.0', '10 December 2024', 'Mindstrom 1.0', 'technical', '9:00 AM - 10:20 AM', 'BUCC122', 'BUCC', 'bucc@gmail.com', 'https://i.ibb.co.com/G3RQy4LL/image.png', 'lecture_theatre', 'approved', NULL, 2, NULL, '2025-05-13 15:13:04'),
(30, 'BRAC University Football Leauge 2022', '1 July 2022', 'Football Tournament', 'sports', '9:00 AM - 10:20 AM', 'fcbu101', 'FCBU', 'fcbu@gmail.com', 'https://i.postimg.cc/CMtXQZG8/487313652-10046916611987363-4626035840652452382-n.jpg', 'auditorium', 'approved', NULL, 6, NULL, '2025-05-15 07:03:01'),
(31, '𝐓𝐫𝐚𝐜𝐭𝐢𝐨𝐧 অভ্যুদয়', '26,27,28 February 2025', 'Robotics Competition', 'technical', '9:00 AM - 10:20 AM', 'robu101', 'ROBU', 'robu@gmail.com', 'https://i.postimg.cc/NjWnjLGX/488576974-1104780188358124-1727199640171586872-n.jpg', 'auditorium', 'approved', NULL, 9, NULL, '2025-05-15 07:21:29'),
(32, 'Intrahactive 1.0', '11 November 2024', 'Hackathon, Debuggers, Database Wizard', 'technical', '4:00 PM - 6:00 PM', 'BUCC121', 'BUCC', 'bucc@gmail.com', 'https://i.postimg.cc/BQb752XD/492529137-1515224296343080-5538634015048598671-n-1.jpg', 'lecture_theatre', 'approved', NULL, 2, NULL, '2025-05-15 07:26:20'),
(33, 'AM Turing Research Wing', '24 April 2025', 'New Wing of BUCC', 'technical', '4:00 PM - 6:00 PM', 'BUCC123', 'BUCC', 'bucc@gmail.com', 'https://i.postimg.cc/mkXXfg6t/492112583-1511771826688327-5788277643840880045-n.jpg', 'lecture_theatre', 'approved', NULL, 2, NULL, '2025-05-15 07:30:06'),
(34, 'Business Case Competiton 2022', '24 April 2025', 'BRACU Event Competiton', 'academic', '4:00 PM - 6:00 PM', 'Bizbee', 'Bizbee', 'bizbee@gmail.com', 'https://i.postimg.cc/L8q7SjSR/488265103-1057084093114328-7881558639402763769-n.jpg', 'auditorium', 'approved', NULL, 4, NULL, '2025-05-15 08:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('registered','attended','cancelled') NOT NULL DEFAULT 'registered',
  `qr_code` varchar(255) DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`id`, `event_id`, `user_id`, `status`, `qr_code`, `registration_time`) VALUES
(10, 24, 16, 'registered', NULL, '2025-05-15 07:55:40'),
(11, 24, 17, 'registered', NULL, '2025-05-15 08:13:33'),
(12, 30, 16, 'registered', NULL, '2025-05-15 08:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Pritom', 'pritom@gmail.com', 'Good website Love it', '2025-05-14 07:16:48'),
(3, 'mnbmb mnmbn mb ', 'pritom@gmail.com', 'hvhvh', '2025-05-14 07:28:15'),
(5, 'Pritom', 'pritom@gmail.com', 'Boring', '2025-05-14 08:18:59'),
(6, 'Pritom', 'pritom@gmail.com', 'gfhf', '2025-05-14 08:44:53'),
(7, 'PRITOM MONDAL', 'pritommondal05@gmail.com', 'hiiiiiii\r\n', '2025-05-14 08:56:40'),
(8, 'PRITOM MONDAL', 'pritommondal05@gmail.com', 'jhjvhv', '2025-05-14 09:06:31'),
(9, 'mnbmb mnmbn mb', 'pritom@gmail.com', 'dsdxfs', '2025-05-14 09:36:33'),
(10, 'mnbmb mnmbn mbasd', 'pritom@gmail.com', 'asdasd', '2025-05-14 09:37:08'),
(11, 'Oitijjha', 'oitijjha@gmail.com', 'KHUBIIIII XOSSSSSS,ONEKKKK VALLOOOOO', '2025-05-14 17:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','club_admin','dept_admin','super_admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(6, 'Admin', 'admin@gmail.com', '$2y$10$nTQWDzuhYmJy8BUDRg7CAuQJoPOniMw7sB7Tu7LAH/r5beUslgS4C', 'super_admin', '2025-05-04 05:52:32'),
(7, 'BUCC', 'bucc@gmail.com', '$2y$10$/VcU7jCCCaYjr4Etv12bq.f9Q4SavBuRULmRAOWxCn7A0z9yj49hS', 'club_admin', '2025-05-04 06:27:34'),
(10, 'BUAC', 'buac@gmail.com', '$2y$10$ImppIFvxDXEcPqmnIhCvPOpYZPzVVHgOffaV2AOaES8nRqDrnhSrG', 'club_admin', '2025-05-11 12:56:25'),
(11, 'bizbee', 'bizbee@gmail.com', '$2y$10$W4GexzWDjEk.enP1ZDw6vuXEnrWdceDm9xC7xOvBcGIstjZ04.ndK', 'club_admin', '2025-05-11 17:08:28'),
(12, 'BUIGC', 'buigc@gmail.com', '$2y$10$EASBk/MHQ2RLLhfWHUBGjuSOcISkOxHM2D1Uz2k7s63eZKoq7JV2O', 'club_admin', '2025-05-11 17:10:33'),
(13, 'FCBU', 'fcbu@gmail.com', '$2y$10$/AYB0l3LQ5VJ4iaEWvvmRub3qt6TGEiC3Sk6hTRW2RxFV3WuzcAoC', 'club_admin', '2025-05-11 17:12:00'),
(14, 'Syeda Lamima', 'lamima@gmail.com', '$2y$10$fGr/Ogt24hjP3Kz8dRiSf.DzVMmKVHbhD19g2SXfYGd5IlG6Z9jxe', 'student', '2025-05-14 16:51:21'),
(15, 'Monon', 'bracumonon@gmail.com', '$2y$10$VU01/AimPuQWiJhUvq8HSunyFMZqUcQjzXwtDCmax/3xJq7LOL7kG', 'club_admin', '2025-05-14 17:32:31'),
(16, 'Pritom Mondal', 'pritom@gmail.com', '$2y$10$DmDf/.HlFbPI25rWK2oUeuxUiyBm.1TJ9AJyBUiuyuMHXxjAbyKTe', 'student', '2025-05-15 02:20:45'),
(17, 'Aornob', 'aornob@gmail.com', '$2y$10$0jXiAf/TFuSH1eOQdK5/euAD8QNp05d3usTnKeNAJsm3pShOfm3S.', 'student', '2025-05-15 06:35:07'),
(18, 'Anonto', 'anonto@gmail.com', '$2y$10$Ri2tC2Flecs.mr8HIDgyGOFQu9eKzSEaJDOTVK.448QvShd/kRS3W', 'student', '2025-05-15 06:35:50'),
(19, 'Sami', 'sami@gmail.com', '$2y$10$GTuzBQCipmdiLgc3I6uW/e0S1pxAO/He5jwb3s/l0Bt1W1LPlAZ06', 'student', '2025-05-15 06:37:21'),
(20, 'Muna', 'muna@gmail.com', '$2y$10$Rn/bKbT9baZtjwutsu12Y.YlGvjJASj4v4TYkTmH6/Y4TqaJYUXAK', 'student', '2025-05-15 06:37:44'),
(21, 'Fahim Shahriar', 'fahim@gmail.com', '$2y$10$02CPdxdTn1Bdk9ND3uGh.e5nzvZJZgCVJdDXEjcc6UkQoZnmbi9EG', 'student', '2025-05-15 06:38:18'),
(22, 'BULDF', 'buldf@gmail.com', '$2y$10$w2UmKa5/sj1a3sCKFoUtwu6TbuoOHrHpMerIEqM.hl9LSpYMMkxh6', 'club_admin', '2025-05-15 06:40:33'),
(23, 'Purno', 'purno@gmail.com', '$2y$10$dV0ekX/G1H0DC8PjThZg.u4DcsIriWOs20FvvwxCZZ.wWS7MOqubq', 'student', '2025-05-15 06:45:33'),
(24, 'ROBU', 'robu@gmail.com', '$2y$10$67zw1h2E6WKfa2CStzhL9eIqVx3.SU/I./y6OIQcw652Kd2HyN6IC', 'club_admin', '2025-05-15 07:08:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `budget_items`
--
ALTER TABLE `budget_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `budget_items_ibfk_2` (`budget_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `budget_items`
--
ALTER TABLE `budget_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `budget_items`
--
ALTER TABLE `budget_items`
  ADD CONSTRAINT `budget_items_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `budget_items_ibfk_2` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`id`);

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `clubs`
--
ALTER TABLE `clubs`
  ADD CONSTRAINT `clubs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_registrations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
