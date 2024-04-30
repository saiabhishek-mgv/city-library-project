# city-library-project
 
```
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2024 at 01:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `city_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `AUTHORS`
--

CREATE TABLE `AUTHORS` (
  `PID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BOOK`
--

CREATE TABLE `BOOK` (
  `DOCID` int(11) NOT NULL,
  `ISBN` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BORROWING`
--

CREATE TABLE `BORROWING` (
  `BOR_NO` int(11) NOT NULL,
  `BDTIME` datetime DEFAULT NULL,
  `RDTIME` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BORROWS`
--

CREATE TABLE `BORROWS` (
  `BOR_NO` int(11) NOT NULL,
  `RID` int(11) DEFAULT NULL,
  `DOCID` int(11) DEFAULT NULL,
  `COPYNO` int(11) DEFAULT NULL,
  `BID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BRANCH`
--

CREATE TABLE `BRANCH` (
  `BID` int(11) NOT NULL,
  `LNAME` varchar(255) DEFAULT NULL,
  `LOCATION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `BRANCH`
--

INSERT INTO `BRANCH` (`BID`, `LNAME`, `LOCATION`) VALUES
(1, 'New York', 'New York');

-- --------------------------------------------------------

--
-- Table structure for table `CHAIRS`
--

CREATE TABLE `CHAIRS` (
  `PID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `COPIES`
--

CREATE TABLE `COPIES` (
  `COPYNO` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL,
  `POSITION` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `COPIES`
--

INSERT INTO `COPIES` (`COPYNO`, `BID`, `DOCID`, `POSITION`) VALUES
(1, 1, 1, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `DOCUMENT`
--

CREATE TABLE `DOCUMENT` (
  `DOCID` int(11) NOT NULL,
  `TITLE` varchar(255) DEFAULT NULL,
  `PDATE` date DEFAULT NULL,
  `PUBLISHERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `DOCUMENT`
--

INSERT INTO `DOCUMENT` (`DOCID`, `TITLE`, `PDATE`, `PUBLISHERID`) VALUES
(1, 'The Wanderer', '2023-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `GEDITS`
--

CREATE TABLE `GEDITS` (
  `PID` int(11) NOT NULL,
  `ISSUE_NO` int(11) NOT NULL,
  `DOCID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JOURNAL_ISSUE`
--

CREATE TABLE `JOURNAL_ISSUE` (
  `ISSUE_NO` int(11) NOT NULL,
  `SCOPE` varchar(255) DEFAULT NULL,
  `DOCID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JOURNAL_VOLUME`
--

CREATE TABLE `JOURNAL_VOLUME` (
  `VOLUME_NO` int(11) DEFAULT NULL,
  `DOCID` int(11) NOT NULL,
  `EDITOR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PERSON`
--

CREATE TABLE `PERSON` (
  `PID` int(11) NOT NULL,
  `PNAME` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PROCEEDINGS`
--

CREATE TABLE `PROCEEDINGS` (
  `DOCID` int(11) NOT NULL,
  `CDATE` date DEFAULT NULL,
  `CLOCATION` varchar(255) DEFAULT NULL,
  `CEDITOR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PUBLISHER`
--

CREATE TABLE `PUBLISHER` (
  `PUBLISHERID` int(11) NOT NULL,
  `PUBNAME` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PUBLISHER`
--

INSERT INTO `PUBLISHER` (`PUBLISHERID`, `PUBNAME`, `ADDRESS`) VALUES
(1, 'A', 'New York');

-- --------------------------------------------------------

--
-- Table structure for table `READER`
--

CREATE TABLE `READER` (
  `RID` int(11) NOT NULL,
  `RTYPE` varchar(50) DEFAULT NULL,
  `RNAME` varchar(255) DEFAULT NULL,
  `RADDRESS` varchar(255) DEFAULT NULL,
  `PHONE_NO` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `READER`
--

INSERT INTO `READER` (`RID`, `RTYPE`, `RNAME`, `RADDRESS`, `PHONE_NO`) VALUES
(1, 'Student', 'Abhishek', '150 belmont', '8624105130');

-- --------------------------------------------------------

--
-- Table structure for table `RESERVATION`
--

CREATE TABLE `RESERVATION` (
  `RES_NO` int(11) NOT NULL,
  `DTIME` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `RESERVES`
--

CREATE TABLE `RESERVES` (
  `RESERVATION_NO` int(11) NOT NULL,
  `RID` int(11) DEFAULT NULL,
  `DOCID` int(11) DEFAULT NULL,
  `COPYNO` int(11) DEFAULT NULL,
  `BID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Role`) VALUES
(1, 'test', 'test', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AUTHORS`
--
ALTER TABLE `AUTHORS`
  ADD PRIMARY KEY (`PID`,`DOCID`),
  ADD KEY `authors_ibfk_2` (`DOCID`);

--
-- Indexes for table `BOOK`
--
ALTER TABLE `BOOK`
  ADD PRIMARY KEY (`DOCID`);

--
-- Indexes for table `BORROWING`
--
ALTER TABLE `BORROWING`
  ADD PRIMARY KEY (`BOR_NO`);

--
-- Indexes for table `BORROWS`
--
ALTER TABLE `BORROWS`
  ADD PRIMARY KEY (`BOR_NO`),
  ADD KEY `RID` (`RID`),
  ADD KEY `DOCID` (`DOCID`,`COPYNO`,`BID`),
  ADD KEY `borrows_ibfk_1` (`BID`);

--
-- Indexes for table `BRANCH`
--
ALTER TABLE `BRANCH`
  ADD PRIMARY KEY (`BID`);

--
-- Indexes for table `CHAIRS`
--
ALTER TABLE `CHAIRS`
  ADD PRIMARY KEY (`PID`,`DOCID`),
  ADD KEY `DOCID` (`DOCID`);

--
-- Indexes for table `COPIES`
--
ALTER TABLE `COPIES`
  ADD PRIMARY KEY (`COPYNO`,`BID`,`DOCID`),
  ADD KEY `copies_ibfk_1` (`BID`),
  ADD KEY `copies_ibfk_2` (`DOCID`);

--
-- Indexes for table `DOCUMENT`
--
ALTER TABLE `DOCUMENT`
  ADD PRIMARY KEY (`DOCID`),
  ADD KEY `PUBLISHERID` (`PUBLISHERID`);

--
-- Indexes for table `GEDITS`
--
ALTER TABLE `GEDITS`
  ADD PRIMARY KEY (`PID`,`ISSUE_NO`,`DOCID`),
  ADD KEY `DOCID` (`DOCID`,`ISSUE_NO`);

--
-- Indexes for table `JOURNAL_ISSUE`
--
ALTER TABLE `JOURNAL_ISSUE`
  ADD PRIMARY KEY (`DOCID`,`ISSUE_NO`);

--
-- Indexes for table `JOURNAL_VOLUME`
--
ALTER TABLE `JOURNAL_VOLUME`
  ADD PRIMARY KEY (`DOCID`),
  ADD KEY `EDITOR` (`EDITOR`);

--
-- Indexes for table `PERSON`
--
ALTER TABLE `PERSON`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `PROCEEDINGS`
--
ALTER TABLE `PROCEEDINGS`
  ADD PRIMARY KEY (`DOCID`);

--
-- Indexes for table `PUBLISHER`
--
ALTER TABLE `PUBLISHER`
  ADD PRIMARY KEY (`PUBLISHERID`);

--
-- Indexes for table `READER`
--
ALTER TABLE `READER`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `RESERVATION`
--
ALTER TABLE `RESERVATION`
  ADD PRIMARY KEY (`RES_NO`);

--
-- Indexes for table `RESERVES`
--
ALTER TABLE `RESERVES`
  ADD PRIMARY KEY (`RESERVATION_NO`),
  ADD KEY `RID` (`RID`),
  ADD KEY `DOCID` (`DOCID`,`COPYNO`,`BID`),
  ADD KEY `reserves_ibfk_1` (`BID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `READER`
--
ALTER TABLE `READER`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AUTHORS`
--
ALTER TABLE `AUTHORS`
  ADD CONSTRAINT `authors_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `PERSON` (`PID`),
  ADD CONSTRAINT `authors_ibfk_2` FOREIGN KEY (`DOCID`) REFERENCES `BOOK` (`DOCID`);

--
-- Constraints for table `BOOK`
--
ALTER TABLE `BOOK`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`);

--
-- Constraints for table `BORROWS`
--
ALTER TABLE `BORROWS`
  ADD CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`BID`) REFERENCES `READER` (`RID`),
  ADD CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`DOCID`,`COPYNO`,`BID`) REFERENCES `COPIES` (`DOCID`, `COPYNO`, `BID`),
  ADD CONSTRAINT `borrows_ibfk_3` FOREIGN KEY (`BOR_NO`) REFERENCES `BORROWING` (`BOR_NO`);

--
-- Constraints for table `CHAIRS`
--
ALTER TABLE `CHAIRS`
  ADD CONSTRAINT `chairs_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `PERSON` (`PID`),
  ADD CONSTRAINT `chairs_ibfk_2` FOREIGN KEY (`DOCID`) REFERENCES `PROCEEDINGS` (`DOCID`);

--
-- Constraints for table `COPIES`
--
ALTER TABLE `COPIES`
  ADD CONSTRAINT `copies_ibfk_1` FOREIGN KEY (`BID`) REFERENCES `BRANCH` (`BID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `copies_ibfk_2` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DOCUMENT`
--
ALTER TABLE `DOCUMENT`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`PUBLISHERID`) REFERENCES `PUBLISHER` (`PUBLISHERID`);

--
-- Constraints for table `GEDITS`
--
ALTER TABLE `GEDITS`
  ADD CONSTRAINT `gedits_ibfk_1` FOREIGN KEY (`PID`) REFERENCES `PERSON` (`PID`),
  ADD CONSTRAINT `gedits_ibfk_2` FOREIGN KEY (`DOCID`,`ISSUE_NO`) REFERENCES `JOURNAL_ISSUE` (`DOCID`, `ISSUE_NO`);

--
-- Constraints for table `JOURNAL_ISSUE`
--
ALTER TABLE `JOURNAL_ISSUE`
  ADD CONSTRAINT `journal_issue_ibfk_1` FOREIGN KEY (`DOCID`) REFERENCES `JOURNAL_VOLUME` (`DOCID`);

--
-- Constraints for table `JOURNAL_VOLUME`
--
ALTER TABLE `JOURNAL_VOLUME`
  ADD CONSTRAINT `journal_volume_ibfk_1` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`),
  ADD CONSTRAINT `journal_volume_ibfk_2` FOREIGN KEY (`EDITOR`) REFERENCES `PERSON` (`PID`);

--
-- Constraints for table `PROCEEDINGS`
--
ALTER TABLE `PROCEEDINGS`
  ADD CONSTRAINT `proceedings_ibfk_1` FOREIGN KEY (`DOCID`) REFERENCES `DOCUMENT` (`DOCID`);

--
-- Constraints for table `RESERVES`
--
ALTER TABLE `RESERVES`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`BID`) REFERENCES `READER` (`RID`),
  ADD CONSTRAINT `reserves_ibfk_2` FOREIGN KEY (`DOCID`,`COPYNO`,`BID`) REFERENCES `COPIES` (`DOCID`, `COPYNO`, `BID`),
  ADD CONSTRAINT `reserves_ibfk_3` FOREIGN KEY (`RESERVATION_NO`) REFERENCES `RESERVATION` (`RES_NO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
