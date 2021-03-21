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

  <div class="d-flex flex-column">
            <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
            <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
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

</body>

</html>