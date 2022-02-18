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
  $allHeaders = getallheaders();
  $auth = new Auth($conn, $allHeaders);
  $Auth = $auth->isValid();
  if (!$Auth['success']) {
    echo json_encode($auth->isValid());
    $conn = null;
    exit();
    return 0;
  }   
  $returnData = [];

  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['id'])){
      // if()
      $fetch_cliente = "SELECT * FROM cliente WHERE idCliente = :wordToSearch";
      $stmt = $conn->prepare($fetch_cliente);
      $wordToSearch = $_GET['id'];
    }else{
      if(isset($_GET['pesquisarCliente'])){
        $wordToSearch = "%{$_GET['pesquisarCliente']}%";
      }else{
        $wordToSearch = "%%";
      }
      $mostrarInativos = json_decode($_GET['mostrarInativos']);
      $queryMostrarInativos = $mostrarInativos === true ? '' : 'AND statusCliente NOT IN (0)';
      $fetch_cliente = "SELECT * FROM cliente WHERE nomeCliente LIKE :wordToSearch $queryMostrarInativos OR cpfCliente LIKE :wordToSearch $queryMostrarInativos OR idCliente LIKE :wordToSearch $queryMostrarInativos OR telefoneCliente  LIKE :wordToSearch $queryMostrarInativos OR referencia LIKE :wordToSearch $queryMostrarInativos";
      $stmt = $conn->prepare($fetch_cliente);
    }
      try {
        $stmt->bindValue(':wordToSearch', $wordToSearch, PDO::PARAM_STR);
        $stmt->execute();
        
        if(true || $stmt->rowCount()){
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $returnData = [
            "success" => 1,
            "message" => 'Pesquisa realizada com sucesso!',
            "cliente" => $row
          ];
        }else {
          $returnData = msg(0, 422, 'Cliente não encontrado!');
        }
      } catch (\Throwable $e) {
        $returnData = msg(0,500,$e->getMessage());
  
      }
    

  }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {

      $verify_cliente = "SELECT nomeCliente, cpfCliente, idCliente FROM cliente WHERE nomeCliente = :nomeCliente AND cpfCliente = :cpfCliente";
      $stmt = $conn->prepare($verify_cliente);
      $stmt->bindValue(':nomeCliente', $data->nomeCliente, PDO::PARAM_STR);
      $stmt->bindValue(':cpfCliente', $data->cpfCliente, PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount()){
        $returnData = [
          "success" => 0,
          "message" => 'Já existe um cliente com mesmo CPF e NOME!',
        ];
      }else{

        $add_cliente = "INSERT INTO cliente (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente, dataNascimento, idadeCliente, referencia, pessoaContato, telefoneContato, cpfConsultado, dataCpfConsultado, redeSocial, enderecoCliente, nacionalidade, profissao, estadoCivil, clienteRedeSocial, poltrona, created) VALUES (:nomeCliente, :emailCliente, :rgCliente, :orgaoEmissor, :cpfCliente, :telefoneCliente, :dataNascimento, :idadeCliente, :referencia, :pessoaContato, :telefoneContato, :cpfConsultado, :dataCpfConsultado, :redeSocial, :enderecoCliente, :nacionalidade, :profissao, :estadoCivil, :clienteRedeSocial, :poltrona, NOW())";
        $stmt = $conn->prepare($add_cliente);
        if($stmt->execute((array) $data)) {
          $returnData = [
            "success" => 1,
            "message" => 'Cadastro realizado com sucesso!',
            "cliente" => $conn->lastInsertId(),
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

    if(isset($data->idCliente) && isset($data->statusCliente) && count((array)$data) === 2){
      $update_cliente = "UPDATE cliente SET statusCliente=:statusCliente WHERE idCliente=:idCliente";
    }else {
      $update_cliente = "UPDATE cliente SET 
      nomeCliente=:nomeCliente,
      emailCliente=:emailCliente,
      rgCliente=:rgCliente,
      orgaoEmissor=:orgaoEmissor,
      cpfCliente=:cpfCliente,
      telefoneCliente=:telefoneCliente,
      dataNascimento=:dataNascimento,
      idadeCliente=:idadeCliente,
      referencia=:referencia,
      pessoaContato=:pessoaContato,
      telefoneContato=:telefoneContato,
      cpfConsultado=:cpfConsultado,
      dataCpfConsultado=:dataCpfConsultado,
      redeSocial=:redeSocial,
      enderecoCliente=:enderecoCliente,
      nacionalidade=:nacionalidade,
      profissao=:profissao,
      estadoCivil=:estadoCivil,
      clienteRedeSocial=:clienteRedeSocial,
      poltrona=:poltrona,
      statusCliente=:statusCliente,
      statusCpf=:statusCpf  WHERE idCliente=:idCliente";
    }
    // 22
    
    $stmt = $conn->prepare($update_cliente);
    // return print_r(json_encode($data));
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


