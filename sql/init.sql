-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： mysql5.7
-- 生成日期： 2022-06-14 15:49:51
-- 服务器版本： 5.7.35
-- PHP 版本： 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `sf_admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin`
--

CREATE TABLE `sys_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `head_img` varchar(1000) DEFAULT NULL,
  `psalt` varchar(32) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `sys_admin`
--

INSERT INTO `sys_admin` (`id`, `name`, `username`, `password`, `head_img`, `psalt`, `status`, `updated_at`, `created_at`) VALUES
(1, 'arkadmin', 'arkadmin', '184fb0f9588f7f87b212a43944a361be', 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80', 'e8fc8d47d56055d66e1f276ed90df14b', 1, '2022-06-14 21:55:11', '2020-08-27 03:38:30');

--
-- 转储表的索引
--

--
-- 表的索引 `sys_admin`
--
ALTER TABLE `sys_admin`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `sys_admin`
--
ALTER TABLE `sys_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
