<?php
// app/controllers/ResidentController.php
require_once 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';
require_once 'D:\GrsDatabase\htdocs\barangaymanagement\app\models\Resident.php';

class ResidentController {
    private $residentModel;

    public function __construct() {
        $this->residentModel = new Resident($db);
    }

    public function index() {
        $limit = 10; // Set number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $residents = $this->residentModel->getResidentsWithPagination($limit, $offset, $search);
        $totalResidents = $this->residentModel->getResidentCount($search);

        $totalPages = ceil($totalResidents / $limit);

        include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\residents\index.php';
    }
}
