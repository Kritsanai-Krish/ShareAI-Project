<?php
/**
 * LiteDB database connection using PHP COM extension.
 *
 * This requires PHP to run on Windows with the .NET Framework and
 * the LiteDB.dll registered as a COM library. You can register LiteDB
 * by running `regasm LiteDB.dll` from the Developer Command Prompt.
 * After registration, the COM class `LiteDB.LiteDatabase` becomes
 * available to PHP through the COM extension.
 */
class Database
{
    private $db;

    public function __construct(string $path)
    {
        // Instantiate the COM object for LiteDB
        // The COM extension must be enabled in php.ini
        $this->db = new COM('LiteDB.LiteDatabase');
        // Open or create the database file
        $this->db->Open($path);
    }

    public function getCollection(string $name)
    {
        // Return a LiteDB collection via COM dispatch
        return $this->db->GetCollection($name);
    }

    public function __destruct()
    {
        // Close the connection when the object is destroyed
        if ($this->db) {
            $this->db->Dispose();
        }
    }
}
