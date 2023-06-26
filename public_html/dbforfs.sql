-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: יוני 09, 2023 בזמן 12:18 AM
-- גרסת שרת: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbforfs`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Status` enum('Not Started','In Progress','Complete') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `projects`
--

INSERT INTO `projects` (`id`, `name`, `Status`, `user_id`, `created_at`, `Description`) VALUES
(11, 'test1', 'In Progress', 5, '2023-05-18 17:25:00', 'test1'),
(15, 'Pro', 'In Progress', 5, '2023-05-19 18:40:02', 'proyaddd');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `status` enum('Not Started','In Progress','Completed') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `due_date`, `project_id`, `status`, `user_id`) VALUES
(1, '', NULL, NULL, '', 5),
(2, '', NULL, NULL, NULL, 5),
(3, '', NULL, NULL, NULL, 5),
(9, 'ab', '2023-05-23 00:00:00', 11, 'Completed', 5),
(11, '1', '2023-05-24 00:00:00', 11, 'In Progress', 5),
(16, 'fdfd', '2023-05-09 00:00:00', 11, 'Completed', 5);

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(5, 'test1', 'test1@gmail.com', '$2y$10$i31FtTm5wD73eY1oalafruBjUXAvB/DA9SUFBrWkq6Z4.yNSR3ZMC', '2023-05-16 21:27:45'),
(8, 'TEST', 'TEST@GMAIL.COM', '$2y$10$OKTaDI9cEi2yW1sruGZTvOWqxmOSu5OV2eDwRKfe1sk20wn8edU8S', '2023-05-19 17:29:47'),
(9, 'FORTEST', 'fortest@gmail.com', '$2y$10$OCO9/s88GOMZxlHxIot6g.7EbZJOSjeh1LjbIeHSrZxDVcVfJdf8y', '2023-05-21 21:29:53'),
(10, 'rec', 'rec@gmail.com', '$2y$10$hOakAkyrJgvDJbTDuKW9E.oQIfSP4FV5TFkeBtoUkTJ/JpeV8mlrO', '2023-05-21 21:36:34');

--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- אינדקסים לטבלה `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- אינדקסים לטבלה `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- הגבלות לטבלאות שהוצאו
--

--
-- הגבלות לטבלה `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- הגבלות לטבלה `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
