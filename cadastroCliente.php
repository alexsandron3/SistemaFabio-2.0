<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>CADASTRAR CLIENTE</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">CADASTRO DE CLIENTE</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST">
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" placeholder="NOME COMPLETO" required="required" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <input type="email" class="form-control" name="emailCliente" id="emailCliente" placeholder="EMAIL DO CLIENTE">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <input data-toggle="tooltip" data-placement="left" title="RG DO CLIENTE" type="text" class="form-control" name="rgCliente" id="rgCliente" placeholder="RG">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <input type="text" class="form-control" name="orgaoEmissor" id="orgaoEmissor" placeholder="ORGÃO EMISSOR" autocomplete="ON" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <input data-toggle="tooltip" data-placement="left" title="CPF DO CLIENTE" type="text" class="form-control " name="cpfCliente" id="cpfCliente" placeholder="CPF DO CLIENTE">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <input data-toggle="tooltip" data-placement="left" title="TELEFONE DO CLIENTE" type="text" class="form-control" name="telefoneCliente" id="telefoneCliente" placeholder="TELEFONE">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label" for="dataNascimento">NASCIMENTO</label>
                <input type="date" class="form-control col-6 " name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label" for="idadeCliente">IDADE DO CLIENTE</label>
                <div class="col">
                </div>
                <input type="text" class="form-control col-3" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
              </div>
            </div>

            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-3 pt-0 text-muted">CPF CONSULTADO</legend>
                <div class="col">
                  <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1" onclick="changeInputDate()">
                  <label class="form-check-label" for="cpfConsultadoSim">
                    SIM
                  </label>
                  <div class="col-1 p-0 m-0">
                    <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0" onclick="changeInputDate()">
                    <label class="form-check-label" for="cpfConsultadoNao">
                      NÃO
                    </label>

                  </div>
                </div>
                <div class="col">
                  <label class=" col-form-label" for="dataCpfConsultado">DATA DA CONSULTA</label>
                  <input type="date" class="form-control" name="dataCpfConsultado" id="dataCpfConsultado" placeholder="MM/DD/AAAA" onclick="setInputDate()">
                </div>
              </div>
            </fieldset>

            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <textarea class="form-control" name="referenciaCliente" id="referenciaCliente" rows="3" placeholder="REFERÊNCIA" onkeydown="upperCaseF(this)"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col">
                <input data-toggle="tooltip" data-placement="left" title="TELEFONE PARA CONTATO" class="form-control " type="tel" name="telefoneContato" id="telefoneContato" placeholder="TELEF. CONTATO">
              </div>
              <div class="col">
                <input data-toggle="tooltip" data-placement="left" title="QUEM CONTATAR" class="form-control " type="text" name="nomeContato" id="nomeContato" placeholder="PESSOA CONTATO" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-group row">
              <div class="col">
                <textarea class="form-control " name="redeSocial" id="redeSocial" cols="3" rows="1" placeholder="REDES SOCIAIS" onkeydown="upperCaseF(this)"></textarea>
              </div>
            </div>
            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-md">CADASTRAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="config/script.php"></script>
</body>

</html>