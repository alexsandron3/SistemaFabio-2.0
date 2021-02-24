<?php
   session_start();
   header("Content-type: text/html; charset=utf-8");
   include_once("../PHP/conexao.php");
   include_once("../PHP/functions.php");
    //echo "<pre>";
   /* -----------------------------------------------------------------------------------------------------  */



   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT  p.nomePasseio, p.dataPasseio, p.idPasseio, c.nomeCliente, c.rgCliente, c.orgaoEmissor, c.idCliente, c.idCliente, c.dataNascimento, pp.idPagamento, pp.valorPago  
                          FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) ORDER BY nomeCliente";
     #echo $buscaPeloIdPasseio;

   

   /* -----------------------------------------------------------------------------------------------------  */
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
   /* -----------------------------------------------------------------------------------------------------  */

  $quantidadeClientes = mysqli_num_rows($setRec);
  $dados = '';
  echo mb_convert_encoding( "NOME" . "\t". "IDADE" ."\t". "EMISSOR". "\n","UTF-16LE","UTF-8");
  
  while($rowDados = mysqli_fetch_array($setRec)){
    $nomePasseio = $rowDados['nomePasseio'];
    $nomePasseioSubstituto = str_replace(" ", $nomePasseio, "_");
    $dataPasseio = date_create($rowDados['dataPasseio']);
    $idCliente = $rowDados['idCliente'];
    $filename = "LISTA DE PASSAGEIROS_".$nomePasseio. $nomePasseioSubstituto. "". date_format($dataPasseio, "d/m/Y");

    $comecoContador = 1;
    $nomeCliente = $rowDados['nomeCliente'];
    $idade = calcularIdade($idCliente, $conn, "");
    $emissor = $rowDados['orgaoEmissor'];



    $dados= $nomeCliente . "\t". $idade. "\t" . $emissor ."\n"; 
    $dados = mb_convert_encoding($dados, "UTF-16LE","UTF-8");

    print $dados;

  }

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');

header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 