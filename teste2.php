<?php




session_start();

include_once("PHP/functions.php");

    $idade = calcularIdade("1", $conn,"");
    echo $idade;
?>
