<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>PESQUISAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="container-fluid mt-4">
    <div class="container-fluid ">
      <p class="h2 text-center">PESQUISAR PASSEIO</p>
      <form action="" autocomplete="off" method="GET">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="nomePasseio">PESQUISAR</label>
          <input type="text" class="form-control col-sm-4" name="valorPesquisaPasseio" id="" placeholder="NOME OU LOCAL" onkeydown="upperCaseF(this)">
          <label class="col-sm-2 col-form-label" for="inicioDataPasseio">DATA:</label>
          <input type="date" class="form-control col-sm-3" name="dataPasseio" id="dataPasseio">
        </div>

        <input type="submit" value="PESQUISAR" name="enviaPesqNome" class="btn btn-primary btn-lg">
        <input type="submit" value="PESQUISAR" name="enviaPesqData" class="btn btn-primary btn-lg float-right">
        <div class="row ml-5">
          <input class="form-check-input " type="checkbox" name="mostrarPasseiosExcluidos" value="1" id="mostrarPasseiosExcluidos">
          <label class="form-check-label " for="mostrarPasseiosExcluidos">
            EXIBE PASSEIOS ENCERRADOS
          </label>
        </div>

      </form>
    </div>
  </div>
  <div class="table mt-5">
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>DATA</th>
          <th>LOCAL</th>
          <th>VAGAS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        /* -----------------------------------------------------------------------------------------------------  */
        $enviaPesqNome = filter_input(INPUT_GET, 'enviaPesqNome', FILTER_SANITIZE_STRING);
        $enviaPesqData = filter_input(INPUT_GET, 'enviaPesqData', FILTER_SANITIZE_STRING);
        $mostrarPasseiosExcluidos = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);
        $exibePasseio = (empty($mostrarPasseiosExcluidos) or is_null($mostrarPasseiosExcluidos)) ? false : true;
        $queryExibePasseio = ($exibePasseio == false) ? 'AND statusPasseio NOT IN (0) ' : ' ';

        /* -----------------------------------------------------------------------------------------------------  */
        if ($enviaPesqNome) {
          /* -----------------------------------------------------------------------------------------------------  */
          $valorPesquisaPasseio     = filter_input(INPUT_GET, 'valorPesquisaPasseio', FILTER_SANITIZE_STRING);
          $valorPesquisaData     = filter_input(INPUT_GET, 'dataPasseio', FILTER_SANITIZE_STRING);

          /* -----------------------------------------------------------------------------------------------------  */
          $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio, p.lotacao 
                                      FROM passeio p WHERE  p.nomePasseio LIKE '%$valorPesquisaPasseio%' $queryExibePasseio OR p.localPasseio LIKE '%$valorPesquisaPasseio%' $queryExibePasseio ORDER BY dataPasseio";
          $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
          while ($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)) {
            $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
            $idPasseio = $valorPesquisaPasseio['idPasseio'];
        ?>
            <tr>
              <th><?php echo $valorPesquisaPasseio['idPasseio'] . "<BR/>"; ?></th>
              <td><?php echo $valorPesquisaPasseio['nomePasseio'] . "<BR/>"; ?></td>
              <td><?php echo date_format($dataPasseio, "d/m/Y") . "<BR/>"; ?></td>
              <td><?php echo $valorPesquisaPasseio['localPasseio'] . "<BR/>"; ?></td>
              <td></td>
              <td>
                <?php echo "<a class='btn btn-primary btn-sm ml-4' href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >LISTA</a><br>"; ?>
                <?php echo "<a class='btn btn-primary btn-sm mt-1' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >RELATÓRIOS</a><br>"; ?>
              </td>
              <td>
                <?php echo "<a class='btn btn-primary btn-sm ml-1'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'>EDITAR  </a><br>"; ?>
                <?php echo "<a class='btn btn-primary btn-sm mt-1' onclick='javascript:confirmationDeletePasseio($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "&dataPasseio=" . $valorPesquisaPasseio['dataPasseio'] . "&nomePasseio=" . $valorPesquisaPasseio['nomePasseio'] . "' >DELETAR</a><br><hr>"; ?>
              </td>
            </tr>
          <?php
          }
        } elseif ($enviaPesqData) {
          $valorPesquisaPasseioData = filter_input(INPUT_GET, 'dataPasseio',          FILTER_SANITIZE_STRING);
          $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio 
                                      FROM passeio p WHERE p.dataPasseio='$valorPesquisaPasseioData' $queryExibePasseio ORDER BY dataPasseio";
          $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
          while ($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)) {
            $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
            $idPasseio = $valorPesquisaPasseio['idPasseio'];
          ?>
            <tr>
              <th><?php echo $valorPesquisaPasseio['idPasseio'] . "<BR/>"; ?></th>
              <td><?php echo $valorPesquisaPasseio['nomePasseio'] . "<BR/>"; ?></td>
              <td><?php echo date_format($dataPasseio, "d/m/Y") . "<BR/>"; ?></td>
              <td><?php echo $valorPesquisaPasseio['localPasseio'] . "<BR/>"; ?></td>
              <td>
                <?php echo "<a class='btn btn-primary btn-sm ml-4' href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >LISTA</a><br>"; ?>
                <?php echo "<a class='btn btn-primary btn-sm mt-1' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >RELATÓRIOS</a><br>"; ?>
              </td>
              <td>
                <?php echo "<a class='btn btn-primary btn-sm ml-1'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'>EDITAR  </a><br>"; ?>
                <?php echo "<a class='btn btn-primary btn-sm mt-1' onclick='javascript:confirmationDeletePasseio($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "&dataPasseio=" . $valorPesquisaPasseio['dataPasseio'] . "&nomePasseio=" . $valorPesquisaPasseio['nomePasseio'] . "' >DELETAR</a><br><hr>"; ?>
              </td>
            </tr>
        <?php
          }
        };
        ?>
      </tbody>
    </table>
  </div>
  <script src="config/script.php"></script>
</body>

</html>