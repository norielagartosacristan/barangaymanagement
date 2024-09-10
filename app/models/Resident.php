<?php
// app/models/Resident.php
require_once '../includes/db.php';

class Resident {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllResidents($search = '') {
        if (!empty($search)) {
            $sql = "SELECT * FROM Resident WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM Resident";
        }

        return $this->db->query($sql);
    }

    public function addResident($first_name, $last_name, $middle_name, $gender, $address) {
        $sql = "INSERT INTO Resident (first_name, last_name, middle_name, gender, address)
                VALUES ('$first_name', '$last_name', '$middle_name', '$gender', '$address')";
        return $this->db->query($sql);
    }

    public function getResidentById($id) {
        $sql = "SELECT * FROM Resident WHERE id = $id";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function updateResident($id, $first_name, $last_name, $middle_name, $gender, $address) {
        $sql = "UPDATE Resident SET first_name='$first_name', last_name='$last_name', middle_name='$middle_name', gender='$gender', address='$address'
                WHERE id=$id";
        return $this->db->query($sql);
    }

    public function deleteResident($id) {
        $sql = "DELETE FROM Resident WHERE id = $id";
        return $this->db->query($sql);
    }
}