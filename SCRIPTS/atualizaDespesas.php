<?php
    session_start();
    include_once("../PHP/conexao.php");
     $idPasseio                       = filter_input(INPUT_POST, 'idPasseioSelecionado',         FILTER_SANITIZE_NUMBER_INT);
     $idDespesa                       = filter_input(INPUT_POST, 'idDespesa',                    FILTER_SANITIZE_NUMBER_INT);
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
     $quantidadeIngresso              = filter_input(INPUT_POST, 'quantidadeIngresso',           FILTER_SANITIZE_NUMBER_INT);
     $quantidadeOnibus                = filter_input(INPUT_POST, 'quantidadeOnibus',             FILTER_SANITIZE_NUMBER_INT);
     $quantidadeMicro                 = filter_input(INPUT_POST, 'quantidadeMicro',              FILTER_SANITIZE_NUMBER_INT);
     $quantidadeVan                   = filter_input(INPUT_POST, 'quantidadeVan',                FILTER_SANITIZE_NUMBER_INT);
     $quantidadeEscuna                = filter_input(INPUT_POST, 'quantidadeEscuna',             FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAlmocoCliente         = filter_input(INPUT_POST, 'quantidadeAlmocoCliente',      FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAlmocoMotorista       = filter_input(INPUT_POST, 'quantidadeAlmocoMotorista',    FILTER_SANITIZE_NUMBER_INT);
     $quantidadeEstacionamento        = filter_input(INPUT_POST, 'quantidadeEstacionamento',     FILTER_SANITIZE_NUMBER_INT);
     $quantidadeGuia                  = filter_input(INPUT_POST, 'quantidadeGuia',               FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAutorizacaoTransporte = filter_input(INPUT_POST, 'quantidadeAutorizacaoTransporte',FILTER_SANITIZE_NUMBER_INT);
     $quantidadeTaxi                  = filter_input(INPUT_POST, 'quantidadeTaxi',               FILTER_SANITIZE_NUMBER_INT);
     $quantidadeMarketing             = filter_input(INPUT_POST, 'quantidadeMarketing',          FILTER_SANITIZE_NUMBER_INT);
     $quantidadeKitLanche             = filter_input(INPUT_POST, 'quantidadeKitLanche',          FILTER_SANITIZE_NUMBER_INT);
     $quantidadeImpulsionamento       = filter_input(INPUT_POST, 'quantidadeImpulsionamento',    FILTER_SANITIZE_NUMBER_INT);
     $valorImpulsionamento            = filter_input(INPUT_POST, 'valorImpulsionamento',         FILTER_SANITIZE_NUMBER_INT);
     $outros                          = filter_input(INPUT_POST, 'outros',                       FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $getData = "UPDATE despesa SET
                valorIngresso='$valorIngresso', valorOnibus='$valorOnibus', valorMicro='$valorMicro', valorVan='$valorVan', valorEscuna='$valorEscuna', valorSeguroViagem='$valorSeguroViagem', valorAlmocoCliente='$valorAlmocoCliente', 
                valorAlmocoMotorista='$valorAlmocoMotorista', valorEstacionamento='$valorEstacionamento', valorGuia='$valorGuia', valorAutorizacaoTransporte='$valorAutorizacaoTransporte', valorTaxi='$valorTaxi', valorKitLanche='$valorKitLanche', 
                valorMarketing='$valorMarketing', valorImpulsionamento='$valorImpulsionamento', outros='$outros', quantidadeIngresso='$quantidadeIngresso', quantidadeOnibus='$quantidadeOnibus', quantidadeMicro='$quantidadeMicro', quantidadeVan='$quantidadeVan', 
                quantidadeEscuna='$quantidadeEscuna', quantidadeAlmocoCliente='$quantidadeAlmocoCliente', quantidadeAlmocoMotorista='$quantidadeAlmocoMotorista', quantidadeEstacionamento='$quantidadeEstacionamento', quantidadeGuia='$quantidadeGuia', 
                quantidadeAutorizacaoTransporte='$quantidadeAutorizacaoTransporte', quantidadeTaxi='$quantidadeTaxi', quantidadeMarketing='$quantidadeMarketing', quantidadeKitLanche='$quantidadeKitLanche', quantidadeImpulsionamento='$quantidadeImpulsionamento', 
                valorImpulsionamento='$valorImpulsionamento'
                WHERE idDespesa='$idDespesa'
                ";
    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
        header("refresh:0.5; url=../editaDespesas.php?id=$idPasseio");
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
        header("refresh:0.5; url=../editaDespesas.php?id=$idPasseio");
    }

?>