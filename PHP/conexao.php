<?php 
$dbHost = "mysql742.umbler.com";
$dbUsuario = "adminfabio";
$dbSenha = "mengo007";
$dbNome = "fabiosistema";

//CRIANDO CONEXÃO
$conexao = mysqli_connect($dbHost, $dbUsuario, $dbSenha, $dbNome);

//VERIFICANDO CONEXÃO
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}


?>


