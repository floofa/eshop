SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `order_delivery_methods`;
CREATE TABLE `order_delivery_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vat_rate_id` smallint(5) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `sys_name` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `price_with_vat` decimal(10,0) unsigned NOT NULL,
  `price_without_vat` decimal(10,2) NOT NULL,
  `description` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `cms_status` tinyint(3) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sys_name` (`sys_name`),
  KEY `vat_rate_id` (`vat_rate_id`),
  CONSTRAINT `order_delivery_methods_ibfk_1` FOREIGN KEY (`vat_rate_id`) REFERENCES `vat_rates` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `order_delivery_methods` (`id`, `vat_rate_id`, `name`, `sys_name`, `price_with_vat`, `price_without_vat`, `description`, `cms_status`, `sequence`) VALUES
(1,  1,  'Obchodní balík České pošty',  NULL,  110,  91.66,  'Zásilka bude odeslána přes společnost Česká pošta.',  1,  2),
(2,  1,  'Osobní odběr',  NULL,  0,  0.00,  'Zboží­ si vyzvednete u nás na skladě.',  1,  1);

DROP TABLE IF EXISTS `order_payment_methods`;
CREATE TABLE `order_payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vat_rate_id` smallint(5) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `sys_name` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `payment_type` enum('delivery','bank_transfer','cash') COLLATE utf8_czech_ci NOT NULL DEFAULT 'delivery',
  `price_with_vat` decimal(10,0) unsigned NOT NULL,
  `price_without_vat` decimal(10,2) NOT NULL,
  `description` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `cms_status` tinyint(3) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sys_name` (`sys_name`),
  KEY `vat_rate_id` (`vat_rate_id`),
  CONSTRAINT `order_payment_methods_ibfk_1` FOREIGN KEY (`vat_rate_id`) REFERENCES `vat_rates` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `order_payment_methods` (`id`, `vat_rate_id`, `name`, `sys_name`, `payment_type`, `price_with_vat`, `price_without_vat`, `description`, `cms_status`, `sequence`) VALUES
(1,  1,  'Dobírka',  NULL,  'delivery',  20,  16.67,  '',  1,  2),
(2,  1,  'Platba na účet',  NULL,  'bank_transfer',  0,  0.00,  '',  1,  3),
(3,  1,  'Hotově',  NULL,  'cash',  0,  0.00,  '',  1,  1);

DROP TABLE IF EXISTS `order_delivery_methods_order_payment_methods`;
CREATE TABLE `order_delivery_methods_order_payment_methods` (
  `order_payment_method_id` int(10) unsigned NOT NULL,
  `order_delivery_method_id` int(10) unsigned NOT NULL,
  KEY `order_delivery_method_id` (`order_delivery_method_id`),
  KEY `order_delivery_methods_order_payment_methods_ibfk_1` (`order_payment_method_id`),
  CONSTRAINT `order_delivery_methods_order_payment_methods_ibfk_1` FOREIGN KEY (`order_payment_method_id`) REFERENCES `order_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_delivery_methods_order_payment_methods_ibfk_2` FOREIGN KEY (`order_delivery_method_id`) REFERENCES `order_delivery_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `order_delivery_methods_order_payment_methods` (`order_payment_method_id`, `order_delivery_method_id`) VALUES
(1,  1),
(2,  1),
(3,  2);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `number` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `vs` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `state` tinyint(3) unsigned NOT NULL,
  `payment_state` tinyint(3) unsigned NOT NULL,
  `email` varchar(127) COLLATE utf8_czech_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `street` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `postcode` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `country` enum('CZ','SK') COLLATE utf8_czech_ci NOT NULL,
  `company` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `cin` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `tin` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `delivery_company` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `delivery_name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `delivery_surname` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `delivery_street` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `delivery_city` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `delivery_postcode` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `delivery_phone` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `delivery_country` enum('CZ','SK') COLLATE utf8_czech_ci NOT NULL,
  `user_comments` text COLLATE utf8_czech_ci NOT NULL,
  `delivery_method_name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `delivery_method_sys_name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `delivery_method_price_with_vat` decimal(10,0) NOT NULL,
  `delivery_method_price_without_vat` decimal(10,2) NOT NULL,
  `delivery_method_vat_rate` float(5,2) NOT NULL,
  `payment_method_name` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `payment_method_sys_name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `payment_method_type` enum('delivery','bank_account','cash') COLLATE utf8_czech_ci NOT NULL DEFAULT 'delivery',
  `payment_method_price_with_vat` decimal(10,0) NOT NULL,
  `payment_method_price_without_vat` decimal(10,2) NOT NULL,
  `payment_method_vat_rate` float(5,2) NOT NULL,
  `package_number` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `comments` text COLLATE utf8_czech_ci NOT NULL,
  `hash` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `type` enum('eshop','personal_selling') COLLATE utf8_czech_ci NOT NULL DEFAULT 'eshop',
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `code` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `price_without_vat` decimal(10,2) unsigned NOT NULL,
  `price_with_vat` decimal(10,2) NOT NULL,
  `vat_rate` tinyint(4) NOT NULL,
  `count` smallint(10) unsigned NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `rew_id` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `lvl` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `cms_status` tinyint(3) unsigned NOT NULL,
  `scope` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rew_id` (`rew_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `product_categories` (`id`, `name`, `rew_id`, `description`, `meta_keywords`, `lft`, `rgt`, `lvl`, `parent_id`, `meta_description`, `cms_status`, `scope`) VALUES
(1,  'ROOT',  NULL,  NULL,  '',  1,  4,  1,  NULL,  '',  0,  1),
(2,  'Prvni kategorie',  'prvni-kategorie',  'Popis',  '',  2,  3,  2,  1,  '',  1,  1);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` int(10) unsigned NOT NULL,
  `vat_rate_id` smallint(5) unsigned NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `rew_id` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `code` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `count_stock` int(10) NOT NULL,
  `price_without_vat` decimal(10,2) unsigned NOT NULL,
  `price_with_vat` decimal(10,0) unsigned NOT NULL,
  `price_final_without_vat` decimal(10,2) unsigned NOT NULL,
  `price_final_with_vat` decimal(10,0) unsigned NOT NULL,
  `discount` int(10) unsigned NOT NULL,
  `discount_perc` tinyint(3) unsigned NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `cms_status` tinyint(3) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `vat_rate_id` (`vat_rate_id`),
  KEY `product_category_id` (`product_category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vat_rate_id`) REFERENCES `vat_rates` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `product_news`;
CREATE TABLE `product_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `cms_status` tinyint(1) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `sequence` (`sequence`),
  CONSTRAINT `product_news_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `product_recomended`;
CREATE TABLE `product_recomended` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `cms_status` tinyint(1) unsigned NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `sequence` (`sequence`),
  CONSTRAINT `product_recomended_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `vat_rates`;
CREATE TABLE `vat_rates` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `value` float(10,2) NOT NULL,
  `coefficient_without_vat` float(4,4) NOT NULL,
  `coefficient_with_vat` float(4,2) NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `vat_rates` (`id`, `name`, `value`, `coefficient_without_vat`, `coefficient_with_vat`, `sequence`) VALUES
(1,  'Základní sazba',  20.00,  0.1667,  0.20,  2),
(2,  'Snížená sazba',  10.00,  0.0909,  0.10,  1);