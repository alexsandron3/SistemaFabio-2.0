<?php
  include_once('../includes/header.php');
  require __DIR__.'/classes/Database.php';
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
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
      
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idPagamento=:idPagamento";
      
    }elseif(isset($_GET['idCliente'])){
      $bindValues['idCliente'] = $_GET['idCliente'];
      $fetch_favorites = "SELECT COUNT(p.nomePasseio) AS quantidade, nomePasseio as passeio FROM pagamento_passeio pp, passeio p where idCliente=:idCliente AND pp.idPasseio = p.idPasseio GROUP BY p.nomePasseio;";
      $stmt = $conn->prepare($fetch_favorites);
      $stmt->execute($bindValues);
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idCliente = :idCliente";
      $returnData = [
        "success" => 1,
        "message" => 'Pesquisa realizada com sucesso!',
        "favoritos" => $row
      ];
      // return print_r(json_encode($returnData));

    }elseif (isset($_GET['idCliente']) && isset($_GET['idPasseio'])){
      $bindValues['idCliente'] = $_GET['idCliente'];
      $bindValues['idPasseio'] = $_GET['idPasseio'];
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idCliente = :idCliente AND idPasseio = :idPasseio";
      // return print_r($fetch_pagamento);
    }elseif(isset($_GET['inicio']) && isset($_GET['fim'])) {
      $bindValues['inicio'] = $_GET['inicio'];
      $bindValues['fim'] = $_GET['fim'];
      $mostrarEncerrados = json_decode( $_GET['mostrarEncerrados']);
      $showCloseds = $mostrarEncerrados === true ? '' : 'AND statusPasseio NOT IN (0)';
      $fetch_pagamento = "SELECT idPasseio, nomePasseio, dataPasseio, lotacao, 0 AS confirmado, 0 AS crianca, 0 AS interessado, 0 as quitado FROM passeio WHERE dataPasseio BETWEEN :inicio AND :fim $showCloseds";
    }else {
      $fetch_pagamento = '';
      $returnData = msg(0, 422, 'Não encontrado');
    }
      $stmt = $conn->prepare($fetch_pagamento);

      try {

        $stmt->execute($bindValues);
  
        if($stmt->rowCount()){
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if($_GET["idCliente"]) {
            $returnData['pagamento'] = $row;
          }else {
            $returnData = [
              "success" => 1,
              "message" => 'Pesquisa realizada com sucesso!',
              "pagamento" => $row
            ];
          }
          
          if(isset($_GET['inicio']) && isset($_GET['fim']))
            foreach ($returnData['pagamento'] as $index => $value) {
              $fetch_pagamento = "SELECT pp.statusPagamento, COUNT(*) AS pagamentos FROM pagamento_passeio pp WHERE pp.idPasseio = {$value['idPasseio']} GROUP BY statusPagamento";
              $stmt1 = $conn->prepare($fetch_pagamento);
              $stmt1->execute();
              $response1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

              for ($i = 0; $i < count($response1); $i++) {
                if ($response1[$i]['statusPagamento'] == CLIENTE_INTERESSADO) $texto = 'interessado';
                if ($response1[$i]['statusPagamento'] == PAGAMENTO_QUITADO) $texto = 'quitado';
                if ($response1[$i]['statusPagamento'] == CLIENTE_CONFIRMADO) $texto = 'confirmado';
                if ($response1[$i]['statusPagamento'] == CLIENTE_PARCEIRO) $texto = 'parceiro';
                if ($response1[$i]['statusPagamento'] == CLIENTE_CRIANCA) $texto = 'crianca';
                $returnData['pagamento'][$index][$texto] = $response1[$i]['pagamentos'];
              }
            }
          
        }else {
          $returnData = msg(0, 422, 'Pagamento não encontrado!');
        }
      } catch (\Throwable $e) {
        $returnData = msg(0,500,$e->getMessage());
  
      }
    

  }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
      // Verifica se pagamento já existe

      $fetch_pagamento = "SELECT idPagamento FROM pagamento_passeio WHERE idPasseio=:idPasseio AND idCliente=:idCliente";
      $stmt = $conn->prepare($fetch_pagamento);
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->bindValue('idCliente', $data->idCliente, PDO::PARAM_STR);
      $stmt->execute();

      if($stmt->rowCount()){
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $returnData = [
          "success" => 2,
          "message" => 'Este cliente já realizou um pagamento para este passeio!',
          "pagamento" => $row
        ];
        return print_r(json_encode($returnData));
      }


      // Define status do pagamento
      $fetch_passeio = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio=:idPasseio";
      $stmt = $conn->prepare($fetch_passeio);
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $data->statusPagamento =  (statusPagamento($data->valorPendente, $data->valorPago, $data->idadeCliente, $row['idadeIsencao'], 
      $data->clienteParceiro));
      
      // Verifica quantidade de vaga
      $CLIENTE_INTERESSADO = CLIENTE_INTERESSADO;
      $CLIENTE_PARCEIRO    = CLIENTE_PARCEIRO;
      $fetch_quantidadeVagas = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=:idPasseio AND statusPagamento NOT IN ({$CLIENTE_INTERESSADO},{$CLIENTE_PARCEIRO})";
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      $rowStatusPagamento = $stmt->fetch(PDO::FETCH_ASSOC);
      
      // Cadastra o pagamento
      unset($data->idadeCliente);
      $add_pagamento = "INSERT INTO pagamento_passeio (
        idCliente,
        idPasseio,
        valorPago,
        valorVendido,
        taxaPagamento,
        valorPendente,
        seguroViagem,
        clienteParceiro,
        valorcontrato,
        numeroVagas,
        opcionais,
        previsaoPagamento,
        localEmbarque,
        transporte,
        anotacoes,
        historicoPagamento,
        clienteDesistente,
        statusPagamento,
        createdAt
      ) 
      VALUES (    
        :idCliente,
        :idPasseio,
        :valorPago,
        :valorVendido,
        :taxaPagamento,
        :valorPendente,
        :seguroViagem,
        :clienteParceiro,
        :valorcontrato,
        :numeroVagas,
        :opcionais,
        :previsaoPagamento,
        :localEmbarque,
        :transporte,
        :anotacoes,
        :historicoPagamento,
        :statusPagamento,
        :clienteDesistente,
        NOW()
      )";
        $stmt = $conn->prepare($add_pagamento);
        if($stmt->execute((array) $data)) {
          $returnData = [
            "success" => 1,
            "message" => 'Pagamento realizado com sucesso!',
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
  }elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    
    // Define status do pagamento
    $fetch_passeio = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio=:idPasseio";
    $stmt = $conn->prepare($fetch_passeio);
    $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $data->statusPagamento =  (statusPagamento(
      $data->valorPendente,
      $data->valorPago,
      $data->idadeCliente,
      $row['idadeIsencao'],
      $data->clienteParceiro
    ));
    
    // Verifica quantidade de vaga
    $CLIENTE_INTERESSADO = CLIENTE_INTERESSADO;
    $CLIENTE_PARCEIRO    = CLIENTE_PARCEIRO;
    $fetch_quantidadeVagas = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=:idPasseio AND statusPagamento NOT IN ({$CLIENTE_INTERESSADO},{$CLIENTE_PARCEIRO})";
    $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
    $stmt->execute();
    $rowStatusPagamento = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Atualiza o pagamento 
    
    unset($data->idadeCliente);
    unset($data->idPasseio);
    // return print_r(json_encode($data));
    $update_pagamento = "UPDATE 
      pagamento_passeio SET 
      valorPago=:valorPago,
      valorVendido=:valorVendido,
      taxaPagamento=:taxaPagamento,
      valorPendente=:valorPendente,
      seguroViagem=:seguroViagem,
      clienteParceiro=:clienteParceiro,
      valorContrato=:valorContrato,
      numeroVagas=:numeroVagas,
      opcionais=:opcionais,
      previsaoPagamento=:previsaoPagamento,
      localEmbarque=:localEmbarque,
      transporte=:transporte,
      anotacoes=:anotacoes,
      historicoPagamento=:historicoPagamento,
      clienteDesistente=:clienteDesistente,
      dataPagamento=:dataPagamento,
      ordemPoltrona=:ordemPoltrona,
      statusPagamento=:statusPagamento
      WHERE idPagamento=:idPagamento";

    $stmt = $conn->prepare($update_pagamento);
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


