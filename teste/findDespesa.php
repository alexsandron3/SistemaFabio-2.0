<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");

if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $sql = "SELECT * FROM despesa WHERE idPasseio=?";
  $apiAnswer = array();
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $id);
    $response = executeSelect($stmt);
    $apiAnswer= $response;
    if ($response['serverResponse']['sql']->num_rows > 0) {
      while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
        $apiAnswer['despesa'] = $row;
      }
    }else{
      $apiAnswer['serverResponse']['status'] = 0;
      $apiAnswer['serverResponse']['msg'] = 'Despesa não encontrado';
    }
  }else{
    $apiAnswer['serverResponse']['msg'] = 'Erro Interno!';
  }
}
print_r(json_encode($apiAnswer));