<?php
    session_start();
    include_once("../PHP/conexao.php");

    /* -----------------------------------------------------------------------------------------------------  */

    $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $buscaPeloIdPasseio = "SELECT DISTINCT 
                            p.nomePasseio, p.dataPasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.cpfCliente, c.orgaoEmissor, c.idadeCliente,  pp.statusPagamento 
                            FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente
                            ";
    $resultadoBuscaPasseio = mysqli_query($conexao, $buscaPeloIdPasseio);
    $cliente = array();
    
    /* -----------------------------------------------------------------------------------------------------  */
    
    
    if (mysqli_num_rows($resultadoBuscaPasseio) > 0) {
        while ($row = mysqli_fetch_assoc($resultadoBuscaPasseio)) {
            $cliente[] = $row;
        }
    }
    header("Content-Type: text/plain");    
    header("Content-Disposition: attachment; filename=filename.xls");  
    header("Pragma: no-cache"); 
    header("Expires: 0");
    $output = fopen('php://output', 'w');
    fputcsv($output, array('NOME', 'CPF', 'EMISSOR', 'IDADE', 'STATUS'));

    if (count($cliente) > 0) {
        foreach ($cliente as $row) {
            fputcsv($output, $row);
            echo implode("\t", array_keys($row)) . "\r\n";
        }
    }
?>