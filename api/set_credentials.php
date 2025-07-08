<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['groupId'], $data['username'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$db = new Database();
$groupCol = $db->getCollection('groups');
$group = $groupCol->FindById($data['groupId']);
if (!$group || $group['ownerId'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

$credCol = $db->getCollection('credentials');
$encryptedUser = openssl_encrypt($data['username'], 'AES-256-CBC', ENCRYPTION_KEY, 0, ENCRYPTION_IV);
$encryptedPass = openssl_encrypt($data['password'], 'AES-256-CBC', ENCRYPTION_KEY, 0, ENCRYPTION_IV);
$existing = $credCol->FindOne(['groupId' => $data['groupId']]);
if ($existing) {
    $credCol->Update($existing['_id'], [
        'encryptedUsername' => $encryptedUser,
        'encryptedPassword' => $encryptedPass
    ]);
} else {
    $credCol->Insert([
        'groupId' => $data['groupId'],
        'encryptedUsername' => $encryptedUser,
        'encryptedPassword' => $encryptedPass
    ]);
}

echo json_encode(['status' => 'ok']);
?>
