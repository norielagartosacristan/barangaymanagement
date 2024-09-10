<?php
// app/controllers/ResidentController.php
require_once '../models/Resident.php';

class ResidentController {
    private $residentModel;

    public function __construct($db) {
        $this->residentModel = new Resident($db);
    }

    public function index() {
        $search = '';
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        }
        $residents = $this->residentModel->getAllResidents($search);
        require_once '../views/residents/index.php';
    }

    public function create() {
        require_once '../views/residents/add.php';
    }

    public function store() {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];

        $this->residentModel->addResident($first_name, $last_name, $middle_name, $gender, $address);
        header('Location: ../public/index.php');
    }

    public function edit($id) {
        $resident = $this->residentModel->getResidentById($id);
        require_once '../views/residents/edit.php';
    }

    public function update($id) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];

        $this->residentModel->updateResident($id, $first_name, $last_name, $middle_name, $gender, $address);
        header('Location: ../public/index.php');
    }

    public function delete($id) {
        $this->residentModel->deleteResident($id);
        header('Location: ../public/index.php');
    }
}
