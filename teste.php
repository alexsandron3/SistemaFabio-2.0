<pre>

<?php
       if(!isset($_SESSION)) 
       { 
           session_start(); 
       } 
 
   include_once("./includes/header.php");
   


    $query = "SELECT  dataNascimento, nomeCliente FROM cliente WHERE statusCliente = 1 AND dataNascimento NOT IN (' ')"; 
    $executaQuery = mysqli_query($conexao, $query);
    while($rowDataNascimento = mysqli_fetch_assoc($executaQuery)){
        $dataAniversarioCliente = '';
        $dataNascimento = $rowDataNascimento['dataNascimento'];
        $nomeCliente = $rowDataNascimento['nomeCliente'];

        $dataAniversariante = new DateTime($dataNascimento, );
        $dataDeHoje = new DateTime('today');
        

        $mesAniversariante = $dataAniversariante->format('m');
        $mesAtual = $dataDeHoje->format('m');

        $diaAniversariante = $dataAniversariante->format('d');
        $diaAtual = $dataDeHoje->format('d');

     
        if($mesAniversariante == $mesAtual){
            $dataAniversarioCliente = $dataAniversariante->format('d/m/Y');
            $arrayA[] = $rowDataNascimento['nomeCliente'];
            $arrayB[] = $rowDataNascimento['dataNascimento'];
            $informacoesClienteAniversariante[] = array (
                                                    'nomeCliente' => $rowDataNascimento['nomeCliente'],
                                                    'dataNascimento' => $rowDataNascimento['dataNascimento']
                                                );
        }
        if($mesAniversariante == $mesAtual AND $diaAniversariante == $diaAtual){


        }


    }
    #echo count($informacoesClienteAniversariante);
    print_r($arrayB);




?> 
