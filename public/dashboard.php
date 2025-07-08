<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../api/login.php');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="p-4">
<h1 class="text-2xl mb-4">Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
<p>Your email: <?php echo htmlspecialchars($user['email']); ?></p>
<p><a href="../api/logout.php" class="text-blue-500">Logout</a></p>
</body>
</html>
