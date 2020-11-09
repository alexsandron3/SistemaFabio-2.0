<?php
    session_start();
    include_once("../PHP/conexao.php");
    
    $idPasseio                       = filter_input(INPUT_POST, 'idPasseioSelecionado',           FILTER_SANITIZE_NUMBER_INT);
    $valorIngresso                   = filter_input(INPUT_POST, 'valorIngresso',                FILTER_SANITIZE_STRING);
    $valorOnibus                     = filter_input(INPUT_POST, 'valorOnibus',                  FILTER_SANITIZE_NUMBER_INT);
    $valorMicro                      = filter_input(INPUT_POST, 'valorMicro',                   FILTER_SANITIZE_NUMBER_INT);
    $valorVan                        = filter_input(INPUT_POST, 'valorVan',                     FILTER_SANITIZE_NUMBER_INT);
    $valorEscuna                     = filter_input(INPUT_POST, 'valorEscuna',                  FILTER_SANITIZE_NUMBER_INT);
    $valorSeguroViagem               = filter_input(INPUT_POST, 'valorSeguroViagem',            FILTER_SANITIZE_NUMBER_INT);
    $valorAlmocoCliente              = filter_input(INPUT_POST, 'valorAlmocoCliente',           FILTER_SANITIZE_NUMBER_INT);
    $valorAlmocoMotorista            = filter_input(INPUT_POST, 'valorAlmocoMotorista',         FILTER_SANITIZE_NUMBER_INT);
    $valorEstacionamento             = filter_input(INPUT_POST, 'valorEstacionamento',          FILTER_SANITIZE_NUMBER_INT);
    $valorGuia                       = filter_input(INPUT_POST, 'valorGuia',                    FILTER_SANITIZE_NUMBER_INT);
    $valorAutorizacaoTransporte      = filter_input(INPUT_POST, 'valorAutorizacaoTransporte',   FILTER_SANITIZE_NUMBER_INT);
    $valorTaxi                       = filter_input(INPUT_POST, 'valorTaxi',                    FILTER_SANITIZE_NUMBER_INT);
    $valorKitLanche                  = filter_input(INPUT_POST, 'valorKitLanche',               FILTER_SANITIZE_NUMBER_INT);
    $valorMarketing                  = filter_input(INPUT_POST, 'valorMarketing',               FILTER_SANITIZE_NUMBER_INT);
    $valorImpulsionamento            = filter_input(INPUT_POST, 'valorImpulsionamento',         FILTER_SANITIZE_NUMBER_INT);
    $outros                          = filter_input(INPUT_POST, 'outros',                       FILTER_SANITIZE_NUMBER_INT);
    $lucroBruto                      = filter_input(INPUT_POST, 'lucroBruto',                   FILTER_SANITIZE_NUMBER_INT);
    $lucroLiquido                    = filter_input(INPUT_POST, 'lucroLiquido',                 FILTER_SANITIZE_NUMBER_INT);
    $totalDespesas                   = filter_input(INPUT_POST, 'totalDespesas',                FILTER_SANITIZE_NUMBER_INT);
    
    $getData = "UPDATE passeio SET 
    valorIngresso='$valorIngresso', valorIngresso='$valorIngresso', valorOnibus='$valorOnibus', valorMicro='$valorMicro', valorVan='$valorVan', valorEscuna='$valorEscuna',  valorSeguroViagem='$valorSeguroViagem', valorAlmocoCliente='$valorAlmocoCliente', 
    valorAlmocoMotorista='$valorAlmocoMotorista', valorEstacionamento='$valorEstacionamento', valorGuia='$valorGuia', valorAutorizacaoTransporte='$valorAutorizacaoTransporte', valorTaxi='$valorTaxi', valorKitLanche='$valorKitLanche', valorMarketing='$valorMarketing',
    valorImpulsionamento='$valorImpulsionamento', outros='$outros', totalDespesas='$totalDespesas'
    WHERE idPasseio='$idPasseio'";

    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p style='color:green;'>Despesas ATUALIZADAS com SUCESSO</p>";
        header("Location:../teste.php");
    }else{
        $_SESSION['msg'] = "<p style='color:red;'>Despesas NÃO foram ATUALIZADAS</p>";
        header("Location:../teste.php");
}

?>