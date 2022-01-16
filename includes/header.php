<?php
    require  __DIR__ . '../../vendor/autoload.php';
    require_once(__DIR__ . '../../api/AuthMiddleware.php');
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__. '\..' );
    $dotenv->safeLoad();
    //CHARSET
    header("Content-type: text/html; charset=utf-8");

    //VERIFICAÇÃO DE SESSÃO
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    include_once("functions.php");

    include_once("constantes.php");
