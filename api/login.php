<?php
session_start();
require_once __DIR__ . '/../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $user = new User();
        $doc = $user->findByEmail($email);
        if ($doc && password_verify($password, $doc['passwordHash'])) {
            $_SESSION['user'] = ['username' => $doc['username'], 'email' => $email];
            header('Location: ../public/dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials';
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
    <title>Login</title>
</head>
<body class="p-4">
<h1 class="text-2xl mb-4">Login</h1>
<?php if (!empty($error)) echo "<p class='text-red-500'>$error</p>"; ?>
<form method="post" class="space-y-2">
    <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
    <input type="password" name="password" placeholder="Password" class="border p-2 w-full" required>
    <button type="submit" class="btn-primary">Login</button>
</form>
<p>No account? <a href="register.php" class="text-blue-500">Register</a></p>
</body>
</html>
