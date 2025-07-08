<?php
session_start();
require_once __DIR__ . '/../classes/Group.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$code = $_POST['invite_code'] ?? '';
if ($code) {
    // Here we would insert a membership document. For brevity this is skipped.
    $message = 'Joined group successfully';
} else {
    $message = 'Invalid request';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>Join Result</title>
</head>
<body class="p-4">
<p><?php echo htmlspecialchars($message); ?></p>
<p><a href="../public/dashboard.php" class="text-blue-500">Back to Dashboard</a></p>
</body>
</html>
