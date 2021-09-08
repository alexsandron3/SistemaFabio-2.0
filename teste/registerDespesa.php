<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");


if (isset($_REQUEST['value'])) {
  $values = $_REQUEST['value'];
  parse_str($_REQUEST['value'], $formData);
  // print_r($formData);
  $columns = '';
  $sqlValue = '';
  $params = '';
  foreach ($formData as $key => $value) {
    if ($key !== 'totalDespesas') {
      $columns .= $key . ' ,';
      $sqlValue .= '?, ';
    } else {
      $columns .= $key;
      $sqlValue .= '?';
    }
    
  }
  
  $sql = "INSERT INTO 
  despesa ($columns)
  VALUES   ($sqlValue)";
  $apiAnswer = array();

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii',  $formData['idPasseio'], $formData['valorAereo'], $formData['quantidadeAereo'], $formData['valorAlmocoCliente'], $formData['quantidadeAlmocoCliente'], $formData['valorAlmocoMotorista'], $formData['quantidadeAlmocoMotorista'], $formData['valorAutorizacaoTransporte'], $formData['quantidadeAutorizacaoTransporte'], $formData['valorEscuna'], $formData['quantidadeEscuna'], $formData['valorEstacionamento'], $formData['quantidadeEstacionamento'], $formData['valorGuia'], $formData['quantidadeGuia'], $formData['valorHospedagem'], $formData['quantidadeHospedagem'], $formData['valorImpulsionamento'], $formData['quantidadeImpulsionamento'], $formData['valorIngresso'], $formData['quantidadeIngresso'], $formData['valorKitLanche'], $formData['quantidadeKitLanche'], $formData['valorMarketing'], $formData['quantidadeMarketing'], $formData['valorMicro'], $formData['quantidadeMicro'], $formData['valorOnibus'], $formData['quantidadeOnibus'], $formData['valorPulseira'], $formData['quantidadePulseira'], $formData['valorSeguroViagem'], $formData['quantidadeSeguroViagem'], $formData['valorServicos'], $formData['quantidadeServicos'], $formData['valorTaxi'], $formData['quantidadeTaxi'], $formData['valorVan'], $formData['quantidadeVan'], $formData['outros'], $formData['totalDespesas']);
    $response = executeInsert($stmt);
    $apiAnswer['serverStatus'] = $response;
    $apiAnswer['serverStatus']['msg'] = 'Despesa cadastrada com sucesso!';
  } else {
    $apiAnswer['serverStatus']['msg'] = 'Erro Interno!';
  }
}

  // echo json_encode($columns);
  print_r(json_encode($apiAnswer));
