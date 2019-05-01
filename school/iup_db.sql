-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 01:25 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iup_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activties`
--

CREATE TABLE `activties` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activties`
--

INSERT INTO `activties` (`id`, `title`, `event_start`, `event_end`) VALUES
(1, 'Test Activity', '2019-01-17 00:00:00', '2019-01-17 00:00:00'),
(2, 'Another Activity', '2019-01-21 00:00:00', '2019-01-23 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled`
--

CREATE TABLE `enrolled` (
  `id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `enroll_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled`
--

INSERT INTO `enrolled` (`id`, `pupil_id`, `enroll_date`) VALUES
(1, 1, '2019-01-22 09:54:19'),
(2, 2, '2019-01-27 19:13:54'),
(3, 3, '2019-01-27 19:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `grade_criteria`
--

CREATE TABLE `grade_criteria` (
  `id` int(11) NOT NULL,
  `criteria` varchar(50) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_criteria`
--

INSERT INTO `grade_criteria` (`id`, `criteria`, `percentage`) VALUES
(1, 'Final Test', 30),
(2, 'Unit Test', 20),
(3, 'Quizzes and Activities', 15),
(4, 'Assignment', 10),
(5, 'Project', 15),
(6, 'Participation', 10);

-- --------------------------------------------------------

--
-- Table structure for table `grade_details`
--

CREATE TABLE `grade_details` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_details`
--

INSERT INTO `grade_details` (`id`, `grade_id`, `criteria_id`, `grade`) VALUES
(1, 1, 1, 80),
(2, 1, 2, 95),
(3, 1, 3, 90),
(4, 1, 4, 90),
(5, 1, 5, 90),
(6, 1, 6, 90);

-- --------------------------------------------------------

--
-- Table structure for table `grade_level`
--

CREATE TABLE `grade_level` (
  `id` int(11) NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_level`
--

INSERT INTO `grade_level` (`id`, `level`) VALUES
(1, 'Grade 1'),
(2, 'Grade 2');

-- --------------------------------------------------------

--
-- Table structure for table `learning_areas`
--

CREATE TABLE `learning_areas` (
  `id` int(11) NOT NULL,
  `area` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learning_areas`
--

INSERT INTO `learning_areas` (`id`, `area`) VALUES
(1, 'Math'),
(2, 'Science'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` varchar(32) NOT NULL,
  `filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `type`, `filename`) VALUES
(1, 'Test Material', 'application/pdf', 'file-1547256121607.pdf'),
(2, 'Parent Guide', 'application/pdf', 'file-1547256201520.pdf'),
(3, 'Handbook', 'application/pdf', 'file-1547256213276.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `parent_info`
--

CREATE TABLE `parent_info` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parent_info`
--

INSERT INTO `parent_info` (`id`, `users_id`, `gender`, `address`, `contact`, `email`) VALUES
(1, 6, 'Female', 'Isulan, Sultan Kudarat', '0937752135', 'jane@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `or_num` varchar(20) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `or_num`, `pupil_id`, `criteria_id`, `price`, `date`) VALUES
(1, 'iUP20190209091909', 1, 1, 500, '2019-02-09 16:19:09'),
(2, 'iUP20190209091909', 1, 2, 100, '2019-02-09 16:19:09'),
(3, 'iUP20190211141926', 1, 2, 900, '2019-02-09 16:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_criteria`
--

CREATE TABLE `payment_criteria` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_criteria`
--

INSERT INTO `payment_criteria` (`id`, `name`, `price`) VALUES
(1, 'Tuition', 2000),
(2, 'Books', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `pre_enroll`
--

CREATE TABLE `pre_enroll` (
  `id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pre_enroll`
--

INSERT INTO `pre_enroll` (`id`, `pupil_id`, `date`) VALUES
(1, 1, '2019-01-21 19:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

CREATE TABLE `pupils` (
  `id` int(11) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `middle_name` varchar(32) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `birthdate` datetime NOT NULL,
  `birthplace` text NOT NULL,
  `address` text NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`id`, `last_name`, `first_name`, `middle_name`, `gender`, `birthdate`, `birthplace`, `address`, `parent_id`) VALUES
(1, 'dennis', 'audrey', 'kite', 'Male', '2009-10-20 00:00:00', 'Isulan', 'Sultan', 6),
(2, 'test', 'test', 'test', 'Female', '2012-04-15 00:00:00', 'test', 'test', 6),
(3, 'yukas', 'leonard', 'mendez', 'Male', '2010-05-10 00:00:00', 'Isulan', 'Isulan', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pupil_grade`
--

CREATE TABLE `pupil_grade` (
  `id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pupil_grade`
--

INSERT INTO `pupil_grade` (`id`, `pupil_id`, `subject_id`, `period`, `grade`) VALUES
(1, 1, 1, 1, 88),
(2, 1, 2, 1, 0),
(3, 1, 1, 2, 0),
(4, 1, 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pupil_level`
--

CREATE TABLE `pupil_level` (
  `id` int(11) NOT NULL,
  `pupil_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pupil_level`
--

INSERT INTO `pupil_level` (`id`, `pupil_id`, `level_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `description`) VALUES
(1, 'Administrator', 'Administrator has fully access the website'),
(2, 'Cashier', 'Cashier is the user can manage the Billing System'),
(3, 'Teacher', 'Teacher of the School'),
(4, 'Parent', 'Main user of the System');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `areas` text NOT NULL,
  `day` varchar(21) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `level`, `areas`, `day`, `time_start`, `time_end`) VALUES
(1, 1, 'Test', 'Monday', '20:00:00', '21:00:00'),
(2, 1, 'Test areas', 'Tuesday', '08:00:00', '09:00:00'),
(3, 1, 'Others', 'Monday', '08:00:00', '08:30:00'),
(4, 2, 'Test', 'Monday', '08:00:00', '08:15:00'),
(5, 1, 'Math', 'Monday', '21:00:00', '21:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject`, `level`) VALUES
(1, 'Math', 1),
(2, 'Science', 1),
(3, 'Math', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_info`
--

CREATE TABLE `teacher_info` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `advisory` int(11) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher_info`
--

INSERT INTO `teacher_info` (`id`, `users_id`, `gender`, `advisory`, `address`, `contact`, `email`) VALUES
(1, 7, 'Female', 1, 'Isulan', '0999999', 'mich@test.co');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', '2019-01-03 19:05:40'),
(6, 'Jane', 'Cruz', 'jane', '1234', '2019-01-07 07:19:20'),
(7, 'michelle', 'villa', 'mich', '1234', '2019-01-07 07:24:59'),
(8, 'Caroline', 'Gray', 'carol', '1234', '2019-01-07 07:38:41'),
(10, 'sample', 'sample', 'sample', '1234', '2019-01-17 09:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `users_id`, `role_id`) VALUES
(1, 1, 1),
(5, 6, 4),
(6, 7, 3),
(7, 8, 2),
(9, 10, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activties`
--
ALTER TABLE `activties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolled`
--
ALTER TABLE `enrolled`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_criteria`
--
ALTER TABLE `grade_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_details`
--
ALTER TABLE `grade_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_level`
--
ALTER TABLE `grade_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_areas`
--
ALTER TABLE `learning_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_info`
--
ALTER TABLE `parent_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_criteria`
--
ALTER TABLE `payment_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_enroll`
--
ALTER TABLE `pre_enroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pupils`
--
ALTER TABLE `pupils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pupil_grade`
--
ALTER TABLE `pupil_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pupil_level`
--
ALTER TABLE `pupil_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_info`
--
ALTER TABLE `teacher_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activties`
--
ALTER TABLE `activties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrolled`
--
ALTER TABLE `enrolled`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade_criteria`
--
ALTER TABLE `grade_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grade_details`
--
ALTER TABLE `grade_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grade_level`
--
ALTER TABLE `grade_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `learning_areas`
--
ALTER TABLE `learning_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parent_info`
--
ALTER TABLE `parent_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_criteria`
--
ALTER TABLE `payment_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pre_enroll`
--
ALTER TABLE `pre_enroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pupils`
--
ALTER TABLE `pupils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pupil_grade`
--
ALTER TABLE `pupil_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pupil_level`
--
ALTER TABLE `pupil_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_info`
--
ALTER TABLE `teacher_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
