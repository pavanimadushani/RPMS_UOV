-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2023 at 08:14 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpms`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `admin_ID` int(11) NOT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `researchprojects`
--

CREATE TABLE `researchprojects` (
  `rp_ID` int(11) NOT NULL,
  `rp_NameWithInitials` varchar(255) DEFAULT NULL,
  `rp_regNo` varchar(255) DEFAULT NULL,
  `rp_title` varchar(255) DEFAULT NULL,
  `rp_year` int(11) DEFAULT NULL,
  `rp_description` varchar(255) DEFAULT NULL,
  `rp_sources` varchar(255) DEFAULT NULL,
  `rp_projectLink` varchar(255) DEFAULT NULL,
  `rp_references` varchar(255) DEFAULT NULL,
  `rp_image` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentdetails`
--

CREATE TABLE `studentdetails` (
  `st_ID` int(11) NOT NULL,
  `st_NameWithInitials` varchar(255) DEFAULT NULL,
  `st_regNo` varchar(255) DEFAULT NULL,
  `st_email` varchar(255) DEFAULT NULL,
  `st_contactNo` varchar(255) DEFAULT NULL,
  `st_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentdetails`
--

INSERT INTO `studentdetails` (`st_ID`, `st_NameWithInitials`, `st_regNo`, `st_email`, `st_contactNo`, `st_password`) VALUES
(3, 'P.P.Madushani', '2018ICTS23', 'pawani@gmail.com', '0710000001', '2018ICTS23'),
(4, 'Y.K.N.C.Yapa', '2018ICTS32', 'navodh@gmail.com', '0710000002', '2018ICTS32'),
(5, 'M.I.D.Silva', '2018ICTS99', 'malshi@gmail.com', '0710000003', '2018ICTS99');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `researchprojects`
--
ALTER TABLE `researchprojects`
  ADD PRIMARY KEY (`rp_ID`);

--
-- Indexes for table `studentdetails`
--
ALTER TABLE `studentdetails`
  ADD PRIMARY KEY (`st_ID`),
  ADD UNIQUE KEY `st_regNo` (`st_regNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `researchprojects`
--
ALTER TABLE `researchprojects`
  MODIFY `rp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studentdetails`
--
ALTER TABLE `studentdetails`
  MODIFY `st_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
