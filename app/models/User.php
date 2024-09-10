<?php

// app/models/User.php
class User {
    private $db;

    // Constructor: Make sure to accept the database connection
    public function __construct($db) {
        $this->db = $db;
    }

    // This is an instance method, not a static method
    public function findUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

