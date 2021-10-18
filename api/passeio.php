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
  // return print_r(json_encode($data));
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
          "passeio" => $row
        ];
      }else {
        $returnData = msg(0, 422, 'Passeio não encontrado!');
      }
    } catch (\Throwable $e) {
      $returnData = msg(0,500,$e->getMessage());

    }

  }else{
    // echo gettype();
    try {
      $verify_passeio = "SELECT nomePasseio, dataPasseio, idPasseio FROM passeio WHERE nomePasseio = :nomePasseio AND dataPasseio = :dataPasseio";
      $stmt = $conn->prepare($verify_passeio);
      // $nomePasseio = $data->nomePasseio;
      // $dataPasseio = $data->dataPasseio;
      $stmt->bindValue(':nomePasseio', $data->nomePasseio, PDO::PARAM_STR);
      $stmt->bindValue(':dataPasseio', $data->dataPasseio, PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount()){
        $returnData = [
          "success" => 0,
          "message" => 'Já existe uma passeio na mesma DATA com o mesmo NOME!',
        ];
      }else{

        $add_passeio = "INSERT INTO passeio (anotacoes, dataLancamento, dataPasseio ,idadeIsencao, itensPacote, localPasseio, lotacao, nomePasseio, prazoVigencia, statusPasseio, valorPasseio) VALUES (:anotacoes, :dataLancamento, :dataPasseio, :idadeIsencao, :itensPacote, :localPasseio, :lotacao, :nomePasseio, :prazoVigencia, :statusPasseio, :valorPasseio)";
        $stmt = $conn->prepare($add_passeio);
        if($stmt->execute((array) $data)) {
          $returnData = [
            "success" => 1,
            "message" => 'Cadastro realizado com sucesso!',
          ];
        }else{
          $returnData = [
            "success" => 1,
            "message" => 'Hove um erro!',
          ];
        }
      }
    } catch (\Throwable $e) {
      $returnData = msg(0,500,$e->getMessage());

    }
    // return json_encode($returnData);

  }

  echo json_encode($returnData);


