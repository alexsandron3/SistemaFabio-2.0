<?php




session_start();

include_once("PHP/conexao.php");


    $idPasseio=1;
    $idadeCliente = 2;
    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao']; 
    echo $idadeIsencao;

    $statusPagamento =0;

    if($idadeCliente <= $idadeIsencao ){
        $statusPagamento = 4;
    }

    echo $statusPagamento;



?>
