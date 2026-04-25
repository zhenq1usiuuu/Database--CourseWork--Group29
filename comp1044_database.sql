-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2026-04-16 08:49:52
-- 服务器版本： 5.7.24
-- PHP 版本： 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `comp1044_database`
--

-- --------------------------------------------------------

--
-- 表的结构 `internship`
--

CREATE TABLE `internship` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Uni_AssessorID` int(11) NOT NULL,
  `Com_AssessorID` int(11) NOT NULL,
  `Final_Average_Mark` decimal(5,2) NOT NULL DEFAULT '0.00',
  `Company` varchar(255) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `result`
--

CREATE TABLE `result` (
  `ID` int(11) NOT NULL,
  `InternshipID` int(11) NOT NULL,
  `AssessorID` int(11) NOT NULL,
  `Tasks_Mark` decimal(5,2) NOT NULL,
  `Health_Mark` decimal(5,2) NOT NULL,
  `Knowledge_Mark` decimal(5,2) NOT NULL,
  `Presentation_Mark` decimal(5,2) NOT NULL,
  `Language_Mark` decimal(5,2) NOT NULL,
  `Activities_Mark` decimal(5,2) NOT NULL,
  `Project_Mark` decimal(5,2) NOT NULL,
  `Time_Mark` decimal(5,2) NOT NULL,
  `Final_Mark` decimal(5,2) NOT NULL,
  `Comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Programme` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `int_stu` (`StudentID`),
  ADD KEY `int_Uni` (`Uni_AssessorID`),
  ADD KEY `int_Com` (`Com_AssessorID`);

--
-- 表的索引 `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `res_int` (`InternshipID`),
  ADD KEY `res_user` (`AssessorID`);

--
-- 表的索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `internship`
--
ALTER TABLE `internship`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `result`
--
ALTER TABLE `result`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `internship`
--
ALTER TABLE `internship`
  ADD CONSTRAINT `int_Com` FOREIGN KEY (`Com_AssessorID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `int_Uni` FOREIGN KEY (`Uni_AssessorID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `int_stu` FOREIGN KEY (`StudentID`) REFERENCES `student` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `res_int` FOREIGN KEY (`InternshipID`) REFERENCES `internship` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_user` FOREIGN KEY (`AssessorID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
