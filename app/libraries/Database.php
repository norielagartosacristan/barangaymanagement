<?php

class Database {
    private $host = 'localhost';  // Database host, usually 'localhost'
    private $user = 'root';       // Your database username
    private $pass = '';           // Your database password
    private $dbname = 'barangay_management_system'; // Your database name

    public $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
