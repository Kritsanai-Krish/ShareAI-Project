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
if (!isset($data['inviteCode'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing invite code']);
    exit;
}

$groupClass = new Group();
$group = $groupClass->findByInvite($data['inviteCode']);
if (!$group) {
    http_response_code(404);
    echo json_encode(['error' => 'Group not found']);
    exit;
}

$db = new Database();
$membershipCol = $db->getCollection('memberships');
$existing = $membershipCol->FindOne(['groupId' => $group['_id'], 'userId' => $_SESSION['user_id']]);
if ($existing) {
    http_response_code(409);
    echo json_encode(['error' => 'Already joined']);
    exit;
}

$membershipCol->Insert([
    'groupId' => $group['_id'],
    'userId' => $_SESSION['user_id'],
    'joinDate' => date('c')
]);

// create payment record for first billing cycle (simplified)
$payments = $db->getCollection('payments');
$payments->Insert([
    'membershipId' => $membershipCol->LastId(),
    'billingCycle' => date('Y-m'),
    'amount' => $group['totalCost'] / $group['maxMembers'],
    'status' => 'Unpaid',
    'paymentProofUrl' => '',
    'lastUpdated' => date('c')
]);

echo json_encode(['status' => 'ok']);
?>
