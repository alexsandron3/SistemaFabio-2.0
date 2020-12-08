<?php

    session_start();

    include_once("../PHP/conexao.php");



    /* -----------------------------------------------------------------------------------------------------  */



    $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $buscaPeloIdPasseio = "SELECT DISTINCT 

                              c.nomeCliente, c.cpfCliente, c.orgaoEmissor, c.idadeCliente 

                            FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente

                            ";

    

    

    /* -----------------------------------------------------------------------------------------------------  */

    $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);  

    $columnHeader = '';  

    $columnHeader = "NOME" . "\t". "CPF" ."\t". "EMISSOR" . "\t" . "IDADE" . "\t";  

    $setData = '';  

      while ($rec = mysqli_fetch_row($setRec)) {  

        $rowData = '';  

        foreach ($rec as $value) {  

            $value = '"' . $value . '"' . "\t";  

            $rowData .= $value;  

        }  

        $setData .= trim($rowData) . "\n";  

    }  

      

    header("Content-type: application/octet-stream");  

    header("Content-Disposition: attachment; filename=detalhes_usuarios.xls");  

    header("Pragma: no-cache");  

    header("Expires: 0");  

    

      echo ucwords($columnHeader) . "\n" . $setData . "\n"; 


?>

