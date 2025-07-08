<?php
session_start();
require_once __DIR__ . '/../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        $user = new User();
        if (!$user->findByEmail($email)) {
            $user->create($username, $email, $password);
            $_SESSION['user'] = ['username' => $username, 'email' => $email];
            header('Location: ../public/dashboard.php');
            exit;
        } else {
            $error = 'Email already registered';
        }
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
    <title>Register</title>
</head>
<body class="p-4">
<h1 class="text-2xl mb-4">Register</h1>
<?php if (!empty($error)) echo "<p class='text-red-500'>$error</p>"; ?>
<form method="post" class="space-y-2">
    <input type="text" name="username" placeholder="Username" class="border p-2 w-full" required>
    <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
    <input type="password" name="password" placeholder="Password" class="border p-2 w-full" required>
    <button type="submit" class="btn-primary">Register</button>
</form>
<p>Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
</body>
</html>
