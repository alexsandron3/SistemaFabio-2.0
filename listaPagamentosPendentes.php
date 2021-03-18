<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$ordemPesquisa = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
$ordemPesquisa = (empty($ordemPesquisa)) ? "nomeCliente" : $ordemPesquisa;

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>LISTA DE PAGAMENTOS PENDENTES</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>


  <?php
  $query = " SELECT c.nomeCliente, c.idCliente, pp.idPagamento, pp.valorPendente, pp.previsaoPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio 
           FROM  pagamento_passeio pp, cliente c, passeio p 
           WHERE statusPagamento NOT IN (0,3) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ORDER BY $ordemPesquisa";
  $executaQuery = mysqli_query($conexao, $query);
  $quantidadePagamentoPendente = mysqli_num_rows($executaQuery);
  $queryValorTotalPendente = "SELECT SUM(valorPendente) AS valorTotalPendente 
                                    FROM pagamento_passeio pp, cliente c, passeio p 
                                    WHERE statusPagamento NOT IN (0,3) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ";
  $executaQueryValorTotalPendente = mysqli_query($conexao, $queryValorTotalPendente);
  $rowValorTotalPendente = mysqli_fetch_assoc($executaQueryValorTotalPendente);
  echo "<p class='h4 text-center alert-info mt-2'> QUANTIDADE DE PAGAMENTOS PENDENTES:  " . $quantidadePagamentoPendente . "</p>";
  ?>
  <table class="table table-sm table-dark mt-3">
    <thead>
      <tr>
        <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=nomeCliente"> NOME </a></th>
        <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=idPagamento">PAGAMENTO </a></th>
        <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=nomePasseio">PASSEIO </a></th>
        <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=valorPendente">PENDENTE : R$ <?php echo number_format($rowValorTotalPendente['valorTotalPendente'] * -1.00, 2, '.', ''); ?> </a></th>
        <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=previsaoPagamento ASC"> PREVISÃO PAGAMENTO </a></th>
      </tr>
    </thead>

    <tbody>
      <?php


      while ($rowPagamentosPendentes = mysqli_fetch_assoc($executaQuery)) {



      ?>
        <tr>
          <td scope="row"> <?php echo " <a target='_blank' href='editarCliente.php?id=" . $rowPagamentosPendentes['idCliente'] . "'>" . $rowPagamentosPendentes['nomeCliente'] . "</a>"; ?></td>
          <td><?php echo " <a target='_blank' href='editarPagamento.php?id=" . $rowPagamentosPendentes['idPagamento'] . "'>" . $rowPagamentosPendentes['idPagamento'] . "</a>"; ?></td>
          <td><?php
              $dataPasseio = date_create($rowPagamentosPendentes['dataPasseio']);
              echo " <a target='_blank' href='listaPasseio.php?id=" . $rowPagamentosPendentes['idPasseio'] . "'>" . $rowPagamentosPendentes['nomePasseio'] . " | " . date_format($dataPasseio, "d/m/Y") . " </a>";
              ?>
          </td>
          <td><?php echo " <a target='_blank' href='editarPagamento.php?id=" . $rowPagamentosPendentes['idPagamento'] . "'>" . number_format($rowPagamentosPendentes['valorPendente'] * -1.00, 2, '.', '') . "</br> </a>"; ?></td>
          <td> <?php
                if ($rowPagamentosPendentes['previsaoPagamento'] != "0000-00-00") {
                  $dataPagamento = date_create($rowPagamentosPendentes['previsaoPagamento']);

                  echo date_format($dataPagamento, 'd/m/Y');
                }
                ?>
          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>

  <a target="_blank" href="includes/servicos/exportarExcel/exportarTodosPagamentosPendentes.php" class="btn btn-info ml-5 mb-2">EXPORTAR</a>

</html>