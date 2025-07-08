<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$groupId = isset($_GET['groupId']) ? $_GET['groupId'] : null;
if (!$groupId) {
    http_response_code(400);
    echo json_encode(['error' => 'groupId required']);
    exit;
}

$db = new Database();
$memberships = $db->getCollection('memberships');
$membership = $memberships->FindOne(['groupId' => $groupId, 'userId' => $_SESSION['user_id']]);
if (!$membership) {
    http_response_code(403);
    echo json_encode(['error' => 'Not a member']);
    exit;
}

$payments = $db->getCollection('payments');
$payment = $payments->FindOne(['membershipId' => $membership['_id'], 'status' => 'Paid']);
if (!$payment) {
    http_response_code(403);
    echo json_encode(['error' => 'Payment required']);
    exit;
}

$credCol = $db->getCollection('credentials');
$cred = $credCol->FindOne(['groupId' => $groupId]);
if (!$cred) {
    http_response_code(404);
    echo json_encode(['error' => 'No credentials']);
    exit;
}

$username = openssl_decrypt($cred['encryptedUsername'], 'AES-256-CBC', ENCRYPTION_KEY, 0, ENCRYPTION_IV);
$password = openssl_decrypt($cred['encryptedPassword'], 'AES-256-CBC', ENCRYPTION_KEY, 0, ENCRYPTION_IV);

echo json_encode(['username' => $username, 'password' => $password]);
?>
