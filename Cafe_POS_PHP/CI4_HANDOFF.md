# แนวทางส่งต่อเข้า CodeIgniter 4

ไฟล์นี้เป็นแผนที่สำหรับทีมที่นำหน้าจอ PHP starter ไปต่อใน CI4

| ของเดิม | ตำแหน่งที่แนะนำใน CI4 |
|---|---|
| `login.php` | `app/Views/auth/login.php` |
| `index.php` | `app/Views/pos/index.php` |
| `inventory.php` | `app/Views/products/index.php` |
| `sales.php` | `app/Views/sales/index.php` |
| `receipt.php` | `app/Views/sales/receipt.php` |
| `members.php` | `app/Views/team/index.php` |
| `assets/` | `public/assets/` |
| `config/database.php` | ตั้งค่าใน `app/Config/Database.php` หรือ `.env` |
| `includes/auth.php` | Filter ใน `app/Filters/` |
| `api/products.php` | `ProductController` + `ProductModel` |
| `api/sales.php` | `SalesController` + `SaleModel` + Transaction |

## ลำดับงานที่แนะนำ
1. สร้าง CI4 project ด้วย Composer และวาง assets ไว้ใน `public/assets/`
2. ย้าย markup จากไฟล์ PHP เดิมไปเป็น CI4 Views และเปลี่ยนลิงก์เป็น `base_url()`
3. สร้าง Models สำหรับ users, products, sales, sale_items และ team_members
4. สร้าง Auth Filter ป้องกัน route POS, products, sales และ team
5. สร้าง Routes สำหรับ login/logout, products CRUD และ checkout
6. ใช้ Transaction ใน checkout เพื่อตรวจ stock และตัดสต๊อกในคำสั่งซื้อเดียวกัน
7. เปลี่ยนการอ่าน/บันทึก LocalStorage ใน `assets/js/app.js` ให้เรียก Controller/API ของ CI4

อย่านำรหัสผ่านตัวอย่างไปใช้บน Hosting จริง และอย่าเชื่อถือยอดเงินหรือจำนวนสินค้าเฉพาะจาก Browser ต้องตรวจสอบราคาและ stock จากฐานข้อมูลฝั่งเซิร์ฟเวอร์ทุกครั้ง
