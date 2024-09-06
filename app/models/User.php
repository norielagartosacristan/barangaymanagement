<?php
require_once '../libraries/Database.php';  // Make sure to include the Database class

class User {
    public static function findByUsername($username) {
        $db = Database::getConnection();  // This will now work if Database class is correctly defined

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_object();

        return $user;
    }
}
?>
