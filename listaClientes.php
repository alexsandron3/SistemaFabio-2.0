<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
if (empty($ordemPesquisa)) {
  $ordemPesquisa = 'nomeCliente';
}
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.rgCliente, c.orgaoEmissor, c.idadeCliente, c.idCliente, c.dataNascimento, pp.idPagamento, pp.valorPago  
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) ORDER BY $ordemPesquisa ";
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


  <title>LISTA DE PASSAGEIROS </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="table mt-3">
    <?php echo "<p class='h5 text-center alert-info '>" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . "</BR> LISTA DE PASSAGEIROS</p>"; ?>
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th> <a href="listaClientes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=nomeCliente"> NOME </a></th>
          <th> <a href="listaClientes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=idadeCliente">IDADE </a></th>
          <th> <a href="listaClientes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=rgCliente">Nº IDENTIDADE </a></th>
          <th> <a href="listaClientes.php?id=<?php echo $idPasseioGet; ?>&ordemPesquisa=orgaoEmissor">ORGÃO EMISSOR</a></th>
        </tr>
      </thead>

      <tbody>
        <?php

        $controleListaPasseio = 0;
        while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {
          $idCliente     = $rowBuscaPasseio['idCliente'];
          $data          = $rowBuscaPasseio['dataNascimento'];
          $idPagamento   = $rowBuscaPasseio['idPagamento'];
          $idPasseioAcao  = $rowBuscaPasseio['idPasseio'];
          if (empty($rowBuscaPasseio['dataCpfConsultado'])) {
            $dataCpfConsultado = "0000-00-00";
          } else {
            $dataCpfConsultado =  date_create($rowBuscaPasseio['dataCpfConsultado']);
          }

          $idadeCliente = $rowBuscaPasseio['idadeCliente'];
          $nomePasseio = $rowBuscaPasseio['nomePasseio'];


        ?>
          <tr>
            <th><?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?></th>
            <th><?php $idade = calcularIdade($idCliente, $conn, $data);
                echo $idade; ?></th>
            <th><?php echo $rowBuscaPasseio['rgCliente'] . "<BR/>"; ?> </th>
            <th><?php echo $rowBuscaPasseio['orgaoEmissor']; ?></th>
            <?php
            if ($rowBuscaPasseio['valorPago'] == 0) {
              $opcao = "DELETAR";
            } else {
              $opcao = "TRANSFERIR";
            }
            ?>
          </tr>

        <?php


        }
        $controleListaPasseio = mysqli_num_rows($resultadoBuscaPasseio);
        ?>
      </tbody>
    </table>
    <?php
    if ($controleListaPasseio > 0) {
      echo "<div class='text-center'>";
      echo "<p class='h5 text-center alert-warning'>TOTAL DE " . $controleListaPasseio . " CLIENTES </p>";

      echo "</div>";
    } else {

      echo "<div class='text-center'>";
      echo "<p class='h5 text-center alert-warning'>Nenhum PAGAMENTO foi cadastrado até o momento</p>";
      echo "</div>";
    }


    ?>
    <a target="_blank" href="SCRIPTS/exportarPassageiros.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info ml-5">EXPORTAR</a>

  </div>
  <script src="config/script.php"></script>
</body>

</html>