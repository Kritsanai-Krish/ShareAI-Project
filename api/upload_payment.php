<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if (!isset($_POST['membershipId']) || !isset($_FILES['proof'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$db = new Database();
$payments = $db->getCollection('payments');
$payment = $payments->FindOne(['membershipId' => (int)$_POST['membershipId']]);
if (!$payment) {
    http_response_code(404);
    echo json_encode(['error' => 'Payment record not found']);
    exit;
}

$filename = uniqid('proof_') . basename($_FILES['proof']['name']);
$target = UPLOAD_DIR . $filename;
if (!move_uploaded_file($_FILES['proof']['tmp_name'], $target)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save file']);
    exit;
}

$payments->Update($payment['_id'], [
    'status' => 'Pending',
    'paymentProofUrl' => $filename,
    'lastUpdated' => date('c')
]);

echo json_encode(['status' => 'ok']);
?>
