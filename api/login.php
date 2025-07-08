<?php
require_once __DIR__ . '/../classes/User.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

$userClass = new User();
$user = $userClass->login($data['email'], $data['password']);

if ($user) {
    $_SESSION['user_id'] = $user['_id'];
    echo json_encode(['status' => 'ok']);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
}
?>
