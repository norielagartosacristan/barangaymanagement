<?php
// models/User.php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
