<?php 
$dbHost = "localhost"
$dbUser = "root"
$dbPass = ""
$dbName = "sistemafabio"

$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error)
}

echo "Conexão bem sucedida";

?>