<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT * FROM passeio p WHERE idPasseio='$idPasseioGet'";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
$rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio);

$passeioAtivo = ($rowBuscaPasseio['statusPasseio'] == 1) ? "checked" : " ";
$passeioInativo = ($rowBuscaPasseio['statusPasseio'] == 0) ? "checked" : " ";

/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>EDITAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">EDIÇÃO DE PASSEIO</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaPasseio.php" autocomplete="off" method="POST">
            <div class="form-row">
              <label class="col-sm-2 col-form-label latinTextBox" for="nomePasseio">NOME DO PASSEIO</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nomePasseio" id="latinTextBox" placeholder="NOME DO PASSEIO" required="required" value="<?php echo $rowBuscaPasseio['nomePasseio'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-sm-2 col-form-label" for="localPasseio">LOCAL DO PASSEIO</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="localPasseio" id="LocalPasseiolatinTextBox" placeholder="LOCAL DO PASSEIO" value="<?php echo $rowBuscaPasseio['localPasseio'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-sm-2 col-form-label" for="valorPasseio">VALOR DO PASSEIO</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="valorPasseio" id="currencyTextBox" placeholder="VALOR DO PASSEIO" value="<?php echo $rowBuscaPasseio['valorPasseio'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-sm-2 col-form-label" for="lotacao"> LOTAÇÃO</label>
              <div class="col-sm-1">
                <input type="text" class="form-control" name="lotacao" id="intLimitTextBox" placeholder="0-200" value="<?php echo $rowBuscaPasseio['lotacao'] ?>">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-sm-2 col-form-label" for="idadeIsencao"> ISENÇÃO</label>
              <div class="col-sm-1">
                <input type="number" class="form-control" name="idadeIsencao" id="idadeIsencao" placeholder="0-200" required="required" value="<?php echo $rowBuscaPasseio['idadeIsencao'] ?>">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-sm-2 col-form-label" for="dataPasseio">DATA DO PASSEIO</label>
              <div class="col-sm-6">
                <input type="date" class="form-control col-sm-4" name="dataPasseio" id="dataPasseio" required="required" value="<?php echo $rowBuscaPasseio['dataPasseio'] ?>">
              </div>
            </div>
            <div class="form-row my-4">
              <label class="col-2 col-form-label" for="anotacoesPasseio">ANOTAÇÕES</label>
              <textarea class="form-control ml-3" name="anotacoesPasseio" id="anotacoesPasseio" rows="3" value="<?php echo $rowBuscaPasseio['anotacoes'] ?>" placeholder="" onkeydown="upperCaseF(this)"></textarea>
            </div>

            <fieldset class='form-group'>
              <div class='row'>
                <legend class='col-form-label col-sm-2 pt-0 text-muted'>STATUS DO PASSEIO</legend>
                <div class='col-sm-5 '>
                  <div class='col'>
                    <input class='form-check-input ' type='radio' name='statusPasseio' id='statusPasseioAtivo' value='1' <?php echo $passeioAtivo ?>>
                    <label class='form-check-label' for='statusPasseioAtivo'>
                      SIM
                    </label>
                  </div>
                  <div class='col'>
                    <input class='form-check-input' type='radio' name='statusPasseio' id='statusPasseioInativo' value='0' <?php echo $passeioInativo ?>>
                    <label class='form-check-label' for='statusPasseioInativo'>
                      NÃO
                    </label>
                  </div>
                </div>
            </fieldset>


            <input type="hidden" name="idPasseio" id="idPasseio" value="<?php echo $rowBuscaPasseio['idPasseio'] ?>">
            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg">ATUALIZAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>