<?php
require_once __DIR__ . '/../classes/User.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username'], $data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

$user = new User();
$success = $user->register($data['username'], $data['email'], $data['password']);

if ($success) {
    echo json_encode(['status' => 'ok']);
} else {
    http_response_code(409);
    echo json_encode(['error' => 'Email already in use']);
}
?>
