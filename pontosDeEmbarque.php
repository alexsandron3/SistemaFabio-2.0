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
  <?php include_once("./includes/head.php"); ?>


  <title>PONTO DE EMBARQUE </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="table mt-3">
    <?php echo "<p class='h5 text-center alert-info '>" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . "</BR> PONTOS DE EMBARQUE</p>"; ?>
    <table class="table table-hover table-dark">
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
            <th><?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?></th>
            <th><?php echo $rowBuscaPasseio['localEmbarque'] . "<BR/>"; ?></th>
            <th><?php $idade = calcularIdade($rowBuscaPasseio['idCliente'], $conn, "");
                echo $idade . "<BR/>"; ?></th>
            <th><?php echo $rowBuscaPasseio['anotacoes'] . "<BR/>"; ?></th>
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