-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2024 at 03:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `subject`, `section`, `teacher_id`, `year_level`, `schedule`) VALUES
(1, 'recess', 'south - 3', 5, 4, '9:00am - 10: 00am'),
(2, 'narra', '1', 4, 4, '9:00am - 10: 00am'),
(4, 'DESTROYER ', 'DESTROYER ', 5, 7, '9:00am - 10: 00am'),
(5, 'OBJECT ORIENTED PROGRAMMING', 'SOUTH - 2', 2, 9, '9:00am - 10: 00am'),
(6, 'filipino', 'south - 4', 4, 5, '9:00am - 10: 00am'),
(7, 'filipino', 'south - 4', 4, 4, '9:00am - 11: 00am');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `grade_level` varchar(10) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `parent_names` varchar(200) DEFAULT NULL,
  `parent_contact` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `dob`, `gender`, `phone`, `home_address`, `grade_level`, `enrollment_date`, `parent_names`, `parent_contact`) VALUES
(20240001, 'john alvin', 'bondoc', '2004-10-18', 'male', '09684829411', 'bangad cabanatuan', 'grade 8', '2024-09-02', 'mercy bondoc', '0945266378'),
(20240003, 'richmond', 'vilaluz', '2004-03-18', 'male', '09826783648', 'bongabon , NE', 'grade 9', '2024-09-02', 'ella elionor ', '0945266378'),
(20240004, 'niko', 'boy hudlum', '2024-10-04', 'male', '346345346436', 'bangad cabanatuan', 'grade 8', '2024-10-05', 'nifa', '0984567348'),
(20240005, 'axel ', 'tampalan', '2024-10-06', 'male', '0942674862', 'bangad cabanatuan', 'Grade 8', '2024-10-06', 'emelio', '0984567348'),
(20240006, 'matt', 'slavador', '2000-10-06', 'male', '09684829411', 'bangad cabanatuan', 'grade 9', '2024-10-06', 'mercy bondoc', '0945266378');

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`student_id`, `class_id`) VALUES
(20240001, 1),
(20240001, 2),
(20240001, 5),
(20240003, 1),
(20240003, 2),
(20240004, 4);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `subject`, `contact_info`) VALUES
(2, 'Isiah  Joshua Mizona', 'filipino', '0945366262'),
(4, 'nikus angelo', 'OPP', '096846538'),
(5, 'venice Goody', 'ITE 257', '094523323');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `fk_teacher` (`teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`student_id`,`class_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20240007;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `student_class`
--
ALTER TABLE `student_class`
  ADD CONSTRAINT `student_class_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_class_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
