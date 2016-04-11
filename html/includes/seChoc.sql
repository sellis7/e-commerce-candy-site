-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Apr 27, 2014 at 06:47 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `seChoc`
--
CREATE DATABASE IF NOT EXISTS `seChoc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `seChoc`;

-- --------------------------------------------------------

--
-- Table structure for table `t_orderDetails`
--
-- Creation: Apr 25, 2014 at 03:53 AM
--

CREATE TABLE `t_orderDetails` (
  `orderItem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `prodID` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `volPrice` decimal(6,2) unsigned NOT NULL,
  `volWgt` int(2) unsigned NOT NULL,
  `bkOrdQnty` tinyint(3) unsigned DEFAULT NULL,
  `bkOrdPrice` decimal(6,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`orderItem`),
  KEY `orderItem` (`orderItem`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_orders`
--
-- Creation: Apr 26, 2014 at 03:39 AM
--

CREATE TABLE `t_orders` (
  `orderID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `ttlPrice` decimal(10,2) unsigned NOT NULL,
  `ttlWgt` int(2) unsigned NOT NULL,
  `pymtType` enum('Visa','MC','Discover') NOT NULL,
  `pymtNum` int(10) unsigned NOT NULL,
  `pymtExpr` varchar(8) NOT NULL,
  `orderDate` datetime DEFAULT NULL,
  `shipDate` datetime DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  UNIQUE KEY `orderID` (`orderID`),
  KEY `orderID_2` (`orderID`),
  KEY `userID` (`userID`),
  KEY `orderDate` (`orderDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stock`
--
-- Creation: Apr 18, 2014 at 08:40 PM
--

CREATE TABLE `t_stock` (
  `prodID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descrip` varchar(150) NOT NULL,
  `price` decimal(6,2) unsigned NOT NULL,
  `avail` tinyint(4) NOT NULL,
  `pieceWgt` int(2) unsigned NOT NULL,
  PRIMARY KEY (`prodID`),
  UNIQUE KEY `prodID` (`prodID`),
  KEY `prodID_2` (`prodID`),
  KEY `avail` (`avail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `t_stock`
--

INSERT INTO `t_stock` (`prodID`, `descrip`, `price`, `avail`, `pieceWgt`) VALUES
(1, 'Dark Chocolate Peanut Brittle', 13.00, 22, 1),
(2, 'Butterscotch Chocolate Squares', 18.50, 9, 2),
(3, 'Nuts and Chews', 21.50, 46, 3),
(4, 'Toffey Nut Popcorn', 13.00, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--
-- Creation: Apr 18, 2014 at 08:39 PM
--

CREATE TABLE `t_users` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `addr` varchar(150) NOT NULL,
  `town` varchar(150) NOT NULL,
  `steCode` char(2) NOT NULL,
  `zip` int(5) unsigned NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(40) NOT NULL,
  `userAccess` enum('cust','admin') NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`),
  KEY `login` (`email`,`pass`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`userID`, `fName`, `lName`, `addr`, `town`, `steCode`, `zip`, `email`, `pass`, `userAccess`) VALUES
(1, 'Joe', 'Bob', '13 Mockingbird Ln', 'Aurora', 'IL', 60505, 'zippy@yahoo.com', '3e1a39bb5fe1aa10cfa68fa1286d4a6421eb8302', 'admin'),
(2, 'Jane', 'Doe', '730 Wilder St', 'Wolcott', 'CT', 80452, 'tired@gmail.com', 'aa7d66be3ed9e16582123aabafdcd253cfdf292e', 'cust');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
