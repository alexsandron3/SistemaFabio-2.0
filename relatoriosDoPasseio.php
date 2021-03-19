<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>
  <title>RELATORIOS PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="d-flex flex-column">
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2"></div>
    <div class="p-2 text-center">
      <a target="_blank" href="listaClientes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info">LISTA PASSAGEIROS</a>
      <a target="_blank" href="pontosDeEmbarque.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info">PONTOS DE EMBARQUE</a>
      <a target="_blank" href="pagamentosPendentes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info">PAGAMENTOS PENDENTES</a>
      <a target="_blank" href="SCRIPTS/exportarExcel.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info">SEGURO VIAGEM</a>
      <a target="_blank" href="listaAniversariantesMes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info">ANIVERSARIANTES</a>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>