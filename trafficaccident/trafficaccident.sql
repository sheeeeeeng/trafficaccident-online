-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-05-19 11:29:44
-- 伺服器版本： 10.4.17-MariaDB
-- PHP 版本： 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `trafficaccident`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ta_log`
--

CREATE TABLE `ta_log` (
  `id` int(11) NOT NULL,
  `serial_number` text NOT NULL COMMENT '案件編號',
  `case_date` date NOT NULL COMMENT '發生日期',
  `case_time` time NOT NULL COMMENT '發生時間',
  `longitude` text DEFAULT NULL COMMENT ' GPS經度',
  `latitude` text DEFAULT NULL COMMENT ' GPS緯度',
  `accident_category` text DEFAULT NULL COMMENT ' 事故類別',
  `case_county` text DEFAULT NULL COMMENT ' 縣市',
  `case_township` text DEFAULT NULL COMMENT ' 市區鄉鎮',
  `case_village` text DEFAULT NULL COMMENT '村里',
  `case_neighborhood` text DEFAULT NULL COMMENT ' 鄰',
  `case_road` text DEFAULT NULL COMMENT '路街',
  `case_section` text DEFAULT NULL COMMENT '段',
  `case_lane` text DEFAULT NULL COMMENT '巷',
  `case_number` text DEFAULT NULL COMMENT '號',
  `case_intersection_road` text DEFAULT NULL COMMENT '路口_路街口',
  `case_intersection_lane` text DEFAULT NULL COMMENT '路口_巷',
  `case_other` text DEFAULT NULL COMMENT '其他',
  `case_highway_category` text DEFAULT NULL COMMENT '公路道路類別',
  `case_highway_name` text DEFAULT NULL COMMENT '公路名稱',
  `case_highway_kilometers` text DEFAULT NULL COMMENT '公路公里數',
  `case_highway_meter` text DEFAULT NULL COMMENT '公路公尺數',
  `case_jurisdiction` text DEFAULT NULL COMMENT ' 管轄單位',
  `case_handle_team` text DEFAULT NULL COMMENT ' 處理單位',
  `case_24h_death` text DEFAULT NULL COMMENT ' 24小時內死亡',
  `case_30d_death` text DEFAULT NULL COMMENT '30日內死亡',
  `case_injuries` text DEFAULT NULL COMMENT '受傷 人數',
  `case_accident_type_parent` text DEFAULT NULL COMMENT '事故類型父類別',
  `case_accident_type_child` text DEFAULT NULL COMMENT '事故類型子類別',
  `case_cause` text DEFAULT NULL COMMENT '肇因',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='事故紀錄_總表';

-- --------------------------------------------------------

--
-- 資料表結構 `ta_log_rank`
--

CREATE TABLE `ta_log_rank` (
  `id` int(11) NOT NULL,
  `serial_number_id` text NOT NULL COMMENT '案件編號',
  `case_rank` text DEFAULT NULL COMMENT '當事者順位',
  `case_rank_age` text DEFAULT NULL COMMENT '當事者年齡',
  `case_car_type` text DEFAULT NULL COMMENT ' 當事者類別',
  `case_is_drunk` text DEFAULT NULL COMMENT '飲酒情形',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='事故紀錄_當事人順位';

-- --------------------------------------------------------

--
-- 資料表結構 `ta_log_upload_cache`
--

CREATE TABLE `ta_log_upload_cache` (
  `id` int(11) NOT NULL,
  `serial_number` text NOT NULL COMMENT '案件編號',
  `case_date` date NOT NULL COMMENT '發生日期',
  `case_time` time NOT NULL COMMENT '發生時間',
  `longitude` text DEFAULT NULL COMMENT ' GPS經度',
  `latitude` text DEFAULT NULL COMMENT ' GPS緯度',
  `accident_category` text DEFAULT NULL COMMENT ' 事故類別',
  `case_county` text DEFAULT NULL COMMENT ' 縣市',
  `case_township` text DEFAULT NULL COMMENT ' 市區鄉鎮',
  `case_village` text DEFAULT NULL COMMENT '村里',
  `case_neighborhood` text DEFAULT NULL COMMENT ' 鄰',
  `case_road` text DEFAULT NULL COMMENT '路街',
  `case_section` text DEFAULT NULL COMMENT '段',
  `case_lane` text DEFAULT NULL COMMENT '巷',
  `case_number` text DEFAULT NULL COMMENT '號',
  `case_intersection_road` text DEFAULT NULL COMMENT '路口_路街口',
  `case_intersection_lane` text DEFAULT NULL COMMENT '路口_巷',
  `case_other` text DEFAULT NULL COMMENT '其他',
  `case_highway_category` text DEFAULT NULL COMMENT '公路道路類別',
  `case_highway_name` text DEFAULT NULL COMMENT '公路名稱',
  `case_highway_kilometers` text DEFAULT NULL COMMENT '公路公里數',
  `case_highway_meter` text DEFAULT NULL COMMENT '公路公尺數',
  `case_jurisdiction` text DEFAULT NULL COMMENT ' 管轄單位',
  `case_handle_team` text DEFAULT NULL COMMENT ' 處理單位',
  `case_24h_death` text DEFAULT NULL COMMENT ' 24小時內死亡',
  `case_30d_death` text DEFAULT NULL COMMENT '30日內死亡',
  `case_injuries` text DEFAULT NULL COMMENT '受傷 人數',
  `case_accident_type_parent` text DEFAULT NULL COMMENT '事故類型父類別',
  `case_accident_type_child` text DEFAULT NULL COMMENT '事故類型子類別',
  `case_cause` text DEFAULT NULL COMMENT '肇因',
  `case_rank` text DEFAULT NULL COMMENT '當事者順位',
  `case_rank_age` text DEFAULT NULL COMMENT '當事者年齡',
  `case_car_type` text DEFAULT NULL COMMENT ' 當事者類別',
  `case_is_drunk` text DEFAULT NULL COMMENT '飲酒情形'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='事故紀錄_上傳處理暫存用';

-- --------------------------------------------------------

--
-- 資料表結構 `ta_patrol`
--

CREATE TABLE `ta_patrol` (
  `id` int(11) NOT NULL,
  `set_date` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日期',
  `work_time` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '時段',
  `communication` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '代號',
  `police_total` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '警力',
  `patrol_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '任務目標',
  `method` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方式',
  `longitude` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '經度',
  `latitude` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '緯度',
  `team_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '單位',
  `police_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '帶班',
  `work_memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '備考',
  `unit_uploader` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '單位上傳人',
  `center_uploader` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '中心上傳人',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ta_log`
--
ALTER TABLE `ta_log`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `ta_log_rank`
--
ALTER TABLE `ta_log_rank`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `ta_log_upload_cache`
--
ALTER TABLE `ta_log_upload_cache`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `ta_patrol`
--
ALTER TABLE `ta_patrol`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ta_log`
--
ALTER TABLE `ta_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ta_log_rank`
--
ALTER TABLE `ta_log_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ta_log_upload_cache`
--
ALTER TABLE `ta_log_upload_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ta_patrol`
--
ALTER TABLE `ta_patrol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
