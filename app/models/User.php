<?php
class User {
    public static function findByUsername($username) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user;
    }
}
