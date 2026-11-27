<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json; charset=utf-8');
function json_input(): array { return json_decode(file_get_contents('php://input'), true) ?? []; }
function api_guard(): void {
 if (empty($_SESSION['user'])) { http_response_code(401); echo json_encode(['ok'=>false,'message'=>'กรุณาเข้าสู่ระบบ']); exit; }
}
function respond(array $data, int $status=200): void { http_response_code($status); echo json_encode($data, JSON_UNESCAPED_UNICODE); exit; }
api_guard();
