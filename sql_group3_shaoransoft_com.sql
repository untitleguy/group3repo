-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2026 at 07:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_group3_shaoransoft_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `menu_code` varchar(20) NOT NULL,
  `stock_qty` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`menu_code`, `stock_qty`) VALUES
('MENU-001', 10),
('MENU-002', 10),
('MENU-003', 10),
('MENU-004', 10),
('MENU-005', 10),
('MENU-006', 10),
('MENU-007', 10),
('MENU-008', 10),
('MENU-009', 10),
('MENU-010', 10),
('MENU-011', 10),
('MENU-012', 10),
('MENU-013', 10),
('MENU-014', 10),
('MENU-015', 10),
('MENU-016', 10),
('MENU-017', 10),
('MENU-018', 10),
('MENU-019', 10),
('MENU-020', 10),
('MENU-021', 10),
('MENU-022', 10),
('MENU-023', 10),
('MENU-024', 10),
('MENU-025', 10),
('MENU-026', 10),
('MENU-027', 10),
('MENU-028', 10),
('MENU-029', 10),
('MENU-030', 10),
('MENU-031', 10),
('MENU-032', 10),
('MENU-033', 10),
('MENU-034', 10),
('MENU-035', 10),
('MENU-036', 10),
('MENU-037', 10),
('MENU-038', 10),
('MENU-039', 10),
('MENU-040', 10),
('MENU-041', 10),
('MENU-042', 10),
('MENU-043', 10),
('MENU-044', 10),
('MENU-045', 10),
('MENU-046', 10),
('MENU-047', 10),
('MENU-048', 10),
('MENU-049', 10),
('MENU-050', 10),
('MENU-051', 10),
('MENU-052', 10),
('MENU-053', 10),
('MENU-054', 10),
('MENU-055', 10),
('MENU-056', 10),
('MENU-057', 10),
('MENU-058', 10),
('MENU-059', 10),
('MENU-060', 10),
('MENU-061', 10),
('MENU-062', 10),
('MENU-063', 10),
('MENU-064', 10),
('MENU-065', 10),
('MENU-066', 10),
('รหัสเมนู', 10);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `menu_code` varchar(20) NOT NULL,
  `category` varchar(100) NOT NULL,
  `menu_name` varchar(150) NOT NULL,
  `style` varchar(50) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(30) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`menu_code`, `category`, `menu_name`, `style`, `price`, `unit`, `image_path`) VALUES
('MENU-001', 'กาแฟ', 'คาปูชิโน่', 'ร้อน', 50.00, 'แก้ว', 'กาแฟ/คาปูชิโน่ ร้อน.png'),
('MENU-002', 'กาแฟ', 'คาปูชิโน่', 'เย็น', 65.00, 'แก้ว', 'กาแฟ/คาปูชิโน่ เย็น.png'),
('MENU-003', 'กาแฟ', 'คาปูชิโน่', 'ปั่น', 70.00, 'แก้ว', 'กาแฟ/คาปูชิโน่ ปั่น.png'),
('MENU-004', 'กาแฟ', 'คาราเมลมัคคิอาโต้', 'เย็น', 85.00, 'แก้ว', 'กาแฟ/คาราเมลมัคคิอาโต้ เย็น.png'),
('MENU-005', 'กาแฟ', 'มอคค่า', 'ร้อน', 55.00, 'แก้ว', 'กาแฟ/มอคค่า ร้อน.png'),
('MENU-006', 'กาแฟ', 'มอคค่า', 'เย็น', 70.00, 'แก้ว', 'กาแฟ/มอคค่า เย็น.png'),
('MENU-007', 'กาแฟ', 'มอคค่า', 'ปั่น', 75.00, 'แก้ว', 'กาแฟ/มอคค่า ปั่น.png'),
('MENU-008', 'กาแฟ', 'ลาเต้', 'ร้อน', 55.00, 'แก้ว', 'กาแฟ/ลาเต้ ร้อน.png'),
('MENU-009', 'กาแฟ', 'ลาเต้', 'เย็น', 70.00, 'แก้ว', 'กาแฟ/ลาเต้ เย็น.png'),
('MENU-010', 'กาแฟ', 'ลาเต้', 'ปั่น', 75.00, 'แก้ว', 'กาแฟ/ลาเต้ ปั่น.png'),
('MENU-011', 'กาแฟ', 'อเมริกาโน่', 'ร้อน', 40.00, 'แก้ว', 'กาแฟ/อเมริกาโน่ ร้อน.png'),
('MENU-012', 'กาแฟ', 'อเมริกาโน่', 'เย็น', 60.00, 'แก้ว', 'กาแฟ/อเมริกาโน่ เย็น.png'),
('MENU-013', 'กาแฟ', 'อเมริกาโน่โคโค่นัท', 'เย็น', 70.00, 'แก้ว', 'กาแฟ/อเมริกาโน่โคโค่นัท เย็น.png'),
('MENU-014', 'กาแฟ', 'อเมริกาโน่ส้ม', 'เย็น', 65.00, 'แก้ว', 'กาแฟ/อเมริกาโน่ส้ม เย็น.png'),
('MENU-015', 'กาแฟ', 'เอสเพรสโซ', 'ร้อน', 40.00, 'แก้ว', 'กาแฟ/เอสเพรสโซ ร้อน.png'),
('MENU-016', 'กาแฟ', 'เอสเพรสโซ', 'เย็น', 60.00, 'แก้ว', 'กาแฟ/เอสเพรสโซ เย็น.png'),
('MENU-017', 'กาแฟ', 'เอสเพรสโซ', 'ปั่น', 65.00, 'แก้ว', 'กาแฟ/เอสเพรสโซ ปั่น.png'),
('MENU-018', 'ชาไทย', 'ชาไทย', 'ร้อน', 45.00, 'แก้ว', 'ชาไทย/ชาไทย ร้อน.png'),
('MENU-019', 'ชาไทย', 'ชาไทย', 'เย็น', 50.00, 'แก้ว', 'ชาไทย/ชาไทย เย็น.png'),
('MENU-020', 'ชาไทย', 'ชาไทย', 'ปั่น', 55.00, 'แก้ว', 'ชาไทย/ชาไทย ปั่น.png'),
('MENU-021', 'ชาไทย', 'ชาไทยกาแฟ', 'เย็น', 65.00, 'แก้ว', 'ชาไทย/ชาไทยกาแฟ เย็น.png'),
('MENU-022', 'ชาไทย', 'ชาไทยกาแฟ', 'ปั่น', 70.00, 'แก้ว', 'ชาไทย/ชาไทยกาแฟ ปั่น.png'),
('MENU-023', 'ชาไทย', 'ชาไทยช็อกโกแลต', 'เย็น', 65.00, 'แก้ว', 'ชาไทย/ชาไทยช็อกโกแลต เย็น.png'),
('MENU-024', 'ชาไทย', 'ชาไทยช็อกโกแลต', 'ปั่น', 70.00, 'แก้ว', 'ชาไทย/ชาไทยช็อกโกแลต ปั่น.png'),
('MENU-025', 'มัทฉะ-ชา', 'ชามะนาว', 'เย็น', 50.00, 'แก้ว', 'มัทฉะ-ชา/ชามะนาว เย็น.png'),
('MENU-026', 'มัทฉะ-ชา', 'มัทฉะถั่วแดง', 'ปั่น', 70.00, 'แก้ว', 'มัทฉะ-ชา/มัทฉะถั่วแดง ปั่น.png'),
('MENU-027', 'มัทฉะ-ชา', 'มัทฉะลาเต้', 'เย็น', 60.00, 'แก้ว', 'มัทฉะ-ชา/มัทฉะลาเต้ เย็น.png'),
('MENU-028', 'มัทฉะ-ชา', 'มัทฉะลาเต้', 'ปั่น', 65.00, 'แก้ว', 'มัทฉะ-ชา/มัทฉะลาเต้ ปั่น.png'),
('MENU-029', 'มัทฉะ-ชา', 'มัทฉะสตอเบอร์รี่', 'เย็น', 70.00, 'แก้ว', 'มัทฉะ-ชา/มัทฉะสตอเบอร์รี่ เย็น.png'),
('MENU-030', 'มัทฉะ-ชา', 'มัทฉะส้ม', 'เย็น', 70.00, 'แก้ว', 'มัทฉะ-ชา/มัทฉะส้ม เย็น.png'),
('MENU-031', 'มัทฉะ-ชา', 'ไลท์มัทฉะ', 'เย็น', 60.00, 'แก้ว', 'มัทฉะ-ชา/ไลท์มัทฉะ เย็น.png'),
('MENU-032', 'ช็อกโกแลต', 'ช็อกโกแลต', 'ร้อน', 45.00, 'แก้ว', 'ช็อกโกแลต/ช็อกโกแลต ร้อน.png'),
('MENU-033', 'ช็อกโกแลต', 'ช็อกโกแลต', 'เย็น', 55.00, 'แก้ว', 'ช็อกโกแลต/ช็อกโกแลต เย็น.png'),
('MENU-034', 'ช็อกโกแลต', 'ช็อกโกแลต', 'ปั่น', 60.00, 'แก้ว', 'ช็อกโกแลต/ช็อกโกแลต ปั่น.png'),
('MENU-035', 'ช็อกโกแลต', 'ดาร์กช็อกโกแลต', 'ร้อน', 50.00, 'แก้ว', 'ช็อกโกแลต/ดาร์กช็อกโกแลต ร้อน.png'),
('MENU-036', 'ช็อกโกแลต', 'ดาร์กช็อกโกแลต', 'เย็น', 60.00, 'แก้ว', 'ช็อกโกแลต/ดาร์กช็อกโกแลต เย็น.png'),
('MENU-037', 'ช็อกโกแลต', 'ดาร์กช็อกโกแลต', 'ปั่น', 65.00, 'แก้ว', 'ช็อกโกแลต/ดาร์กช็อกโกแลต ปั่น.png'),
('MENU-038', 'ช็อกโกแลต', 'เฟรชดาร์กช็อกโกแลต', 'เย็น', 60.00, 'แก้ว', 'ช็อกโกแลต/เฟรชดาร์กช็อกโกแลต เย็น.png'),
('MENU-039', 'นมสด', 'นมสด', 'ร้อน', 40.00, 'แก้ว', 'นมสด/นมสด ร้อน.png'),
('MENU-040', 'นมสด', 'นมสด', 'เย็น', 50.00, 'แก้ว', 'นมสด/นมสด เย็น.png'),
('MENU-041', 'นมสด', 'นมสด', 'ปั่น', 55.00, 'แก้ว', 'นมสด/นมสด ปั่น.png'),
('MENU-042', 'นมสด', 'นมสดคาราเมลบิสคอฟ', 'ปั่น', 85.00, 'แก้ว', 'นมสด/นมสดคาราเมลบิสคอฟ ปั่น.png'),
('MENU-043', 'นมสด', 'นมสดสตอเบอร์รี่', 'ปั่น', 60.00, 'แก้ว', 'นมสด/นมสดสตอเบอร์รี่ ปั่น.png'),
('MENU-044', 'นมสด', 'สตรอเบอร์รีชีสเค้ก', 'ปั่น', 75.00, 'แก้ว', 'นมสด/สตรอเบอร์รีชีสเค้ก ปั่น.png'),
('MENU-045', 'ขนม', 'ขนมปังมันหวานญี่ปุ่น', '', 55.00, 'ชิ้น', 'ขนม/ขนมปังมันหวานญี่ปุ่น.png'),
('MENU-046', 'ขนม', 'ครัวซอง ช็อคโกแลต', '', 65.00, 'ชิ้น', 'ขนม/ครัวซอง ช็อคโกแลต.png'),
('MENU-047', 'ขนม', 'ครัวซอง อัลมอนด์', '', 69.00, 'ชิ้น', 'ขนม/ครัวซอง อัลมอนด์.png'),
('MENU-048', 'ขนม', 'เค้กช็อคโกแลตหน้านิ่ม', '', 70.00, 'ชิ้น', 'ขนม/เค้กช็อคโกแลตหน้านิ่ม.png'),
('MENU-049', 'ขนม', 'เค้กมะพร้าว', '', 70.00, 'ชิ้น', 'ขนม/เค้กมะพร้าว.png'),
('MENU-050', 'ขนม', 'เค้กสตรอว์เบอร์รี่', '', 70.00, 'ชิ้น', 'ขนม/เค้กสตรอว์เบอร์รี่.png'),
('MENU-051', 'ขนม', 'เค้กส้ม', '', 70.00, 'ชิ้น', 'ขนม/เค้กส้ม.png'),
('MENU-052', 'ขนม', 'ซอฟต์คุกกี้ ช็อคโกแลตชิพ', '', 65.00, 'ชิ้น', 'ขนม/ซอฟต์คุกกี้ ช็อคโกแลตชิพ.png'),
('MENU-053', 'ขนม', 'ซอฟต์คุกกี้ บิสคอฟ', '', 70.00, 'ชิ้น', 'ขนม/ซอฟต์คุกกี้ บิสคอฟ.png'),
('MENU-054', 'ขนม', 'ซอฟต์คุกกี้ เรดเวลเวท', '', 65.00, 'ชิ้น', 'ขนม/ซอฟต์คุกกี้ เรดเวลเวท.png'),
('MENU-055', 'ขนม', 'บราวนี่', '', 65.00, 'ชิ้น', 'ขนม/บราวนี่.png'),
('MENU-056', 'ขนม', 'บลูเบอร์รี่ชีสเค้ก', '', 70.00, 'ชิ้น', 'ขนม/บลูเบอร์รี่ชีสเค้ก.png'),
('MENU-057', 'ขนม', 'บานอฟฟี่', '', 70.00, 'ชิ้น', 'ขนม/บานอฟฟี่.png'),
('MENU-058', 'อาหารเพื่อสุขภาพ', 'แรพไก่กรอบ', '', 89.00, 'ชิ้น', 'อาหารเพื่อสุขภาพ/แรพไก่กรอบ.png'),
('MENU-059', 'อาหารเพื่อสุขภาพ', 'แรพทูน่า', '', 89.00, 'ชิ้น', 'อาหารเพื่อสุขภาพ/แรพทูน่า.png'),
('MENU-060', 'อาหารเพื่อสุขภาพ', 'แรพยำสาหร่าย ปูอัด', '', 79.00, 'ชิ้น', 'อาหารเพื่อสุขภาพ/แรพยำสาหร่าย ปูอัด.png'),
('MENU-061', 'อาหารเพื่อสุขภาพ', 'สลัดไก่กรอบ', '', 99.00, 'ที่', 'อาหารเพื่อสุขภาพ/สลัดไก่กรอบ.png'),
('MENU-062', 'อาหารเพื่อสุขภาพ', 'สลัดทูน่า', '', 99.00, 'ที่', 'อาหารเพื่อสุขภาพ/สลัดทูน่า.png'),
('MENU-063', 'ของทอด ทานเล่น', 'ไก่ป๊อบ', '', 69.00, 'ที่', 'ของทอด ทานเล่น/ไก่ป๊อบ.png'),
('MENU-064', 'ของทอด ทานเล่น', 'นักเก็ต', '', 69.00, 'ที่', 'ของทอด ทานเล่น/นักเก็ต.png'),
('MENU-065', 'ของทอด ทานเล่น', 'ฟิชแอนด์ชิพ', '', 129.00, 'ที่', 'ของทอด ทานเล่น/ฟิชแอนด์ชิพ.png'),
('MENU-066', 'ของทอด ทานเล่น', 'เฟรนช์ฟรายส์', '', 59.00, 'ที่', 'ของทอด ทานเล่น/เฟรนช์ฟรายส์.png'),
('รหัสเมนู', 'หมวดหมู่', 'ชื่อเมนู', 'รูปแบบ', 0.00, 'หน่วยขาย', 'ไฟล์รูปภาพ');

-- --------------------------------------------------------

--
-- Stand-in structure for view `receipt_details`
-- (See below for the actual view)
--
CREATE TABLE `receipt_details` (
`sale_id` bigint(20) unsigned
,`sold_at` datetime
,`customer_name` varchar(150)
,`menu_name` varchar(150)
,`quantity` int(10) unsigned
,`unit_price` decimal(8,2)
,`line_total` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `receipt_totals`
-- (See below for the actual view)
--
CREATE TABLE `receipt_totals` (
`sale_id` bigint(20) unsigned
,`sold_at` datetime
,`customer_name` varchar(150)
,`total_cost` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `sold_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `menu_code` varchar(20) NOT NULL,
  `menu_name` varchar(150) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `line_total` decimal(10,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `sale_items`
--
DELIMITER $$
CREATE TRIGGER `sale_items_before_delete` BEFORE DELETE ON `sale_items` FOR EACH ROW BEGIN
  UPDATE inventory
  SET stock_qty = stock_qty + OLD.quantity
  WHERE menu_code = OLD.menu_code;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sale_items_before_insert` BEFORE INSERT ON `sale_items` FOR EACH ROW BEGIN
  IF NEW.quantity IS NULL OR NEW.quantity = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Quantity must be greater than zero';
  END IF;

  SET NEW.menu_name = (
    SELECT menu_name FROM menu_items WHERE menu_code = NEW.menu_code
  );
  SET NEW.unit_price = (
    SELECT price FROM menu_items WHERE menu_code = NEW.menu_code
  );

  UPDATE inventory
  SET stock_qty = stock_qty - NEW.quantity
  WHERE menu_code = NEW.menu_code
    AND stock_qty >= NEW.quantity;

  IF ROW_COUNT() = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insufficient stock or inventory item is missing';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sale_items_before_update` BEFORE UPDATE ON `sale_items` FOR EACH ROW BEGIN
  IF NEW.quantity IS NULL OR NEW.quantity = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Quantity must be greater than zero';
  END IF;

  UPDATE inventory
  SET stock_qty = stock_qty + OLD.quantity
  WHERE menu_code = OLD.menu_code;

  IF NEW.menu_code <> OLD.menu_code THEN
    SET NEW.menu_name = (
      SELECT menu_name FROM menu_items WHERE menu_code = NEW.menu_code
    );
    SET NEW.unit_price = (
      SELECT price FROM menu_items WHERE menu_code = NEW.menu_code
    );
  END IF;

  UPDATE inventory
  SET stock_qty = stock_qty - NEW.quantity
  WHERE menu_code = NEW.menu_code
    AND stock_qty >= NEW.quantity;

  IF ROW_COUNT() = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insufficient stock or inventory item is missing';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `receipt_details`
--
DROP TABLE IF EXISTS `receipt_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `receipt_details`  AS SELECT `s`.`sale_id` AS `sale_id`, `s`.`sold_at` AS `sold_at`, `s`.`customer_name` AS `customer_name`, `si`.`menu_name` AS `menu_name`, `si`.`quantity` AS `quantity`, `si`.`unit_price` AS `unit_price`, `si`.`line_total` AS `line_total` FROM (`sales` `s` join `sale_items` `si` on(`si`.`sale_id` = `s`.`sale_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `receipt_totals`
--
DROP TABLE IF EXISTS `receipt_totals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `receipt_totals`  AS SELECT `s`.`sale_id` AS `sale_id`, `s`.`sold_at` AS `sold_at`, `s`.`customer_name` AS `customer_name`, coalesce(sum(`si`.`line_total`),0.00) AS `total_cost` FROM (`sales` `s` left join `sale_items` `si` on(`si`.`sale_id` = `s`.`sale_id`)) GROUP BY `s`.`sale_id`, `s`.`sold_at`, `s`.`customer_name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`menu_code`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`menu_code`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `fk_sale_items_menu` (`menu_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_menu` FOREIGN KEY (`menu_code`) REFERENCES `menu_items` (`menu_code`) ON UPDATE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_sale_items_menu` FOREIGN KEY (`menu_code`) REFERENCES `menu_items` (`menu_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
