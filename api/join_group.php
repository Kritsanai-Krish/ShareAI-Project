<?php
session_start();
require_once __DIR__ . '/../classes/Group.php';

$code = $_GET['invite_code'] ?? '';
$group = null;

if ($code) {
    $g = new Group();
    $group = $g->findByInvite($code);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>Join Group</title>
</head>
<body class="p-4">
<?php if (!$group): ?>
    <p class="text-red-500">Invalid invite code</p>
<?php else: ?>
    <h1 class="text-2xl mb-4">Join <?php echo htmlspecialchars($group['groupName']); ?></h1>
    <?php if (!isset($_SESSION['user'])): ?>
        <p>You must <a href="login.php" class="text-blue-500">login</a> first.</p>
    <?php else: ?>
        <p>AI Service: <?php echo htmlspecialchars($group['aiService']); ?></p>
        <p>Total Cost: <?php echo htmlspecialchars($group['totalCost']); ?></p>
        <form method="post" action="confirm_join.php" class="mt-4">
            <input type="hidden" name="invite_code" value="<?php echo htmlspecialchars($code); ?>">
            <button type="submit" class="btn-primary">Join</button>
        </form>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
