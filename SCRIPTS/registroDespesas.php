<?php
    session_start();
    include_once("../PHP/conexao.php");
    
    $idPasseio                       = filter_input(INPUT_POST, 'idPasseioSelecionado',         FILTER_SANITIZE_NUMBER_INT);
    $valorIngresso                   = filter_input(INPUT_POST, 'valorIngresso',                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorOnibus                     = filter_input(INPUT_POST, 'valorOnibus',                  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorMicro                      = filter_input(INPUT_POST, 'valorMicro',                   FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorVan                        = filter_input(INPUT_POST, 'valorVan',                     FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorEscuna                     = filter_input(INPUT_POST, 'valorEscuna',                  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorSeguroViagem               = filter_input(INPUT_POST, 'valorSeguroViagem',            FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorAlmocoCliente              = filter_input(INPUT_POST, 'valorAlmocoCliente',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorAlmocoMotorista            = filter_input(INPUT_POST, 'valorAlmocoMotorista',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorEstacionamento             = filter_input(INPUT_POST, 'valorEstacionamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorGuia                       = filter_input(INPUT_POST, 'valorGuia',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorAutorizacaoTransporte      = filter_input(INPUT_POST, 'valorAutorizacaoTransporte',   FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorTaxi                       = filter_input(INPUT_POST, 'valorTaxi',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorKitLanche                  = filter_input(INPUT_POST, 'valorKitLanche',               FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorMarketing                  = filter_input(INPUT_POST, 'valorMarketing',               FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorImpulsionamento            = filter_input(INPUT_POST, 'valorImpulsionamento',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $outros                          = filter_input(INPUT_POST, 'outros',                       FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $totalDespesas                   = filter_input(INPUT_POST, 'totalDespesas',                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
    $getData = "INSERT INTO 
    despesa (valorIngresso, valorOnibus, valorMicro, valorVan, valorEscuna, valorSeguroViagem, valorAlmocoCliente, valorAlmocoMotorista, valorEstacionamento, valorGuia, valorAutorizacaoTransporte,
             valorTaxi, valorKitLanche, valorMarketing, valorImpulsionamento, outros, idPasseio,  totalDespesas)
    VALUES   ('$valorIngresso', '$valorOnibus', '$valorMicro', '$valorVan', '$valorEscuna',  '$valorSeguroViagem', '$valorAlmocoCliente', '$valorAlmocoMotorista', 
    '$valorEstacionamento', '$valorGuia', '$valorAutorizacaoTransporte', '$valorTaxi', '$valorKitLanche', '$valorMarketing', '$valorImpulsionamento', '$outros', '$idPasseio', '$totalDespesas')
    ";

    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Despesas CADASTRADAS com SUCESSO</p>";
        header("Location:../cadastroDespesas.php");
        
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Despesas NÃO foram CADASTRADAS</p>";
        header("Location:../cadastroDespesas.php");
}

?>