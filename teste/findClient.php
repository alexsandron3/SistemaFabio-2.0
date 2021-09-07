<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $sql = "SELECT * FROM cliente WHERE idCliente=?";
  $apiAnswer = array();
  if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $id);
    $response = executeSelect($stmt);
    $apiAnswer['serverStatus'] = $response;
    if ($response['sql']->num_rows > 0) {
      $apiAnswer['data'] = $response['sql']->fetch_array(MYSQLI_ASSOC);
    }else{
      $apiAnswer['serverStatus']['msg'] = 'Cliente não encontrado';
    }
  }
  print_r(json_encode($apiAnswer));
  // print_r(json_encode($clienteInfo));
  $stmt->close();
  $conn->close();

}


