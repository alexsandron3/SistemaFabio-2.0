<?php
    include_once("conexao.php");
    function cadastro($getData, $conexao, $tipoCadastro, $paginaRedirecionamento) {
        $getData = $getData;
        $insertData = mysqli_query($conexao, $getData);
        if(mysqli_insert_id($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'> $tipoCadastro CADASTRADO(A) com sucesso</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoCadastro NÃO foi CADASTRADO(A), alguma informação não foi inserida dentro dos padrões. </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php");
        }
    }

    function atualizar($getData, $conexao, $tipoAtualizacao, $paginaRedirecionamento, $id){
        $insertData = mysqli_query($conexao, $getData);

        /* -----------------------------------------------------------------------------------------------------  */
        
        if(mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoAtualizacao ATUALIZADO(A) com sucesso</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoAtualizacao não foi ATUALIZADO(A) </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }
    }

    function valorSeguroviagem ($statusEditaSeguroViagemCliente, $idPasseio, $idPagamento, $conexao, $idadeCliente){
        $queryValorSeguroViagem = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
        $resultadoValorSeguroViagem = mysqli_query($conexao,$queryValorSeguroViagem);
        $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
        $valorSeguroViagem = $rowSeguroViagem ['valorSeguroViagem'];
        #--------------------------------------------------------------------------------------------------
        $queryStatusSeguroViagem = "SELECT seguroViagem FROM pagamento_passeio WHERE idPagamento=$idPagamento";
        $resultadoStatusSeguroViagem = mysqli_query($conexao, $queryStatusSeguroViagem);
        $rowStatusSeguroViagem = mysqli_fetch_all($resultadoStatusSeguroViagem);
        $statusSeguroViagem = $rowStatusSeguroViagem ['seguroViagem'];
    
        if($statusEditaSeguroViagemCliente == 1){
            
            if($statusSeguroViagem == 1){
                $novoValorSeguroViagem = $valorSeguroViagem;
            }else{
                if($idadeCliente >= 0 and $idadeCliente <=85){
                    $novoValorSeguroViagem = $valorSeguroViagem + 2.47;
                }else{
                    $novoValorSeguroViagem = $valorSeguroViagem + 0;

                }     
            }
        }else{
            if($statusSeguroViagem == 1){
                if($idadeCliente >= 0 and $idadeCliente <=85){
                    $novoValorSeguroViagem = $valorSeguroViagem - 2.47;
                }else{
                    $novoValorSeguroViagem = $valorSeguroViagem - 0;

                }
                
            }
        }
        return $novoValorSeguroViagem;   

    }



?>