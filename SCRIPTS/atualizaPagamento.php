<?php
       session_start();
       include_once("../PHP/conexao.php");
       include_once("../PHP/functions.php");

    $idPagamento                 = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $idCliente                   = filter_input(INPUT_POST, 'idCliente',              FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $historicoPagamento          = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);
    $clienteParceiro             = filter_input(INPUT_POST, 'clienteParceiro',        FILTER_VALIDATE_BOOLEAN);
    $statusEditaSeguroViagemCliente= filter_input(INPUT_POST, 'seguroViagemCliente',  FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $localEmbarque               = filter_input(INPUT_POST, 'localEmbarque',          FILTER_SANITIZE_STRING);
    $valorPagoAtual              = filter_input(INPUT_POST, 'valorPagoAtual',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $taxaPagamento               = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $idUser                      = $_SESSION['id'];

    if(empty($taxaPagamento)){
        $taxaPagamento = 0;
    }
    $valorPendente               = -$valorVendido + ($valorPago + $taxaPagamento);
    
    $valorPendente = round($valorPendente,2);
    if($valorPendente == -0){
        $valorPendente = 0;
    }else{
        $valorPendente = $valorPendente;
    }

    /* -----------------------------------------------------------------------------------------------------  */


    #--------------------------------------------------------------------------------------------------
    $queryStatusSeguroViagem = "SELECT seguroViagem, valorSeguroViagemCliente FROM pagamento_passeio WHERE idPagamento=$idPagamento";
    $resultadoStatusSeguroViagem = mysqli_query($conexao, $queryStatusSeguroViagem);
    $rowStatusSeguroViagem = mysqli_fetch_assoc($resultadoStatusSeguroViagem);
    $statusSeguroViagem = $rowStatusSeguroViagem ['seguroViagem'];
    $idadeCliente = calcularIdade($idCliente, $conn, "");
    /* -----------------------------------------------------------------------------------------------------  */

    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao'];
    $nomePasseio             = $rowLotacaoPasseio['nomePasseio']; 
    $dataPasseio             = $rowLotacaoPasseio['dataPasseio']; 

    $statusPagamento = statusPagamento($valorPendente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro);

    $recebeNomeCliente = "SELECT nomeCliente FROM cliente WHERE idCliente=$idCliente";
    $resultadoNomeCliente = mysqli_query($conexao, $recebeNomeCliente);
    $rowNomeCliente = mysqli_fetch_assoc($resultadoNomeCliente);
    $nomeCliente = $rowNomeCliente['nomeCliente'];
    
    /* -----------------------------------------------------------------------------------------------------  */

    $getData =  "UPDATE pagamento_passeio SET    
                valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', anotacoes='$anotacoes', historicoPagamento='$historicoPagamento', statusPagamento='$statusPagamento', clienteParceiro='$clienteParceiro' ,valorPendente='$valorPendente', seguroViagem='$statusEditaSeguroViagemCliente',
                transporte='$transporteCliente', taxaPagamento='$taxaPagamento', localEmbarque='$localEmbarque', dataPagamento=NOW()
                WHERE idPagamento='$idPagamento'
                ";

    /* -----------------------------------------------------------------------------------------------------  */


    if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
        $insertData = mysqli_query($conexao, $getData);
        /* -----------------------------------------------------------------------------------------------------  */
        if(mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
            header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");

        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
            header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");
        }
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "ATUALIZAR" , 0);
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
        header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "ATUALIZAR" , 1);

    }

?>