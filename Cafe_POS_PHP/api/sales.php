<?php
require_once __DIR__ . '/bootstrap.php';
try {
 if ($_SERVER['REQUEST_METHOD']==='GET') {
   $rows=db()->query('SELECT s.id,s.receipt_no,s.subtotal,s.paid,s.change_amount,s.created_at,u.name AS cashier FROM sales s LEFT JOIN users u ON u.id=s.user_id ORDER BY s.id DESC')->fetchAll();
   respond(['ok'=>true,'data'=>$rows]);
 }
 if ($_SERVER['REQUEST_METHOD']==='POST') {
   $d=json_input(); $items=$d['items']??[]; $paid=(float)($d['paid']??0);
   if (!$items) respond(['ok'=>false,'message'=>'ไม่มีสินค้าในรายการ'],422);
   $pdo=db(); $pdo->beginTransaction();
   $subtotal=0; $checked=[];
   foreach($items as $item) {
     $id=$item['product_id']??''; $qty=(int)($item['qty']??0);
     if($qty<1) { $pdo->rollBack(); respond(['ok'=>false,'message'=>'จำนวนสินค้าไม่ถูกต้อง'],422); }
     $st=$pdo->prepare('SELECT id,name,variant,price,stock FROM products WHERE id=? AND status="active" FOR UPDATE');
     $st->execute([$id]); $product=$st->fetch();
     if(!$product || (int)$product['stock']<$qty) { $pdo->rollBack(); respond(['ok'=>false,'message'=>'สินค้า '.$id.' หมดหรือมีสต๊อกไม่เพียงพอ'],409); }
     $product['qty']=$qty; $product['line_total']=(float)$product['price']*$qty;
     $subtotal+=$product['line_total']; $checked[]=$product;
   }
   if($paid<$subtotal) { $pdo->rollBack(); respond(['ok'=>false,'message'=>'จำนวนเงินที่รับมาไม่เพียงพอ'],422); }
   $receipt='MC'.date('YmdHis').random_int(100,999);
   $st=$pdo->prepare('INSERT INTO sales(receipt_no,user_id,subtotal,paid,change_amount) VALUES(?,?,?,?,?)');
   $st->execute([$receipt,$_SESSION['user']['id'],$subtotal,$paid,$paid-$subtotal]); $saleId=(int)$pdo->lastInsertId();
   $upd=$pdo->prepare('UPDATE products SET stock=stock-? WHERE id=? AND stock>=?');
   $ins=$pdo->prepare('INSERT INTO sale_items(sale_id,product_id,product_name,variant,qty,unit_price,line_total) VALUES(?,?,?,?,?,?,?)');
   foreach($checked as $p) { $upd->execute([$p['qty'],$p['id'],$p['qty']]); if(!$upd->rowCount()) { $pdo->rollBack(); respond(['ok'=>false,'message'=>'สต๊อกเปลี่ยนแปลง กรุณาลองใหม่'],409); } $ins->execute([$saleId,$p['id'],$p['name'],$p['variant'],$p['qty'],$p['price'],$p['line_total']]); }
   $pdo->commit();
   respond(['ok'=>true,'receipt_no'=>$receipt,'subtotal'=>$subtotal,'paid'=>$paid,'change'=>$paid-$subtotal],201);
 }
 http_response_code(405); respond(['ok'=>false,'message'=>'Method not allowed'],405);
} catch(Throwable $e) { if(isset($pdo) && $pdo->inTransaction()) $pdo->rollBack(); respond(['ok'=>false,'message'=>'Database error'],500); }
