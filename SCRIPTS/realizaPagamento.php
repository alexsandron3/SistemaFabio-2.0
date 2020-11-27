<?php
    session_start();
    include_once("../PHP/conexao.php");

    $idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_VALIDATE_BOOLEAN);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    //$valorSeguroViagem           = filter_input(INPUT_POST, 'novoValorSeguroViagem',  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPendente               = -$valorVendido + $valorPago;

    /* -----------------------------------------------------------------------------------------------------  */

    $recebeLotacaoPasseio    = "SELECT lotacao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    
    
    
    $recebeQtdCliente        = "SELECT COUNT(idPagamento) AS qtdClientes FROM pagamento_passeio";
    $resultadoQtdCliente     = mysqli_query($conexao, $recebeQtdCliente);
    $rowQtdCliente           = mysqli_fetch_assoc($resultadoQtdCliente);
    $qtdCliente              = $rowQtdCliente ['qtdClientes'];


    if($seguroViagemCliente == 1){
        if($idadeCliente >= 0 and $idadeCliente <=40 ){
            $valorSeguroViagem = 2.23;
        }elseif($idadeCliente >=41 and $idadeCliente <=60){
            $valorSeguroViagem = 2.73;
        }elseif($idadeCliente > 60){
            $valorSeguroViagem = 5.93;
        }else{
            $valorSeguroViagem = 0;
        }
    }else{
        $valorSeguroViagem = 0;
    }
    /* -----------------------------------------------------------------------------------------------------  */

    $getDataPagamentoPasseio = "INSERT INTO pagamento_passeio 
    (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, anotacoes, valorPendente, statusPagamento, transporte, seguroViagem, valorSeguroViagemCliente)  
    VALUES ('$idCliente', '$idPasseio', '$valorVendido', '$valorPago', '$previsaoPagamento', '$anotacoes', '$valorPendente', '$statusPagamento', '$transporteCliente', '$seguroViagemCliente', '$valorSeguroViagem')
    ";

    /* -----------------------------------------------------------------------------------------------------  */

    if($lotacaoPasseio > $qtdCliente){
        $insertDataPagamentoPasseio = mysqli_query($conexao, $getDataPagamentoPasseio);

        if(mysqli_insert_id($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
            header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
            header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
        }
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO</p>";
        header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
    }




?>