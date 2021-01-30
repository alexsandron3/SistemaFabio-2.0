<?php
       session_start();
       include_once("../PHP/conexao.php");

    $idPagamento                 = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $historicoPagamento          = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);
    $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_SANITIZE_NUMBER_INT);
    $clienteParceiro             = filter_input(INPUT_POST, 'clienteParceiro',        FILTER_VALIDATE_BOOLEAN);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    $valorSeguroViagem           = filter_input(INPUT_POST, 'novoValorSeguroViagem',  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPagoAtual              = filter_input(INPUT_POST, 'valorPagoAtual',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $taxaPagamento               = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $valorPendente               = -$valorVendido + ($valorPago + $taxaPagamento);

    /* -----------------------------------------------------------------------------------------------------  */

    if($seguroViagemCliente == 0 ){
        $valorSeguroViagem1 = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
        $resultadoValorSeguroViagem = mysqli_query($conexao,$valorSeguroViagem1);
        $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
        $valorSeguroViagem = $rowSeguroViagem ['valorSeguroViagem'];
        if($seguroViagemCliente == 1){
            if($idadeCliente >= 0 and $idadeCliente <=85 ){
                $valorSeguroViagem = 2.47;
            }
        }else{
            $novoValorSeguroViagem = $valorSeguroViagem - 0;
        }
    }else{
        $novoValorSeguroViagem = $valorSeguroViagem;
    }

    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao'];
    if($idadeCliente <= $idadeIsencao ){
        $statusPagamento = 4;
    }

    
    /* -----------------------------------------------------------------------------------------------------  */

    $getData =                  "UPDATE pagamento_passeio SET    
                                valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', anotacoes='$anotacoes', historicoPagamento='$historicoPagamento' ,statusPagamento='$statusPagamento', clienteParceiro='$clienteParceiro' ,valorPendente='$valorPendente', seguroViagem='$seguroViagemCliente',
                                transporte='$transporteCliente', taxaPagamento='$taxaPagamento'
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