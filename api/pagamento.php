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
  $query = '';
  $types = "";
  $params = [];
  if (isset($_GET['inicio']) && isset($_GET['fim'])){
    $inicio = $_GET['inicio'];
    $fim = $_GET['fim'];
    $query .= 'AND dataPasseio BETWEEN ? AND ?';
    $types .= 'ss';
    $params[] = $_GET['inicio'];
    $params[] = $_GET['fim'];
  }  

  $passeioId = "SELECT idPasseio, nomePasseio, dataPasseio, lotacao, 0 as confirmado, 0 as crianca, 0 as interessado, 0 as parceiro, 0 as quitado FROM passeio WHERE 1 $query";
  if(strlen($types) > 0) {
    $stmt = $conn->prepare($passeioId);
    $stmt->bind_param($types, ...$params);
    $response = executeSelect($stmt);
  }else {
    $stmt = $conn->prepare($passeioId);
    $response = executeSelect($stmt);

  }
  $apiAnswer = $response;

  // while ($row = ) {
  //   // $id = $row;
  // }
  $apiAnswer['passeios'] = $response['serverResponse']['sql']->fetch_all(MYSQLI_ASSOC);
  // while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
  //   // $id = $row;
  //   $apiAnswer['passeio'][] = $row;
  // }
  foreach ($apiAnswer['passeios'] as $key => $value) {
    // print_r($value['idPasseio']);
    $id = $value['idPasseio'];
    // print_r($row);
    $query = "SELECT pp.statusPagamento, COUNT(*) AS pagamentos FROM pagamento_passeio pp WHERE pp.idPasseio = $id GROUP BY statusPagamento";
    $stmt1 = $conn->prepare($query);
    $response1 = executeSelect($stmt1);
    while($result = $response1['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
      if ($result['statusPagamento'] === CLIENTE_INTERESSADO) $texto = 'interessado';
      if ($result['statusPagamento'] === CLIENTE_CONFIRMADO) $texto = 'confirmado';
      if ($result['statusPagamento'] === PAGAMENTO_QUITADO) $texto = 'quitado';
      if ($result['statusPagamento'] === CLIENTE_PARCEIRO) $texto = 'parceiro';
      if ($result['statusPagamento'] === CLIENTE_CRIANCA) $texto = 'crianca';
      
      $apiAnswer['passeios'][$key][$texto] = $result['pagamentos'];

    }
  }

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
$apiAnswer['serverResponse']['execTime'] = $execution_time;

echo json_encode($apiAnswer);