-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2022 at 06:39 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

 CREATE DATABASE IF NOT EXISTS  bank
   COLLATE = 'latin1_swedish_ci';
  


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `fin_accounts`
--
USE bank;
CREATE TABLE IF NOT EXISTS `fin_accounts` (
  `account_No` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `permanent_Address` varchar(200) NOT NULL,
  `temporary_Address` varchar(200) NOT NULL,
  `mobile_No` varchar(20) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `membership_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`account_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `fin_transactions`
--
USE bank;
CREATE TABLE IF NOT EXISTS `fin_transactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_No` int(11) DEFAULT NULL,
  `drcr` varchar(2) NOT NULL,
  `amount` double DEFAULT NULL,
  `remark` text,
  `rec_Status` varchar(1) DEFAULT NULL,
  `transaction_Date` varchar(15) NOT NULL,
  `transaction_ID` int(11) DEFAULT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Constraints for table `fin_transactions`
--
USE bank;
ALTER TABLE `fin_transactions`
  ADD CONSTRAINT `fin_transactions_ibfk_1` FOREIGN KEY (`account_No`) REFERENCES `fin_accounts` (`account_No`);



-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--
USE bank;
CREATE TABLE IF NOT EXISTS `user_accounts` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_role` varchar(4) NOT NULL,
   PRIMARY KEY(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- AUTO_INCREMENT for table `user_accounts`
--
-- USE bank;
-- ALTER TABLE `user_accounts`
 -- MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT;


--
-- Dumping data for table `user_accounts`
--
USE bank;
INSERT INTO `user_accounts` (`username`, `password`, `user_role`) VALUES
('office', '$2y$10$CHw6tm2TcJfHWxpCukS6U.dvtkefC69r4z7Rd44mF7SXEcRre7tL.', '1');

USE bank;
CREATE TABLE `bank`.`interest_calculation`(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `account_no` INT NOT NULL,
    `date_from` VARCHAR(50) NOT NULL,
    `date_to` VARCHAR(50) NOT NULL,
    `interest_amount` INT NOT NULL,
    `tax_amount` INT NOT NULL,
    `Remarks` VARCHAR(50) NOT NULL,
    `rec_Status` VARCHAR(5) NOT NULL,
    `transaction_ID` int(11) DEFAULT NULL,
    PRIMARY KEY(`ID`),
    FOREIGN KEY(account_no) REFERENCES fin_accounts(account_No)
) ENGINE = InnoDB;


-- Create License Table 

USE bank;
CREATE TABLE `license` (
  `ID` int(11) NOT NULL,
  `orgName` varchar(255) NOT NULL,
  `validUpto` text NOT NULL,
  `license` varchar(255) NOT NULL,
  `recDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


USE bank;
INSERT INTO `license` (`ID`, `orgName`, `validUpto`, `license`, `recDate`) VALUES
(1, 'Demo', '2085/12/30', '/cfhK2eq2dV7hzxDk6BIbg==', '2022-09-09');

ALTER TABLE `license`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `license`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;