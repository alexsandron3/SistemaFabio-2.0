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
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  if(isset($_GET['inicio']) && isset($_GET['fim'])) {
    $bindValues['inicio'] = $_GET['inicio'];
    $bindValues['fim'] = $_GET['fim'];

    $query = "SELECT pp.idPagamento, p.nomePasseio, p.dataPasseio, u.userName FROM pagamento_passeio pp, passeio p, users u WHERE pp.dataPagamentoEfetuado BETWEEN :inicio AND :fim AND pp.createdBy = u.id";

  };
  $stmt = $conn->prepare($query);
  try {
    $stmt->execute($bindValues);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $returnData = [
      "success" => 1,
      "message" => 'Pesquisa realizada com sucesso!',
      "pagamento" => $row
    ];
  } catch (\Throwable $e) {
    $returnData = msg(0,500,$e->getMessage());
  }
}else {
  $returnData = [
    "success" => 0,
    "message" => 'Método inválido',
  ];
}
echo json_encode($returnData);
