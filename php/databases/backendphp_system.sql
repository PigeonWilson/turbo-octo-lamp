-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2026 at 08:43 PM
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
-- Database: `backendphp_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `instance_information`
--

CREATE TABLE `instance_information` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `project_name` text NOT NULL,
  `project_version` text NOT NULL,
  `project_email_contact` text NOT NULL,
  `source_code_link` text NOT NULL,
  `source_code_license_link` text NOT NULL,
  `project_documentation_link` text NOT NULL,
  `project_manifest_link` text NOT NULL,
  `project_rules_link` text NOT NULL,
  `project_multimedia_credits_link` text NOT NULL,
  `project_default_lang` text NOT NULL,
  `debug_mode` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instance_module`
--

CREATE TABLE `instance_module` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instance_information`
--
ALTER TABLE `instance_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instance_module`
--
ALTER TABLE `instance_module`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instance_information`
--
ALTER TABLE `instance_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instance_module`
--
ALTER TABLE `instance_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
