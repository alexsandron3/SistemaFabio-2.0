<?php
    session_start();
    include_once("../PHP/functions.php");

    $idPasseio   = filter_input(INPUT_GET, 'idPasseio',   FILTER_SANITIZE_NUMBER_INT);
    $idPagamento = filter_input(INPUT_GET, 'idPagamento', FILTER_SANITIZE_NUMBER_INT);
    $opcao       = filter_input(INPUT_GET, 'opcao',       FILTER_SANITIZE_STRING);
    /* -----------------------------------------------------------------------------------------------------  */
    $getData = "DELETE FROM pagamento_passeio WHERE idPagamento ='$idPagamento' AND idPasseio='$idPasseio'";
    if($opcao == "DELETAR"){
        apagar($getData, $conexao, "PAGAMENTO", $idPagamento, $idPasseio, "index");
    }else{
        header("refresh:0.5; url=../transferirPagamento.php?idPasseioAntigo=$idPasseio&idPagamentoAntigo=$idPagamento");
    }

?>