<?php 
$dbHost = "fdb28.awardspace.net	";
$dbUsuario = "3735917_fabiosistema";
$dbSenha = "@L3xsandro";
$dbNome = "3735917_fabiosistema";

//CRIANDO CONEXÃO
$conexao = mysqli_connect($dbHost, $dbUsuario, $dbSenha, $dbNome);

//VERIFICANDO CONEXÃO
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}


?>


