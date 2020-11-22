<?php
    session_start();
    include_once("../PHP/conexao.php");
    
    $idCliente              = filter_input(INPUT_POST, 'idCliente',             FILTER_SANITIZE_NUMBER_INT);
    $nome                   = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $email                  = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rg                     = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $emissor                = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpf                    = filter_input(INPUT_POST, 'cpfCliente',            FILTER_SANITIZE_STRING); 
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING); 
    $dataNascimento         = filter_input(INPUT_POST, 'dataNascimento',        FILTER_SANITIZE_STRING);
    $idade                  = filter_input(INPUT_POST, 'idadeCliente',          FILTER_SANITIZE_NUMBER_INT);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = filter_input(INPUT_POST, 'dataCpfConsultado',     FILTER_SANITIZE_STRING);
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $meioTransporte         = filter_input(INPUT_POST, 'meioTransporte',        FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING); 
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $seguroViagemCliente    = filter_input(INPUT_POST, 'seguroViagemCliente',   FILTER_VALIDATE_BOOLEAN);
    $redeSocial             = filter_input(INPUT_POST, 'redeSocial',            FILTER_SANITIZE_STRING);
    

    $getData = "UPDATE cliente SET 
                nomeCliente='$nome', emailCliente='$email', rgCliente='$rg', orgaoEmissor='$emissor', cpfCliente='$cpf', telefoneCliente='$telefoneCliente', dataNascimento='$dataNascimento', idadeCliente='$idade', 
                cpfConsultado='$cpfConsultado', dataCpfConsultado='$dataConsulta', referencia='$referenciaCliente', transporte='$meioTransporte', telefoneContato='$telefoneContato', pessoaContato='$nomeContato', 
                seguroViagem='$seguroViagemCliente', redeSocial='$redeSocial' 
                WHERE idCliente='$idCliente'";
    
    /* $verificaSeClienteExiste = "SELECT c.cpfCliente FROM cliente c WHERE c.cpfCliente='$cpf'";
    $resultadoVerificaCliente = mysqli_query($conexao, $verificaSeClienteExiste);
    $rowResultadoVerificaCliente = mysqli_fetch_assoc($resultadoVerificaCliente); */
    //if(mysqli_num_rows($resultadoVerificaCliente) == 0){
        $insertData = mysqli_query($conexao, $getData);
        if(mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Usuário ATUALIZADO com sucesso</p>";
            header("refresh:0.5; url=../editarCliente.php?id=$idCliente");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Usuário não foi ATUALIZADO </p>";
            header("refresh:0.5; url=../editarCliente.php?id=$idCliente");
        }
    /* }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>JÁ EXISTE UM CLIENTE CADASTRADO COM ESTE CPF </p>";
            header("refresh:0.5; url=../editarCliente.php?id=$idCliente");
    } */


?>