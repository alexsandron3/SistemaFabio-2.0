<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");

if(isset($_REQUEST['value'])){
  parse_str($_REQUEST['value'], $searcharray);  
  $nomeCliente = $searcharray['nomeCliente']; 
  $emailCliente = $searcharray['emailCliente']; 
  $rgCliente = $searcharray['rgCliente']; 
  $orgaoEmissor = $searcharray['orgaoEmissor']; 
  $cpfCliente = $searcharray['cpfCliente']; 
  $telefoneCliente = $searcharray['telefoneCliente']; 
  $dataNascimento = $searcharray['dataNascimento']; 
  $idadeCliente = $searcharray['idadeCliente']; 
  $estadoCivil = $searcharray['estadoCivil']; 
  $profissao = $searcharray['profissao']; 
  $nacionalidade = $searcharray['nacionalidade'];
  $poltrona = $searcharray['poltrona']; 
  $cpfConsultado = $searcharray['cpfConsultado']; 
  $dataCpfConsultado = $searcharray['dataCpfConsultado']; 
  $enderecoCliente = $searcharray['enderecoCliente']; 
  $referencia = $searcharray['referencia']; 
  $telefoneContato = $searcharray['telefoneContato']; 
  $pessoaContato = $searcharray['pessoaContato']; 
  $redeSocial = $searcharray['redeSocial']; 
  $statusCliente = 1; 
  $clienteRedeSocial = $searcharray['clienteRedeSocial']; 

  $sqlRegisterUser = "INSERT INTO cliente (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente,dataNascimento, idadeCliente, cpfConsultado, dataCpfConsultado, referencia, enderecoCliente, telefoneContato,pessoaContato,  redeSocial, statusCliente, created, nacionalidade, profissao, estadoCivil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?) ";
  
  $sqlVerifyUser = "SELECT c.cpfCliente, c.nomeCliente, c.idCliente FROM cliente c WHERE c.cpfCliente=? AND c.nomeCliente=?";

  if ($stmt = $conn->prepare($sqlVerifyUser)) {
    $stmt->bind_param("ss", $cpfCliente, $nomeCliente);
    $response = executeSelect($stmt);
    
    // Verificando se já existe este usuário
    if ($response['sql']->num_rows === 0 || $cpfCliente === NULL) {
      if ($stmt = $conn->prepare($sqlRegisterUser)) {
        $stmt->bind_param('sssssssisssssssisss', $nomeCliente, $emailCliente, $rgCliente, $orgaoEmissor, $cpfCliente, $telefoneCliente, $dataNascimento, $idadeCliente, $cpfConsultado, $dataCpfConsultado, $referencia, $enderecoCliente, $telefoneContato, $pessoaContato, $redeSocial, $statusCliente, $nacionalidade, $profissao, $estadoCivil);
        $response = executeInsert($stmt);
      }
    }else{
      $response['status'] = 0;
      $response['msg'] = 'CPF já cadastrado';
    }
    print_r(json_encode($response));
  }
  $stmt->close();
  $conn->close();
}
