<?php


    function redirecionamento($paginaRedirecionamento, $id){
        if(!empty($paginaRedirecionamento)){
            if(empty($id)){
                header("refresh:0.5; url=../$paginaRedirecionamento.php");
            }else{
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");

            }
        }else{
            header("refresh:0.5; url=../index.php");
            
        }
    }



?>