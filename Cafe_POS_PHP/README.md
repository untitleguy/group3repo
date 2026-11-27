# Mellow Café POS — PHP Login + Backend Handoff

## โครงสร้าง
- `login.php` / `logout.php` — ล็อกอินและออกจากระบบด้วย PHP Session
- `index.php` — หน้าขาย POS
- `inventory.php` — จัดการสินค้าและสต๊อก (หน้าจอเดิม)
- `sales.php` — ประวัติการขาย
- `receipt.php` — ใบเสร็จอย่างย่อ
- `members.php` — สมาชิกและหน้าที่ของกลุ่ม
- `assets/css/style.css` — CSS หลักไฟล์เดียว ใช้ร่วมกันทุกหน้า รวมหน้าล็อกอิน
- `assets/js/` — JavaScript และข้อมูลเมนู
- `assets/products/` — รูปเมนู 66 รายการ
- `config/database.php` — ตั้งค่าการเชื่อมต่อ MySQL
- `includes/auth.php` — จัดการ Session และตรวจสอบการเข้าสู่ระบบ
- `api/products.php` — API รายการสินค้าและเพิ่มสินค้า
- `api/sales.php` — API บันทึกการขายแบบ Transaction พร้อมล็อกแถวสต๊อกและป้องกันขายเกินจำนวน
- `database.sql` — สร้างตารางและนำเข้าเมนูเริ่มต้น

## ติดตั้งด้วย XAMPP
1. แตก ZIP แล้วนำโฟลเดอร์ `Cafe_POS_PHP` ไปไว้ที่ `C:\xampp\htdocs\`
2. เปิด XAMPP แล้ว Start `Apache` และ `MySQL`
3. เข้า `http://localhost/phpmyadmin`
4. เลือกแท็บ Import แล้วเลือกไฟล์ `database.sql` ในโฟลเดอร์โปรเจกต์ จากนั้นกด Import
5. ตรวจสอบ `config/database.php` ให้ตรงกับ MySQL ของเครื่อง (ค่าเริ่มต้น XAMPP: user `root`, password ว่าง)
6. เปิด `http://localhost/Cafe_POS_PHP/` ระบบจะพาไปหน้าล็อกอิน

## บัญชีทดลอง
- อีเมล: `admin@mellowcafe.local`
- รหัสผ่าน: `admin123`

ควรเปลี่ยนรหัสผ่านหลังติดตั้งและก่อนนำขึ้น Hosting

## จุดเริ่มต้นสำหรับทีม Back-end
- ปรับค่าฐานข้อมูลใน `config/database.php`
- ตารางหลัก: `users`, `products`, `sales`, `sale_items`, `team_members`
- API ต้องเรียกหลังล็อกอิน:
  - `GET /Cafe_POS_PHP/api/products.php`
  - `POST /Cafe_POS_PHP/api/products.php`
  - `GET /Cafe_POS_PHP/api/sales.php`
  - `POST /Cafe_POS_PHP/api/sales.php`
- ตัวอย่าง body สำหรับบันทึกขาย:
  `{"paid":150,"items":[{"product_id":"MENU-001","qty":2}]}`
- API ขายจะตรวจสต๊อกซ้ำในฐานข้อมูลภายใน Transaction และไม่อนุญาตให้ขายเมื่อสต๊อกไม่พอ

## หมายเหตุสำคัญ
- หน้าล็อกอินเชื่อม MySQL จริงและป้องกันหน้าระบบด้วย Session แล้ว
- API สินค้า/ขายเป็นจุดต่อ Back-end ที่เตรียมไว้ให้ทีมพัฒนาต่อ
- หน้าจอ POS/คลังสินค้าเดิมยังใช้ LocalStorage ในการแสดงผลและจำลองการทำงานอยู่ ยังไม่ได้เปลี่ยน JavaScript ทั้งหมดให้เรียก API โดยตรง ทีม Back-end ต้องเชื่อม `assets/js/app.js` กับ API หรือย้ายหน้าเป็น Controller/Views ของ CodeIgniter 4
- โครงนี้เป็น PHP starter สำหรับรัน XAMPP ไม่ใช่โปรเจกต์ CodeIgniter 4 ที่ติดตั้ง Composer แล้ว หากอาจารย์กำหนดให้ CI4 เป็นแกนหลัก ให้ทีม Back-end นำ views/assets และ schema ไปวางในโครง CI4 พร้อมสร้าง Controllers/Models/Routes ตามคู่มือและย้าย logic ไปฝั่งเซิร์ฟเวอร์
