<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['paymentId'], $data['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$db = new Database();
$payments = $db->getCollection('payments');
$payment = $payments->FindById($data['paymentId']);
if (!$payment) {
    http_response_code(404);
    echo json_encode(['error' => 'Payment not found']);
    exit;
}

// verify current user is group owner
$memberships = $db->getCollection('memberships');
$membership = $memberships->FindById($payment['membershipId']);
$groupCol = $db->getCollection('groups');
$group = $groupCol->FindById($membership['groupId']);
if ($group['ownerId'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

$newStatus = $data['action'] === 'approve' ? 'Paid' : 'Unpaid';
$payments->Update($payment['_id'], [
    'status' => $newStatus,
    'lastUpdated' => date('c')
]);

echo json_encode(['status' => 'ok']);
?>
