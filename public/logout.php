<?php
// public/logout.php
require_once '../app/controllers/AuthController.php';

$auth = new AuthController($db);
$auth->logout();
