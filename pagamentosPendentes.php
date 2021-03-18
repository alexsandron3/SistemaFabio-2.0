<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
if (empty($ordemPesquisa)) {
  $ordemPesquisa = 'referencia';
}
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.idCliente, c.referencia, pp.valorPendente , pp.anotacoes, pp.statusPagamento
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0,1,3) AND pp.clienteDesistente NOT IN(1) ORDER BY $ordemPesquisa";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
$queryValorPendenteTotal = "SELECT SUM(valorPendente) AS valorPendenteTotal FROM pagamento_passeio WHERE idPasseio=$idPasseioGet AND statusPagamento NOT IN (0,1,3) AND clienteDesistente NOT IN(1)";
$resultadoTotalPendente = mysqli_query($conexao, $queryValorPendenteTotal);
$rowTotalPendente = mysqli_fetch_assoc($resultadoTotalPendente);
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


  <title>PAGAMENTOS PENDENTES </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="table mt-3">
    <?php echo "<p class='h5 text-center alert-info '>" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . "</BR> PAGAMENTOS PENDENTES</p>"; ?>
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th> <a href="pagamentosPendentes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=nomeCliente"> NOME </a></th>
          <th> <a href="pagamentosPendentes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=referencia">REFERENCIA </a></th>
          <th> <a href="pagamentosPendentes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=valorPendente">PAGTO PENDENTE </a></th>
          <th> ANOTAÇÕES </th>
        </tr>
      </thead>

      <tbody>
        <?php
        $controleListaPasseio = 0;
        while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {
          $nomePasseio = $rowBuscaPasseio['nomePasseio'];
          if ($rowBuscaPasseio['statusPagamento'] == 4 and $rowBuscaPasseio['valorPendente'] == 0) {
          } else {
        ?>
            <tr>
              <th><?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?></th>
              <th><?php echo $rowBuscaPasseio['referencia'] . "<BR/>"; ?></th>
              <th><?php



                  $operador = ($rowBuscaPasseio['valorPendente'] < 0) ? -1 : 1;
                  echo "R$ " . number_format($rowBuscaPasseio['valorPendente'] * $operador, 2, '.', '') . "<BR/>"; ?> </th>
              <th><?php echo $rowBuscaPasseio['anotacoes'] . "<BR/>"; ?></th>
            </tr>

        <?php


          }
        }
        $controleListaPasseio = mysqli_num_rows($resultadoBuscaPasseio);
        ?>
      </tbody>
    </table>
    <?php
    if ($controleListaPasseio > 0) {
      $valorPendenteTotal = $rowTotalPendente['valorPendenteTotal'];
      $operadorTotal = ($valorPendenteTotal < 0) ? -1 : 1;

      echo "<div class='text-center'>";
      echo "<p class='h5 text-center alert-warning'>TOTAL DE R$" . $valorPendenteTotal * $operadorTotal . "  PENDENTE</p>";

      echo "</div>";
    } else {

      echo "<div class='text-center'>";
      echo "<p class='h5 text-center alert-warning'>Nenhum PAGAMENTO PENDENTE até o momento</p>";
      echo "</div>";
    }


    ?>
    <a target="_blank" href="SCRIPTS/exportarPendentes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info ml-5">EXPORTAR</a>

  </div>
  <script src="config/script.php"></script>
</body>

</html>