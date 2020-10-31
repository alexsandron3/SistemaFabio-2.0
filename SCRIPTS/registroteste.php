<?php
    session_start();
    include_once("../PHP/connection.php");

    $nome                   = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $email                  = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rg                     = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $emissor                = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpf                    = filter_input(INPUT_POST, 'cpf',            FILTER_SANITIZE_STRING); //MUDAR NAME CAUSA DO JAVASCRIPT
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING); //MUDAR NAME CAUSA DO JAVASCRIPT
    $dataNascimento         = $_POST["dataNascimento"];
    $idadeCliente           = filter_input(INPUT_POST, 'idadeCliente',          FILTER_SANITIZE_NUMBER_INT);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = $_POST["dataConsulta"];
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $meioTransporte         = filter_input(INPUT_POST, 'meioTransporte',        FILTER_SANITIZE_STRING);
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING); //MUDAR NAME CAUSA DO JAVASCRIPT
    $seguroViagemCliente    = filter_input(INPUT_POST, 'seguroViagemCliente',   FILTER_VALIDATE_BOOLEAN);

    
  
    
    //
    $getData = "INSERT INTO 
    CLIENTE (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente)
    VALUES  ('$nome', '$email', '$rg', '$emissor', '$cpf', '$telefoneCliente')
    ";
    $insertData = mysqli_query($connection, $getData);
    if(mysqli_insert_id($connection)){
        $_SESSION['msg'] = "<p style='color:green;'>Usuário cadastrado com sucesso</p>";
        header("Location:../cadastro.php");
    }else{
        $_SESSION['msg'] = "<p style='color:red;'>Usuário não foi cadastrado com sucesso</p>";
        header("Location:../cadastro.php");
    }
 ?>   