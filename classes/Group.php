<?php
require_once __DIR__ . '/../config/database.php';

class Group {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($ownerId, $aiService, $totalCost, $maxMembers) {
        $groups = $this->db->getCollection('groups');
        $inviteCode = bin2hex(random_bytes(5));
        $groups->Insert([
            'groupName' => $aiService,
            'aiService' => $aiService,
            'ownerId' => $ownerId,
            'totalCost' => $totalCost,
            'maxMembers' => $maxMembers,
            'inviteCode' => $inviteCode,
            'isArchived' => false
        ]);
        return $inviteCode;
    }

    public function findByInvite($code) {
        $groups = $this->db->getCollection('groups');
        return $groups->FindOne(['inviteCode' => $code]);
    }
}
?>
