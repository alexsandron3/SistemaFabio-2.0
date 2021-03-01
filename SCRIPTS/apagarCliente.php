<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    
    //RECEBENDO E VALIDANDO VALORES
    $id            = filter_input(INPUT_GET, 'id',     FILTER_SANITIZE_NUMBER_INT);
    $statusCliente = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_BOOLEAN );
    $nomeCliente   = filteR_input(INPUT_GET, 'nomeCliente', FILTER_SANITIZE_STRING);
    $idUser        = $_SESSION['id'];

    //VERFICANDO SE O ID FOI ENVIADO
    if(!empty($id)){

        
    /* -----------------------------------------------------------------------------------------------------  */
        //ALTERANDO STATUS DO CLIENTE
        if($statusCliente == 1){
            $pesquisaCliente = "UPDATE cliente SET statusCliente=0 WHERE idCliente ='$id'";
            $resultadoPesquisaCliente = mysqli_query ($conexao, $pesquisaCliente );
            $tipoModificacao = "DESATIVAR";

        }else{
            $pesquisaCliente = "UPDATE cliente SET statusCliente=1 WHERE idCliente ='$id'";
            $resultadoPesquisaCliente = mysqli_query ($conexao, $pesquisaCliente );
            $tipoModificacao = "ATIVAR";


        }
    /* -----------------------------------------------------------------------------------------------------  */
        //VERIFICANDO SE AS ALTERACOES FORAM ENVIADAS
        if( mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>STATUS do CLIENTE alterado com SUCESSO</p>";
            header("refresh:0.5; url= ../pesquisarCliente.php");

        
        }else {
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>STATUS do CLIENTE NÃO foi alterado </p>";
            header("refresh:0.5; url= index.php");
        
        }


    }else {
        $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um usuário</p>";
        header("refresh:0.5; url=../pesquisaCliente.php");

    }
    gerarLog("CLIENTE", $conexao, $idUser, $nomeCliente, " ", " ", " ", $tipoModificacao, 0);

?>