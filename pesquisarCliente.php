<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");


?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>

  <title>PESQUISAR CLIENTE</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- TODO FORM -->
  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
                  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                  <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <p class="h2 text-center">PESQUISAR CLIENTE</p>
          <form action="" autocomplete="off" method="POST" name="formularioPesquisarCliente">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="nomeCliente">INSIRA: </label>
              <div class="col-sm-6">
                <input type="text" class="form-control col-sm-6" name="valorPesquisaCliente" id="" placeholder="CPF OU NOME OU TELEFONE" onkeydown="upperCaseF(this)">
                <input type="hidden" class="form-control col-sm-6" name="" id="paginaSelecionada" placeholder="página" onkeydown="upperCaseF(this)">
              </div>


            </div>
            <input type="submit" value="PESQUISAR" name="enviarPesqCliente" id="enviarPesqCliente" class="btn btn-info">
          </form>

          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="userTable">
              <thead>
                <tr>
                  <th>NOME</th>
                  <th>NASCIMENTO</th>
                  <th>IDADE</th>
                  <th>REFERÊNCIA</th>
                  <th>TEL. CLIENTE</th>
                  <th>EMAIL</th>
                  <th>REDE SOCIAL</th>
                  <th>AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                <?php
                /* -----------------------------------------------------------------------------------------------------  */
                $enviarPesqNome = filter_input(INPUT_POST, 'enviarPesqCliente', FILTER_SANITIZE_STRING);
                /* -----------------------------------------------------------------------------------------------------  */
                if ($enviarPesqNome) {

                  /* -----------------------------------------------------------------------------------------------------  */
                  $valorPesquisaCliente = filter_input(INPUT_POST, 'valorPesquisaCliente', FILTER_SANITIZE_STRING);
                  /* -----------------------------------------------------------------------------------------------------  */
                  if (empty($valorPesquisaCliente)) {
                    $vazio = true;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c ORDER BY c.nomeCliente ";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);



                    $quantidadePagina = 50;

                    $numeroPaginasTotal = ceil($totalCliente / $quantidadePagina);

                    #$inicio = ($quantidadePagina * $pagina) - $quantidadePagina;
                    $numeroPaginas = $numeroPaginasTotal;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c  ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                  } else {
                    $vazio = false;
                    $paginaPesquisa = 1;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);


                    $numeroPaginasTotal = 1;

                    $quantidadePagina = 500;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);
                  }



                  while ($valorPesquisaCliente = mysqli_fetch_assoc($resultadoPesquisaCliente)) {
                    $dataNascimento = (empty($valorPesquisaCliente['dataNascimento']) or $valorPesquisaCliente['dataNascimento'] == "0000-00-00") ? "" : date_create($valorPesquisaCliente['dataNascimento']);

                    $idCliente =  $valorPesquisaCliente['idCliente'];
                ?>
                    <tr>
                      <td><?php echo $valorPesquisaCliente['nomeCliente'] . "<BR/>"; ?></td>
                      <td><?php $dataNascimentoFormatada = (empty($dataNascimento) or $dataNascimento == "0000-00-00") ? "" : date_format($dataNascimento, "d/m/Y") . "<BR/>";
                          echo $dataNascimentoFormatada ?></td>
                      <td><?php echo $valorPesquisaCliente['idadeCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['referencia'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['telefoneCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['emailCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['redeSocial'] . "<BR/>"; ?></td>
                      <td class=" text-right">
                        <?php echo "<a class='btn btn-info btn-sm' target='_blank' rel='noopener noreferrer' href='editarCliente.php?id=" . $idCliente . "'><i class='material-icons'>edit</i></a>"; ?>


                        <?php
                        if ($valorPesquisaCliente['statusCliente'] == 1) {
                          echo "<a class='btn btn-success btn-sm' target='_blank' rel='noopener noreferrer' href='pagamentoCliente.php?id="  . $idCliente . "' ><i class='material-icons'>shopping_cart</i></a>";
                        }
                        ?>
                        <?php
                        if ($valorPesquisaCliente['statusCliente'] == 0) {
                          echo "<a class='btn btn-success btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=0&nomeCliente=" . $valorPesquisaCliente['nomeCliente'] . "' ><i class='material-icons'>person_add</i></a>";
                        } else {
                          echo "<a class='btn btn-danger btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=1&nomeCliente=" . $valorPesquisaCliente['nomeCliente'] . "' ><i class='material-icons'>person_remove</i></a>";
                        }
                        ?>

                      </td>

                    </tr>
                <?php
                  }
                }
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