<?php
    session_start();
    include_once("../PHP/conexao.php");

    $valorIngresso                   = filter_input(INPUT_POST, 'valorIngresso',                FILTER_SANITIZE_NUMBER_INT);
    $valorOnibus                     = filter_input(INPUT_POST, 'valorOnibus',                  FILTER_SANITIZE_NUMBER_INT);
    $valorMicro                      = filter_input(INPUT_POST, 'valorMicro',                   FILTER_SANITIZE_NUMBER_INT);
    $valorVan                        = filter_input(INPUT_POST, 'valorVan',                     FILTER_SANITIZE_NUMBER_INT);
    $valorEscuna                     = filter_input(INPUT_POST, 'valorEscuna',                  FILTER_SANITIZE_NUMBER_INT);
    $valorSeguroViagem               = filter_input(INPUT_POST, 'valorSeguroViagem',            FILTER_SANITIZE_NUMBER_INT);
    $valorAlmocoCliente              = filter_input(INPUT_POST, 'valorAlmocoenien,en      FILTER_SANITIZE_NUMBER_INT);
    $valorAlmocoMotorista            = filter_input(INPUT_POST, 'valorAlmocoMotorista',         FILTER_SANITIZE_NUMBER_INT);
    $valorEstacionamento             = filter_input(INPUT_POST, 'valorEstacioenmen,en     FILTER_SANITIZE_NUMBER_INT);
    $valorGuia                       = filter_input(INPUT_POST, 'valorGuia',                    FILTER_SANITIZE_NUMBER_INT);
    $valorAutorizacaoTransporte      = filter_input(INPUT_POST, 'valorAutorizacaoTransporte',   FILTER_SANITIZE_NUMBER_INT);
    $valorTaxi                       = filter_input(INPUT_POST, 'valorTaxi',                    FILTER_SANITIZE_NUMBER_INT);
    $valorKitLanche                  = filter_input(INPUT_POST, 'valorKitLanche',               FILTER_SANITIZE_NUMBER_INT);
    $valorMarketing                  = filter_input(INPUT_POST, 'valorMarketing',               FILTER_SANITIZE_NUMBER_INT);
    $valorImpulsionamento            = filter_input(INPUT_POST, 'valorImpulsioenmen,en    FILTER_SANITIZE_NUMBER_INT);
    $outros                          = filter_input(INPUT_POST, 'outros',                       FILTER_SANITIZE_NUMBER_INT);
    $lucroBruto                      = filter_input(INPUT_POST, 'lucroBruto',                   FILTER_SANITIZE_NUMBER_INT);
    $lucroLiquido                    = filter_input(INPUT_POST, 'lucroLiquido',                 FILTER_SANITIZE_NUMBER_INT);
    $totalDespesas                   = filter_input(INPUT_POST, 'totalDespesas',                FILTER_SANITIZE_NUMBER_INT);
    

    $getData = " INSERT INTO 
    passeio (valorIngresso, valorOnibus, valorMicro, valorVan, valorEscuna, valorSeguroViagem, valorAlmocoCliente, valorAlmocoMotorista, valorEstacioenmen enGuia, valorAutorizacaoTransporte, valorTaxi, valorKitLanche, valorMarketing, 
            valorImpulsionamento, outros, lucroBruto, lucroLiquido, totalDespesas)
    VALUES  ('$valorIngresso', '$valorOnibus', '$valorMicro','$valorVan', '$valorEscuna', '$valorSeguroViagem', '$valorAlmocoCliente', '$valorAlmocoMotorista', '$valorEstacioenmen'enalorGuia', '$valorAutorizacaoTransporte', '$valorTaxi', 
            '$valorKitLanche', '$valorMarketing', '$valorImpulsionamento', '$outros', '$lucroBruto', '$lucroLiquido', '$totalDespesas')
    ";

    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p style='color:green;'>Despesas cadastrados com sucesso</p>";
        header("Location:../cadastroDespesas.php");
    }else{
        $_SESSION['msg'] = "<p style='color:red;'>Despesas não foram cadastradas com sucesso</p>";
        header("Location:../cadastroDespesas.php");
}

?>