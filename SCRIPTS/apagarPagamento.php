<?php
session_start();
include_once("../PHP/conexao.php");
$idPasseio = filter_input(INPUT_GET, 'idPasseio', FILTER_SANITIZE_NUMBER_INT);
$idCliente = filter_input(INPUT_GET, 'idCliente', FILTER_SANITIZE_NUMBER_INT);
$idadeCliente = filter_input(INPUT_GET, 'idadeCliente', FILTER_SANITIZE_NUMBER_INT);
if(!empty($idPasseio || $idCliente)){
    $pesquisaCliente = "DELETE FROM pagamento_passeio WHERE idCliente ='$idCliente' AND idPasseio='$idPasseio'";
    $resultadoPesquisaCliente = mysqli_query ($conexao, $pesquisaCliente );
    
    $valorSeguroViagem = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
    $resultadoValorSeguroViagem = mysqli_query($conexao,$valorSeguroViagem);
    $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
    $valorSeguroViagem = $rowSeguroViagem ['valorSeguroViagem'];
    if($idadeCliente >= 0 and $idadeCliente <=40 ){
        $novoValorSeguroViagem = $valorSeguroViagem - 2.23;
    }elseif($idadeCliente >=41 and $idadeCliente <=60){
        $novoValorSeguroViagem = $valorSeguroViagem - 2.73;
    }elseif($idadeCliente > 60){
        $novoValorSeguroViagem = $valorSeguroViagem - 5.93;
    }else{
        $novoValorSeguroViagem = $valorSeguroViagem - 0;
    }


    
    
    if( mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Pagamento APAGADO com sucesso</p>";
        header("refresh:0.5; url=../listaPasseio.php?id=$idPasseio");
    }else {
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Pagamento NÃO foi APAGADO </p>";
        header("refresh:0.5; url=../listaPasseio.php?id=$idPasseio");
    
    }


}else {
    $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um pagamento</p>";
    header("refresh:0.5; url=../listaPasseio.php?id=$idPasseio");

}

?>