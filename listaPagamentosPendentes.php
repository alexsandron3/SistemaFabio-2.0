<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$ordemPesquisa = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
$ordemPesquisa = (empty($ordemPesquisa)) ? "nomeCliente" : $ordemPesquisa;

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>

  <title>LISTA DE PAGAMENTOS PENDENTES</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>



  <?php
  $contador=0; 
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
  ?>
  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
                  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                  <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1"> <?php
          mensagensInfoNoSession("QUANTIDADE DE PAGAMENTOS PENDENTES:  " . $quantidadePagamentoPendente);
          #echo "<p class='h4 text-center alert-info mt-2'> QUANTIDADE DE PAGAMENTOS PENDENTES:  " . $quantidadePagamentoPendente . "</p>"; ?>


            <div class="table-responsive">
              <table style="width:100%" class="table table-striped table-bordered" id="userTable">
                <thead>
                  <tr>
                  <th > <a href="#"> Nº DE ORDEM </a></th>
                    <th> <a href="#"> NOME </a></th>
                    <th> <a href="#">Nº PEDIDO </a></th>
                    <th> <a href="#">PASSEIO </a></th>
                    <th> <a href="#">PENDENTE  <?php/*  echo number_format($rowValorTotalPendente['valorTotalPendente'] * -1.00, 2, '.', ''); */ ?> </a></th>
                    <th> <a href="#"> PREVISÃO PAGAMENTO </a></th>
                    <th class="text-right"> <a href="#"> AÇÕES </a></th>
                  </tr>
                </thead>

                <tbody>
                  <?php


                  while ($rowPagamentosPendentes = mysqli_fetch_assoc($executaQuery)) {



                  ?>
                    <tr class="text-muted">
                    <td class="text-center"><?php echo ++$contador; ?></td>
                      <td scope="row"> <?php echo  $rowPagamentosPendentes['nomeCliente']; ?></td>
                      <td><?php echo $rowPagamentosPendentes['idPagamento']; ?></td>
                      <td><?php
                          $dataPasseio = date_create($rowPagamentosPendentes['dataPasseio']);
                          echo $rowPagamentosPendentes['nomePasseio'] . " | " . date_format($dataPasseio, "d/m/Y");
                          ?>
                      </td>
                      <td><?php echo "R$" . number_format($rowPagamentosPendentes['valorPendente'] * -1.00, 2, '.', ''); ?></td>
                      <td> <?php
                            if ($rowPagamentosPendentes['previsaoPagamento'] != "0000-00-00") {
                              $dataPagamento = date_create($rowPagamentosPendentes['previsaoPagamento']);

                              echo date_format($dataPagamento, 'd/m/Y');
                            }
                            ?>
                      </td>
                      <td class="td-actions text-right">
                        <a href="editarCliente.php?id=<?php echo $rowPagamentosPendentes['idCliente']; ?>" class="btn btn-warning btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">manage_accounts</i>
                        </a>
                        <a href="editarPagamento.php?id=<?php echo $rowPagamentosPendentes['idPagamento']; ?>" class="btn btn-warning btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">payment</i>
                        </a>
                        <a href="listaPasseio.php?id=<?php echo $rowPagamentosPendentes['idPasseio']; ?>" class="btn btn-info btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">local_airport</i>
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                <tfoot>
                  <tr>
                    <th colspan="5" style="text-align:right">Total:</th>
                  </tr>
                </tfoot>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

</html>