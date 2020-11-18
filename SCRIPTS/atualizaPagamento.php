<?php
       session_start();
       include_once("../PHP/conexao.php");
   
       $idPagamento                 = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
       $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
       $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
       $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
       $sinalCliente                = filter_input(INPUT_POST, 'sinalCliente',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
       //$valorPendente               = filter_input(INPUT_POPST, 'valorPendente',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
       $statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_VALIDATE_BOOLEAN);
       $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
       //$transporteCliente           = filter_input(INPUT_POST, 'transporteCliente',      FILTER_SANITIZE_STRING);
    $valorPendente = -$valorVendido + ($valorPago +$sinalCliente);
    $getData = "UPDATE pagamento_passeio SET    
                valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', sinalCliente='$sinalCliente', statusPagamento='$statusPagamento', valorPendente='$valorPendente'
                WHERE idPagamento='$idPagamento'
                ";
    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
        header("Location:../editarPagamento.php?id=$idPagamento");
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
        header("Location:../editarPagamento.php?id=$idPagamento");
    }

?>