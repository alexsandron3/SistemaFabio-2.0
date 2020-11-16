<?php
    session_start();
    include_once("../PHP/conexao.php");
    $idPasseio           = filter_input(INPUT_POST, 'idPasseio',            FILTER_SANITIZE_NUMBER_INT);
    $nomePasseio         = filter_input(INPUT_POST, 'nomePasseio',          FILTER_SANITIZE_STRING);
    $localPasseio        = filter_input(INPUT_POST, 'localPasseio',         FILTER_SANITIZE_STRING);
    $valorPasseio        = filter_input(INPUT_POST, 'valorPasseio',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $quantidadeCliente   = filter_input(INPUT_POST, 'quantidadeCliente',    FILTER_SANITIZE_NUMBER_INT);
    $dataPasseio         = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);
    $anotacoes           = filter_input(INPUT_POST, 'anotacoesPasseio',     FILTER_SANITIZE_STRING);

    $getData = "UPDATE passeio SET
                nomePasseio='$nomePasseio', localPasseio='$localPasseio', valorPasseio='$valorPasseio', quantidadeCliente='$quantidadeCliente', dataPasseio='$dataPasseio', anotacoes='$anotacoes'
                WHERE idPasseio='$idPasseio'";
    $insertData = mysqli_query($conexao, $getData);

    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>passeio ATUALIZADO com sucesso</p>";
        header("Location:../editarPasseio.php?id=$idPasseio");
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>passeio não foi ATUALIZADO </p>";
        header("Location:../editarPasseio.php?id=$idPasseio");
    }

?>