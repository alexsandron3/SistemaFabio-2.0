<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.idCliente, pp.localEmbarque, pp.anotacoes
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) AND pp.clienteDesistente NOT IN(1) ORDER BY localEmbarque";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
/* -----------------------------------------------------------------------------------------------------  */

$pegarNomePasseio = "SELECT nomePasseio, lotacao, dataPasseio FROM passeio WHERE idPasseio='$idPasseioGet'";
$resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
$rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
$nomePasseioTitulo = $rowpegarNomePasseio['nomePasseio'];
$lotacao = $rowpegarNomePasseio['lotacao'];
$dataPasseio = date_create($rowpegarNomePasseio['dataPasseio']);

/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/dataTables/dataTablesHead.php"); ?>


  <title>PONTO DE EMBARQUE </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ml-1">
                  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                  <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1">   
            
          <?php 
          mensagensInfoNoSession($nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . "</BR> PONTOS DE EMBARQUE");
          #echo "<p class='h5 text-center alert-info '>" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . "</BR> PONTOS DE EMBARQUE</p>"; ?>
    <table class="table table-striped table-hover table-bordered" id="userTable">
      <thead>
        <tr>
          <th>NOME</th>
          <th>PONTO EMBARQUE</th>
          <th>IDADE</th>
          <th>ANOTAÇÕES</th>
        </tr>
      </thead>

      <tbody>
        <?php

        while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {



        ?>
          <tr>
            <td><?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?></td>
            <td><?php echo $rowBuscaPasseio['localEmbarque'] . "<BR/>"; ?></td>
            <td><?php $idade = calcularIdade($rowBuscaPasseio['idCliente'], $conn, "");
                echo $idade . "<BR/>"; ?></td>
            <td><?php echo $rowBuscaPasseio['anotacoes'] . "<BR/>"; ?></td>
          </tr>

        <?php


        }

        ?>
      </tbody>
    </table>
    <a target="_blank" href="SCRIPTS/exportarPontoEmbarque.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info ml-5">EXPORTAR</a>

  </div>
  <script src="config/script.php"></script>
</body>

</html>