-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2017 at 06:19 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `Author_id` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Gender` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Hometown` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `Title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Series` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ISBN` int(11) NOT NULL,
  `Publish_date` date DEFAULT NULL,
  `Number_of_pages` int(11) DEFAULT NULL,
  `Publisher` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`Name`) VALUES
('Art'),
('Biography'),
('Business'),
('Chick-Lit'),
('Childrens'),
('Christian'),
('Classics'),
('Comedy'),
('Comics'),
('Contemporary'),
('Cookbooks'),
('Crime'),
('Detective'),
('Essay'),
('Fable'),
('Fairy-tale'),
('Fan-fiction'),
('Fantasy'),
('Fiction'),
('Fiction-narrative'),
('Folklore'),
('Graphic-Novels'),
('Historical-Fiction'),
('History'),
('Horror'),
('Humor'),
('Legend'),
('Magical-realism'),
('Manga'),
('Memoir'),
('Meta-fiction'),
('Music'),
('Mystery'),
('Mythology'),
('Mythopoeia'),
('Narrative-nonfiction'),
('Nonfiction'),
('Paranormal'),
('Personal-narrative'),
('Philosophy'),
('Picture-book'),
('Poetry'),
('Psychology'),
('Realistic-fiction'),
('Reference'),
('Religion'),
('Romance'),
('Science'),
('Science-fiction'),
('Self-Help'),
('Short-story'),
('Speech'),
('Spirituality'),
('Sports'),
('Suspense'),
('Suspense/thriller'),
('Tall-tale'),
('Textbook'),
('Thriller'),
('Travel'),
('Western'),
('Young-Adult');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `ISBN` int(11) NOT NULL,
  `Id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `part_of`
--

CREATE TABLE `part_of` (
  `ISBN` int(11) NOT NULL,
  `Genre` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Year_Est` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Rating` int(11) DEFAULT NULL,
  `Review_text` text COLLATE utf8_unicode_ci,
  `ISBN` int(11) NOT NULL,
  `Reviewer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Id` int(11) NOT NULL,
  `Address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Fine` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Name`, `Id`, `Address`, `Fine`) VALUES
('31231', 2, '312', 0),
('31233', 3, '123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wrote`
--

CREATE TABLE `wrote` (
  `Author_id` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`Author_id`),
  ADD UNIQUE KEY `Author_id` (`Author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ISBN`),
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `ISBN_2` (`ISBN`),
  ADD KEY `Publisher` (`Publisher`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`ISBN`,`Id`),
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `Library card#` (`Id`);

--
-- Indexes for table `part_of`
--
ALTER TABLE `part_of`
  ADD PRIMARY KEY (`ISBN`,`Genre`),
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `Genre` (`Genre`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ISBN`,`Reviewer_id`),
  ADD KEY `Reviewer_id` (`Reviewer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `wrote`
--
ALTER TABLE `wrote`
  ADD PRIMARY KEY (`Author_id`,`ISBN`),
  ADD KEY `Author_ID` (`Author_id`),
  ADD KEY `ISBN` (`ISBN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `Author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk _publisher` FOREIGN KEY (`Publisher`) REFERENCES `publisher` (`Name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `fk_book_isbn` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`Id`) REFERENCES `user` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `part_of`
--
ALTER TABLE `part_of`
  ADD CONSTRAINT `fk_ISBN2` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_genre_name` FOREIGN KEY (`Genre`) REFERENCES `genre` (`Name`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_book_isbn2` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviewer_id` FOREIGN KEY (`Reviewer_id`) REFERENCES `user` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wrote`
--
ALTER TABLE `wrote`
  ADD CONSTRAINT `fk_ISBN` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
