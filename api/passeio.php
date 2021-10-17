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
    if(isset($_GET['pesquisarPasseio'])){
      $wordToSearch = "%{$_GET['pesquisarPasseio']}%";
    }else{
      $wordToSearch = "% %";

    }

    try {
      $fetch_passeio = "SELECT * FROM passeio WHERE nomePasseio LIKE :wordToSearch OR localPasseio LIKE :wordToSearch OR idPasseio LIKE :wordToSearch";
      $stmt = $conn->prepare($fetch_passeio);
      $stmt->bindValue(':wordToSearch', $wordToSearch, PDO::PARAM_STR);
      $stmt->execute();

      if($stmt->rowCount()){
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $returnData = [
          "success" => 1,
          "message" => 'Pesquisa realizada com sucesso!',
          "usuario" => $row
        ];
      }else {
        $returnData = msg(0, 422, 'Passeio não encontrado!');
      }
    } catch (\Throwable $e) {
      $returnData = msg(0,500,$e->getMessage());

    }

  }else{
    return json_encode(print_r('AAAABBB'));

  }

  echo json_encode($returnData);


