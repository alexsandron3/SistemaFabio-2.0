<?php
    session_start();
    include_once("../PHP/conexao.php");

    $idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $sinalCliente                = filter_input(INPUT_POST, 'sinalCliente',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_VALIDATE_BOOLEAN);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    $valorSeguroViagem           = filter_input(INPUT_POST, 'novoValorSeguroViagem',  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
    $valorPendente = -$valorVendido + ($valorPago +$sinalCliente);
    $getDataPagamentoPasseio = "INSERT INTO pagamento_passeio 
                (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, sinalCliente, valorPendente, statusPagamento, transporte)  
                VALUES ('$idCliente', '$idPasseio', '$valorVendido', '$valorPago', '$previsaoPagamento', '$sinalCliente', '$valorPendente', '$statusPagamento', '$transporteCliente')
     ";

    $recebeNumeroVagas = "SELECT qtdCliente, lotacao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoNumeroVagas = mysqli_query($conexao, $recebeNumeroVagas);
    $rowNumeroVagas = mysqli_fetch_assoc($resultadoNumeroVagas);
    $lotacaoPasseio = $rowNumeroVagas['lotacao']; 
    $qtdCliente     = $rowNumeroVagas ['qtdCliente'];
    
    $novaQuantidadeVagas = $qtdCliente +1;
    $getDataQtdCliente = "UPDATE passeio SET
                          qtdCliente='$novaQuantidadeVagas' WHERE idPasseio='$idPasseio'
                          ";
    $getDataSeguroViagemPasseio = "UPDATE despesa SET
                          valorSeguroViagem='$valorSeguroViagem' WHERE idPasseio='$idPasseio'  
                          ";
    
    $insertDataPagamentoPasseio = mysqli_query($conexao, $getDataPagamentoPasseio);
    if(mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
        header("Location:../pagamentoCliente.php?id=$idCliente");
        
        if($qtdCliente < $lotacaoPasseio){
            $insertDataqtdCliente = mysqli_query($conexao, $getDataQtdCliente);
            $insertDataSeguroViagemPasseio = mysqli_query($conexao, $getDataSeguroViagemPasseio);

        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO</p>";
        }


    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
        header("Location:../pagamentoCliente.php?id=$idCliente");
        echo "$idCliente";
    }




?>