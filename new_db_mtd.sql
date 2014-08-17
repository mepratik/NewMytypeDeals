-- phpMyAdmin SQL Dump
-- version 3.4.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2014 at 01:01 PM
-- Server version: 5.1.52
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mytype_deals`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `uid` int(10) NOT NULL,
  `did` int(10) NOT NULL,
  `num_deal` int(10) NOT NULL,
  `tiemstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `details` varchar(250) NOT NULL COMMENT 'Details like color, size etc.',
  PRIMARY KEY (`uid`,`did`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT 'Description about category, contains what items etc.',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `name`, `title`) VALUES
(1, 'City Deals', ''),
(2, 'Electronics', ''),
(3, 'Restaurants and Hotels', ''),
(4, 'Cake Taxi', ''),
(5, 'Health And Beauty', ''),
(6, 'Miscellaneous', '');

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE IF NOT EXISTS `dealers` (
  `dealerid` int(10) NOT NULL AUTO_INCREMENT,
  `dealername` varchar(100) NOT NULL,
  `dealeremail` varchar(100) NOT NULL,
  `phnum` char(10) NOT NULL,
  `address` varchar(300) NOT NULL,
  `city` varchar(70) NOT NULL,
  `state` varchar(70) NOT NULL,
  PRIMARY KEY (`dealerid`),
  UNIQUE KEY `phnum` (`phnum`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`dealerid`, `dealername`, `dealeremail`, `phnum`, `address`, `city`, `state`) VALUES
(1, 'NA', 'NA', 'NA', 'NA', 'NA', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE IF NOT EXISTS `deals` (
  `did` int(10) NOT NULL AUTO_INCREMENT,
  `dealerid` int(10) NOT NULL COMMENT 'The id of the dealer for this deal, references dealerid of dealers',
  `scid` int(10) NOT NULL COMMENT 'Subcategory ID.',
  `cid` int(10) NOT NULL COMMENT 'Category ID.',
  `iid` int(10) NOT NULL COMMENT 'Image ID.',
  `title` varchar(100) NOT NULL,
  `desc` varchar(250) DEFAULT NULL COMMENT 'Detailed description about deal. Separate different points by semi colon',
  `originalprice` double(10,2) NOT NULL,
  `price` double(10,2) NOT NULL,
  `features` varchar(1000) DEFAULT NULL COMMENT 'Detailed features about deal. Separate different points by semi colon',
  `otherdetails` varchar(1000) DEFAULT NULL COMMENT 'Othee details about deal. Separate different points by semi colon',
  `instock` int(10) NOT NULL,
  `homedelivery` tinyint(1) NOT NULL,
  `validupto` datetime NOT NULL,
  `refundable` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT 'Number of views to this deal. ',
  `warranty` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ordered` int(10) NOT NULL DEFAULT '0' COMMENT 'Number of orders of this deal. ',
  `bigdeal` tinyint(1) NOT NULL COMMENT 'If 1, then dipayed in the slideshow.',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'If 1, then deal dipayed.',
  `cod` tinyint(1) NOT NULL COMMENT 'If 1, then cash on delivery is enabled.',
  PRIMARY KEY (`did`),
  KEY `dealerid` (`dealerid`),
  KEY `scid` (`scid`),
  KEY `cid` (`cid`),
  KEY `iid` (`iid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`did`, `dealerid`, `scid`, `cid`, `iid`, `title`, `desc`, `originalprice`, `price`, `features`, `otherdetails`, `instock`, `homedelivery`, `validupto`, `refundable`, `views`, `warranty`, `timestamp`, `ordered`, `bigdeal`, `active`, `cod`) VALUES
(1, 1, 23, 3, 1, 'Kabila Rajasthani Multicuisine', 'Rajasthani thaali combo- Batti, Dal, Churma, Gata Curry,Choice of chefs veg, Lal Maans or Desi Chicken, Raita\n, Salad, Papad, Choice of two indian breads, Steamed Rice, Masala Chaans complimentary.', 699.00, 349.00, 'This deal is on rajasthani multi cuisine restaurant Kabila Dehradun.;It contains the Rajasthani thaali combo-Batti,Dal,Churma\n,Gata Curry,Choice of chefs veg,Lal Maans or Desi Chicken ,Raita\n,Salad,Papad,Choice of two indian breads,Steamed Rice,Masala Chaans complimentary.', 'Avail 10% discount on non sharing thaali.', -1, 1, '2014-04-20 12:07:27', 0, 0, 'This deal is brought to you by Kabila Rajasthani Multicuisine and mytypedeals is not responsible for what they offer.;This deal is exclusively for the users of mytypedeals only.;This deal cannot be clubbed with other existing offers and deals.;To redeem please buy the deal and show the order receipt mailed to you at the restaurant.;The price is exclusive of taxes.; For more info contact 9758297776', '2014-04-17 09:55:20', 0, 0, 1, 1),
(2, 1, 10, 3, 2, 'Elloras melting moments cake @ 99', 'Dream cake is no more a dream now! Deal covers approximately 1 pound vanilla cake by elloras melting moments.', 599.00, 99.00, 'This deal covers approximately 1 pound vanilla cake by elloras melting moments.;Quality and standards maintained by Elloras Melting Moments.', '', 1, 0, '2014-04-25 00:00:00', 1, 0, 'To redeem this deal please carry the electronic receipt mailed to you at Elloras Melting Moments after you buy the deal.;Cash on delivery is not applicable on this deal.;Deal is valid for 27 days only.;Disclaimer: The prices at the outlet and caketaxi may vary.;This deal is exclusive for mytypedeals users only and cannot be redeemed without showing the order receipt.;To redeem this deal please carry the electronic receipt mailed to you at Elloras Melting Moments after you buy the deal.;Cash on delivery is not applicable on this deal.;Deal is valid for 27 days only.;Disclaimer: The prices at the outlet and caketaxi may vary.;This deal is exclusive for mytypedeals users only and cannot be redeemed without showing the order receipt.', '2014-04-17 10:08:59', 0, 0, 1, 0),
(3, 1, 18, 5, 3, 'Fragnance', NULL, 1099.00, 599.00, NULL, NULL, -1, 0, '2014-06-11 12:46:00', 0, 0, NULL, '2014-04-17 21:54:07', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `iid` int(10) NOT NULL AUTO_INCREMENT,
  `did` int(10) DEFAULT NULL,
  `path` varchar(50) NOT NULL,
  `alt` varchar(50) NOT NULL COMMENT 'Description of image.',
  PRIMARY KEY (`iid`),
  KEY `did` (`did`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`iid`, `did`, `path`, `alt`) VALUES
(1, 1, 'images/deals/food1.jpg', 'Restaurant Deal'),
(2, 2, 'images/deals/valcake1.jpg', 'Elloras Melting Moments'),
(3, 3, 'images/deals/fragnance.jpg', 'Smell the Fragnance');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `did` int(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orderstatus` varchar(100) NOT NULL,
  `paymentmode` varchar(10) NOT NULL,
  `odernotes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `uid` (`uid`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `picked4u`
--

CREATE TABLE IF NOT EXISTS `picked4u` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `banner_path` varchar(100) NOT NULL,
  `link` varchar(200) NOT NULL COMMENT 'Link to the deal.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE IF NOT EXISTS `subcategories` (
  `scid` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`scid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`scid`, `cid`, `name`, `title`) VALUES
(1, 1, 'Top city deals', ''),
(2, 1, 'Deal of the day', ''),
(3, 1, 'Past deals', ''),
(4, 1, 'Most bought deals', ''),
(5, 2, 'Mobiles & Gadgets', ''),
(6, 2, 'Computer asscessories', ''),
(7, 2, 'Gaming', ''),
(8, 2, 'Home and Kitchen appliances', ''),
(9, 2, 'Camera', ''),
(10, 4, 'Cakes', ''),
(11, 4, 'Flowers', ''),
(12, 4, 'Chocolates', ''),
(13, 4, 'Special occasions combos', ''),
(14, 5, 'Apparels', ''),
(15, 5, 'Beauty And Wellness', ''),
(16, 5, 'Dental', ''),
(17, 5, 'Fitness', ''),
(18, 5, 'Fragrance', ''),
(19, 6, 'Books', ''),
(20, 6, 'Stationary', ''),
(21, 6, 'Holiday packages', ''),
(22, 6, 'Sports', ''),
(23, 3, 'Restaurant And Hotels', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(70) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `houseno` varchar(50) NOT NULL,
  `street1` varchar(70) NOT NULL,
  `street2` varchar(70) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(30) NOT NULL,
  `mobile` char(10) NOT NULL,
  `othermobile` char(10) DEFAULT NULL,
  `occupation` varchar(100) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `fname`, `lname`, `password`, `dob`, `email`, `gender`, `houseno`, `street1`, `street2`, `city`, `state`, `country`, `mobile`, `othermobile`, `occupation`) VALUES
(1, 'Nishkarsh', 'Sharma', '437b930db84b8079c2dd804a71936b5f', '1992-01-30', 'nishkarsh4@gmail.com', 'male', '143/2, Gurudwara Road,', 'Lane no. 11, Society Area', 'Clement Town', 'Dehradun', 'Uttarakhand', 'India', '7409359161', NULL, 'Student');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`did`) REFERENCES `deals` (`did`),
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`did`) REFERENCES `deals` (`did`);

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_ibfk_64` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_1` FOREIGN KEY (`dealerid`) REFERENCES `dealers` (`dealerid`),
  ADD CONSTRAINT `deals_ibfk_10` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_11` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_12` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_13` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_14` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_15` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_16` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_17` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_18` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_19` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_2` FOREIGN KEY (`dealerid`) REFERENCES `dealers` (`dealerid`),
  ADD CONSTRAINT `deals_ibfk_20` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_21` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_22` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_23` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_24` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_25` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_26` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_27` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_28` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_29` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_3` FOREIGN KEY (`scid`) REFERENCES `subcategories` (`scid`),
  ADD CONSTRAINT `deals_ibfk_30` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_31` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_32` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_33` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_34` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_35` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_36` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_37` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_38` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_39` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_4` FOREIGN KEY (`scid`) REFERENCES `subcategories` (`scid`),
  ADD CONSTRAINT `deals_ibfk_40` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_41` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_42` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_43` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_44` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_45` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_46` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_47` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_48` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_49` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_5` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_50` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_51` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_52` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_53` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_54` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_55` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_56` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_57` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_58` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_59` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_6` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_60` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_61` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_62` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_63` FOREIGN KEY (`iid`) REFERENCES `images` (`iid`),
  ADD CONSTRAINT `deals_ibfk_7` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_8` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `deals_ibfk_9` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`did`) REFERENCES `deals` (`did`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`did`) REFERENCES `deals` (`did`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`did`) REFERENCES `deals` (`did`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
