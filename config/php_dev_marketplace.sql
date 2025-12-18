-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 03:35 PM
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
-- Database: `php_dev_marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

CREATE TABLE `client_profiles` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `budget` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logo_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`user_id`, `company_name`, `contact_person`, `business_name`, `description`, `budget`, `location`, `website`, `created_at`, `logo_image`) VALUES
(2, 'BusinessLabs', 'praveenjadhav', 'HR', 'We are continuously building our team and upgrading the knowledge to help you make your business grow. Some businesses trust Business Labs and we help them with their online presence, designs, e-commerce consultation, content marketing and much more. Let us chart out a Growth Plan for you with our experiences gained while working with many successful business ventures.What does your business require?\r\n\r\n', '180000', 'Hyderabad', 'https://businesslabs.org', '2025-12-16 06:11:05', '6942460741d4b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `developer_profiles`
--

CREATE TABLE `developer_profiles` (
  `user_id` int(11) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `primary_skill` varchar(50) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL,
  `certification_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `developer_profiles`
--

INSERT INTO `developer_profiles` (`user_id`, `gender`, `primary_skill`, `skills`, `experience`, `rate`, `location`, `portfolio`, `created_at`, `avatar`, `certification_pdf`) VALUES
(3, 'Male', 'api', '[\"php\",\"api\",\"html\"]', 5, 1900, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-16 06:08:22', '6943fcd595de9.jpg', '6943fcd59739c.pdf'),
(4, 'Male', 'wordpress', '[\"js\",\"node\",\"php\",\"react\"]', 2, 1000, 'belagavi', 'https://github.com/praveenjadhav1510', '2025-12-17 04:52:05', '694237240f029.png', '694237240f523.pdf'),
(5, '', 'mysql', '[\"js\",\"html\",\"css\",\"node\",\"api\"]', 3, 750, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 04:54:48', '6942379884939.png', '6942379884c93.pdf'),
(6, 'Male', 'laravel', '[\"js\",\"css\",\"html\",\"react\",\"cloud\"]', 5, 1300, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 04:56:38', '6942380667569.png', '6942380667a06.pdf'),
(7, '', 'backend', '[\"js\",\"css\",\"js5\",\"restapi\"]', 2, 990, 'belagavi', 'https://github.com/praveenjadhav1510', '2025-12-17 04:58:07', '6942385f69d7a.png', '6942385f6a1c3.pdf'),
(8, 'Male', 'api', '[\"js\",\"api\",\"cloud\",\"blender\"]', 6, 1300, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 04:59:32', '694238b43af3a.png', '694238b43b2fa.pdf'),
(9, 'Female', 'backend', '[\"js\",\"css\",\"nextjs\",\"typescript\"]', 7, 890, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 05:00:54', '69423906a9a82.png', '69423906a9e2a.pdf'),
(10, 'Male', 'mysql', '[\"js\",\"css\",\"html\"]', 12, 1500, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 05:02:19', '6942395becd36.png', '6942395bed12e.pdf'),
(11, 'Female', 'wordpress', '[\"js\",\"css\",\"node\",\"python\"]', 1, 660, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 05:03:30', '694239a232f4a.png', '694239a2332d4.pdf'),
(12, 'Male', 'api', '[\"js\",\"treejs\",\"animation\"]', 3, 559, 'Mumbai, 905/906 Raheja Chambers, 213 Nariman Point, India', 'https://github.com/praveenjadhav1510', '2025-12-17 05:04:52', '694239f4a0f6c.png', '694239f4a12ff.pdf'),
(13, 'Female', 'wordpress', '[\"js\",\"css\",\"es6\",\"java\"]', 14, 1900, 'Hyderabad', 'https://github.com/praveenjadhav1510', '2025-12-17 05:06:18', '69423a54c65ee.png', '69423a54c69d5.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan` enum('free','pro','premium') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','success','failed','refunded') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `plan`, `amount`, `payment_id`, `payment_status`, `payment_method`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'pro', 199.00, 'pay_6942d4943e5be_1765987476', 'success', 'card', 'txn_6942d4943e5c4_1765987476', '2025-12-17 16:04:36', '2025-12-17 16:04:36'),
(2, 3, 'pro', 199.00, 'pay_6942db083e962_1765989128', 'success', 'card', 'txn_6942db083e968_1765989128', '2025-12-17 16:32:08', '2025-12-17 16:32:08'),
(3, 2, 'premium', 999.00, 'pay_69438efbbb029_1766035195', 'success', 'card', 'txn_69438efbbb02e_1766035195', '2025-12-18 05:19:55', '2025-12-18 05:19:55'),
(4, 14, 'premium', 999.00, 'pay_6943fbdabfff8_1766063066', 'success', 'card', 'txn_6943fbdabffff_1766063066', '2025-12-18 13:04:26', '2025-12-18 13:04:26'),
(5, 3, 'premium', 999.00, 'pay_6943fe4e462d1_1766063694', 'success', 'card', 'txn_6943fe4e462d5_1766063694', '2025-12-18 13:14:54', '2025-12-18 13:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(191) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `skills` varchar(255) NOT NULL,
  `budget_min` int(11) NOT NULL,
  `budget_max` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `logo_image` varchar(255) DEFAULT NULL,
  `status` enum('open','in_progress','completed','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `email`, `project_title`, `project_description`, `skills`, `budget_min`, `budget_max`, `deadline`, `logo_image`, `status`, `created_at`) VALUES
(4, 2, 'praveenjadhav1510@gmail.com', 'First project', 'test dicription', 'Laravel', 120000, 190000, '2025-12-31', 'logo_6942d4e4d2335.jpg', 'completed', '2025-12-17 16:05:56'),
(5, 2, 'praveenjadhav1510@gmail.com', 'test2', 'test 2 description', 'API', 9000, 50000, '2025-12-30', 'logo_694390cea07b7.jpg', 'in_progress', '2025-12-18 05:27:42'),
(6, 2, 'praveenjadhav1510@gmail.com', 'test project', 'test', 'Laravel', 10000, 20000, '2025-12-28', 'logo_6943fa98d4c53.jpg', 'closed', '2025-12-18 12:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `project_applications`
--

CREATE TABLE `project_applications` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL,
  `proposal` text NOT NULL,
  `expected_budget` int(11) DEFAULT NULL,
  `expected_days` int(11) DEFAULT NULL,
  `status` enum('applied','approved','rejected') DEFAULT 'applied',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_applications`
--

INSERT INTO `project_applications` (`id`, `project_id`, `developer_id`, `proposal`, `expected_budget`, `expected_days`, `status`, `created_at`) VALUES
(1, 4, 3, 'test praposal', 12000, 12, 'approved', '2025-12-17 16:08:00'),
(2, 5, 3, 'test2 for proposal', 19000, 8, 'approved', '2025-12-18 05:45:01'),
(3, 6, 3, 'hii', 12000, 10, 'approved', '2025-12-18 13:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `project_assignments`
--

CREATE TABLE `project_assignments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `status` enum('in_progress','completed') DEFAULT 'in_progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_assignments`
--

INSERT INTO `project_assignments` (`id`, `project_id`, `developer_id`, `started_at`, `completed_at`, `status`) VALUES
(1, 4, 3, '2025-12-17 16:17:14', '2025-12-18 05:56:13', 'completed'),
(2, 5, 3, '2025-12-18 05:49:45', NULL, 'in_progress'),
(3, 6, 3, '2025-12-18 13:10:59', '2025-12-18 13:12:08', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `project_invitations`
--

CREATE TABLE `project_invitations` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `user_type` enum('client','developer') NOT NULL,
  `plan` enum('free','pro','premium') DEFAULT 'free',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `user_type`, `plan`, `created_at`, `reset_token`, `reset_expires`) VALUES
(2, 'Praveen Jadhav', 'praveenjadhav1510@gmail.com', '$2y$10$bV2ou6YSbK9VTrmb8co3g.y.fQrKRTWJz8pECJHsnjNhHCXQOXOxe', NULL, 'client', 'premium', '2025-12-15 05:50:22', NULL, NULL),
(3, 'Praveen Jadhav', 'praveenjadhav@gmail.com', '$2y$10$Tnv562LXds2oHhJqoRtg3O.Qtz7/98YzvZ6PhNRLyEbmMyiibisEC', NULL, 'developer', 'premium', '2025-12-15 12:15:18', NULL, NULL),
(4, 'Aarav Patil', 'aarav.patil@gmail.com', '$2y$10$u7kYWdRdPTmYufa87l8yBeOkR308zYNfC/7fUePtZyuhUh.60vih.', NULL, 'developer', 'free', '2025-12-17 04:49:57', NULL, NULL),
(5, 'Sneha Sharma', 'sneha.sharma@gmail.com', '$2y$10$9a2k5EkTaA6wfpm1b9g4wOgpzbda9r41P4s4gTHdD5S1.DM3Nf2zy', NULL, 'developer', 'free', '2025-12-17 04:53:21', NULL, NULL),
(6, 'Rohit Singh', 'rohit.singh@gmail.com', '$2y$10$hPdHNkELlnppiz881oxpyuQJCfIn2dq2IlZa2.mhqqf53emPZy5BO', NULL, 'developer', 'free', '2025-12-17 04:55:22', NULL, NULL),
(7, 'Ananya Mehta', 'ananya.mehta@gmail.com', '$2y$10$753AskLAmb/ZN0BwaOfsceyg5vGTK6sfriOTqeaw1Ok3UgmiCoZG6', NULL, 'developer', 'free', '2025-12-17 04:56:55', NULL, NULL),
(8, 'Karan Verma', 'karan.verma@gmail.com', '$2y$10$r4nRSE7kBgyirmZVAjdWkulxHMv6PsZx1jI.sWEtix.VMsx3JBpO2', NULL, 'developer', 'free', '2025-12-17 04:58:30', NULL, NULL),
(9, 'Pooja Nair', 'pooja.nair@gmail.com', '$2y$10$f2oXgloUnnBIxWei1RmUwurCak0K30lHX5epcc1KFgV97Wl4xsvBu', NULL, 'developer', 'free', '2025-12-17 04:59:49', NULL, NULL),
(10, 'Vikas Joshi', 'vikas.joshi@gmail.com', '$2y$10$jmZgsNx82n0nVpIL.a9t2uWapn2dV0x/r/BL4XDNea.LYTLe1V0SW', NULL, 'developer', 'free', '2025-12-17 05:01:46', NULL, NULL),
(11, 'Neha Agarwal', 'neha.agarwal@gmail.com', '$2y$10$3/xGkhrdPoa0FEFz.XYtsOxI8OedeBTLxuOR4WWBRcP1nSu4Awetu', NULL, 'developer', 'free', '2025-12-17 05:02:44', NULL, NULL),
(12, 'Amit Kulkarni', 'amit.kulkarni@gmail.com', '$2y$10$23vUFHDLSEuBw3bAR7zaeOpCImuKANzLfPqPg9srjGhBC7U1K7vcu', NULL, 'developer', 'free', '2025-12-17 05:03:52', NULL, NULL),
(13, 'Riya Desai', 'riya.desai@gmail.com', '$2y$10$LJFGqtSZneeJVq0YalYvwemDNc8Sf0Gw/bY7oxB2ou5QkHNl5wiDy', NULL, 'developer', 'free', '2025-12-17 05:05:16', NULL, NULL),
(14, 'Praveen Jadhav', 'praveenjadhav15@gmail.com', '$2y$10$vLvssKHlf8UbbFrfGJuZYOdPUfUMrwo29LZar1nFBVCe87.ODAKHC', NULL, 'client', 'premium', '2025-12-18 12:52:24', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `developer_profiles`
--
ALTER TABLE `developer_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_payment_status` (`payment_status`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_applications`
--
ALTER TABLE `project_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_app_per_project_dev` (`project_id`,`developer_id`),
  ADD KEY `fk_app_developer` (`developer_id`);

--
-- Indexes for table `project_assignments`
--
ALTER TABLE `project_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_assignment_per_project` (`project_id`),
  ADD KEY `fk_assign_developer` (`developer_id`);

--
-- Indexes for table `project_invitations`
--
ALTER TABLE `project_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_invite_per_project_dev` (`project_id`,`developer_id`),
  ADD KEY `idx_project_id` (`project_id`),
  ADD KEY `idx_developer_id` (`developer_id`),
  ADD KEY `idx_client_id` (`client_id`),
  ADD KEY `idx_status` (`status`);

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
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_applications`
--
ALTER TABLE `project_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_assignments`
--
ALTER TABLE `project_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_invitations`
--
ALTER TABLE `project_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD CONSTRAINT `fk_client_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `developer_profiles`
--
ALTER TABLE `developer_profiles`
  ADD CONSTRAINT `fk_dev_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_applications`
--
ALTER TABLE `project_applications`
  ADD CONSTRAINT `fk_app_developer` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_assignments`
--
ALTER TABLE `project_assignments`
  ADD CONSTRAINT `fk_assign_developer` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assign_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_invitations`
--
ALTER TABLE `project_invitations`
  ADD CONSTRAINT `fk_invite_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_invite_developer` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_invite_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
