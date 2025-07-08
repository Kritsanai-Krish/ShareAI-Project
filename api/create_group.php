<?php
require_once __DIR__ . '/../classes/Group.php';
require_once __DIR__ . '/../classes/User.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['aiService'], $data['totalCost'], $data['maxMembers'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$group = new Group();
$invite = $group->create($_SESSION['user_id'], $data['aiService'], (float)$data['totalCost'], (int)$data['maxMembers']);

echo json_encode(['status' => 'ok', 'inviteCode' => $invite]);
?>
