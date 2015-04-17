-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-18 15:01:11
-- 服务器版本： 5.5.40
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dc`
--

-- --------------------------------------------------------

--
-- 表的结构 `sj`
--

CREATE TABLE IF NOT EXISTS `sj` (
  `id` int(20) NOT NULL,
  `user` char(50) NOT NULL,
  `num` int(20) NOT NULL DEFAULT '1',
  `times` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isdel` int(2) NOT NULL DEFAULT '0',
  `bz` char(60) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sj`
--

INSERT INTO `sj` (`id`, `user`, `num`, `bz`) VALUES
(1, '张三', 1, NULL),
(2, '李四', 1, NULL),
(3, '二货', 5, NULL),
(4, '锤子', 5, NULL),
(5, '撒', 1, NULL),
(6, '速度', 3, NULL),
(7, '昨天1', 1, NULL),
(8, '二货', 1, NULL),
(9, '张三', 1,  NULL),
(10, '张三', 1,  NULL),
(11, '周斌', 5, '测试1'),
(12, '李四', 6, NULL),
(13, '李四', 1, ''),
(14, '李四', 2,  '什么'),
(15, '李四', 6,  '测试'),
(16, '周五', 1,  '测试2'),
(17, '张三', 7,  '测试3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sj`
--
ALTER TABLE `sj`
  ADD PRIMARY KEY (`id`), ADD KEY `AUTO_INCREMENT` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sj`
--
ALTER TABLE `sj`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
