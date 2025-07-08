<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$db = new Database();
$memberships = $db->getCollection('memberships');
$groupsCol = $db->getCollection('groups');
$payments = $db->getCollection('payments');

$userMemberships = $memberships->Find(['userId' => $_SESSION['user_id']]);
$result = [];
foreach ($userMemberships as $m) {
    $group = $groupsCol->FindById($m['groupId']);
    $payment = $payments->FindOne(['membershipId' => $m['_id']]);
    $result[] = [
        'membershipId' => $m['_id'],
        'group' => $group,
        'payment' => $payment
    ];
}

echo json_encode(['groups' => $result]);
?>
