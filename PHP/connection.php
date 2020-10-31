<?php 
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "sistema_teste";

//CRIANDO CONEXÃO
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

//VERIFICANDO CONEXÃO
if (!$connection) {
    die("Conexão falhou: " . mysqli_connect_error());
}

echo "Conexão bem sucedida";

?>