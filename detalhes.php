<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$inicio   = filter_input(INPUT_GET, 'inicio',            FILTER_SANITIZE_STRING);
$fim   = filter_input(INPUT_GET, 'fim',            FILTER_SANITIZE_STRING);

/* -----------------------------------------------------------------------------------------------------  */
$filterByUser = ' ';
if ($_SESSION['nivelAcesso'] === 3) {
  $filterByUser = "AND createdBy = {$_SESSION["id"]}";
}
$listaDetalhes = "SELECT p.nomePasseio, p.dataPasseio, pp.valorVendido, pp.valorPago, u.username FROM pagamento_passeio pp, passeio p, users u WHERE createdAt BETWEEN '$inicio' AND '$fim' AND statusPagamento NOT IN (0) AND pp.valorPago > 0 AND p.idPasseio = pp.idPasseio AND pp.idPasseio = 30 $filterByUser AND u.id = pp.createdBy ;";
$resultadolistaDetalhes = mysqli_query($conexao, $listaDetalhes);

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
  <?php include_once("./includes/mdbcss.php"); ?>


  <title>Detalhes </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-2">
    <div class="col-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
          <p class="h2 text-center mb-5">Lista </p>
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1"> <?php
                                    mensagensInfoNoSession($nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y"));
                                    ?>
            <table style="width:100%" class="table table-striped table-bordered" id="tabelaPagamentosPendentes">
              <thead>
                <tr>
                  <th> PASSEIO </th>
                  <th> VALOR VENDA </th>
                  <th> VALOR PAGO</th>
                  <th> USUÁRIO </th>
                </tr>
              </thead>

              <tbody>
                <?php
                $controleListaPasseio = 0;
                while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadolistaDetalhes)) {
                  $nomePasseio = $rowBuscaPasseio['nomePasseio'];
                ?>
                  <tr>
                    <td><?php echo $rowBuscaPasseio['nomePasseio'] ; ?></td>
                    <td><?php echo $rowBuscaPasseio['valorVendido'] ; ?></td>
                    <td>R$<?php echo $rowBuscaPasseio['valorPago'] ; ?></td>
                    <td><?php echo $rowBuscaPasseio['username'] ; ?></td>
                  </tr>

                <?php
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="1" style="text-align:left"></th>
                  <th></th>
                  <th colspan="1" style="text-align:left"></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesDetalhes.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>