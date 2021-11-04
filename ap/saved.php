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
  $query = ' AND statusPasseio NOT IN (0) ';
  $types = "";
  $params = [];
  if(isset($_GET['exibirEncerrados'])) {
    $exibirEncerrados = $_GET['exibirEncerrados'];
    if($exibirEncerrados == true) $query = '' ;
  }
  if (isset($_GET['inicio']) && isset($_GET['fim'])){
    $dataInicio = $_GET['inicio'];
    $dataFim = $_GET['fim'];
    $query .= 'AND dataPasseio BETWEEN ? AND ?';
    $types .= 'ss';
    $params[] = $_GET['inicio'];
    $params[] = $_GET['fim'];
  }
  

  $queryListaPasseio = "SELECT idPasseio, nomePasseio, dataPasseio, lotacao, 0 as confirmado, 0 as crianca, 0 as interessado, 0 as parceiro, 0 as quitado FROM passeio WHERE 1 $query";
  if(strlen($types) > 0) {
    $stmt = $conn->prepare($queryListaPasseio);
    $stmt->bind_param($types, ...$params);
    $response = executeSelect($stmt);
  }else {
    $stmt = $conn->prepare($queryListaPasseio);
    $response = executeSelect($stmt);

  }
  $apiAnswer = $response;


  $apiAnswer['passeios'] = $response['serverResponse']['sql']->fetch_all(MYSQLI_ASSOC);

  foreach ($apiAnswer['passeios'] as $key => $value) {

    $id = $value['idPasseio'];
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