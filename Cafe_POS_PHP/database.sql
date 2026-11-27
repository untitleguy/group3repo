CREATE DATABASE IF NOT EXISTS mellow_cafe CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mellow_cafe;
CREATE TABLE IF NOT EXISTS users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','cashier') NOT NULL DEFAULT 'cashier',
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS products (
 id VARCHAR(30) PRIMARY KEY,
 category VARCHAR(100) NOT NULL,
 name VARCHAR(150) NOT NULL,
 variant VARCHAR(80) NOT NULL DEFAULT '',
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 unit VARCHAR(30) NOT NULL DEFAULT 'ชิ้น',
 image VARCHAR(255) DEFAULT NULL,
 stock INT NOT NULL DEFAULT 0,
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS sales (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 receipt_no VARCHAR(40) NOT NULL UNIQUE,
 user_id INT UNSIGNED NULL,
 subtotal DECIMAL(10,2) NOT NULL,
 paid DECIMAL(10,2) NOT NULL,
 change_amount DECIMAL(10,2) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_sales_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS sale_items (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 sale_id BIGINT UNSIGNED NOT NULL,
 product_id VARCHAR(30) NOT NULL,
 product_name VARCHAR(150) NOT NULL,
 variant VARCHAR(80) NOT NULL DEFAULT '',
 qty INT NOT NULL,
 unit_price DECIMAL(10,2) NOT NULL,
 line_total DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_item_sale FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
 CONSTRAINT fk_item_product FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS team_members (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(150) NOT NULL,
 responsibility VARCHAR(255) NOT NULL,
 photo VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- Demo administrator. Change the password after first login.
INSERT INTO users (name,email,password,role,status)
VALUES ('ผู้ดูแลระบบ','admin@mellowcafe.local','$2y$12$EVFi76cfIubzn4Gzfuvj/OhXOEMs7Dp6FgC2SanzKOl3QUSfxt8US','admin','active')
ON DUPLICATE KEY UPDATE email=VALUES(email);

-- Menu catalog imported from the supplied cafe resource CSV (default stock: 20)
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-001','กาแฟ','คาปูชิโน่','ร้อน',50.0,'แก้ว','assets/products/product_001.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-002','กาแฟ','คาปูชิโน่','เย็น',65.0,'แก้ว','assets/products/product_002.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-003','กาแฟ','คาปูชิโน่','ปั่น',70.0,'แก้ว','assets/products/product_003.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-004','กาแฟ','คาราเมลมัคคิอาโต้','เย็น',85.0,'แก้ว','assets/products/product_004.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-005','กาแฟ','มอคค่า','ร้อน',55.0,'แก้ว','assets/products/product_005.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-006','กาแฟ','มอคค่า','เย็น',70.0,'แก้ว','assets/products/product_006.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-007','กาแฟ','มอคค่า','ปั่น',75.0,'แก้ว','assets/products/product_007.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-008','กาแฟ','ลาเต้','ร้อน',55.0,'แก้ว','assets/products/product_008.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-009','กาแฟ','ลาเต้','เย็น',70.0,'แก้ว','assets/products/product_009.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-010','กาแฟ','ลาเต้','ปั่น',75.0,'แก้ว','assets/products/product_010.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-011','กาแฟ','อเมริกาโน่','ร้อน',40.0,'แก้ว','assets/products/product_011.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-012','กาแฟ','อเมริกาโน่','เย็น',60.0,'แก้ว','assets/products/product_012.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-013','กาแฟ','อเมริกาโน่โคโค่นัท','เย็น',70.0,'แก้ว','assets/products/product_013.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-014','กาแฟ','อเมริกาโน่ส้ม','เย็น',65.0,'แก้ว','assets/products/product_014.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-015','กาแฟ','เอสเพรสโซ','ร้อน',40.0,'แก้ว','assets/products/product_015.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-016','กาแฟ','เอสเพรสโซ','เย็น',60.0,'แก้ว','assets/products/product_016.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-017','กาแฟ','เอสเพรสโซ','ปั่น',65.0,'แก้ว','assets/products/product_017.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-018','ชาไทย','ชาไทย','ร้อน',45.0,'แก้ว','assets/products/product_018.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-019','ชาไทย','ชาไทย','เย็น',50.0,'แก้ว','assets/products/product_019.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-020','ชาไทย','ชาไทย','ปั่น',55.0,'แก้ว','assets/products/product_020.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-021','ชาไทย','ชาไทยกาแฟ','เย็น',65.0,'แก้ว','assets/products/product_021.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-022','ชาไทย','ชาไทยกาแฟ','ปั่น',70.0,'แก้ว','assets/products/product_022.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-023','ชาไทย','ชาไทยช็อกโกแลต','เย็น',65.0,'แก้ว','assets/products/product_023.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-024','ชาไทย','ชาไทยช็อกโกแลต','ปั่น',70.0,'แก้ว','assets/products/product_024.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-025','มัทฉะ-ชา','ชามะนาว','เย็น',50.0,'แก้ว','assets/products/product_025.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-026','มัทฉะ-ชา','มัทฉะถั่วแดง','ปั่น',70.0,'แก้ว','assets/products/product_026.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-027','มัทฉะ-ชา','มัทฉะลาเต้','เย็น',60.0,'แก้ว','assets/products/product_027.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-028','มัทฉะ-ชา','มัทฉะลาเต้','ปั่น',65.0,'แก้ว','assets/products/product_028.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-029','มัทฉะ-ชา','มัทฉะสตอเบอร์รี่','เย็น',70.0,'แก้ว','assets/products/product_029.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-030','มัทฉะ-ชา','มัทฉะส้ม','เย็น',70.0,'แก้ว','assets/products/product_030.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-031','มัทฉะ-ชา','ไลท์มัทฉะ','เย็น',60.0,'แก้ว','assets/products/product_031.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-032','ช็อกโกแลต','ช็อกโกแลต','ร้อน',45.0,'แก้ว','assets/products/product_032.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-033','ช็อกโกแลต','ช็อกโกแลต','เย็น',55.0,'แก้ว','assets/products/product_033.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-034','ช็อกโกแลต','ช็อกโกแลต','ปั่น',60.0,'แก้ว','assets/products/product_034.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-035','ช็อกโกแลต','ดาร์กช็อกโกแลต','ร้อน',50.0,'แก้ว','assets/products/product_035.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-036','ช็อกโกแลต','ดาร์กช็อกโกแลต','เย็น',60.0,'แก้ว','assets/products/product_036.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-037','ช็อกโกแลต','ดาร์กช็อกโกแลต','ปั่น',65.0,'แก้ว','assets/products/product_037.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-038','ช็อกโกแลต','เฟรชดาร์กช็อกโกแลต','เย็น',60.0,'แก้ว','assets/products/product_038.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-039','นมสด','นมสด','ร้อน',40.0,'แก้ว','assets/products/product_039.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-040','นมสด','นมสด','เย็น',50.0,'แก้ว','assets/products/product_040.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-041','นมสด','นมสด','ปั่น',55.0,'แก้ว','assets/products/product_041.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-042','นมสด','นมสดคาราเมลบิสคอฟ','ปั่น',85.0,'แก้ว','assets/products/product_042.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-043','นมสด','นมสดสตอเบอร์รี่','ปั่น',60.0,'แก้ว','assets/products/product_043.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-044','นมสด','สตรอเบอร์รีชีสเค้ก','ปั่น',75.0,'แก้ว','assets/products/product_044.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-045','ขนม','ขนมปังมันหวานญี่ปุ่น','',55.0,'ชิ้น','assets/products/product_045.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-046','ขนม','ครัวซอง ช็อคโกแลต','',65.0,'ชิ้น','assets/products/product_046.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-047','ขนม','ครัวซอง อัลมอนด์','',69.0,'ชิ้น','assets/products/product_047.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-048','ขนม','เค้กช็อคโกแลตหน้านิ่ม','',70.0,'ชิ้น','assets/products/product_048.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-049','ขนม','เค้กมะพร้าว','',70.0,'ชิ้น','assets/products/product_049.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-050','ขนม','เค้กสตรอว์เบอร์รี่','',70.0,'ชิ้น','assets/products/product_050.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-051','ขนม','เค้กส้ม','',70.0,'ชิ้น','assets/products/product_051.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-052','ขนม','ซอฟต์คุกกี้ ช็อคโกแลตชิพ','',65.0,'ชิ้น','assets/products/product_052.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-053','ขนม','ซอฟต์คุกกี้ บิสคอฟ','',70.0,'ชิ้น','assets/products/product_053.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-054','ขนม','ซอฟต์คุกกี้ เรดเวลเวท','',65.0,'ชิ้น','assets/products/product_054.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-055','ขนม','บราวนี่','',65.0,'ชิ้น','assets/products/product_055.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-056','ขนม','บลูเบอร์รี่ชีสเค้ก','',70.0,'ชิ้น','assets/products/product_056.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-057','ขนม','บานอฟฟี่','',70.0,'ชิ้น','assets/products/product_057.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-058','อาหารเพื่อสุขภาพ','แรพไก่กรอบ','',89.0,'ชิ้น','assets/products/product_058.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-059','อาหารเพื่อสุขภาพ','แรพทูน่า','',89.0,'ชิ้น','assets/products/product_059.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-060','อาหารเพื่อสุขภาพ','แรพยำสาหร่าย ปูอัด','',79.0,'ชิ้น','assets/products/product_060.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-061','อาหารเพื่อสุขภาพ','สลัดไก่กรอบ','',99.0,'ที่','assets/products/product_061.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-062','อาหารเพื่อสุขภาพ','สลัดทูน่า','',99.0,'ที่','assets/products/product_062.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-063','ของทอด ทานเล่น','ไก่ป๊อบ','',69.0,'ที่','assets/products/product_063.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-064','ของทอด ทานเล่น','นักเก็ต','',69.0,'ที่','assets/products/product_064.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-065','ของทอด ทานเล่น','ฟิชแอนด์ชิพ','',129.0,'ที่','assets/products/product_065.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
INSERT INTO products (id,category,name,variant,price,unit,image,stock) VALUES ('MENU-066','ของทอด ทานเล่น','เฟรนช์ฟรายส์','',59.0,'ที่','assets/products/product_066.webp',20) ON DUPLICATE KEY UPDATE category=VALUES(category),name=VALUES(name),variant=VALUES(variant),price=VALUES(price),unit=VALUES(unit),image=VALUES(image);
