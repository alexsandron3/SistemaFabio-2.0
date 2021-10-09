<?php
  include_once("../includes/header.php");
  include_once("passeio/selectAll.php");
  include_once("passeio/select.php");
  // required headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  $apiAnswer = array();
  $showInactives = 0;
  $inicio = null;
  $fim = null;
  if (isset($_GET['inicio']) && isset($_GET['fim'])){
    $inicio = $_GET['inicio'];
    $fim = $_GET['fim'];
  }  
  $data = array(
    'inicio' => $inicio,
    'fim' => $fim,
  );

  if (isset($_GET['showInactives'])) $showInactives = $_GET['showInactives'];
  if(isset($_GET['id'])) {
    $apiAnswer = select($conn, $_GET['id'], $showInactives);
  }else {
    $apiAnswer =  selectAll($conn, $showInactives, $data);
  }
echo json_encode($apiAnswer); 