<?php
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");

    

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

    function calcularIdade ($idCliente, $conn, $data){
        $queryBuscaDataNascimento = "SELECT dataNascimento FROM cliente WHERE idCliente =$idCliente";
        $resultadoBuscaDataNascimento = $conn->query($queryBuscaDataNascimento);
        $rowBuscaDataNascimento = $resultadoBuscaDataNascimento ->fetch_assoc();
        
        if(empty($data)){
            $dataNascimento = new DateTime ($rowBuscaDataNascimento['dataNascimento']);
        }else{
            $dataNascimento = new DateTime($data);
        }
        $hoje           = new DateTime();
        $diferenca      = $hoje->diff($dataNascimento);
        $idade          = $diferenca->y;

        return $idade;

    }




?>