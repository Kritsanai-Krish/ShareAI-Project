<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';

class User
{
    private $db;
    private $collection;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        $this->db = new Database($config['database_path']);
        $this->collection = $this->db->getCollection('users');
    }

    public function create(string $username, string $email, string $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $doc = new COM('LiteDB.BsonDocument');
        $doc['username'] = $username;
        $doc['email'] = $email;
        $doc['passwordHash'] = $hash;
        $this->collection->Insert($doc);
    }

    public function findByEmail(string $email)
    {
        return $this->collection->FindOne("$.email = '$email'");
    }
}
