<?php
    session_start();
    include_once("../PHP/conexao.php");

    $idPasseio = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
    $idadeCliente = filter_input(INPUT_GET, 'idade',FILTER_SANITIZE_NUMBER_INT);




    $getDataValorSeguroViagem = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
    $resultadoValorSeguroViagem = mysqli_query($conexao, $getDataValorSeguroViagem);
    $rowValorSeguroViagem = mysqli_fetch_assoc($resultadoNumeroVagas);
    $valorSeguroViagem = $rowValorSeguroViagem ['valorSeguroViagem'];
    if($seguroViagemCliente == 1){
        $idade1 = 2.23;
        $idade2 = 2.73;
        $idade3 = 5.93;
        if($idadeCliente >= 0 && $idadeCliente <= 40 ){
            $valorSeguroViagemNovo =  $valorSeguroViagem + 2.23;
        }else if($idadeCliente >=41 && $idadeCliente <=60){
            $valorSeguroViagemNovo =  $valorSeguroViagem + 2.73;
        }else if($idadeCliente>60){
            $valorSeguroViagemNovo =  $valorSeguroViagem + 5.93;
        }
    }else{
        $valorSeguroViagemNovo = $valorSeguroViagem + 0;
    }
    $getDataSeguroViagemPasseio = "UPDATE despesa SET
                                      valorSeguroViagem='$valorSeguroViagemNovo' WHERE idPasseio='$idPasseio'  
                                        ";
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>SEGURO VIAGEM ATUALIZADO</p>";
        header("refresh:0.5; url=../index.php?id=$idPasseio&idade=$idadeCliente");
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>SEGURO VIAGEM não foi ATUALIZADO </p>";
        header("refresh:0.5; url=../index.php?id=$idPasseio&idade=$idadeCliente");
    }

?>