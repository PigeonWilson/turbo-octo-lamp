-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 10:33 PM
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

--
-- Dumping data for table `instance_information`
--

INSERT INTO `instance_information` (`id`, `project_name`, `project_version`, `project_email_contact`, `source_code_link`, `source_code_license_link`, `project_documentation_link`, `project_manifest_link`, `project_rules_link`, `project_multimedia_credits_link`, `project_default_lang`, `debug_mode`) VALUES
(1, 'Turbo Octo Lamp', '0.0.1', 'pigeonWilson@pm.me', 'https://github.com/pigeonwilson/turbo-octo-lamp/tree/main/', 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/LICENSE', 'https://github.com/PigeonWilson/turbo-octo-lamp/tree/main/php', 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/Manifeste.md', 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/reglements.md', 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/credits_multimedia.md', 'fr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `instance_module`
--

CREATE TABLE `instance_module` (
  `id` int(11) NOT NULL,
  `isAnon` tinyint(1) NOT NULL DEFAULT 0,
  `prefix` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instance_module`
--

INSERT INTO `instance_module` (`id`, `isAnon`, `prefix`, `name`, `description`) VALUES
(1, 1, 'api_module_', 'auth', ' The \'auth\' module doesn\'t require authentication.  It provides a service to authenticate users.  It requires a token to open a session into the database  and it provides a token to authenticate the user for all requests  until the session is closed. The user session can be  terminated by the user or by the server.'),
(2, 1, 'api_module_', 'registration', ' The \'registration\' module doesn\'t require authentication.  It provides a service to register new users.'),
(3, 0, 'api_module_', 'db', 'The \'db\' module require authentication. It provides crud operations to the database and some other operations.'),
(4, 0, 'api_module_', 'whoami', ' The \'whoami\' module requires authentication.  It provides information about the user.'),
(5, 1, 'api_module_', 'package', 'The \'package\' module doesn\'t require authentication. It provides information about the packages.'),
(6, 0, 'api_module_', 'packaging', 'The \'packaging\' module requires authentication. It provides a service to decommission protected information into a format that is accessible to the public.');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instance_module`
--
ALTER TABLE `instance_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
