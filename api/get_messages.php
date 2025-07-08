<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');
set_time_limit(0); // allow long polling

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$groupId = isset($_GET['groupId']) ? $_GET['groupId'] : null;
$since = isset($_GET['since']) ? $_GET['since'] : null;

if (!$groupId) {
    http_response_code(400);
    echo json_encode(['error' => 'groupId required']);
    exit;
}

$db = new Database();
$messagesCol = $db->getCollection('messages');
$start = time();
$timeout = 30; // seconds

while (true) {
    if ($since) {
        $msgs = $messagesCol->Find(['groupId' => $groupId, 'timestamp' => ['$gt' => $since]]);
    } else {
        $msgs = $messagesCol->Find(['groupId' => $groupId]);
    }
    if ($msgs->Count() > 0) {
        $arr = [];
        foreach ($msgs as $m) { $arr[] = $m; }
        echo json_encode(['messages' => $arr]);
        exit;
    }
    if (time() - $start >= $timeout) {
        echo json_encode(['messages' => []]);
        exit;
    }
    sleep(1);
}
?>
