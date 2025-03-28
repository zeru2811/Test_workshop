-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2025 at 06:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auto_workshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `Booking`
--

CREATE TABLE `Booking` (
  `BookingID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `WorkshopID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `BookingDateTime` datetime DEFAULT current_timestamp(),
  `Status` enum('Pending','Confirmed','Completed') DEFAULT 'Pending',
  `EstimatedWaitTime` int(11) DEFAULT NULL,
  `ConfirmationDateTime` datetime DEFAULT NULL,
  `CompletionDateTime` datetime DEFAULT NULL,
  `EstimatedPrice` decimal(10,2) DEFAULT NULL,
  `FinalPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Booking`
--

INSERT INTO `Booking` (`BookingID`, `CustomerID`, `WorkshopID`, `Description`, `BookingDateTime`, `Status`, `EstimatedWaitTime`, `ConfirmationDateTime`, `CompletionDateTime`, `EstimatedPrice`, `FinalPrice`) VALUES
(23, 18, 16, 'Tie Broke', '2025-03-28 22:42:00', 'Completed', 15, '2025-03-28 22:42:58', '2025-03-28 22:43:44', NULL, NULL),
(24, 18, 11, 'Tie broke again', '2025-03-28 22:47:30', 'Completed', 20, '2025-03-28 22:49:15', '2025-03-28 22:50:00', NULL, NULL),
(25, 18, 12, 'Can start engine!!', '2025-03-28 23:31:01', 'Completed', 30, '2025-03-28 23:31:47', '2025-03-28 23:32:38', NULL, NULL),
(26, 18, 12, 'tie break', '2025-03-28 23:38:31', 'Completed', 25, '2025-03-28 23:38:42', '2025-03-28 23:40:34', NULL, NULL),
(27, 18, 12, 'hi', '2025-03-28 23:47:05', 'Completed', 15, '2025-03-28 23:47:18', '2025-03-28 23:47:33', '30000.00', '25000.00'),
(28, 18, 12, 'hihi', '2025-03-28 23:52:30', 'Completed', 100, '2025-03-28 23:54:21', '2025-03-28 23:54:33', '100.00', NULL),
(29, 18, 12, 'hijh', '2025-03-28 23:53:23', 'Completed', 100, '2025-03-28 23:54:26', '2025-03-28 23:54:32', '100.00', '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `Township`
--

CREATE TABLE `Township` (
  `TownshipID` int(11) NOT NULL,
  `TownshipName` varchar(50) NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Township`
--

INSERT INTO `Township` (`TownshipID`, `TownshipName`, `CreatedAt`) VALUES
(1, 'Aungmyaythazan', '2025-03-28 00:46:37'),
(2, 'Chanmyathazi', '2025-03-28 00:46:37'),
(3, 'Mahaaungmye', '2025-03-28 00:46:37'),
(4, 'Chanayethazan', '2025-03-28 00:46:37'),
(5, 'Pyigyidagun', '2025-03-28 00:46:37'),
(6, 'Amarapura', '2025-03-28 00:46:37'),
(7, 'Patheingyi', '2025-03-28 00:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `UserType` enum('customer','workshop') NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `FullName`, `Email`, `Password`, `PhoneNumber`, `UserType`, `CreatedAt`) VALUES
(3, 'wai yan', 'zeru@gmail.com', '$2y$10$w9w7c7SwSMLpzU7xhkOgmuucN/uhy46wvX7gmoSI2DPL5QpZigrEW', '09763033544', 'customer', '2025-03-28 12:13:41'),
(4, 'Ko Aung Ko', 'aungko@mandalayexpress.com', '$2y$10$hxCNEaXUgTfAbAM/UpnzCeQjhuOgVvsffe3Ad3gB/yXjBR3ojGwH.', '09123456789', 'workshop', '2025-03-28 22:09:52'),
(5, 'Daw Hla Hla', 'hlahla@goldenwheelmm.com', '$2y$10$Nfb2fGsjKZ6S4VQ8H6ga5OyYLoeG5SRdoMJDX0IIgxc12jc3h5YSq', '09 987 654 321', 'workshop', '2025-03-28 22:10:58'),
(6, 'U Myo Min', 'myomin@chanauto.com', '$2y$10$UwsZJ1XMiHc6ODn7u/qSi.6OQ.Zo44uK2xe8sCABVInps3tFHNYiW', '09 111 222 333', 'workshop', '2025-03-28 22:18:54'),
(7, 'Ko Zaw Zaw', 'zawzaw@precisionmotors.com', '$2y$10$z.abOLUcV73c8PBhFQRtP.uxrxXL3qztmPie9RCU1TpbmbCFgfVq6', '09 444 555 666', 'workshop', '2025-03-28 22:19:43'),
(8, 'Daw Su Su', 'susu@royalcarworkshop.com', '$2y$10$091V0SvPcnWjkLTHCWcrte.TbzDxtYk5Pzk8LMi.ocjZT75FHspGu', '09 777 888 999', 'workshop', '2025-03-28 22:20:30'),
(9, 'U Tin Htun', 'tinhtun@mingalarauto.com', '$2y$10$XkSBAsXI7FcLyjSq6tNgxuw8955SOX4U2yMQ765FZrHMhOSKM0WO2', '09 777 111 222', 'workshop', '2025-03-28 22:21:26'),
(10, 'Ko Kyaw Zin', 'kyawzin@thiricar.com', '$2y$10$3lLWYMGe8s7vdeowcsLjgujakGC0MgSfLV4Sj8UwQImocZgi78m1C', '09 333 444 555', 'workshop', '2025-03-28 22:23:09'),
(11, 'Daw Khin Khin', 'khinkhin@shwebama.com', '$2y$10$s5Tk7NMVvFYh1GCvNPVtZegDtgFF4RO6V.z1mpxyW0pXNbxjOZaya', '09 666 777 888', 'workshop', '2025-03-28 22:23:56'),
(12, 'U Thein Han', 'theinhan@mandalayhillauto.com', '$2y$10$LBcSFSLD24Eyfg78udPhQ.q98IwZR1.tX/OHw/6BRxbLDSxeOmAH2', '09 999 000 111', 'workshop', '2025-03-28 22:24:29'),
(13, 'Ko Nay Win', 'naywin@citystargarage.com', '$2y$10$yy3GbWCA14NmBrfzI01imeVrskl0Bf2Z6DcHGCe7DKY6n0wLkFhr2', '09 222 333 444', 'workshop', '2025-03-28 22:25:13'),
(14, 'Daw May Zin', 'mayzin@amarapuraclinic.com', '$2y$10$KJnoKpJ5S8EJHh57y26KtOfbkO1WfMN.CMB3Xn/3OyDAzPsHXQfGi', '09 555 666 777', 'workshop', '2025-03-28 22:26:01'),
(15, 'U Soe Moe', 'soemoe@ubeinbridge.com', '$2y$10$WSSChTcB/j5hxiJksvnZeOzPpvaJf.sggT/B0uAATuDqi32jtALo.', '09 888 999 000', 'workshop', '2025-03-28 22:26:39'),
(16, 'Ko Min Thu', 'minthu@highwayexperts.com', '$2y$10$JkAZTREEsg5rFV0kTtLZbOfBzMqwNM.2aOqo2xNCGc3Ay5lEIYbUS', '09 121 212 121', 'workshop', '2025-03-28 22:27:24'),
(17, 'Daw Nwe Nwe', 'nwenwe@thiriexpress.com', '$2y$10$n/Yu6lyFSN325.SZ9.7XvOTob9Rp7AX55HNVsu3/8/O.Kl5e4iuYe', '09 343 434 343', 'workshop', '2025-03-28 22:28:16'),
(18, 'Wai Yan Ko Ko', 'zeru28112001@gmail.com', '$2y$10$ACs6vVAc6JTwh6ynaqvJNepkqq9YK1UedWjVElL/oniNq5PD7JPAC', '09763033544', 'customer', '2025-03-28 22:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `Workshop`
--

CREATE TABLE `Workshop` (
  `WorkshopID` int(11) NOT NULL,
  `WorkshopName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `TownshipID` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Workshop`
--

INSERT INTO `Workshop` (`WorkshopID`, `WorkshopName`, `Address`, `TownshipID`, `CreatedAt`, `UserID`) VALUES
(9, 'Mandalay Express Auto Care', '45B, 78th Street', 1, '2025-03-28 22:09:52', 4),
(10, 'Golden Wheel Garage', 'Corner of 80th & 28th Street', 1, '2025-03-28 22:10:58', 5),
(11, 'Chan Auto Services', '112, 35th Street', 2, '2025-03-28 22:18:54', 6),
(12, 'Precision Motors', 'Near Zay Cho Market', 2, '2025-03-28 22:19:43', 7),
(13, 'Royal Car Workshop', '56, 83rd Street', 3, '2025-03-28 22:20:30', 8),
(14, 'Mingalar Auto Repair', 'Behind Central Railway Station', 3, '2025-03-28 22:21:26', 9),
(15, 'Thiri Car Care Center', '72nd St (Between 25th-26th)', 4, '2025-03-28 22:23:09', 10),
(16, 'Shwe Bama Mechanic', 'Near Chanayethazan Market', 4, '2025-03-28 22:23:56', 11),
(17, 'Mandalay Hill Auto Services', 'Main Road', 5, '2025-03-28 22:24:29', 12),
(18, 'City Star Garage', 'Near Oakthar Myaing Roundabout', 5, '2025-03-28 22:25:13', 13),
(19, 'Amarapura Auto Clinic', 'Bagaya Road', 6, '2025-03-28 22:26:01', 14),
(20, 'U Bein Bridge Car Care', 'Taungthaman Road', 6, '2025-03-28 22:26:39', 15),
(21, 'Highway Auto Experts', 'Yangon-Mandalay Highway', 7, '2025-03-28 22:27:24', 16),
(22, 'Thiri Express Garage', 'Near Patheingyi Bus Terminal', 7, '2025-03-28 22:28:16', 17);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Booking`
--
ALTER TABLE `Booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `WorkshopID` (`WorkshopID`),
  ADD KEY `fk_booking_user` (`CustomerID`);

--
-- Indexes for table `Township`
--
ALTER TABLE `Township`
  ADD PRIMARY KEY (`TownshipID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Workshop`
--
ALTER TABLE `Workshop`
  ADD PRIMARY KEY (`WorkshopID`),
  ADD KEY `TownshipID` (`TownshipID`),
  ADD KEY `fk_workshops_user` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Booking`
--
ALTER TABLE `Booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `Township`
--
ALTER TABLE `Township`
  MODIFY `TownshipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Workshop`
--
ALTER TABLE `Workshop`
  MODIFY `WorkshopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Booking`
--
ALTER TABLE `Booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`WorkshopID`) REFERENCES `Workshop` (`WorkshopID`),
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`CustomerID`) REFERENCES `Users` (`UserID`);

--
-- Constraints for table `Workshop`
--
ALTER TABLE `Workshop`
  ADD CONSTRAINT `fk_workshops_user` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `workshop_ibfk_1` FOREIGN KEY (`TownshipID`) REFERENCES `Township` (`TownshipID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
