<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");

if (isset($_REQUEST['hideInactives'])) {
  $query = '';
  $hideInactives = ' ';
  if ($_REQUEST['hideInactives'] === 'true') {
    $hideInactives = 'WHERE statusPasseio NOT IN (0) ';
  }
  if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $hideInactives = $hideInactives . 'AND idpasseio=?';
  }
  $sql = "SELECT * FROM passeio $hideInactives ORDER BY dataPasseio";
  $apiAnswer = array();
  if ($stmt = $conn->prepare($sql)) {
    if (isset($_REQUEST['id'])) {
      $stmt->bind_param("i", $id);
    }
    // $stmt->bind_param("i", $statusPasseio);
    // $statusPasseio = $_REQUEST['hideInactives'];
    $response = executeSelect($stmt);
    $apiAnswer['serveStatus'] = $response;
    if ($response['sql']->num_rows > 0) {
      while ($row = $response['sql']->fetch_array(MYSQLI_ASSOC)) {
        $apiAnswer['data'][] = $row;
      }
    }else{
      $apiAnswer['serverStatus']['msg'] = 'Passeio não encontrado';
    }
  }else{
    $apiAnswer['msg'] = 'Erro Interno!';

  }
}

print_r(json_encode($apiAnswer));