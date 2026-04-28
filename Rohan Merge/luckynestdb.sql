-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 08:37 PM
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
-- Database: `luckynestdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` text NOT NULL,
  `check_in` text NOT NULL,
  `check_out` text NOT NULL,
  `payment_cycle` text NOT NULL,
  `booking_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `room_id`, `booking_date`, `check_in`, `check_out`, `payment_cycle`, `booking_status`) VALUES
(1, 1, 7, '2026-02-16', '2026-03-10', '2026-04-17', 'Weekly', 'Ongoing'),
(2, 4, 11, '2026-02-12', '2026-03-09', '2026-04-14', 'Weekly', 'Ended'),
(3, 3, 3, '2026-02-07', '2026-03-12', '2026-03-22', 'Weekly', 'Ongoing'),
(4, 5, 2, '2026-02-02', '2026-03-14', '2026-03-29', 'Weekly', 'Ongoing'),
(5, 2, 9, '2026-02-27', '2026-03-29', '2026-04-09', 'monthly', 'Ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `emergencycontact`
--

CREATE TABLE `emergencycontact` (
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_fname` text NOT NULL,
  `contact_mname` text DEFAULT NULL,
  `contact_lname` text NOT NULL,
  `contact_phoneno` text NOT NULL,
  `relationship` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencycontact`
--

INSERT INTO `emergencycontact` (`contact_id`, `user_id`, `contact_fname`, `contact_mname`, `contact_lname`, `contact_phoneno`, `relationship`) VALUES
(1, 1, 'Melanie', 'Ann', 'Burns', '01828498271', 'Mother'),
(2, 1, 'Michael', NULL, 'Burns', '02928127288', 'Father'),
(3, 2, 'Billy', NULL, 'Bob', '0123284839', 'Friend'),
(4, 2, 'Ryan', NULL, 'Scott', '0128283922', 'Friend'),
(5, 3, 'Timmy', 'Joe', 'Ryan', '0122994822', 'Brother'),
(6, 3, 'Shannon', 'Rose', 'Turner', '01828827172', 'Sister'),
(7, 4, 'Richard', NULL, 'Smith', '098182839111', 'Friend'),
(8, 4, 'Ben', NULL, 'Mills', '02183192319', 'Uncle'),
(9, 5, 'Prichard', NULL, 'Dunk', '098182939192', 'Aunt'),
(10, 5, 'Amy', 'Louise', 'Ryan', '08918339192', 'Friend');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `issue_date` text NOT NULL,
  `due_date` text NOT NULL,
  `invoice_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `booking_id`, `amount`, `issue_date`, `due_date`, `invoice_status`) VALUES
(1, 1, 1650, '2026-02-16', '2026-03-10', 'Paid'),
(2, 2, 1100, '2026-02-12', '2026-03-09', 'Overdue'),
(3, 3, 950, '2026-02-07', '2026-03-12', 'Overdue'),
(4, 4, 1200, '2026-02-02', '2026-03-14', 'Paid'),
(5, 5, 1200, '2026-02-27', '2026-03-29', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payment_date` text NOT NULL,
  `payment_status` text NOT NULL,
  `late_fee` double DEFAULT NULL,
  `payment_method` text NOT NULL,
  `payment_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `booking_id`, `amount`, `payment_date`, `payment_status`, `late_fee`, `payment_method`, `payment_type`) VALUES
(1, 1, 172, '2026-02-19', 'Paid', NULL, 'Credit Card', 'Visa'),
(2, 2, 273, '2026-02-19', 'Paid', NULL, 'Debit Card', 'Visa'),
(3, 3, 432, '2026-02-07', 'Unpaid', 43.2, 'Credit Card', 'Visa'),
(4, 4, 228, '2026-03-18', 'Paid', 12.4, 'Credit Card', 'Visa'),
(5, 5, 347, '2026-03-20', 'Paid', NULL, 'Credit Card', 'Visa');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `floor_no` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `type_id`, `floor_no`, `room_no`, `room_status`) VALUES
(1, 1, 1, 1, 'Active'),
(2, 1, 1, 2, 'Active'),
(3, 1, 1, 3, 'Active'),
(4, 1, 1, 4, 'Active'),
(5, 1, 1, 5, 'Active'),
(6, 1, 1, 6, 'Active'),
(7, 1, 1, 7, 'Active'),
(8, 1, 1, 8, 'Active'),
(9, 1, 1, 9, 'Active'),
(10, 1, 1, 10, 'Active'),
(11, 2, 1, 11, 'Active'),
(12, 2, 1, 12, 'Active'),
(13, 2, 1, 13, 'Active'),
(14, 2, 1, 14, 'Active'),
(15, 2, 1, 15, 'Active'),
(16, 3, 1, 16, 'Active'),
(17, 3, 1, 16, 'Active'),
(18, 3, 1, 16, 'Active'),
(19, 3, 1, 16, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `type_id` int(11) NOT NULL,
  `type_name` text NOT NULL,
  `weekly_rate` double NOT NULL,
  `monthly_rate` double NOT NULL,
  `security_deposit` double NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`type_id`, `type_name`, `weekly_rate`, `monthly_rate`, `security_deposit`, `description`) VALUES
(1, 'Single', 150, 600, 750, 'Single occupancy room'),
(2, 'Double', 100, 400, 500, 'Double occupancy Room, 2 people'),
(3, 'Triple', 70, 280, 350, 'Triple occupancy room, 3 people');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `service_type` text NOT NULL,
  `base_price` double NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_name`, `service_type`, `base_price`, `description`) VALUES
(1, 'Laundry', 'Cleaning', 4.5, 'Clean Clothes'),
(2, 'Meal Plan', 'Food', 18.92, 'Regular Meal Plan'),
(3, 'Housekeeping', 'Room cleaning', 25.22, 'Room cleaning'),
(4, 'Maintenance', 'Upkeep', 56.98, 'General maintenance requests');

-- --------------------------------------------------------

--
-- Table structure for table `servicerequest`
--

CREATE TABLE `servicerequest` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `request_date` text NOT NULL,
  `schedule_date` text NOT NULL,
  `service_status` text NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicerequest`
--

INSERT INTO `servicerequest` (`request_id`, `user_id`, `service_id`, `request_date`, `schedule_date`, `service_status`, `price`) VALUES
(1, 1, 1, '2026-03-15', '2026-03-16', 'Complete', 4.5),
(2, 1, 2, '2026-03-13', '2026-03-14', 'Complete', 18.92),
(3, 1, 3, '2026-03-15', '2026-03-16', 'Complete', 25.22),
(4, 2, 1, '2026-04-03', '2026-04-04', 'Incomplete', 4.5),
(5, 2, 4, '2026-04-07', '2026-04-08', 'Complete', 56.98),
(6, 2, 3, '2026-04-08', '2026-04-09', 'Incomplete', 25.22),
(7, 3, 4, '2026-03-16', '2026-03-17', 'Complete', 56.98),
(8, 3, 3, '2026-03-19', '2026-03-20', 'Complete', 25.22),
(9, 3, 2, '2026-03-21', '2026-03-22', 'Complete', 18.92),
(10, 4, 1, '2026-03-18', '2026-03-19', 'Incomplete', 4.5),
(11, 4, 3, '2026-03-28', '2026-03-29', 'Complete', 25.22),
(12, 4, 4, '2026-04-03', '2026-04-02', 'Incomplete', 56.98),
(13, 5, 1, '2026-03-19', '2026-03-20', 'Complete', 4.5),
(14, 5, 2, '2026-03-22', '2026-03-23', 'Complete', 18.92),
(15, 5, 4, '2026-03-25', '2026-03-26', 'Complete', 56.98);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_fname` text NOT NULL,
  `user_mname` text DEFAULT NULL,
  `user_lname` text NOT NULL,
  `email` text NOT NULL,
  `user_phoneno` text NOT NULL,
  `user_role` text NOT NULL,
  `address` text NOT NULL,
  `occupation` text NOT NULL,
  `date_of_birth` text NOT NULL,
  `id_type` text NOT NULL,
  `id_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_fname`, `user_mname`, `user_lname`, `email`, `user_phoneno`, `user_role`, `address`, `occupation`, `date_of_birth`, `id_type`, `id_number`) VALUES
(1, 'Reece', NULL, 'Burns', 'reeceuni@hallam.shu.ac.uk', '07912395754', 'Paying Guest', 'Central Quey Room 50, Sheffield, S38RA', 'Unemployed', '1999-10-13', 'Passport', '913asih213'),
(2, 'Daniel', NULL, 'Alexandrii', 'daniel@hallam.shu.ac.uk', '01829389219', 'Paying Guest', '18 Random Street, Sheffield, S38 R9', 'Doctor', '2006-04-19', 'National Insurance', '912aj28hassha'),
(3, 'Rohan', NULL, 'Ali', 'rohanali@hallam.shu.ac.uk', '02829872838', 'Admin', '19 West Street, Sheffield, S9 3RB', 'Waiter', '2006-05-29', 'Passport', '928438192'),
(4, 'Hana', NULL, 'Ahmed', 'hana@hallam.shu.ac.uk', '02930182939', 'Owner', '29 North Street, Manchester, M8 72J', 'Cashier', '2007-07-11', 'National Insurance', '28273819129'),
(5, 'Shon', NULL, 'Sony', 'shonsony@hallam.shu.ac.uk', '02818249190', 'Paying Guest', '28 Sheffield Road, Sheffield, S8 9KI', 'Developer', '2008-09-08', 'Passport', '92912819319');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` int(11) NOT NULL,
  `visitor_fname` text NOT NULL,
  `visitor_mname` text DEFAULT NULL,
  `visitor_lname` text NOT NULL,
  `id_type` text NOT NULL,
  `id_number` text NOT NULL,
  `vehicle_number` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_id`, `visitor_fname`, `visitor_mname`, `visitor_lname`, `id_type`, `id_number`, `vehicle_number`) VALUES
(1, 'Reece', NULL, 'Burns', 'Passport', '021I13I028', '9KJ JA9'),
(2, 'Ingua', 'Rhyna', 'Alguara', 'Passport', '218291292', '92A 92J'),
(3, 'Ryan', NULL, 'Scott', 'National Insurance', 'AJA918391j', NULL),
(4, 'Ritty', NULL, 'Luka', 'Passport', '92292921', NULL),
(5, 'Thomas', 'Isacc', 'Unbar', 'Passport', '1282892992', '9kJ UkN');

-- --------------------------------------------------------

--
-- Table structure for table `visitorlog`
--

CREATE TABLE `visitorlog` (
  `visit_id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in_date` text NOT NULL,
  `check_out_date` text NOT NULL,
  `purpose` text NOT NULL,
  `approval_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitorlog`
--

INSERT INTO `visitorlog` (`visit_id`, `visitor_id`, `room_id`, `check_in_date`, `check_out_date`, `purpose`, `approval_status`) VALUES
(1, 1, 7, '2026-03-12', '2026-03-13', 'Visiting Friend', 'Approved'),
(2, 2, 11, '2026-03-14', '2026-03-14', 'Unknown', 'Not Approved'),
(3, 3, 2, '2026-03-28', '2026-03-29', 'Helping Move Out', 'Approved'),
(4, 4, 3, '2026-03-20', '2026-03-22', 'Birthday Party', 'Approved'),
(5, 5, 9, '2026-04-04', '2026-04-06', 'Visiting Friend', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  ADD PRIMARY KEY (`contact_id`),
  ADD UNIQUE KEY `contact_phoneno` (`contact_phoneno`) USING HASH,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `user_phoneno` (`user_phoneno`) USING HASH;

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `visitorlog`
--
ALTER TABLE `visitorlog`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `servicerequest`
--
ALTER TABLE `servicerequest`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visitorlog`
--
ALTER TABLE `visitorlog`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  ADD CONSTRAINT `emergencycontact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `roomtype` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD CONSTRAINT `servicerequest_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicerequest_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visitorlog`
--
ALTER TABLE `visitorlog`
  ADD CONSTRAINT `visitorlog_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`visitor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visitorlog_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
