-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2016 at 11:42 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `be_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `admin` varchar(45) NOT NULL,
  `password` varchar(120) NOT NULL,
  `cert` varchar(45) NOT NULL,
  PRIMARY KEY (`idadmin`),
  UNIQUE KEY `idadmin_UNIQUE` (`idadmin`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idadmin`, `email`, `admin`, `password`, `cert`) VALUES
(1, 'steve@admin.si', 'Steve Admin', '$2y$10$5ufA916p4D7SvtWVYYx1vekkxoNSJNMqfed6L1Fywi55D/eXiXjv2', 'Admin Steve');

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE IF NOT EXISTS `clerk` (
  `idclerk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cemail` varchar(45) NOT NULL,
  `cname` varchar(45) NOT NULL,
  `cpassword` varchar(120) NOT NULL,
  `cstatus` char(1) NOT NULL,
  `cert` varchar(45) NOT NULL,
  PRIMARY KEY (`idclerk`),
  UNIQUE KEY `idclerk_UNIQUE` (`idclerk`),
  UNIQUE KEY `cemail_UNIQUE` (`cemail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`idclerk`, `cemail`, `cname`, `cpassword`, `cstatus`, `cert`) VALUES
(1, 'bob@clerk.si', 'Bob', '$2y$10$VpXGCSKL5Wyf7t37ALoPW.9tuZdXTVliyNj7f473CIrZWm5W3h2OK', 'A', 'Clerk Bob'),
(2, 'john@clerk.si', 'Johnny', '$2y$10$.TF8jripgvOhOMdPAzQJ2epj4x0rSbFcMsgyI4UOYKOGQFmPfypd2', 'A', 'Clerk John'),
(3, 'charlie@clerk.si', 'Charlie', '$2y$10$VpXGCSKL5Wyf7t37ALoPW.9tuZdXTVliyNj7f473CIrZWm5W3h2OK', 'A', 'Clerk Charlie'),
(5, 'frank@clerk.si', 'Frank', '$2y$10$VWq091qVt6.675DVQzBjjefVnELHK7S4kwtF3l.PTqOlENgsQXyPS', 'A', 'Clerk Frank'),
(6, 'tony@clerk.si', 'Tony', '$2y$10$50xykbQXxoxjuKMhZRO.beEeV4bqbvxehrMjc7cSEYir1I24WK926', 'D', 'Clerk Tony');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `idorder` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_iduser` int(10) unsigned NOT NULL,
  `sum` float unsigned NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`idorder`),
  KEY `fk_order_user_idx` (`user_iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`idorder`, `user_iduser`, `sum`, `status`) VALUES
(1, 2, 285.7, 'W'),
(2, 1, 218.8, 'S'),
(3, 1, 209.8, 'S'),
(4, 1, 444.7, 'S'),
(6, 1, 386.7, 'W'),
(7, 1, 381.7, 'A'),
(8, 2, 95.9, 'W'),
(9, 2, 269.7, 'W'),
(10, 2, 235.8, 'D'),
(11, 2, 0, 'W');

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE IF NOT EXISTS `orders_item` (
  `orders_idorder` int(10) unsigned NOT NULL,
  `product_idproduct` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`orders_idorder`,`product_idproduct`),
  KEY `fk_orders_item_orders1_idx` (`orders_idorder`),
  KEY `fk_orders_item_product1_idx` (`product_idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`orders_idorder`, `product_idproduct`, `quantity`) VALUES
(0, 1, 1),
(0, 2, 2),
(2, 14, 1),
(2, 15, 1),
(3, 12, 2),
(4, 4, 1),
(4, 17, 2),
(6, 11, 1),
(6, 15, 2),
(7, 1, 2),
(7, 4, 2),
(7, 8, 1),
(8, 1, 1),
(9, 2, 2),
(9, 13, 1),
(10, 12, 1),
(10, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `idproduct` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pbrand` varchar(45) NOT NULL,
  `pmodel` varchar(45) NOT NULL,
  `pcategory` varchar(45) NOT NULL,
  `pcolor` varchar(45) NOT NULL,
  `psize` int(10) unsigned NOT NULL,
  `pprice` float NOT NULL,
  `pstock` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idproduct`),
  UNIQUE KEY `idproduct_UNIQUE` (`idproduct`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idproduct`, `pbrand`, `pmodel`, `pcategory`, `pcolor`, `psize`, `pprice`, `pstock`) VALUES
(1, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Blue', 44, 12.9, 12),
(2, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Blue', 43, 94.9, 9),
(3, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Blue', 42, 94.9, 8),
(4, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Blue', 45, 94.9, 3),
(5, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Black', 45, 94.9, 5),
(7, 'Nike', 'Hyperdunk 2015', 'Basketball', 'Red', 44, 94.9, 5),
(8, 'Nike', 'Lebron X', 'Basketball', 'Gold', 45, 189.9, 1),
(9, 'Under Armour', 'Curry One', 'Basketball', 'Yellow', 44, 174.9, 4),
(11, 'Adidas', 'Rose 3.5', 'Basketball', 'Red', 44, 124.9, 11),
(12, 'Adidas', 'CrazyQuick', 'Basketball', 'Grey', 43, 104.9, 7),
(13, 'Adidas', 'Ultra Boost', 'Running', 'White', 41, 79.9, 3),
(14, 'Adidas', 'Ultra Boost LT', 'Running', 'Silver', 42, 87.9, 4),
(15, 'Adidas', 'Adizero 5-Star', 'Football', 'Red', 44, 130.9, 3),
(16, 'Adidas', 'Howard 5', 'Basketball', 'Green', 47, 99.9, 3),
(17, 'Under Armour', 'Curry One', 'Basketball', 'Black', 45, 174.9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(120) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `email`, `password`, `name`, `address`, `phone`, `status`) VALUES
(1, 'david@user.si', '$2y$10$DPZdge3zC80WgIZh774LqeAAGVRLgO1IFFyc/Vh1yogqCH3RMnMoq', 'David', 'FRI LJ', '051000000', 'A'),
(2, 'rok.zidarn@gmail.com', '$2y$10$AXx/DjmVKyHYOKWtZ95lVOM0AISMDmShI9uUmk7rW09OTUE1l6FYi', 'Rok Zidarn', 'Bucerca 26 Krsko', '051257356', 'A'),
(3, 'lukineli@gmail.com', '$2y$10$kg8SZeoPQVjpPDXVe/Q7Quf2q1zJeElwsiBTYZl2FwmGDE3P3hOT.', 'Ludvik Zidarn', 'Krsko', '051622213', 'A'),
(4, 'kobe24@lakers.com', '$2y$10$e1lOewnl3XxSMnrSr4Cn9.zHty55DKJD.QVC7V8DRdl1M5O3GnkyG', 'Kobe Bryant', 'Los Angeles', '555555555', 'D');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD CONSTRAINT `fk_orders_item_orders1` FOREIGN KEY (`orders_idorder`) REFERENCES `orders` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_item_product1` FOREIGN KEY (`product_idproduct`) REFERENCES `product` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
