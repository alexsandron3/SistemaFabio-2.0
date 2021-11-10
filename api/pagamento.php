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
      
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idPagamento = :idPagamento";
      $stmt = $conn->prepare($fetch_pagamento);
      
    }elseif (isset($_GET['idCliente']) && isset($_GET['idPasseio'])){
      $bindValues['idCliente'] = $_GET['idCliente'];
      $bindValues['idPasseio'] = $_GET['idPasseio'];
      $fetch_pagamento = "SELECT * FROM pagamento_passeio WHERE idCliente = :idCliente AND idPasseio = :idPasseio";
      // return print_r(json_encode($_GET['idPasseio']));
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
      // Define status do pagamento
      $fetch_passeio = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio=:idPasseio";
      $stmt = $conn->prepare($fetch_passeio);
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $idadeIsencao = $row['idadeIsencao'];
      $lotacao = $row['lotacao'];
      
      $data->statusPagamento =  (statusPagamento($data->valorPendente, $data->valorPago, $data->idadeCliente, $idadeIsencao, 
      $data->clienteParceiro));

      // Verifica se cliente já realizou pagamento
      $response = file_get_contents("http://localhost/SistemaFabio-2.0/api/pagamento.php?idCliente={$data->idCliente}&idPasseio={$data->idPasseio}");
      $response = json_decode($response);
        // return print_r(json_encode($response));
      if($response->success === 1) {
        $returnData = [
          "success" => 0,
          "message" => 'Este cliente já tem um pagamento para este passeio!',
        ];
        return print_r(json_encode($returnData));
      }

      // Verifica quantidade de vaga
      $CLIENTE_INTERESSADO = CLIENTE_INTERESSADO;
      $CLIENTE_PARCEIRO    = CLIENTE_PARCEIRO;
      $fetch_quantidadeVagas = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=:idPasseio AND statusPagamento NOT IN ({$CLIENTE_INTERESSADO},{$CLIENTE_PARCEIRO})";
      $stmt = $conn->prepare($fetch_quantidadeVagas);
      $stmt->bindValue('idPasseio', $data->idPasseio, PDO::PARAM_STR);
      $stmt->execute();
      $qtdConfirmados = $stmt->rowCount();
      $alertaVagasRestantes = $lotacao * PORCENTAGEM_VAGAS_OCUPADAS;
      $vagasRestantes = ($lotacao - $qtdConfirmados) - VAGA_ATUAL;
      
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
        dataPagamento,
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
        NOW(),
        NOW()
      )";
      if($lotacao <= $qtdConfirmados) {
        $returnData = [
          "success" => 0,
          "message" => "Limite de vagas atingido!",
          "opa1" => $lotacao,
          "opa" => $qtdConfirmados,
        ];
      }elseif($lotacao > $qtdConfirmados) {
        $stmt = $conn->prepare($add_pagamento);
        if($stmt->execute((array) $data)) {
            if($data->statusPagamento === CLIENTE_INTERESSADO  || $data->statusPagamento === CLIENTE_CRIANCA) {
              $vagasRestantes = $lotacao - $qtdConfirmados;
            }
          if(($qtdConfirmados + VAGA_ATUAL) >= $lotacao) {
            $returnData = [
              "success" => 2,
              "message" => 'Cadastro realizado com sucesso! LIMITE DE VAGAS ATINGIDO!',
              "left" => "Existem apenas $vagasRestantes vagas disponíveis"
            ];
          }else {
            $returnData = [
              "success" => 1,
              "message" => 'Cadastro realizado com sucesso!',
              "left" => "Existem apenas $vagasRestantes vagas disponíveis"
            ];
          }
        }else{
          $returnData = [
            "success" => 1,
            "message" => 'Hove um erro, tente novamente ou entre em contato com o suporte!',
          ];
        }
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


