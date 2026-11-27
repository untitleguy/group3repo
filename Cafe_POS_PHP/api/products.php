<?php
require_once __DIR__ . '/bootstrap.php';
try {
 if ($_SERVER['REQUEST_METHOD']==='GET') {
   $rows=db()->query("SELECT id,category,name,variant,price,unit,image,stock,status FROM products WHERE status='active' ORDER BY id")->fetchAll();
   respond(['ok'=>true,'data'=>$rows]);
 }
 if ($_SERVER['REQUEST_METHOD']==='POST') {
   $d=json_input();
   foreach (['id','category','name','price'] as $key) if (!isset($d[$key]) || $d[$key]==='') respond(['ok'=>false,'message'=>"ข้อมูล $key ไม่ครบ"],422);
   $st=db()->prepare('INSERT INTO products(id,category,name,variant,price,unit,image,stock) VALUES(?,?,?,?,?,?,?,?)');
   $st->execute([$d['id'],$d['category'],$d['name'],$d['variant']??'',$d['price'],$d['unit']??'ชิ้น',$d['image']??null,max(0,(int)($d['stock']??0))]);
   respond(['ok'=>true,'message'=>'เพิ่มสินค้าแล้ว'],201);
 }
 http_response_code(405); respond(['ok'=>false,'message'=>'Method not allowed'],405);
} catch(Throwable $e) { respond(['ok'=>false,'message'=>'Database error'],500); }
