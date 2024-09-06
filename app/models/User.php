<?php
require_once 'libraries/Database.php';

class User {
    public static function findByUsername($username) {
        // Get the database connection
        $db = (new Database())->getConnection();

        // Prepare the query
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        
        // Execute the query
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        // Return the user data
        return $user;
    }
}
