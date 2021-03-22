<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>

  <title>PESQUISAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <p class="h2 text-center">PESQUISAR PASSEIO</p>
          <form action="" autocomplete="off" method="GET">
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" name="valorPesquisaPasseio" id="" placeholder="NOME OU LOCAL" onkeydown="upperCaseF(this)">
              </div>
              <div class="col">
                <input type="date" class="form-control" name="dataPasseio" id="dataPasseio">
              </div>
            </div>
            <div class="form-row">
              <div class="col ml-3 mt-2">
                <input class="form-check-input " type="checkbox" name="mostrarPasseiosExcluidos" value="1" id="mostrarPasseiosExcluidos">
                <label class="form-check-label " for="mostrarPasseiosExcluidos">
                  EXIBE PASSEIOS ENCERRADOS
                </label>
              </div>
            </div>
              <div class="form-row">
                <div class="col">  
                  <input type="submit" value="PESQUISAR" name="enviaPesqNome" class="btn btn-info btn-md">
                </div>
                <div class="col"> 
                  <input type="submit" value="PESQUISAR" name="enviaPesqData" class="btn btn-info btn-md float-right">
                </div>
              </div>
          </form>
          <div class="table-reponsive">
              <?php esconderTabela(6); ?>
            </div>
          <div class="table mt-5">
            <table class="table table-striped table-bordered" id="userTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>NOME</th>
                  <th>DATA</th>
                  <th>LOCAL</th>
                  <th>VAGAS</th>
                  <th>AÇÕES</th>
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
                        <?php echo "<a class='btn btn-info btn-just-icon btn-sm '  href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' ><i class='material-icons'>groups</i></a>"; ?>
                        <?php echo "<a class='btn btn-success btn-just-icon btn-sm' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' ><i class='material-icons'>price_check</i></a>"; ?>
                        <?php echo "<a class='btn btn-warning btn-just-icon btn-sm'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'><i class='material-icons'>edit</i>  </a>"; ?>
                        <?php echo "<a class='btn btn-danger btn-just-icon btn-sm' onclick='javascript:confirmationDeletePasseio($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "&dataPasseio=" . $valorPesquisaPasseio['dataPasseio'] . "&nomePasseio=" . $valorPesquisaPasseio['nomePasseio'] . "' ><i class='material-icons'>delete_forever</i></a>"; ?>
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
                        <?php echo "<a class='btn btn-primary btn-sm ml-4' href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' ><i class='material-icons'>groups</i></a>"; ?>
                        <?php echo "<a class='btn btn-primary btn-sm mt-1' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' ><i class='material-icons'>price_check</i></a>"; ?>
                        <?php echo "<a class='btn btn-primary btn-sm ml-1'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'><i class='material-icons'>edit</i>  </a>"; ?>
                        <?php echo "<a class='btn btn-primary btn-sm mt-1' onclick='javascript:confirmationDeletePasseio($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "&dataPasseio=" . $valorPesquisaPasseio['dataPasseio'] . "&nomePasseio=" . $valorPesquisaPasseio['nomePasseio'] . "' ><i class='material-icons'>delete_forever</i></a>"; ?>
                      </td>
                    </tr>
                <?php
                  }
                };
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="config/script.php"></script>
</body>

</html>