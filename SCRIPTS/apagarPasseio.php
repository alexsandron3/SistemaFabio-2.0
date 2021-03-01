<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
    
    //RECEBENDO E VALIDANDO VALORES
    $nomePasseio = filter_input(INPUT_GET , 'nomePasseio', FILTER_SANITIZE_STRING);
    $dataPasseio = filter_input(INPUT_GET , 'dataPasseio', FILTER_SANITIZE_STRING);
    $id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    //VERFICANDO SE O ID FOI ENVIADO
    if(!empty($id)){

        //VERIFICANDO SE EXISTEM PAGAMENTOS NO PASSEIO
        $verificaSeExistemPagamentos ="SELECT idPagamento FROM pagamento_passeio WHERE idPasseio =$id";
        $resultadoVerificaSeExistemPagamentos = mysqli_query($conexao, $verificaSeExistemPagamentos);
        $resultado = mysqli_num_rows($resultadoVerificaSeExistemPagamentos);
        $idUser = $_SESSION['id'];

        //DELETANDO UM PASSEIO E DESPESAS
        if($resultado == 0){
            $getDataDespesa = "DELETE FROM despesa WHERE idPasseio ='$id'";
            $deleteDataDespesa = mysqli_query ($conexao, $getDataDespesa );
            $getDataPasseio = "DELETE FROM passeio WHERE idPasseio ='$id'";
            $inserDataPasseio = mysqli_query ($conexao, $getDataPasseio );
            if(mysqli_affected_rows($conexao)){
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Passeio APAGADO com sucesso</p>";
                header("refresh:0.5; url=../pesquisarPasseio.php");
            }else{
                $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Passeio NÃO foi APAGADO </p>";
                header("refresh:0.5; url= ../pesquisarPasseio.php");
            }
            gerarLog("DELETAR PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, null , 0);
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>RESOLVA OS PAGAMENTOS FEITOS NESSE PASSEIO ANTES DE DELETAR</p>";
            header("refresh:0.5; url=../pesquisarPasseio.php");
            gerarLog("DELETAR PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, null , 1);
        }


    }

?>