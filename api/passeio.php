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
if (isset($_REQUEST['showInactives'])) $showInactives = $_REQUEST['showInactives'];
if(isset($_GET['id'])) {
  $apiAnswer = select($conn, $_REQUEST['id'], $showInactives);
}else {
  $apiAnswer =  selectAll($conn, $showInactives);
}
echo json_encode($apiAnswer); 