<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Find user by username
    public function findByUsername($username) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }
}
