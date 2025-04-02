<?php 
if (!isset($_GET["nouicheck"])) {
    echo json_encode(array("status" => "401", "message" => "No credentials provided"));
    die();
}
$_admincheckdirname = dirname(__DIR__, 1);
require_once $_admincheckdirname . '/includes/admin-check.php';
echo json_encode(array("status" => "401", "message" => "No credentials provided"));