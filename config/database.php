<?php
require_once __DIR__ . '/config.php';

/**
 * Database connection wrapper for LiteDB using PHP COM extension.
 * LiteDB is a .NET library so we interact with it as a COM object.
 * This requires PHP to run on Windows with the COM extension enabled
 * and LiteDB.dll registered via regasm or available via COM.
 */
class Database {
    /** @var COM */
    private $db;

    public function __construct() {
        // Instantiate LiteDatabase COM object. CP_UTF8 ensures UTF-8 strings.
        $this->db = new COM('LiteDB.LiteDatabase', null, CP_UTF8);
        // Connection string specifying the database file.
        $this->db->Connect("Filename=" . DB_PATH);
    }

    /**
     * Get collection reference.
     * @param string $name
     * @return COM
     */
    public function getCollection(string $name) {
        return $this->db->GetCollection($name);
    }
}
?>
