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
// return print_r(json_encode($data));
$returnData = [];
$bindValues = array();
$query = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $query = "SELECT pp.historicoPagamento, pp.idPagamento, c.nomeCliente, c.referencia, p.nomePasseio, p.dataPasseio FROM pagamento_passeio pp, cliente c, passeio p WHERE pp.idCliente=c.idCliente AND pp.idPasseio=p.idPasseio AND historicoPagamento REGEXP '\r\n' AND statusPagamento NOT IN(0)";

  $stmt = $conn->prepare($query);
  try {
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $returnData = [
      "success" => 1,
      "message" => 'Pesquisa realizada com sucesso',
      "pagamento" => $row,
    ];
  } catch (\Throwable $e) {
    $returnData = msg(0, 500, $e->getMessage());
  }
} else {
  $returnData = [
    "success" => 0,
    "message" => "Método inválido"
  ];
}
echo json_encode($returnData);
