<?php
// Global configuration for ShareAI application

return [
    // Encryption key and IV for credential encryption
    'encryption_key' => 'my_super_secret_key_32_bytes_long!',
    'encryption_iv'  => 'my_secret_iv_16_by',
    // Path to LiteDB database file
    'database_path'  => __DIR__ . '/../data/shareai.db'
];
