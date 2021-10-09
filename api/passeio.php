<?php
include_once("../includes/header.php");
include_once("passeio/selectAll.php");
include_once("passeio/select.php");
// required headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$apiAnswer = array();
if(isset($_GET['id'])) {
  // $response['response']['showInactives'] = 0;
  if(isset($_GET['showInactives'])) $response['response']['showInactives'] = $_REQUEST['showInactives'];
  $apiAnswer = select($conn, $_REQUEST['id']);
}else {
  $apiAnswer =  selectAll($conn);
  // print_r($answer);
}
// echo dirname(__DIR__)."/includes/header.php";
echo json_encode($apiAnswer); 