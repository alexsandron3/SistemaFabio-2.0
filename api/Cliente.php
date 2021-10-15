<?php
  include_once('../includes/header.php');
  require __DIR__.'/classes/Database.php';
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
  header('Access-Control-Allow-Origin: *');


  $db_connection = new Database();
  $conn = $db_connection->dbConnection();
  $data = json_decode(file_get_contents("php://input"));
  $returnData = [];

  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['pesquisarCliente'])){
      $userToSearch = "%{$_GET['pesquisarCliente']}%";
    }else{
      $userToSearch = "% %";

    }

    try {
      $fetch_cliente = "SELECT * FROM cliente WHERE idCliente LIKE :userToSearch OR nomeCliente LIKE :userToSearch OR cpfCliente LIKE :userToSearch OR telefoneCliente LIKE :userToSearch OR referencia LIKE :userToSearch";
      $stmt = $conn->prepare($fetch_cliente);
      $stmt->bindValue(':userToSearch', $userToSearch, PDO::PARAM_STR);
      $stmt->execute();

      if($stmt->rowCount()){
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $returnData = [
          "success" => 1,
          "message" => 'Pesquisar realizada com sucesso!',
          "usuario" => $row
        ];
      }else {
        $returnData = msg(0, 422, 'Usuário não encontrado!');
      }
    } catch (\Throwable $e) {
      $returnData = msg(0,500,$e->getMessage());

    }

  }else{
    return json_encode(print_r('AAAABBB'));

  }

  echo json_encode($returnData);


