<?php
       session_start();
       include_once("../PHP/conexao.php");

    $idPagamento                 = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
    //$idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_VALIDATE_BOOLEAN);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    $valorSeguroViagem           = filter_input(INPUT_POST, 'novoValorSeguroViagem',  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPagoAtual              = filter_input(INPUT_POST, 'valorPagoAtual',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPendente = -$valorVendido + $valorPago;

    /* -----------------------------------------------------------------------------------------------------  */

    if($seguroViagemCliente == 0 ){
        $valorSeguroViagem1 = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
        $resultadoValorSeguroViagem = mysqli_query($conexao,$valorSeguroViagem1);
        $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
        $valorSeguroViagem = $rowSeguroViagem ['valorSeguroViagem'];
        if($idadeCliente >= 0 and $idadeCliente <=40 ){
            $novoValorSeguroViagem = $valorSeguroViagem - 2.23;
        }elseif($idadeCliente >=41 and $idadeCliente <=60){
            $novoValorSeguroViagem = $valorSeguroViagem - 2.73;
        }elseif($idadeCliente > 60){
            $novoValorSeguroViagem = $valorSeguroViagem - 5.93;
        }else{
            $novoValorSeguroViagem = $valorSeguroViagem - 0;
        }
    }else{
        $novoValorSeguroViagem = $valorSeguroViagem;
    }


    /* -----------------------------------------------------------------------------------------------------  */

    $getData = "UPDATE pagamento_passeio SET    
    valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', anotacoes='$anotacoes', statusPagamento='$statusPagamento', valorPendente='$valorPendente', seguroViagem='$seguroViagemCliente',
    transporte='$transporteCliente'
    WHERE idPagamento='$idPagamento'
    ";

    $getDataValorSeguroViagem = "UPDATE despesa SET
    valorSeguroViagem='$novoValorSeguroViagem' WHERE idPasseio='$idPasseio'
    ";

    /* -----------------------------------------------------------------------------------------------------  */



    $insertData = mysqli_query($conexao, $getData);
    /* -----------------------------------------------------------------------------------------------------  */

    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
        header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");
        $insertDataSeguroViagemPasseio = mysqli_query($conexao, $getDataValorSeguroViagem);

    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
        header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");
    }

?>