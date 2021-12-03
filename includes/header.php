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

    $allowed = array(
        "cadastroCliente",
        "registroCliente",
        "editarCliente",
        "pesquisarCliente",
        "relatorioDiario",
        "pagamentoCliente",
        "realizaCliente",
        "atualizaCliente",
        "editarPagamento",
        "backend-search"
    );
    // if( $_SESSION['nivelAcesso'] === 3){
    //     $page = explode('/', $_SERVER['REQUEST_URI']);
    //     $fileName = explode('.', end($page));
    //     if (!in_array($fileName[0], $allowed)){
    //         header("location: http://localhost/SistemaFabio-2.0/relatorioDiario.php");
    //         die();
    //     }
    // }


    //ARQUIVOS NECESSÁRIOS PARA UM INCLUDE
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");
    include_once("functions.php");
    include_once("servicos/servicoValidacaoPermissao.php");
    include_once("servicos/servicoRedirecionamento.php");
    include_once("servicos/servicoMsgText.php");
    include_once("servicos/servicoMensagens.php");
    include_once("constantes.php");
    include_once("htmlElements/esconderTabelas.php");
