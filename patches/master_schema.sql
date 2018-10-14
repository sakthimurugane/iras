-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 01:06 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'pointofsale', 'invoice_details', '{\"sorted_col\":\"`invoice_details`.`invoice_id`  DESC\"}', '2018-10-14 10:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2018-10-14 11:05:38', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `pointofsale`
--
CREATE DATABASE IF NOT EXISTS `pointofsale` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pointofsale`;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_mail` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_phone`, `customer_mail`, `customer_address`, `remarks`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'gopal', '971234560', 'gopalkt@gmail.com', 'Pondyyy', 'Premium', 1, '2018-09-08 15:56:29', '1', '2018-09-09 10:55:09', '1'),
(2, 'sakthuh', '848975859', 'sasdfsda@dsfa.com', 'Cuddalore', '243534', 0, '2018-09-08 16:00:35', '1', '2018-09-08 16:00:49', '1'),
(3, 'Raja', '8489775859', 'asa@sdes.com', '', '', 0, '2018-09-18 08:32:32', '1', NULL, NULL),
(4, NULL, '9847987983', NULL, NULL, NULL, 0, '2018-09-22 19:06:55', '1', NULL, NULL),
(5, NULL, '84', NULL, NULL, NULL, 0, '2018-09-22 19:19:23', '1', NULL, NULL),
(6, NULL, '9876543210', NULL, NULL, NULL, 0, '2018-09-23 12:50:28', '1', NULL, NULL),
(7, 'General Account', 'General', 'NA', 'NA', 'Anonymous shopping account', 0, '2018-09-23 13:08:30', '1', '2018-10-14 16:15:09', '1'),
(8, NULL, '123444', NULL, NULL, NULL, 0, '2018-09-25 07:49:39', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home`
--

CREATE TABLE `home` (
  `home_id` int(11) NOT NULL,
  `home_name` varchar(255) DEFAULT NULL,
  `home_legal_name` varchar(255) DEFAULT NULL,
  `home_gstin` varchar(255) DEFAULT NULL,
  `home_propertier` varchar(255) DEFAULT NULL,
  `home_mobile` varchar(255) DEFAULT NULL,
  `home_landline` varchar(255) DEFAULT NULL,
  `is_tax` int(11) NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `home_state` varchar(255) DEFAULT NULL,
  `home_pincode` varchar(255) DEFAULT NULL,
  `home_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home`
--

INSERT INTO `home` (`home_id`, `home_name`, `home_legal_name`, `home_gstin`, `home_propertier`, `home_mobile`, `home_landline`, `is_tax`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`, `home_address`, `address_1`, `address_2`, `home_state`, `home_pincode`, `home_email`) VALUES
(88859999, 'Balu Enterprises', 'Paint Shop', '34AYDPG4278R1ZV', 'Gopal B', '9876543210', '0413 40108888', 1, 0, NULL, NULL, '2018-09-29 19:05:37', 'SYSTEM', 'www.baluentrp.com', '100 FT Road, VASAVI School', 'Muthialpet', 'Puducherry', '607001', 'abcd@baluentrp.com');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `invoice_id` int(11) NOT NULL,
  `ordernum` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `billed_amount` float NOT NULL DEFAULT '0',
  `cash_paid` float NOT NULL DEFAULT '0',
  `advance_amount` float NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `is_taxed` int(11) NOT NULL DEFAULT '0',
  `bill_date` date DEFAULT NULL,
  `bill_profit` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`invoice_id`, `ordernum`, `customer_id`, `payment_type`, `payment_status`, `due_date`, `billed_amount`, `cash_paid`, `advance_amount`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`, `is_taxed`, `bill_date`, `bill_profit`) VALUES
(14, '09201809231736', 2, 'credit', 'S', '2018-10-03', 90, 0, 0, 1, '2018-09-23 12:47:55', '1', '2018-09-24 08:37:02', '1', 1, '2018-09-23', 50),
(15, '09201809231943', 6, 'cash', 'C', NULL, 17, 20, 0, 1, '2018-09-23 12:50:28', '1', '2018-09-24 08:38:39', '1', 0, '2018-09-23', 10),
(16, '09201809233728', 7, 'cash', 'C', NULL, 1000, 1400, 0, 0, '2018-09-23 13:08:30', '1', NULL, NULL, 0, '2018-09-23', 60),
(17, '09201804251922', 8, 'credit', 'C', NULL, 605, 0, 611, 0, '2018-09-25 07:49:39', '1', '2018-09-26 08:29:58', '1', 1, '2018-09-25', 90),
(18, '09201818254645', 7, 'cash', 'C', NULL, 18.36, 100, 0, 0, '2018-09-25 22:17:11', '1', NULL, NULL, 1, '2018-09-25', 10),
(19, '09201816291450', 7, 'cash', 'C', NULL, 604.8, 700, 0, 0, '2018-09-29 19:45:20', '1', NULL, NULL, 1, '2018-09-29', 90),
(20, '10201812132706', 7, 'cash', 'C', NULL, 17.28, 600, 0, 0, '2018-10-13 15:58:13', '1', NULL, NULL, 1, '2018-10-13', 9),
(21, '10201812142546', 7, 'credit', 'C', '2018-10-24', 577, 0, 652, 0, '2018-10-14 15:56:08', '1', NULL, NULL, 0, '2018-10-14', 100),
(22, '10201812143245', 7, 'credit', 'C', '2018-10-24', 623.16, 0, 650, 0, '2018-10-14 16:03:04', '1', NULL, NULL, 1, '2018-10-14', 100),
(23, '10201812144132', 7, 'credit', 'C', '2018-10-24', 18.36, 0, 300, 0, '2018-10-14 16:12:03', '1', NULL, NULL, 1, '2018-10-14', 10),
(24, '10201812144524', 7, 'cash', 'C', NULL, 18.36, 233, 0, 0, '2018-10-14 16:18:35', '1', NULL, NULL, 1, '2018-10-14', 10),
(25, '10201812144844', 7, 'cash', 'C', NULL, 604.8, 324, 0, 1, '2018-10-14 16:18:54', '1', '2018-10-14 16:20:11', '1', 1, '2018-10-14', 90);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `is_locked` int(11) NOT NULL DEFAULT '0',
  `person_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `person_name`, `username`, `password`, `created_on`, `created_by`, `modified_on`, `modified_by`, `is_deleted`, `is_locked`, `person_role`) VALUES
(1, 'sakthi', 's', 's', '2018-08-30 12:02:25', 'SYSTEM', NULL, NULL, 0, 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `hsnsac` varchar(255) DEFAULT NULL,
  `o_price` varchar(255) DEFAULT NULL,
  `s_price` varchar(255) DEFAULT NULL,
  `profit` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `arrival_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `alert_qty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `hsnsac`, `o_price`, `s_price`, `profit`, `quantity`, `is_deleted`, `arrival_date`, `expiry_date`, `created_on`, `created_by`, `modified_on`, `modified_by`, `supplier_id`, `alert_qty`) VALUES
(2, 'NP5K', 'Nerolac Paint 5 Kg', '96873', '470', '560', '90', 394, 0, '2018-09-09', '2021-11-26', '2018-09-09 10:59:25', '1', '2018-10-14 16:20:11', '1', 3, 0),
(3, 'PB5IN', 'Paint Brush 5 inch', '98409', '7', '17', '10', 1990, 0, '2018-09-15', '2021-09-30', '2018-09-15 20:21:49', '1', '2018-10-14 16:18:35', '1', 0, 1998);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `sale_id` int(11) NOT NULL,
  `ordernum` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `item_hsn` varchar(255) DEFAULT NULL,
  `bill_price` float NOT NULL DEFAULT '0',
  `bill_qty` int(11) NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `bill_amount` float NOT NULL DEFAULT '0',
  `item_profit` float NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'UNBILLED'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`sale_id`, `ordernum`, `product_id`, `item_name`, `item_code`, `item_hsn`, `bill_price`, `bill_qty`, `is_deleted`, `bill_amount`, `item_profit`, `created_on`, `created_by`, `modified_on`, `modified_by`, `status`) VALUES
(97, '09201809231736', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 5, 1, 85, 50, '2018-09-23 12:47:42', '1', '2018-09-24 08:37:02', '1', 'CANCELLED'),
(98, '09201809231943', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 1, 17, 10, '2018-09-23 12:49:51', '1', '2018-09-24 08:38:40', '1', 'CANCELLED'),
(99, '09201809232228', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 15, 3, 0, 45, 24, '2018-09-23 12:52:50', '1', NULL, NULL, 'UNBILLED'),
(100, '09201809233728', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 500, 2, 0, 1000, 60, '2018-09-23 13:07:38', '1', '2018-09-23 13:08:30', '1', 'BILLED'),
(101, '09201818244552', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-09-24 22:16:04', '1', NULL, NULL, 'UNBILLED'),
(102, '09201818244552', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-09-24 22:17:52', '1', NULL, NULL, 'UNBILLED'),
(103, '09201804251922', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-09-25 07:49:27', '1', '2018-09-25 07:49:39', '1', 'BILLED'),
(104, '09201817255133', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-09-25 21:21:37', '1', NULL, NULL, 'UNBILLED'),
(105, '09201818254645', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-09-25 22:16:50', '1', '2018-09-25 22:17:11', '1', 'BILLED'),
(106, '09201805260430', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-09-26 08:34:34', '1', NULL, NULL, 'UNBILLED'),
(107, '09201816291450', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-09-29 19:44:55', '1', '2018-09-29 19:45:20', '1', 'BILLED'),
(108, '10201812132706', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 16, 1, 0, 16, 9, '2018-10-13 15:57:15', '1', '2018-10-13 15:58:13', '1', 'BILLED'),
(109, '10201812142546', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-10-14 15:55:52', '1', '2018-10-14 15:56:08', '1', 'BILLED'),
(110, '10201812142546', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-10-14 15:55:56', '1', '2018-10-14 15:56:08', '1', 'BILLED'),
(111, '10201812143245', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 0, 560, 90, '2018-10-14 16:02:47', '1', '2018-10-14 16:03:04', '1', 'BILLED'),
(112, '10201812143245', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-10-14 16:02:52', '1', '2018-10-14 16:03:04', '1', 'BILLED'),
(113, '10201812144132', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-10-14 16:11:34', '1', '2018-10-14 16:12:03', '1', 'BILLED'),
(114, '10201812144524', 3, 'Paint Brush 5 inch', 'PB5IN', '98409', 17, 1, 0, 17, 10, '2018-10-14 16:15:26', '1', '2018-10-14 16:18:35', '1', 'BILLED'),
(115, '10201812144844', 2, 'Nerolac Paint 5 Kg', 'NP5K', '96873', 560, 1, 1, 560, 90, '2018-10-14 16:18:46', '1', '2018-10-14 16:20:11', '1', 'CANCELLED');

-- --------------------------------------------------------

--
-- Table structure for table `sales_tax`
--

CREATE TABLE `sales_tax` (
  `sales_tax_id` int(11) NOT NULL,
  `ordernum` varchar(255) DEFAULT NULL,
  `slab_id` int(11) DEFAULT NULL,
  `tax_amount` float DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_tax`
--

INSERT INTO `sales_tax` (`sales_tax_id`, `ordernum`, `slab_id`, `tax_amount`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(13, '09201809231736', NULL, 5, 1, '2018-09-23 12:47:55', '1', '2018-09-24 08:37:02', '1'),
(14, '09201804251922', NULL, 45, 0, '2018-09-25 07:49:38', '1', NULL, NULL),
(15, '09201818254645', NULL, 1.36, 0, '2018-09-25 22:17:11', '1', NULL, NULL),
(16, '09201816291450', NULL, 44.8, 0, '2018-09-29 19:45:20', '1', NULL, NULL),
(17, '10201812132706', NULL, 1.28, 0, '2018-10-13 15:58:13', '1', NULL, NULL),
(18, '10201812143245', NULL, 46.16, 0, '2018-10-14 16:03:04', '1', NULL, NULL),
(19, '10201812144132', NULL, 1.36, 0, '2018-10-14 16:12:03', '1', NULL, NULL),
(20, '10201812144524', NULL, 1.36, 0, '2018-10-14 16:15:36', '1', NULL, NULL),
(21, '10201812144524', NULL, 1.36, 0, '2018-10-14 16:18:35', '1', NULL, NULL),
(22, '10201812144844', NULL, 44.8, 1, '2018-10-14 16:18:54', '1', '2018-10-14 16:20:11', '1');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_phone` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `item_desc` varchar(255) DEFAULT NULL,
  `supplier_mail` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_phone`, `supplier_name`, `supplier_address`, `contact_person`, `item_desc`, `supplier_mail`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'asdasd', 'asdasd', 'sdasdsdaasd', 'dasdasasdasd', 'asdasdaasd', 'a', 1, '2018-09-08 12:29:16', '1', '2018-09-08 12:46:25', '1'),
(2, '989384089230480', 'newonw', 'sdkflasdfj', 'lksdjfgljelkfjklj', 'lkfgkewlkfdjg', 'asdcasdf@asfdwasdf.com', 1, '2018-09-08 12:32:49', '1', '2018-09-08 12:45:25', '1'),
(3, '98765432', 'Nerolac', 'Pondy', 'Sakthi', 'Paint,\r\nBrush', 'sakthi@nerolac.com', 0, '2018-09-08 12:47:32', '1', '2018-09-08 14:52:31', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tax_slab`
--

CREATE TABLE `tax_slab` (
  `slab_id` int(11) NOT NULL,
  `slab_name` varchar(255) DEFAULT NULL,
  `slab_desc` varchar(255) DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `tax_value` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'ACTIVE',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax_slab`
--

INSERT INTO `tax_slab` (`slab_id`, `slab_name`, `slab_desc`, `tax_type`, `tax_value`, `status`, `is_deleted`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'GST', 'GST 6% value', 'Percentage', 8, 'ACTIVE', 0, '2018-09-22 02:14:30', 'SYSTEM', '2018-09-23 12:52:27', '1'),
(2, 'VAT', 'Value Added Tax', 'Fixed', 100, 'INACTIVE', 1, '2018-09-23 11:57:55', '1', '2018-09-23 12:02:42', '1'),
(3, 'TAX', 'testing', 'Percentage', 100, 'INACTIVE', 1, '2018-09-23 12:02:29', '1', '2018-09-23 12:02:39', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sales_tax`
--
ALTER TABLE `sales_tax`
  ADD PRIMARY KEY (`sales_tax_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tax_slab`
--
ALTER TABLE `tax_slab`
  ADD PRIMARY KEY (`slab_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `home`
--
ALTER TABLE `home`
  MODIFY `home_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88860000;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `sales_tax`
--
ALTER TABLE `sales_tax`
  MODIFY `sales_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tax_slab`
--
ALTER TABLE `tax_slab`
  MODIFY `slab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
