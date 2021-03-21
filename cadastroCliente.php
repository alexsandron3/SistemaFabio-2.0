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
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="nomeCliente">NOME</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" placeholder="NOME COMPLETO" required="required" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="emailCliente">EMAIL</label>
              <div class="col-sm-6">
                <input type="email" class="form-control" name="emailCliente" id="emailCliente" placeholder="EMAIL DO CLIENTE">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="rgCliente">RG</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="rgCliente" id="rgCliente" placeholder="RG">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="orgaoEmissor">EMISSOR</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="orgaoEmissor" id="orgaoEmissor" placeholder="ORGÃO EMISSOR" autocomplete="ON" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="cpfCliente">CPF</label>
              <div class="col-sm-6">
                <input type="text" class="form-control " name="cpfCliente" id="cpfCliente" placeholder="CPF DO CLIENTE">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="telefoneCliente">TELEFONE</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="telefoneCliente" id="telefoneCliente" placeholder="55 9 1234 5678">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="dataNascimento">NASCIMENTO</label>
              <input type="date" class="form-control col-sm-3 ml-3 " name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)">

            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="idadeCliente">IDADE DO CLIENTE</label>
              <div class="col-sm-6">
                <input type="text" class="form-control col-md-1" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
              </div>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0 text-muted">CPF CONSULTADO</legend>
                <div class="col-sm-5">
                  <div class="ml-3">
                    <input class="form-check-input bg-info" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1" onclick="changeInputDate()">
                    <label class="form-check-label" for="cpfConsultadoSim">
                      SIM
                    </label>
                  </div>
                  <div class="ml-3">
                    <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0" onclick="changeInputDate()">
                    <label class="form-check-label" for="cpfConsultadoNao">
                      NÃO
                    </label>
                  </div>
                </div>

              </div>
            </fieldset>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="dataCpfConsultado">DATA DA CONSULTA</label>
              <input type="date" class="form-control col-sm-3 ml-3" name="dataCpfConsultado" id="dataCpfConsultado" placeholder="MM/DD/AAAA" onclick="setInputDate()">
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="referenciaCliente">REFERÊNCIA</label>
              <textarea class="form-control col-sm-3 ml-3" name="referenciaCliente" id="referenciaCliente" cols="3" rows="1" placeholder="INFORMAÇÕES" onkeydown="upperCaseF(this)"></textarea>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="telefoneContato">TELEF. CONTATO</label>
              <input class="form-control col-sm-3 ml-3" type="tel" name="telefoneContato" id="telefoneContato" placeholder="XX 9 XXXX-XXXX">
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="nomeContato">PESSOA CONTATO</label>
              <input class="form-control col-sm-3 ml-3" type="text" name="nomeContato" id="nomeContato" placeholder="QUEM CONTATAR" onkeydown="upperCaseF(this)">
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="redeSocial">REDES SOCIAIS</label>
              <textarea class="form-control col-sm-3 ml-3" name="redeSocial" id="redeSocial" cols="3" rows="1" placeholder="REDES SOCIAIS" onkeydown="upperCaseF(this)"></textarea>
            </div>
            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg">CADASTRAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="config/script.php"></script>
</body>

</html>