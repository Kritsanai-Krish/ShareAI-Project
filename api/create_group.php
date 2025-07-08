<?php
session_start();
require_once __DIR__ . '/../classes/Group.php';
require_once __DIR__ . '/../classes/User.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupName  = trim($_POST['group_name'] ?? '');
    $aiService  = trim($_POST['ai_service'] ?? '');
    $totalCost  = trim($_POST['total_cost'] ?? '');
    $maxMembers = trim($_POST['max_members'] ?? '');

    if ($groupName && $aiService && $totalCost && $maxMembers) {
        $inviteCode = bin2hex(random_bytes(5));
        $group = new Group();
        $group->create([
            'groupName'  => $groupName,
            'aiService'  => $aiService,
            'ownerId'    => $_SESSION['user']['email'], // using email as owner id
            'totalCost'  => $totalCost,
            'maxMembers' => $maxMembers,
            'inviteCode' => $inviteCode
        ]);
        $success = "Group created! Invite link: join_group.php?invite_code=$inviteCode";
    } else {
        $error = 'All fields are required';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>Create Group</title>
</head>
<body class="p-4">
<h1 class="text-2xl mb-4">Create Sharing Group</h1>
<?php if (!empty($error)) echo "<p class='text-red-500'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p class='text-blue-500'>$success</p>"; ?>
<form method="post" class="space-y-2">
    <input type="text" name="group_name" placeholder="Group Name" class="border p-2 w-full" required>
    <input type="text" name="ai_service" placeholder="AI Service" class="border p-2 w-full" required>
    <input type="number" step="0.01" name="total_cost" placeholder="Total Cost" class="border p-2 w-full" required>
    <input type="number" name="max_members" placeholder="Max Members" class="border p-2 w-full" required>
    <button type="submit" class="btn-primary">Create</button>
</form>
</body>
</html>
