<?php
  include_once('../includes/header.php');
  require __DIR__.'/classes/Database.php';
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
  header('Access-Control-Allow-Origin: *');


  $db_connection = new Database();
  $conn = $db_connection->dbConnection();
  $data = json_decode(file_get_contents("php://input"));
  // return print_r(json_encode($data));
  $returnData = [];

  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['id'])){
      // if()
      $fetch_passeio = "SELECT * FROM passeio WHERE idPasseio = :wordToSearch";
      $stmt = $conn->prepare($fetch_passeio);
      $wordToSearch = $_GET['id'];
    }else{
      if(isset($_GET['pesquisarPasseio'])){
        $wordToSearch = "%{$_GET['pesquisarPasseio']}%";
      }else{
        $wordToSearch = "% %";
      }
      $mostrarEncerrados = json_decode($_GET['mostrarEncerrados']);
      $queryMostrarEncerrados = $mostrarEncerrados === true ? '' : 'AND statusPasseio NOT IN (0)';
      $fetch_passeio = "SELECT * FROM passeio WHERE nomePasseio LIKE :wordToSearch $queryMostrarEncerrados OR localPasseio LIKE :wordToSearch $queryMostrarEncerrados OR idPasseio LIKE :wordToSearch $queryMostrarEncerrados OR dataPasseio LIKE :wordToSearch $queryMostrarEncerrados";
      $stmt = $conn->prepare($fetch_passeio);
    }
      try {
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
    

  }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
      $verify_passeio = "SELECT nomePasseio, dataPasseio, idPasseio FROM passeio WHERE nomePasseio = :nomePasseio AND dataPasseio = :dataPasseio";
      $stmt = $conn->prepare($verify_passeio);
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
  }elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($data->idPasseio) && isset($data->statusPasseio) && count((array)$data) === 2){
      $update_passeio = "UPDATE passeio SET statusPasseio=:statusPasseio WHERE idPasseio=:idPasseio";
      
    } else {
      $update_passeio = "UPDATE passeio SET anotacoes=:anotacoes, dataLancamento=:dataLancamento, dataPasseio=:dataPasseio, idadeIsencao=:idadeIsencao , itensPacote=:itensPacote ,localPasseio=:localPasseio ,lotacao=:lotacao ,nomePasseio=:nomePasseio ,prazoVigencia=:prazoVigencia ,statusPasseio=:statusPasseio ,valorPasseio=:valorPasseio WHERE idpasseio=:idPasseio";
    }
    $stmt = $conn->prepare($update_passeio);
    $stmt->execute((array) $data);
    if($stmt->rowCount()){
      $returnData = [
        "success" => 1,
        "message" => 'Atualização realizada com sucesso!',
      ];
    }else{
      $returnData = [
        "success" => 0,
        "message" => 'Alterações não realizadas, tente novamente ou entre em contato com o suporte!',
      ];
    }
  } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $idPasseio = $data->idPasseio;
  try {
    // Verificando se existe algum pagamento
    $buscarPagamentos = "SELECT idPagamento FROM pagamento_passeio WHERE idPasseio =:idPasseio";
    $stmt = $conn->prepare($buscarPagamentos);
    $stmt->bindValue('idPasseio', $idPasseio, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount()) {
      $returnData = [
        "success" => 2,
        "message" => 'Este passeio não pôde ser deletado pois existem pagamentos inclusos nele!',
      ];

    }else{
      // Deletando despesa
      $deletarDespesa = "DELETE FROM despesa WHERE idPasseio=:idPasseio";
      $stmt = $conn->prepare($deletarDespesa);
      $stmt->bindValue('idPasseio', $idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      // Deletando passeio
      $deletarPasseio = "DELETE FROM passeio WHERE idPasseio=:idPasseio";
      $stmt = $conn->prepare($deletarPasseio);
      $stmt->bindValue('idPasseio', $idPasseio, PDO::PARAM_STR);
      $stmt->execute();
    
      if ($stmt->rowCount()) {
        $returnData = [
          "success" => 1,
          "message" => 'Passeio deletado com sucesso!',
        ];
      } else {
        $returnData = [
          "success" => 0,
          "message" => 'Alterações não realizadas, tente novamente ou entre em contato com o suporte!',
        ];
      }
    }
  } catch (\Throwable $e) {
    $returnData = msg(0, 500, $e->getMessage());
  }
}

  echo json_encode($returnData);


