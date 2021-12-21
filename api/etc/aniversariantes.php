<?php
include_once('../includes/header.php');
require __DIR__ . '/classes/Database.php';
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Origin: *');


$db_connection = new Database();
$conn = $db_connection->dbConnection();
$data = json_decode(file_get_contents("php://input"));
$returnData = [];
$bindValues = array();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  if(isset($_GET['idPasseio'])) {
    $buscarAniversariantes = "SELECT * FROM "
  }
}