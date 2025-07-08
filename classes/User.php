<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Register a new user.
     */
    public function register(string $username, string $email, string $password): bool {
        $users = $this->db->getCollection('users');
        // Ensure email uniqueness
        $existing = $users->FindOne([ 'email' => $email ]);
        if ($existing) {
            return false;
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $users->Insert([
            'username' => $username,
            'email'    => $email,
            'passwordHash' => $hash
        ]);
        return true;
    }

    /**
     * Verify login credentials.
     */
    public function login(string $email, string $password): ?array {
        $users = $this->db->getCollection('users');
        $user = $users->FindOne(['email' => $email]);
        if ($user && password_verify($password, $user['passwordHash'])) {
            return $user;
        }
        return null;
    }

    public function getById($id) {
        $users = $this->db->getCollection('users');
        return $users->FindById($id);
    }
}
?>
