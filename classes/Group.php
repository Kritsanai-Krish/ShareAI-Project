<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';

class Group
{
    private $db;
    private $collection;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        $this->db = new Database($config['database_path']);
        $this->collection = $this->db->getCollection('groups');
    }

    public function create(array $data)
    {
        $doc = new COM('LiteDB.BsonDocument');
        $doc['groupName'] = $data['groupName'];
        $doc['aiService'] = $data['aiService'];
        $doc['ownerId'] = $data['ownerId'];
        $doc['totalCost'] = (float)$data['totalCost'];
        $doc['maxMembers'] = (int)$data['maxMembers'];
        $doc['inviteCode'] = $data['inviteCode'];
        $doc['isArchived'] = false;
        $this->collection->Insert($doc);
    }

    public function findByInvite(string $code)
    {
        return $this->collection->FindOne("$.inviteCode = '$code'");
    }
}
