<?php
  include_once('../includes/header.php');
  require __DIR__.'/classes/Database.php';
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: GET, POST, UPDATE');
  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
  header('Access-Control-Allow-Origin: *');


  $db_connection = new Database();
  $conn = $db_connection->dbConnection();
  $data = json_decode(file_get_contents("php://input"));
  // return print_r(json_encode($data));
  $returnData = [];
  $bindValues = array();
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['idPagamento'])){
      $bindValues['idPagamento'] = $_GET['idPagamento'];
      
      $fetch_pagamento = "SELECT * FROM pagamento WHERE idPagamento = :idPagamento";
      $stmt = $conn->prepare($fetch_pagamento);
      
    }elseif (isset($_GET['idCliente']) && isset($_GET['idPasseio'])){
      $bindValues['idCliente'] = $_GET['idCliente'];
      $bindValues['idPasseio'] = $_GET['idPasseio'];
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idCliente = :idCliente AND idPasseio = :idPasseio";
      // return print_r($fetch_pagamento);
    }
      $stmt = $conn->prepare($fetch_pagamento);

      try {

        $stmt->execute($bindValues);
  
        if($stmt->rowCount()){
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $returnData = [
            "success" => 1,
            "message" => 'Pesquisa realizada com sucesso!',
            "pagamento" => $row
          ];
        }else {
          $returnData = msg(0, 422, 'Pagamento não encontrado!');
        }
      } catch (\Throwable $e) {
        $returnData = msg(0,500,$e->getMessage());
  
      }
    

  }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    // return print_r(json_encode($data));
    try {
      $fetch_passeio = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio=:idPasseio";
      $stmt = $conn->prepare($fetch_passeio);
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $data->statusPagamento =  (statusPagamento($data->valorPendente, $data->valorPago, $data->idadeCliente, $row['idadeIsencao'], 
      $data->clienteParceiro));
      // return print_r(json_encode($data->statusPagamento));
      
      /* $returnData = [
        "success" => 1,
        "message" => 'Pesquisa realizada com sucesso!',
        "passeio" => $row['lotacao']
      ];
      return  print_r(json_encode($returnData)); */
      
      unset($data->idadeCliente);
      $add_pagamento = "INSERT INTO pagamento_passeio (
        valorVendido,
        valorPago,
        valorPendente,
        taxaPagamento,
        previsaoPagamento,
        localEmbarque,
        transporte,
        opcionais,
        anotacoes,
        seguroViagem,
        clienteParceiro,
        valorContrato,
        clienteDesistente,
        historicoPagamento,
        idCliente,
        idPasseio,
        statusPagamento,
        createdAt
      ) 
      VALUES (    
        :valorVendido,
        :valorPago,
        :valorPendente,
        :taxaPagamento,
        :previsaoPagamento,
        :localEmbarque,
        :transporte,
        :opcionais,
        :anotacoes,
        :seguroViagem,
        :clienteParceiro,
        :valorContrato,
        :clienteDesistente,
        :historicoPagamento,
        :idCliente,
        :idPasseio,
        :statusPagamento,
        NOW()
      )";
        $stmt = $conn->prepare($add_pagamento);
        if($stmt->execute((array) $data)) {
          $returnData = [
            "success" => 1,
            "message" => 'Cadastro realizado com sucesso!',
          ];
        }else{
          $returnData = [
            "success" => 1,
            "message" => 'Hove um erro, tente novamente ou entre em contato com o suporte!',
          ];
        }
      
    } catch (\Throwable $e) {
      $returnData = msg(0,500,$e->getMessage());

    }
  }elseif ($_SERVER['REQUEST_METHOD'] === 'UPDATE') {
    $update_passeio = "UPDATE passeio SET anotacoes=:anotacoes, dataLancamento=:dataLancamento, dataPasseio=:dataPasseio, idadeIsencao=:idadeIsencao , itensPacote=:itensPacote ,localPasseio=:localPasseio ,lotacao=:lotacao ,nomePasseio=:nomePasseio ,prazoVigencia=:prazoVigencia ,statusPasseio=:statusPasseio ,valorPasseio=:valorPasseio WHERE idpasseio=:idPasseio";
  // return print_r(json_encode($data));

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

  }

  echo json_encode($returnData);


