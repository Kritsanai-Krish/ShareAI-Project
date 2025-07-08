<?php
// Global configuration for ShareAI
// Path to LiteDB database file
// Ensure the server runs on Windows with the COM extension enabled and LiteDB DLL registered.

define('DB_PATH', __DIR__ . '/../data/shareai.db');

// Encryption settings for storing service credentials securely.
// NOTE: In production, store the key and IV securely (e.g., environment variables).
define('ENCRYPTION_KEY', 'change_this_key_32_chars_long');
define('ENCRYPTION_IV', '16charinitvector');

// Directory to store uploaded payment proofs
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

session_start();
?>
