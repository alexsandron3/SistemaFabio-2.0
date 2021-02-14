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
        
        if(mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoAtualizacao ATUALIZADO(A) com sucesso</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoAtualizacao não foi ATUALIZADO(A) </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }
    }

    function apagar($getData, $conexao, $tipoDelete, $idPagamento, $idPasseio, $paginaRedirecionamento){
        if(!empty($idPagamento OR $idPasseio)){
            $deleteData = mysqli_query ($conexao, $getData );
            if( mysqli_affected_rows($conexao)){
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoDelete APAGADO(A) com sucesso</p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");
            }else {
                $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoDelete NÃO foi APAGADO(A) </p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");

            }
        }else {
            $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um $tipoDelete</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");

        }
    }

    function calcularIdade ($idCliente, $conn, $data = ""){
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

    function statusPagamento($valorPendenteCliente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro){

        if($valorPendenteCliente < 0 AND $valorPago == 0 AND $clienteParceiro == 0){
            $statusPagamento = 0; //NÃO PAGO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif( $valorPendenteCliente == 0 AND $clienteParceiro == 0){
            $statusPagamento = 1; //PAGO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif($valorPendenteCliente < 0 AND $valorPago > 0 AND $clienteParceiro == 0){
            $statusPagamento = 2; //INTERESSADO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif($clienteParceiro == 1){
            $statusPagamento = 3; // PARCEIRO
            
        }elseif($idadeCliente <= $idadeIsencao){
            $statusPagamento = 4; // CRIANÇA
        }
        return $statusPagamento;
    }

    function seguroViagem(){
        
    }




?>