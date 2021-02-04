<?php
   session_start();
   header("Content-type: text/html; charset=utf-8");
   include_once("../PHP/conexao.php");

   /* -----------------------------------------------------------------------------------------------------  */



   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT p.nomePasseio, p.idPasseio, c.nomeCliente, c.cpfCliente, c.dataNascimento, pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, SUBSTRING_INDEX(c.nomeCliente, ' ', 1) AS primeiroNome 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
                            #ECHO$buscaPeloIdPasseio;

   

   

   /* -----------------------------------------------------------------------------------------------------  */
   $comecoContador0 = 1;
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);

   
   /* -----------------------------------------------------------------------------------------------------  */
   $rowDados = mysqli_fetch_array($setRec);
  

   /* -----------------------------------------------------------------------------------------------------  */

  $dados = '';
  echo "NOME" . "\t". "DATA NASCIMENTO" ."\t". "NUMERO DOCTO" . "\t" ."VALOR" . "\t" ."NOME SEGURO VIAGEM". "\n";
  while($rowDados = mysqli_fetch_array($setRec)){
    
    $comecoContador = 1;
    $nomeCliente = $rowDados['nomeCliente'];
    $dataNascimento = $rowDados['dataNascimento'];
    $numeroDocumento = $rowDados['cpfCliente'];
    $valorSeguroViagem = 2.47;
    $primeiroNome = $rowDados['primeiroNome'];

    if (($pos = strpos($nomeCliente, " ")) !== FALSE) { 
    $nomeSeguroViagem = substr($nomeCliente, strpos($nomeCliente, " ") + 1);    
    #echo $nomeSeguroViagem;
    }else{
      $nomeSeguroViagem = "";
    }

    $dados= $nomeCliente . "\t". $dataNascimento. "\t". $numeroDocumento ."\t". $valorSeguroViagem. "\t". $nomeSeguroViagem. " /$primeiroNome". "\n"; 
    $str = mb_convert_encoding($dados, 'UTF-16LE', 'UTF-8');

    print $dados;

  }

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=Customers_Export.xls');
echo "\xEF\xBB\xBF"; // UTF-8 BOM
?> 