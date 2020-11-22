<?php
session_start();
include_once("../PHP/conexao.php");
$id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)){
    $pesquisaCliente = "DELETE FROM cliente WHERE idCliente ='$id'";
    $resultadoPesquisaCliente = mysqli_query ($conexao, $pesquisaCliente );
    
    if( mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Usuário APAGADO com sucesso</p>";
        echo '<script> window.setTimeout("window.close()", 2000); </script>';

    
    }else {
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Usuário NÃO foi APAGADO </p>";
        header("refresh:0.5; url= index.php");
    
    }


}else {
    $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um usuário</p>";
    header("refresh:0.5; url=../pesquisaCliente.php");

}

?>