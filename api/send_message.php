<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['groupId'], $data['content'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

$db = new Database();
$messages = $db->getCollection('messages');
$messages->Insert([
    'groupId' => $data['groupId'],
    'userId' => $_SESSION['user_id'],
    'content' => $data['content'],
    'timestamp' => date('c')
]);

echo json_encode(['status' => 'ok']);
?>
