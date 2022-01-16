<?php
include_once('../../includes/header.php');
require __DIR__ . '/../classes/Database.php';
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Origin: *');

$db_connection = new Database();
$conn = $db_connection->dbConnection();
$data = json_decode(file_get_contents("php://input"));
$allHeaders = getallheaders();
$auth = new Auth($conn, $allHeaders);
$Auth = $auth->isValid();
if (!$Auth['success']) {
  echo json_encode($auth->isValid());
  $conn = null;
  exit();
  return 0;
}
$returnData = [];
$bindValues = array();
$query = '';
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['inicio']) && isset($_GET['fim'])) {
    $bindValues['inicio'] = $_GET['inicio'];
    $bindValues['fim'] = $_GET['fim'];
    // Valor pendente, taxas de pagamento, valor pago
    $queryValorPendenteTaxasPago = "SELECT COALESCE(ABS(SUM(pp.valorPendente)), 0) AS pendente, COALESCE(SUM(pp.taxaPagamento), 0) AS taxasDePagamento, COALESCE(SUM(pp.valorPago), 0) AS recebimentos, COALESCE(COUNT(pp.idPagamento), 0) AS pagantes FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio = p.idPasseio AND p.dataPasseio BETWEEN :inicio AND :fim AND PP.statusPagamento NOT IN(0)";

    // Total despesas
    $queryTotalDespesas = "SELECT COALESCE(SUM(d.totalDespesas), 0) as totalDespesas FROM despesa d, passeio p WHERE p.dataPasseio BETWEEN :inicio AND :fim AND p.idPasseio = d.idPasseio";

    //  Valor médio vendido e quantidade de clientes
    $queryValorMedioVendidoQtdClientes = " SELECT COALESCE(AVG(valorVendido), 0) AS valorMedioVendido FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio = p.idPasseio AND p.dataPasseio BETWEEN :inicio AND :fim AND statusPagamento NOT IN(0, 3) ORDER BY createdAt";
    $stmt = $conn->prepare($queryValorPendenteTaxasPago);

    // Pagamentos
    $queryPagamentos = "SELECT p.dataPasseio, pp.idPagamento, pp.valorPago, pp.valorVendido  FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio = p.idPasseio AND p.dataPasseio BETWEEN :inicio AND :fim AND PP.statusPagamento NOT IN(0)";

    try {
      // Valor pendente, taxas de pagamento, valor pago
      $stmt->execute($bindValues);
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $returnData = [
        "success" => 1,
        "message" => 'Pesquisa realizada com sucesso',
        "resultado" => array(
          $row[0],
        )
      ];
      // Total despesas, lucro estimado, lucro real
      $stmt = $conn->prepare($queryTotalDespesas);
      $stmt->execute($bindValues);
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // Calculos
      $returnData['resultado'][0]['totalDespesas'] = $row[0]['totalDespesas'];
      $pendente = $returnData['resultado'][0]['pendente'];
      $recebimentos = $returnData['resultado'][0]['recebimentos'];
      $totalDespesas = $returnData['resultado'][0]['totalDespesas'];
      $lucroEstimado = ($pendente + $recebimentos) - $totalDespesas;
      $lucroReal = $recebimentos - $totalDespesas;
      $returnData['resultado'][0]['lucroEstimado'] = $lucroEstimado;
      $returnData['resultado'][0]['lucroReal'] = $lucroReal;
  
      // Valor médio vendido
      $stmt = $conn->prepare($queryValorMedioVendidoQtdClientes);
      $stmt->execute($bindValues);
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $returnData['resultado'][0]['valorMedioVendido'] = $row[0]['valorMedioVendido'];

      // Pagamentos 
      $stmt = $conn->prepare($queryPagamentos);
      $stmt->execute($bindValues);
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $returnData['resultado'][0]['pagamentos'] = $row;
  
      
  
    } catch (\Throwable $e) {
      $returnData = msg(0,500, $e->getMessage());
    }
  }elseif(isset($_GET['quantidadeMeses']) && isset($_GET['anoFinal'])) {
    $quantidadeMeses = $_GET['quantidadeMeses'];
    // for ($i=1; $i <= $quantidadeMeses ; $i++) { 
    //   $ano = $_GET['anoFinal'];
    //   $mes = $i < 10 ? "0$i" : $i;
    //   $dia = $i == $quantidadeMeses ? '31' : '1';
    //   $fullDate = "{$ano}-{$mes}-01";


    //   // echo $fullDate. PHP_EOL;
    //   $query =  "SELECT SUM(valorVendido), SUM(valorPago) FROM pagamento_passeio WHERE createdAt >= NOW() - INTERVAL 11 MONTH";
    //   // $query =  "SELECT * FROM pagamento_passeio WHERE createdAt = :ano-$mes";
    //   echo $query. PHP_EOL;
    // }
  }
}else {
  $returnData = [
    "success" => 0,
    "message" => "Método inválido"
  ];
}
echo json_encode($returnData);
