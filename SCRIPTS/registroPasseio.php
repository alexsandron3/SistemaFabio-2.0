<?php
    session_start();
    include_once("../PHP/conexao.php");

    $nomePasseio    = filter_input(INPUT_POST, 'nomePasseio',          FILTER_SANITIZE_STRING);
    $localPasseio   = filter_input(INPUT_POST, 'localPasseio',         FILTER_SANITIZE_STRING);
    $valorPasseio   = filter_input(INPUT_POST, 'valorPasseio',         FILTER_SANITIZE_NUMBER_INT);
    $dataPasseio    = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);

    $getData = "INSERT INTO
    passeio (nomePasseio, localPasseio, valorPasseio, dataPasseio)
    VALUES  ('$nomePasseio', '$localPasseio', '$valorPasseio', '$dataPasseio')
    ";
    $insertData = mysqli_query($conexao, $getData);
    if(mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p style='color:green;'>Usuário cadastrado com sucesso</p>";
        header("Location:../cadastroPasseio.php");
    }else{
        $_SESSION['msg'] = "<p style='color:red;'>Usuário não foi cadastrado com sucesso</p>";
        header("Location:../cadastroPasseio.php");
    }

?>