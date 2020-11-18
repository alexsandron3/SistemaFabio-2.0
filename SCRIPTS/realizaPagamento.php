<?php
    session_start();
    include_once("../PHP/conexao.php");

    $idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $sinalCliente                = filter_input(INPUT_POST, 'sinalCliente',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //$valorPendente               = filter_input(INPUT_POST, 'valorPendente',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_VALIDATE_BOOLEAN);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    //$transporteCliente           = filter_input(INPUT_POST, 'transporteCliente',      FILTER_SANITIZE_STRING);

    
    $valorPendente = -$valorVendido + ($valorPago +$sinalCliente);
    $getData = "INSERT INTO pagamento_passeio 
                (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, sinalCliente, valorPendente, statusPagamento/* , transporte */)  
                VALUES ('$idCliente', '$idPasseio', '$valorVendido', '$valorPago', '$previsaoPagamento', '$sinalCliente', '$valorPendente', '$statusPagamento'/* , '$transporteCliente' */)
     ";

    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
        header("Location:../pagamentoCliente.php?id=$idCliente");

    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
        header("Location:../pagamentoCliente.php?id=$idCliente");
        echo "$idCliente";
    }




?>