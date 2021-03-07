<?php
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
    function validarNivelAceso(){
        if($_SESSION['nivelAcesso'] == 0 ){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => true,
                "atualizar"     => true,
                "visualizar"    => true,
                "apagar"        => true,
                "transferir"    => true,
                "visualizarLog" => true

            );

            
        }else if ($_SESSION['nivelAcesso'] == 1){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => true,
                "atualizar"     => true,
                "visualizar"    => true,
                "apagar"        => true,
                "transferir"    => true,
                "visualizarLog" => false

            );
        }else if ($_SESSION['nivelAcesso'] == 2){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => false,
                "atualizar"     => false,
                "visualizar"    => true,
                "apagar"        => false,
                "transferir"    => false,
                "visualizarLog" => false

            );
        }
        return $operacoesPermitidas;
    }
    
    function retornaPermissao ($opcao){
        $operacoesPermitidas = validarNivelAceso();
        switch ($opcao) {
            case 'gerarLog':
                $permissao = $operacoesPermitidas ['gerarLog'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;
            
            case 'cadastrar':
                $permissao = $operacoesPermitidas ['cadastrar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;

            case 'atualizar':
                $permissao = $operacoesPermitidas ['atualizar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;                
            
            case 'visualizar':
                $permissao = $operacoesPermitidas ['visualizar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;                
            
            case 'apagar':
                $permissao = $operacoesPermitidas ['apagar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;                
            
            case 'transferir':
                $permissao = $operacoesPermitidas ['transferir'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;                
            
            case 'visualizarLog':
                $permissao = $operacoesPermitidas ['visualizarLog'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                return $permissao;
                break;                 
            default:
                return false;
            break;
        
        }
          
    }

    var_dump(retornaPermissao("cadastrar"));






