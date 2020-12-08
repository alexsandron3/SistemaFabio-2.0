<?php
    session_start();
    include_once("../PHP/conexao.php");

    $nomePasseio         = filter_input(INPUT_POST, 'nomePasseio',          FILTER_SANITIZE_STRING);
    $localPasseio        = filter_input(INPUT_POST, 'localPasseio',         FILTER_SANITIZE_STRING);
    $valorPasseio        = filter_input(INPUT_POST, 'valorPasseio',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $lotacao             = filter_input(INPUT_POST, 'lotacao',              FILTER_SANITIZE_NUMBER_INT);
    $dataPasseio         = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);
    $anotacoes           = filter_input(INPUT_POST, 'anotacoesPasseio',     FILTER_SANITIZE_STRING);

    /* -----------------------------------------------------------------------------------------------------  */

    $getData = "INSERT INTO
    passeio (nomePasseio, localPasseio, valorPasseio, dataPasseio, anotacoes, lotacao)
    VALUES  ('$nomePasseio', '$localPasseio', '$valorPasseio', '$dataPasseio', '$anotacoes', '$lotacao')
    ";

    /* -----------------------------------------------------------------------------------------------------  */


    $verificaSeExistePasseio = "SELECT  upper(p.nomePasseio), p.dataPasseio, p.idPasseio FROM passeio p WHERE p.nomePasseio='$nomePasseio' AND p.dataPasseio='$dataPasseio' ";
    $resultadoVerificaSeExistePasseio = mysqli_query($conexao, $verificaSeExistePasseio);
    $rowPasseioVerificado = mysqli_fetch_assoc($resultadoVerificaSeExistePasseio );
    /* -----------------------------------------------------------------------------------------------------  */
    
    if(mysqli_num_rows($resultadoVerificaSeExistePasseio) == 0 ){
        
    /* -----------------------------------------------------------------------------------------------------  */
        $insertData = mysqli_query($conexao, $getData);
    /* -----------------------------------------------------------------------------------------------------  */

        if(mysqli_insert_id($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Passeio CADASTRADO com sucesso</p>";
            header("refresh:0.5; url=../cadastroPasseio.php");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Passeio NÃO foi CADASTRADO, alguma informação não foi inserida dentro dos padrões.</p>";
            header("refresh:0.5; url=../cadastroPasseio.php");
            
        }
        
    }else{
        $idPasseio = $rowPasseioVerificado ['idPasseio']; 
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>JÁ EXISTE UM PASSEIO NA MESMA DATA COM O MESMO NOME </p>";
        header("refresh:0.5; url=../editarPasseio.php?id=$idPasseio");
        
    }

?>