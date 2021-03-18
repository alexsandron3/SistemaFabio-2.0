<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <?php include_once("./includes/head.php"); ?>

  <title>CADASTRAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>


  <div class="container-fluid mt-3">
    <form action="SCRIPTS/registroPasseio.php" autocomplete="off" method="POST">
      <div class="form-group row">
        <label class="col-sm-1 col-form-label latinTextBox" for="nomePasseio">NOME DO PASSEIO</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="nomePasseio" id="nomePasseio" placeholder="NOME DO PASSEIO" required="required" onkeydown="upperCaseF(this)">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="localPasseio">LOCAL DO PASSEIO</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="localPasseio" id="LocalPasseiolatinTextBox" placeholder="LOCAL DO PASSEIO" onkeydown="upperCaseF(this)">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="valorPasseio">VALOR DO PASSEIO</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="valorPasseio" id="valorPasseio" placeholder="VALOR DO PASSEIO" value="0" onblur="converterParaFloat()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="lotacao"> LOTAÇÃO</label>
        <div class="col-sm-1">
          <input type="text" class="form-control" name="lotacao" id="intLimitTextBox" placeholder="0-200" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="idadeIsencao"> ISENÇÃO</label>
        <div class="col-sm-1">
          <input type="number" class="form-control" name="idadeIsencao" id="idadeIsencao" placeholder="0-200" required="required">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="dataPasseio">DATA DO PASSEIO</label>
        <div class="col-sm-6">
          <input type="date" class="form-control col-sm-4" name="dataPasseio" id="dataPasseio" required="required" onblur="verificaDataPasseio()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label" for="anotacoesPasseio">ANOTAÇÕES</label>
        <textarea class="form-control col-sm-3 ml-3" name="anotacoesPasseio" id="anotacoesPasseio" cols="3" rows="1" placeholder="ANOTAÇÕES" onkeydown="upperCaseF(this)"></textarea>
      </div>
      <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-primary btn-lg">CADASTRAR</button>
    </form>
  </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>