<?php
require_once('../includes/pdoCONEXAO.php');
include_once("../includes/header.php");

if (isset($_REQUEST['value'])) {
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
  $idCliente = $searcharray['idCliente'];
  
  $sqlRegisterUser = "UPDATE cliente SET nomeCliente=?, emailCliente=?, rgCliente=?, orgaoEmissor=?, cpfCliente=?, telefoneCliente=?, dataNascimento=?,idadeCliente=?, cpfConsultado=?, dataCpfConsultado=?,referencia=?, enderecoCliente=?, telefoneContato=?,pessoaContato=?, redeSocial=?, nacionalidade=?, poltrona= ?, profissao=?, estadoCivil=?, clienteRedeSocial=?
  WHERE idCliente=?";




  if ($stmt = $conn->prepare($sqlRegisterUser)) {
    $stmt->bind_param('sssssssisssssssssssii', $nomeCliente, $emailCliente, $rgCliente, $orgaoEmissor, $cpfCliente, $telefoneCliente, $dataNascimento, $idadeCliente, $cpfConsultado, $dataCpfConsultado, $referencia, $enderecoCliente, $telefoneContato, $pessoaContato, $redeSocial, $nacionalidade, $poltrona, $profissao, $estadoCivil, $clienteRedeSocial, $idCliente);
    $response = executeUpdate($stmt);
  }

  print_r(json_encode($response));

  $stmt->close();
  $conn->close();
}
