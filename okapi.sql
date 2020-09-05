-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 05, 2020 at 02:03 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `okapi`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getDistance` (`lat1` VARCHAR(200), `lng1` VARCHAR(200), `lat2` VARCHAR(200), `lng2` VARCHAR(200)) RETURNS VARCHAR(10) CHARSET utf8 begin
declare distance varchar(10);

set distance = (select (6371 * acos( 
                cos( radians(lat2) ) 
              * cos( radians( lat1 ) ) 
              * cos( radians( lng1 ) - radians(lng2) ) 
              + sin( radians(lat2) ) 
              * sin( radians( lat1 ) )
                ) ) as distance); 

if(distance is null)
then
 return '';
else 
return distance;
end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `user_id`, `name`, `email`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(87, 55, 'Electronic Department', 'shivamyadav8959@gmail.com', '8959070299', '2020-09-04 10:21:43', '2020-09-04 10:21:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `type` enum('tendor','request','quotation','order','register') NOT NULL,
  `meta_data` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `sender_id`, `type`, `meta_data`, `created_at`, `updated_at`, `deleted_at`) VALUES
(86, 'New supplier', 'A new supplier registered', 54, 'register', 'a:2:{s:7:\"user_id\";i:54;s:9:\"user_type\";s:1:\"3\";}', '2020-09-04 15:37:32', NULL, NULL),
(87, 'New Vendor & supplier', 'A new Vendor & supplier registered', 54, 'register', 'a:2:{s:7:\"user_id\";i:54;s:9:\"user_type\";s:1:\"3\";}', '2020-09-04 15:37:32', NULL, NULL),
(88, 'New vendor', 'A new vendor registered', 55, 'register', 'a:2:{s:7:\"user_id\";i:55;s:9:\"user_type\";s:1:\"2\";}', '2020-09-04 15:50:22', NULL, NULL),
(89, 'New Vendor & supplier', 'A new Vendor & supplier registered', 55, 'register', 'a:2:{s:7:\"user_id\";i:55;s:9:\"user_type\";s:1:\"2\";}', '2020-09-04 15:50:22', NULL, NULL),
(90, 'New supplier', 'A new supplier registered', 56, 'register', 'a:2:{s:7:\"user_id\";i:56;s:9:\"user_type\";s:1:\"3\";}', '2020-09-04 15:52:54', NULL, NULL),
(91, 'New Vendor & supplier', 'A new Vendor & supplier registered', 56, 'register', 'a:2:{s:7:\"user_id\";i:56;s:9:\"user_type\";s:1:\"3\";}', '2020-09-04 15:52:54', NULL, NULL),
(92, 'You have a request', 'You have a request from  North Wood', 56, 'request', 'a:3:{s:7:\"user_id\";i:56;s:10:\"request_id\";i:2;s:4:\"type\";s:12:\"sent_requset\";}', '2020-09-04 16:09:44', NULL, NULL),
(93, 'Request accepted', 'You request has accepted by Action Group', 55, 'request', 'a:3:{s:7:\"user_id\";i:55;s:10:\"request_id\";i:2;s:4:\"type\";s:15:\"accepet_request\";}', '2020-09-04 16:12:49', NULL, NULL),
(94, 'You have a new tendor', 'You have a new tendor by Action Group', 55, 'tendor', 'a:1:{s:9:\"tendor_id\";i:49;}', '2020-09-04 16:17:23', NULL, NULL),
(95, 'You have a new tendor', 'You have a new tendor by Action Group', 55, 'tendor', 'a:1:{s:9:\"tendor_id\";i:50;}', '2020-09-04 16:17:58', NULL, NULL),
(96, 'You have a new tendor', 'You have a new tendor by Action Group', 55, 'tendor', 'a:1:{s:9:\"tendor_id\";i:51;}', '2020-09-04 16:18:41', NULL, NULL),
(97, 'You have a new submission tendor request', 'You have a new submission tendor request by North Wood', 56, 'quotation', 'a:2:{s:9:\"tendor_id\";s:2:\"49\";s:12:\"quotation_id\";i:24;}', '2020-09-04 16:33:05', NULL, NULL),
(98, 'Quotation is accepted', 'Quotation accepted by Action Group', 55, 'order', 'a:1:{s:8:\"order_id\";i:19;}', '2020-09-04 16:34:37', NULL, NULL),
(99, 'Order cancel', 'Your order is cancel by North Wood', 56, 'order', 'a:1:{s:8:\"order_id\";s:2:\"19\";}', '2020-09-04 16:45:54', NULL, NULL),
(100, 'Order cancel', 'Your order is cancel by Action Group', 55, 'order', 'a:1:{s:8:\"order_id\";s:2:\"19\";}', '2020-09-04 16:50:24', NULL, NULL),
(101, 'Order dispatch', 'Your order is dispatch by North Wood', 56, 'order', 'a:1:{s:8:\"order_id\";s:2:\"19\";}', '2020-09-04 17:00:21', NULL, NULL),
(102, 'Order dispatch', 'Your order is dispatch by North Wood', 56, 'order', 'a:1:{s:8:\"order_id\";s:2:\"19\";}', '2020-09-04 17:20:34', NULL, NULL),
(103, 'Order Received', 'Your order is received by Action Group', 55, 'order', 'a:1:{s:8:\"order_id\";s:2:\"19\";}', '2020-09-04 17:20:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_receivers`
--

CREATE TABLE `notification_receivers` (
  `id` int(11) UNSIGNED NOT NULL,
  `notification_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `is_read` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_receivers`
--

INSERT INTO `notification_receivers` (`id`, `notification_id`, `receiver_id`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(73, 87, 1, '0', '2020-09-04 15:37:32', NULL, NULL),
(74, 89, 1, '0', '2020-09-04 15:50:22', NULL, NULL),
(75, 91, 1, '0', '2020-09-04 15:52:54', NULL, NULL),
(83, 99, 55, '0', '2020-09-04 16:45:54', NULL, NULL),
(85, 101, 55, '0', '2020-09-04 17:00:21', NULL, NULL),
(86, 102, 55, '0', '2020-09-04 17:20:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `tendor_id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `vendor_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `currency` varchar(100) NOT NULL,
  `tendor_date` date NOT NULL,
  `close_day` tinyint(4) NOT NULL,
  `lead_day` tinyint(4) NOT NULL,
  `tax_title` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL COMMENT '0 Pending , 1 Processing, 2 Dispatch , 3 delivered , 4 Cancel ,5 Received',
  `cancel_user_id` int(11) UNSIGNED DEFAULT NULL,
  `cancel_reason` text,
  `processing_date` datetime DEFAULT NULL,
  `dispatch_date` datetime DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `received_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tendor_id`, `quotation_id`, `vendor_id`, `supplier_id`, `currency`, `tendor_date`, `close_day`, `lead_day`, `tax_title`, `tax`, `status`, `cancel_user_id`, `cancel_reason`, `processing_date`, `dispatch_date`, `delivered_date`, `cancel_date`, `received_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 49, 24, 55, 56, 'INR', '2020-09-04', 5, 5, 'SGST', '9', '5', 55, 'dfadsfsaf', NULL, '2020-09-04 11:50:34', NULL, '2020-09-04 00:00:00', '2020-09-04 11:50:47', '2020-09-04 16:34:37', '2020-09-04 11:50:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `required_qty` int(11) NOT NULL,
  `supply_qty` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `title`, `description`, `required_qty`, `supply_qty`, `price`, `unit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(23, 19, 'Title 1', 'Lorem ipsum Lorem ipsum Lorem ipsum', 10, 10, '10.00', NULL, '2020-09-04 16:34:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `currency` varchar(255) DEFAULT 'USD',
  `price` float(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_requests`
--

CREATE TABLE `supplier_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `tax` float(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `user_id`, `title`, `tax`, `created_at`, `updated_at`, `deleted_at`) VALUES
(39, 56, 'SGST', 9.00, '2020-09-04 16:02:46', NULL, NULL),
(40, 56, 'CGST', 18.00, '2020-09-04 16:02:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tendors`
--

CREATE TABLE `tendors` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `currency` varchar(250) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tendors`
--

INSERT INTO `tendors` (`id`, `user_id`, `currency`, `day`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(46, 51, 'USD', 5, '1', '2020-09-04 13:39:20', NULL, NULL),
(47, 51, 'USD', 10, '0', '2020-09-04 13:44:12', NULL, NULL),
(48, 51, 'USD', 5, '1', '2020-09-04 13:55:22', NULL, NULL),
(49, 55, 'INR', 5, '1', '2020-09-04 16:17:23', NULL, NULL),
(50, 55, 'USD', 7, '0', '2020-09-04 16:17:58', NULL, NULL),
(51, 55, 'EUR', 10, '0', '2020-09-04 16:18:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tendor_products`
--

CREATE TABLE `tendor_products` (
  `id` int(11) UNSIGNED NOT NULL,
  `tendor_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tendor_products`
--

INSERT INTO `tendor_products` (`id`, `tendor_id`, `title`, `qty`, `unit`, `description`, `created_at`, `deleted_at`, `updated_at`) VALUES
(35, 49, 'Title 1', 10, 'Kg', 'Lorem ipsum Lorem ipsum Lorem ipsum', '2020-09-04 16:17:23', NULL, NULL),
(36, 50, 'Title 2', 20, 'liter', 'Lorem ipsum Lorem ipsum Lorem ipsum', '2020-09-04 16:17:58', NULL, NULL),
(37, 51, 'Title 3', 10, 'MM', 'Lorem ipsum Lorem ipsum Lorem ipsum', '2020-09-04 16:18:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tendor_quotations`
--

CREATE TABLE `tendor_quotations` (
  `id` int(11) UNSIGNED NOT NULL,
  `tendor_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `status` enum('0','1','2','3') DEFAULT '0',
  `lead_day` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `cancel_user_id` int(11) DEFAULT NULL,
  `cancel_reason` text,
  `cancel_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tendor_quotations`
--

INSERT INTO `tendor_quotations` (`id`, `tendor_id`, `supplier_id`, `status`, `lead_day`, `tax_id`, `cancel_user_id`, `cancel_reason`, `cancel_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 49, 56, '1', 5, 39, NULL, NULL, NULL, '2020-09-04 16:33:05', '2020-09-04 11:04:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tendor_quotation_products`
--

CREATE TABLE `tendor_quotation_products` (
  `id` int(11) UNSIGNED NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `tendor_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float(8,2) NOT NULL,
  `unit` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tendor_quotation_products`
--

INSERT INTO `tendor_quotation_products` (`id`, `quotation_id`, `tendor_id`, `product_id`, `supplier_id`, `qty`, `price`, `unit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(30, 24, 49, 35, 56, 10, 10.00, 'Kg', '2020-09-04 16:33:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tendor_suppliers`
--

CREATE TABLE `tendor_suppliers` (
  `id` int(11) UNSIGNED NOT NULL,
  `tendor_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tendor_suppliers`
--

INSERT INTO `tendor_suppliers` (`id`, `tendor_id`, `supplier_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(62, 49, 56, '2020-09-04 16:17:23', NULL, NULL),
(63, 50, 56, '2020-09-04 16:17:58', NULL, NULL),
(64, 51, 56, '2020-09-04 16:18:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `longitude` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_verified` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `phone`, `password`, `profile_image`, `remember_token`, `title`, `business_name`, `address`, `latitude`, `longitude`, `country`, `state`, `city`, `status`, `is_verified`, `created_at`, `updated_at`, `deleted_at`) VALUES
(55, '2', 'Okapi vendor', 'vendor@gmail.com', '8959070299', '$2y$10$ZM/pb0wziaVvhvYY2jsNqeuUJZ0HQ2RRUkFLdSXS/8SmDRd4DaII2', 'lQSnQhgMJk.1599214897.png', NULL, 'Manager', 'Action Group', '505 Pukhraj Corparator indore near naulakha indore', '22.684977', '75.8186789', 'India', 'Madhaya Pradesh', 'Indore', '1', '0', '2020-09-04 04:50:22', '2020-09-04 04:51:37', NULL),
(56, '3', 'Okapi Supplier', 'supplier@gmail.com', '7974682508', '$2y$10$1D40WlUn/D9AZ8M6hWfrFuN1hdPoq/9MT.52B.tErjpFcfSPQ/1Nq', 'PbXwZmhMtY.1599215471.png', NULL, 'Manager', 'North Wood', 'G- 248 kalandi Gold Near Arbindo', '22.684977', '75.8186789', 'India', 'Madhya Pradesh', 'Indore', '1', '0', '2020-09-04 04:52:54', '2020-09-04 05:01:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_currencies`
--

CREATE TABLE `user_currencies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_currencies`
--

INSERT INTO `user_currencies` (`id`, `user_id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 55, 'INR', '2020-09-04 10:21:49', '2020-09-04 10:21:49', NULL),
(23, 55, 'USD', '2020-09-04 10:21:54', '2020-09-04 10:21:54', NULL),
(24, 55, 'EUR', '2020-09-04 10:22:01', '2020-09-04 10:22:01', NULL),
(25, 56, 'INR', '2020-09-04 10:33:01', '2020-09-04 10:33:01', NULL),
(26, 56, 'USD', '2020-09-04 10:33:05', '2020-09-04 10:33:05', NULL),
(27, 56, 'ERO', '2020-09-04 10:33:10', '2020-09-04 10:33:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `document` varchar(255) NOT NULL,
  `is_varified` enum('0','1','2') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `title`, `document`, `is_varified`, `created_at`, `updated_at`, `deleted_at`) VALUES
(28, 56, 'Adhar Card', 'tVqfGs9XF7.1599215546.jpeg', '0', '2020-09-04 16:02:26', NULL, NULL),
(29, 56, 'PAN CARD', 'HTZWcP1kNM.1599215546.jpeg', '0', '2020-09-04 16:02:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_suppliers`
--

CREATE TABLE `vendor_suppliers` (
  `id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor_suppliers`
--

INSERT INTO `vendor_suppliers` (`id`, `vendor_id`, `supplier_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(41, 55, 56, '2020-09-04 10:42:49', '2020-09-04 10:42:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_receivers`
--
ALTER TABLE `notification_receivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_requests`
--
ALTER TABLE `supplier_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tendors`
--
ALTER TABLE `tendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tendor_products`
--
ALTER TABLE `tendor_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tendor_quotations`
--
ALTER TABLE `tendor_quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tendor_quotation_products`
--
ALTER TABLE `tendor_quotation_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tendor_suppliers`
--
ALTER TABLE `tendor_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_currencies`
--
ALTER TABLE `user_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_suppliers`
--
ALTER TABLE `vendor_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `notification_receivers`
--
ALTER TABLE `notification_receivers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier_requests`
--
ALTER TABLE `supplier_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tendors`
--
ALTER TABLE `tendors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `tendor_products`
--
ALTER TABLE `tendor_products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tendor_quotations`
--
ALTER TABLE `tendor_quotations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tendor_quotation_products`
--
ALTER TABLE `tendor_quotation_products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `tendor_suppliers`
--
ALTER TABLE `tendor_suppliers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `user_currencies`
--
ALTER TABLE `user_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `vendor_suppliers`
--
ALTER TABLE `vendor_suppliers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
