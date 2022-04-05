-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2022 at 05:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `prequest`
--

CREATE TABLE `prequest` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` varchar(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `service_id` varchar(255) NOT NULL,
  `query` longtext DEFAULT NULL,
  `posting_date` timestamp NULL DEFAULT current_timestamp(),
  `remark` longtext DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prequest`
--

INSERT INTO `prequest` (`id`, `name`, `email`, `contactno`, `company`, `service_id`, `query`, `posting_date`, `remark`, `status`) VALUES
(7, 'Iqbal Hossan Fazlay Rabbi', 'mdiqbalhossen7265@gmail.com', '01679487265', 'DH', 'Seo,Web Design and Development,Content Management System', 'This is query', NULL, 'Admin Remarked', 1),
(8, 'Iqbal Hossen', 'jmiqbal2019@gmail.com', '01580358565', 'Rs it solution', 'Seo', 'This is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is QueryThis is Query', '2022-03-28 12:07:52', 'Admin Remarked', 1),
(9, 'Iqbal Hossan Fazlay Rabbi', 'mdiqbalhossen7265@gmail.com', '01447852369', 'Rs it solution', 'Others', 'This is query', '2022-03-28 14:02:42', 'Admin Remarked', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `created_at`) VALUES
(1, 'Seo', '2022-03-24 15:01:18'),
(3, 'Web Design and Development', '2022-03-24 15:04:17'),
(4, 'Content Management System', '2022-03-24 15:05:26'),
(5, 'Others', '2022-03-24 15:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(11) DEFAULT NULL,
  `email_id` varchar(300) DEFAULT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `task_type` varchar(300) DEFAULT NULL,
  `prioprity` varchar(300) DEFAULT NULL,
  `ticket` longtext DEFAULT NULL,
  `attachment` varchar(300) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT '0. Pending 1. Closed',
  `admin_remark` longtext DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `admin_remark_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `ticket_id`, `email_id`, `subject`, `task_type`, `prioprity`, `ticket`, `attachment`, `status`, `admin_remark`, `posting_date`, `admin_remark_date`) VALUES
(12, '5', 'phpgurukulteam@gmail.com', 'Test Ticket', 'billing', 'important', 'This ticket for testing purpose.', '', 1, 'Ticket resolved.  Solution provided', '2021-04-22', '2022-03-27 16:24:37'),
(14, '02', 'admin@gmail.com', 'This is subject', 'technical', 'urgent', 'This is description', NULL, 1, 'Admin Remarked', NULL, '2022-03-27 16:25:12'),
(15, '37', 'admin@gmail.com', 'This is subject', 'technical', 'urgent', 'This is Description', NULL, 0, NULL, '0000-00-00', '2022-03-27 18:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alt_email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `profile_img` varchar(255) NOT NULL DEFAULT 'user.png',
  `status` int(11) DEFAULT NULL COMMENT '1. Verified 2. Unverified',
  `type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1. Admin 2. User',
  `posting_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `alt_email`, `password`, `mobile`, `gender`, `address`, `profile_img`, `status`, `type`, `posting_date`) VALUES
(1, 'Anuj Kumar', 'phpgurukulteam@gmail.com', 'test123@asgggfag.com', 'Demo@123', '++81234567890', 'm', 'New Delhi India 110001', 'user.png', 1, 2, '2021-04-22 12:25:19'),
(4, 'Admin Hossen', 'admin@gmail.com', 'mdiqbalhossen7265@gmail.com', '$2y$10$urnHVXxAaPZ/h4SHwAXe2uURAblZGSXfeyt/nkqICapS3lzGHH7Km', '01679487265', 'Male', 'Nazrul Avenue, Kandir Par, Cumilla', 'user.png', NULL, 1, '2022-03-30 15:48:40'),
(3, 'Iqbal Hossen', 'jmiqbal2019@gmail.com', 'jmiqbal2019@gmail.com', '$2y$10$uHfWXBOqmTzdIovZw1slm.53.iyO9ypZMfExsg0zK3wGs59Eb58ZO', '+8801679487265', 'Male', 'Nazrul Avenue, Kandir Par, Cumilla', 'user.png', NULL, 2, '2022-03-30 12:27:57'),
(5, 'Sumaiya Akter', 'sumu232@gmail.com', 'sumu232@gmail.com', '$2y$10$I5xORNaH7NoT1XognmxhseCdQZXqj13DfzySLumarEW9H58Eaogne', '014477856693', 'Female', 'Laksham, PoschimGaw', 'user.png', NULL, 2, '2022-03-30 15:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `usercheck`
--

CREATE TABLE `usercheck` (
  `id` int(11) NOT NULL,
  `logindate` varchar(255) DEFAULT '',
  `logintime` varchar(255) DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT '',
  `ip` varbinary(16) DEFAULT NULL,
  `mac` varbinary(16) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usercheck`
--

INSERT INTO `usercheck` (`id`, `logindate`, `logintime`, `user_id`, `username`, `email`, `ip`, `mac`, `city`, `country`) VALUES
(1, '2021/04/22', '05:59:18pm', 1, 'Anuj Kumar', 'phpgurukulteam@gmail.com', 0x3a3a31, 0x31322d46342d38442d31322d39392d39, '', ''),
(2, '2021/05/22', '10:00:15pm', 1, 'Anuj Kumar', 'phpgurukulteam@gmail.com', 0x3a3a31, 0x31322d46342d38442d31322d39392d39, '', ''),
(3, '2022/04/05', '1649157911', 4, 'Admin Hossen', 'admin@gmail.com', NULL, 0x42302d43302d39302d31432d41392d46, NULL, NULL),
(4, '2022/04/05', '1649158561', 3, 'Iqbal Hossen', 'jmiqbal2019@gmail.com', 0x3a3a31, 0x42302d43302d39302d31432d41392d46, NULL, NULL),
(5, '2022/04/05', '1649172187', 4, 'Admin Hossen', 'admin@gmail.com', 0x3a3a31, 0x32322d43302d39302d31432d41392d46, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_statics`
--

CREATE TABLE `user_statics` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `ip` varchar(255) NOT NULL,
  `mac` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_statics`
--

INSERT INTO `user_statics` (`id`, `date`, `ip`, `mac`) VALUES
(1, '2022-04-05', '::1', '22-C0-90-1C-A9-F1'),
(2, '2022-04-05', '::1', '22-C0-90-1C-A9-F1'),
(3, '2022-05-05', '::1', '22-C0-90-1C-A9-F1'),
(4, '2022-05-05', '::1', '22-C0-90-1C-A9-F1'),
(5, '2022-06-05', '::1', '22-C0-90-1C-A9-F1'),
(6, '2022-06-05', '::1', '22-C0-90-1C-A9-F1'),
(7, '2022-07-05', '::1', '22-C0-90-1C-A9-F1'),
(8, '2022-07-05', '::1', '22-C0-90-1C-A9-F1'),
(9, '2022-07-05', '::1', '22-C0-90-1C-A9-F1'),
(10, '2022-07-05', '::1', '22-C0-90-1C-A9-F1'),
(11, '2022-08-05', '::1', '22-C0-90-1C-A9-F1'),
(12, '2022-08-05', '::1', '22-C0-90-1C-A9-F1'),
(13, '2022-04-05', '::1', '22-C0-90-1C-A9-F1'),
(14, '2022-04-05', '::1', '22-C0-90-1C-A9-F1'),
(15, '2022-04-05', '::1', '22-C0-90-1C-A9-F1'),
(16, '2022-04-05', '::1', '22-C0-90-1C-A9-F1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prequest`
--
ALTER TABLE `prequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercheck`
--
ALTER TABLE `usercheck`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_statics`
--
ALTER TABLE `user_statics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prequest`
--
ALTER TABLE `prequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usercheck`
--
ALTER TABLE `usercheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_statics`
--
ALTER TABLE `user_statics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
