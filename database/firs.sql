-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2018 at 03:37 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `firs`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_auditor`
--

CREATE TABLE `customer_auditor` (
  `id` int(11) NOT NULL,
  `sname` varchar(230) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(220) NOT NULL,
  `address` text NOT NULL,
  `tin` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_auditor`
--

INSERT INTO `customer_auditor` (`id`, `sname`, `phone`, `email`, `address`, `tin`) VALUES
(1, 'AbdulJaleel Usman', '084566232', 'aabdulraheemsherif@gmail.com', 'Ajaokuta, Kogi State', '05-710863774'),
(3, 'Usman Tanimu', '08043434342', 'asaw@gmail.com', 'GRA Bauchi - Nigeria', '05-413258301');

-- --------------------------------------------------------

--
-- Table structure for table `customer_branch`
--

CREATE TABLE `customer_branch` (
  `id` int(11) NOT NULL,
  `state` varchar(200) NOT NULL,
  `lgv` varchar(220) NOT NULL,
  `address` text NOT NULL,
  `tin` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_branch`
--

INSERT INTO `customer_branch` (`id`, `state`, `lgv`, `address`, `tin`) VALUES
(1, 'Abuja', 'Gwagwalada', 'Government Road, Gwagwalada Abuja.', '05-710863774'),
(2, 'Adamawa', 'Ganaye', 'No. 24B Yaradua Street 	Ganaye, Adamawa State.', '05-710863774'),
(4, 'Bauchi', 'Bauchi', 'GRA Bauchi State - Nigeria.', '05-413258301');

-- --------------------------------------------------------

--
-- Table structure for table `customer_cit`
--

CREATE TABLE `customer_cit` (
  `id` int(11) NOT NULL,
  `tin` varchar(150) DEFAULT NULL,
  `turnOver` varchar(220) DEFAULT NULL,
  `profitLoss` varchar(220) DEFAULT NULL,
  `nprofitLoss` varchar(50) DEFAULT NULL,
  `depreciation` varchar(220) DEFAULT NULL,
  `ane` varchar(220) DEFAULT NULL,
  `capital` varchar(220) DEFAULT NULL,
  `vatDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cit` varchar(220) DEFAULT NULL,
  `et` varchar(220) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_cit`
--

INSERT INTO `customer_cit` (`id`, `tin`, `turnOver`, `profitLoss`, `nprofitLoss`, `depreciation`, `ane`, `capital`, `vatDate`, `cit`, `et`) VALUES
(1, '05-710863774', '20000', '10000', 'Profit', '50', '500', '5000', '2018-08-29 00:00:00', '1665', '111'),
(2, '05-710863774', '50000', '10000', 'Profit', '5000', '550', '15000', '2010-02-09 00:00:00', '1539.45', '102.63'),
(3, '05-710863774', '50000', '10000', 'Profit', '5000', '550', '15000', '2010-02-09 00:00:00', '1539.45', '102.63'),
(4, '05-710863774', '50000', '2000', 'Loss', '4000', '5000', '25000', '2017-10-24 00:00:00', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `customer_company`
--

CREATE TABLE `customer_company` (
  `id` int(11) NOT NULL,
  `cname` varchar(230) NOT NULL,
  `rc` varchar(220) NOT NULL,
  `address` text NOT NULL,
  `tin` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_company`
--

INSERT INTO `customer_company` (`id`, `cname`, `rc`, `address`, `tin`) VALUES
(1, 'Garage Computer Internation Plc', '23456666', 'Abuja Nigeria', '05-710863774');

-- --------------------------------------------------------

--
-- Table structure for table `customer_director`
--

CREATE TABLE `customer_director` (
  `id` int(11) NOT NULL,
  `sname` varchar(230) NOT NULL,
  `tin` varchar(100) NOT NULL,
  `spe` varchar(50) NOT NULL,
  `shareA` varchar(230) NOT NULL,
  `cname` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_director`
--

INSERT INTO `customer_director` (`id`, `sname`, `tin`, `spe`, `shareA`, `cname`) VALUES
(1, 'Hawa Sumaila', '05-710863774', '07063217781', 'Ajaokuta, Kogi State.', 'Ifytom Bakeries Nigeria Ltd.'),
(2, 'John Tochukwu K.', '05-710863774', '0707321110', 'Akwanga LG, Abia State.', 'Bambam Fashion Design and Breweries Stores. Ltd.'),
(4, 'Suleiman Bala', '05-413258301', '0706454454', 'Abuja- Nigeria', 'Sule & Co.');

-- --------------------------------------------------------

--
-- Table structure for table `customer_officer`
--

CREATE TABLE `customer_officer` (
  `id` int(11) NOT NULL,
  `sname` varchar(230) NOT NULL,
  `tin` varchar(100) NOT NULL,
  `spe` varchar(50) NOT NULL,
  `shareA` varchar(230) NOT NULL,
  `cname` varchar(230) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_officer`
--

INSERT INTO `customer_officer` (`id`, `sname`, `tin`, `spe`, `shareA`, `cname`) VALUES
(1, 'Agbakagba John', '05-710863774', '07034745602', 'Kaduna Estate, Ajaokuta Kogi State.', 'Manager'),
(2, 'Abdulraheem Sherif A', '05-710863774', '08164377187', 'Abuja Estate, Ajaokuta Kogi State.', 'Instructor'),
(4, 'Asmau Ibrahim', '05-413258301', '07037928142', 'GRA Bauchi - Nigeria', 'CEO'),
(5, 'Ishaq Muhammed', '05-413258301', '08034621149', 'GRA Bauchi - Nigeria', 'Director');

-- --------------------------------------------------------

--
-- Table structure for table `customer_record`
--

CREATE TABLE `customer_record` (
  `id` int(11) NOT NULL,
  `cname` text NOT NULL,
  `cemail` varchar(200) NOT NULL,
  `cpassword` varchar(100) NOT NULL,
  `rcnumber` varchar(150) NOT NULL,
  `confirm` varchar(5) NOT NULL,
  `cid` varchar(150) NOT NULL,
  `tin` varchar(150) NOT NULL DEFAULT 'Nil',
  `phone` varchar(20) DEFAULT NULL,
  `aregoffice` varchar(240) DEFAULT NULL,
  `aoproffice` varchar(240) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `bline` varchar(100) DEFAULT NULL,
  `bform` varchar(100) DEFAULT NULL,
  `nbusiness` varchar(100) DEFAULT NULL,
  `ocd` date DEFAULT NULL,
  `doi` date DEFAULT NULL,
  `acntDate` date DEFAULT NULL,
  `bankA` varchar(230) DEFAULT NULL,
  `bankB` varchar(230) DEFAULT NULL,
  `bankN` varchar(200) DEFAULT NULL,
  `accnsc` varchar(20) DEFAULT NULL,
  `accnnumber` varchar(15) DEFAULT NULL,
  `accntname` varchar(230) DEFAULT NULL,
  `app_status` varchar(10) DEFAULT NULL,
  `dateSub` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateApprove` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_record`
--

INSERT INTO `customer_record` (`id`, `cname`, `cemail`, `cpassword`, `rcnumber`, `confirm`, `cid`, `tin`, `phone`, `aregoffice`, `aoproffice`, `website`, `bline`, `bform`, `nbusiness`, `ocd`, `doi`, `acntDate`, `bankA`, `bankB`, `bankN`, `accnsc`, `accnnumber`, `accntname`, `app_status`, `dateSub`, `dateApprove`) VALUES
(1, 'Pesoka Computers Nigeria Limited', 'aabdulraheemsherif@yahoo.com', '12345', '2233445566', '1', '992121022', '05-710863774', '08164377187', 'Flat 24B Road E4 Kaduna Estate, Ajaokuta Kogi State.', 'Flat 24B Road E4 Kaduna Estate, Ajaokuta Kogi State.', 'www.pesokasystems.com', '0974333222', 'Information Technology', 'Ltd', '2005-02-09', '2002-03-24', '2009-01-29', 'Ajaokuta Kogi State', 'Ajaokuta, Kogi State', 'First Bank', '56789', '3055822223', 'Pesoka Computers Nigeria Limited', '2', '2018-09-21 08:41:07', '2018-09-21 15:49:47'),
(2, 'YUCCY Catering Services', 'mbilkisu10@gmail.com', 'bilqees10', '764555122', '1', '5555555', '05-343206245', '08036935689', 'GRA Bauchi', 'GRA Bauchi', 'www.yuccycatering.com', '07037928142', 'Hotel And Catering', 'Ltd', '2010-11-18', '2010-06-02', '2018-09-21', 'Bank Road Bauchi', 'Bauchi', 'Keystone Bank', '23444', '203555588', 'YUC Catering Services', '0', '2018-09-21 15:30:52', '2018-09-21 15:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `customer_share`
--

CREATE TABLE `customer_share` (
  `id` int(11) NOT NULL,
  `sname` varchar(230) NOT NULL,
  `tin` varchar(100) NOT NULL,
  `spe` varchar(50) NOT NULL,
  `shareA` varchar(230) NOT NULL,
  `vshare` varchar(230) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_share`
--

INSERT INTO `customer_share` (`id`, `sname`, `tin`, `spe`, `shareA`, `vshare`) VALUES
(8, 'Usman Tanimu', '05-710863774', '07034745602', 'Washington USA', '3000000'),
(3, 'Alhaji Usman Adams', '05-710863774', '07034761741', 'DASS Road Bauchi State.', '1000000'),
(12, 'Adams Usman', '05-413258301', '0804343431212', 'Bauchi, Nigeria', '300000'),
(13, 'Yusuf Kamal', '05-413258301', '09043434242', 'Kaduna, Nigeria', '5000000');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tax`
--

CREATE TABLE `customer_tax` (
  `id` int(11) NOT NULL,
  `sname` varchar(230) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(220) NOT NULL,
  `address` text NOT NULL,
  `tin` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_tax`
--

INSERT INTO `customer_tax` (`id`, `sname`, `phone`, `email`, `address`, `tin`) VALUES
(1, 'AbdulKudus Anataku', '093456777', 'asa@gmail.com', 'Kaduna North, Kaduna State', '05-710863774'),
(2, 'John P. Anataku', '090999927', 'asK@gmail.com', 'Kaduna North, Kaduna State', '05-710863774'),
(3, 'Gabriel Tochukwu K.', '080232323231', 'oled@yaho.com', 'Imo State - Nigeria.', '05-413258301');

-- --------------------------------------------------------

--
-- Table structure for table `customer_vat`
--

CREATE TABLE `customer_vat` (
  `id` int(11) NOT NULL,
  `totBuy` varchar(200) NOT NULL,
  `totSales` varchar(200) NOT NULL,
  `vatPurchase` varchar(200) NOT NULL,
  `vatSales` varchar(200) NOT NULL,
  `vat` varchar(200) NOT NULL,
  `vatDate` date NOT NULL,
  `tin` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_vat`
--

INSERT INTO `customer_vat` (`id`, `totBuy`, `totSales`, `vatPurchase`, `vatSales`, `vat`, `vatDate`, `tin`) VALUES
(1, '20000', '40000', '1000', '2000', '1000', '2018-09-05', '05-710863774'),
(2, '500000', '1000000', '25000', '50000', '25000', '2017-09-29', '05-710863774'),
(3, '3000', '4000', '150', '200', '50', '2018-09-05', '05-413258301'),
(4, '13000', '14800', '650', '740', '90', '2018-09-05', '05-413258301');

-- --------------------------------------------------------

--
-- Table structure for table `staff_record`
--

CREATE TABLE `staff_record` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `staff_password` varchar(100) NOT NULL,
  `staff_name` varchar(230) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_record`
--

INSERT INTO `staff_record` (`id`, `staff_id`, `staff_password`, `staff_name`) VALUES
(1, '1122', '1122', 'Abdulraheem Sherif A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_auditor`
--
ALTER TABLE `customer_auditor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_branch`
--
ALTER TABLE `customer_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_cit`
--
ALTER TABLE `customer_cit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_company`
--
ALTER TABLE `customer_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_director`
--
ALTER TABLE `customer_director`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_officer`
--
ALTER TABLE `customer_officer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_record`
--
ALTER TABLE `customer_record`
  ADD PRIMARY KEY (`tin`),
  ADD UNIQUE KEY `id` (`id`);
ALTER TABLE `customer_record` ADD FULLTEXT KEY `cname` (`cname`);

--
-- Indexes for table `customer_share`
--
ALTER TABLE `customer_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_tax`
--
ALTER TABLE `customer_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_vat`
--
ALTER TABLE `customer_vat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_record`
--
ALTER TABLE `staff_record`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_auditor`
--
ALTER TABLE `customer_auditor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_branch`
--
ALTER TABLE `customer_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_cit`
--
ALTER TABLE `customer_cit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_company`
--
ALTER TABLE `customer_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_director`
--
ALTER TABLE `customer_director`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_officer`
--
ALTER TABLE `customer_officer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_record`
--
ALTER TABLE `customer_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_share`
--
ALTER TABLE `customer_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `customer_tax`
--
ALTER TABLE `customer_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_vat`
--
ALTER TABLE `customer_vat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `staff_record`
--
ALTER TABLE `staff_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
