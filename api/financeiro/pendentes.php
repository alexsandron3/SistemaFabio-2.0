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
$interessado = CLIENTE_INTERESSADO;
$quitado = PAGAMENTO_QUITADO;
$confimado = CLIENTE_CONFIRMADO;
$parceiro = CLIENTE_PARCEIRO;
$crianca = CLIENTE_CRIANCA;
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  $query =  "SELECT  c.nomeCliente, c.idCliente, c.referencia, pp.anotacoes , pp.idPagamento, pp.valorPendente, pp.previsaoPagamento, pp.statusPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio FROM  pagamento_passeio pp, cliente c, passeio p  WHERE statusPagamento NOT IN ({$quitado}) AND valorPendente < 0 AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio";
  $stmt = $conn->prepare($query);

  try {
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $returnData = [
      "success" => 1,
      "message" => 'Pesquisa realizada com sucesso',
      "pagamento" => $row
    ];
  } catch (\Throwable $e) {
    $returnData = msg(0, 500, $e->getMessage());
  }
}else {
  $returnData = [
    "success" => 0,
    "message" => 'Método inválido'
  ];
}

echo json_encode($returnData);