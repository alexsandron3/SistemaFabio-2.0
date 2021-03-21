<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

$inicioDataPasseio           = filter_input(INPUT_GET, 'inicioDataPasseio',       FILTER_SANITIZE_STRING);
$fimDataPasseio              = filter_input(INPUT_GET, 'fimDataPasseio',          FILTER_SANITIZE_STRING);
$mostrarPasseiosExcluidos    = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);
$inicioDataPasseioPadrao = '2000-01-01';
$fimDataPasseioPadrao    = '2099-01-01';

$exibePasseio = (empty($mostrarPasseiosExcluidos) or is_null($mostrarPasseiosExcluidos)) ? false : true;
$queryExibePasseio = ($exibePasseio == false) ? 'AND statusPasseio NOT IN (0)' : ' ';


if (!empty($inicioDataPasseio) and !empty($fimDataPasseio)) {
  $pesquisaIntervaloData = "SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM  passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'  $queryExibePasseio ORDER BY  dataPasseio";

  $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
} else {
  $pesquisaIntervaloData = "SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'  $queryExibePasseio ORDER BY  dataPasseio";
  $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
}
/* -----------------------------------------------------------------------------------------------------  */
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>

  <title>PASSEIOS SELECIONADOS</title>
</head>

<body>
  <?php

  $contador = 0;
  ?>
  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
          <div class="table-responsive">
                    <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                    <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
            <div class="text-center mb-4">
              <h4><small>LISTA DE PASSEIOS</small></h4>
            </div>

            <div class="table-reponsive">
              <table class="table table-striped table-bordered" id="simpleTable" >
                <thead>
                  <tr>
                    <th class="text-center">Nº DE ORDEM</th>
                    <th>Passeio</th>
                    <th>Data</th>
                    <th class="text-right">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  while ($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)) {
                    $dataPasseio = (empty($rowPesquisaIntervaloData['dataPasseio'])) ? "" : date_create($rowPesquisaIntervaloData['dataPasseio']);
                    $dataPasseioFromatada = (empty($dataPasseio)) ? "" : date_format($dataPasseio, "d/m/Y");

                    /* -----------------------------------------------------------------------------------------------------  */
                  ?>
                    <tr>
                      <td class="text-center"><?php echo ++$contador; ?></td>
                      <td><?php echo $rowPesquisaIntervaloData['nomePasseio']; ?></td>
                      <td><?php echo $dataPasseioFromatada ?></td>
                      <td class="td-actions text-right">

                        <a href="listaPasseio.php?id=<?php echo $rowPesquisaIntervaloData['idPasseio']; ?>" class="btn btn-info btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">groups</i>
                        </a>
                        <a href="editaDespesas.php?id=<?php echo $rowPesquisaIntervaloData['idPasseio']; ?>" class="btn btn-danger btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">money_off</i>
                        </a>
                        <a href="relatoriosDoPasseio.php?id= <?php echo $rowPesquisaIntervaloData['idPasseio']; ?>" class="btn btn-dark btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">summarize</i>
                        </a>
                        <a href="relatoriosPasseio.php?id=<?php echo $rowPesquisaIntervaloData['idPasseio']; ?>" class="btn btn-success btn-just-icon btn-sm" target="_blank">
                          <i class="material-icons">price_check </i>

                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>

</html>