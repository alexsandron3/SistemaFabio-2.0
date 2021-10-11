<?php
  include_once("../includes/header.php");
  // include_once("pagamento/selectAll.php");
  include_once("pagamento/select.php");
  include_once("pagamento/countStatus.php");
  // required headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  $apiAnswer = array();
  $time_start = microtime(true);

  // $showInactives = 0;
  // $inicio = null;
  // $fim = null;
  // if (isset($_GET['inicio']) && isset($_GET['fim'])){
  //   $inicio = $_GET['inicio'];
  //   $fim = $_GET['fim'];
  // }  
  // $data = array(
  //   'inicio' => $inicio,
  //   'fim' => $fim,
  // );

  // if (isset($_GET['showInactives'])) $showInactives = $_GET['showInactives'];
  // if(isset($_GET['id'])) {
  //   $apiAnswer = select($conn, $_GET['id'], $showInactives);
  // }else {
  //   $apiAnswer =  selectAll($conn, $showInactives, $data);
  // }
  // $apiAnswer = countStatus($conn, $_GET['id']);
  $passeioId = "SELECT idPasseio, nomePasseio, dataPasseio, lotacao FROM passeio";
  $stmt = $conn->prepare($passeioId);
  $response = executeSelect($stmt);
  $apiAnswer = $response;

  // while ($row = ) {
  //   // $id = $row;
  // }
  $apiAnswer['passeio'] = $response['serverResponse']['sql']->fetch_all(MYSQLI_ASSOC);
  // while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
  //   // $id = $row;
  //   $apiAnswer['passeio'][] = $row;
  // }
  foreach ($apiAnswer['passeio'] as $key => $value) {
    // print_r($value['idPasseio']);
    $id = $value['idPasseio'];
    // print_r($row);
    $query = "SELECT pp.statusPagamento, COUNT(*) AS pagamentos FROM pagamento_passeio pp WHERE pp.idPasseio = $id GROUP BY statusPagamento";
    $stmt1 = $conn->prepare($query);
    $response1 = executeSelect($stmt1);
    while($result = $response1['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
      $apiAnswer['passeio'][$key]['pagamentos'][] = $result;

    }
  }

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
$apiAnswer['serverResponse']['execTime'] = $execution_time;

echo json_encode($apiAnswer);