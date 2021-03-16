<?php
    //CHARSET
    header("Content-type: text/html; charset=utf-8");

    //VERIFICAÇÃO DE SESSÃO
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    //VERIFICANDO SE USUÁRIO ESTÁ LOGADO
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
        }


    //ARQUIVOS NECESSÁRIOS PARA UM INCLUDE
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");
    include_once("functions.php");
    include_once("servicos/servicoValidacaoPermissao.php");
    include_once("servicos/servicoRedirecionamento.php");
    include_once("constantes.php");

    



?>