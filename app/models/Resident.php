<?php
// app/models/Resident.php

require_once 'D:\GrsDatabase\htdocs\barangaymanagement\app\controllers\ResidentController.php';
class Resident {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getResidentsWithPagination($limit, $offset, $search = '') {
        $query = "SELECT * FROM residents WHERE CONCAT(lastname, ' ', firstname) LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        $search = '%' . $search . '%';
        $stmt->bind_param("ii", $search, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $residents = [];
        while ($row = $result->fetch_assoc()) {
            $residents[] = $row;
        }

        return $residents;
    }

    public function getResidentCount($search = '') {
        $query = "SELECT COUNT(*) AS total FROM residents WHERE CONCAT(lastname, ' ', firstname) LIKE ?";
        $stmt = $this->db->prepare($query);
        $search = '%' . $search . '%';
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
