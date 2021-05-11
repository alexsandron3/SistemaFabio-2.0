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
    <div class="col-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">CADASTRO DE CLIENTE</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST">
            <div class="form-row">
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeCliente">NOME: </label>
                <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" required="required" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="emailCliente">EMAIL: </label>
                <input type="email" class="form-control" name="emailCliente" id="emailCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="rgCliente">RG: </label>
                <input data-toggle="tooltip" data-placement="left" title="RG DO CLIENTE" type="text" class="form-control" name="rgCliente" id="rgCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="orgaoEmissor">EMISSOR: </label>
                <input type="text" class="form-control" name="orgaoEmissor" id="orgaoEmissor" autocomplete="ON" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="cpfCliente">CPF: </label>
                <input data-toggle="tooltip" data-placement="left" title="CPF DO CLIENTE" type="text" class="form-control " name="cpfCliente" id="cpfCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="telefoneCliente">TELEFONE: </label>
                <input data-toggle="tooltip" data-placement="left" title="TELEFONE DO CLIENTE" type="text" class="form-control" name="telefoneCliente" id="telefoneCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="dataNascimento">NASCIMENTO: </label>
                <input type="date" class="form-control col-6 " name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="idadeCliente">IDADE DO CLIENTE: </label>
                <input type="text" class="form-control col-3" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="estadoCivil" name="estadoCivil">ESTADO CIVIL</label>
                <select class="form-control col-6" id="estadoCivil">
                  <option>Solteiro(a)</option>
                  <option>Casado(a)</option>
                  <option>Divorciado(a)</option>
                  <option>Viúvo(a)</option>
                  <option>Separado(a)</option>
                </select>
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="profissao">PROFISSÃO</label>
                <input type="text" class="form-control col-6" id="profissao" name="profissao">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="nacionalidade">NACIONALIDADE</label>
                <input type="text" class="form-control col-6" id="nacionalidade" name="nacionalidade">
              </div>
            </div>

            <fieldset class="form-group">
              <div class="row">
                <label class="col-form-label text-dark col-3 pt-0 text-dark">CPF CONSULTADO: </label>
                <div class="col">
                  <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1" onclick="changeInputDate()">
                  <label class="form-check-label text-dark" for="cpfConsultadoSim">
                    SIM
                  </label>
                  <div class="col-1 p-0 m-0">
                    <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0" onclick="changeInputDate()">
                    <label class="form-check-label text-dark" for="cpfConsultadoNao">
                      NÃO
                    </label>

                  </div>
                </div>
                <div class="col">
                  <label class=" col-form-label text-dark" for="dataCpfConsultado">DATA DA CONSULTA: </label>
                  <input type="date" class="form-control" name="dataCpfConsultado" id="dataCpfConsultado" onclick="setInputDate()">
                </div>
              </div>
            </fieldset>

            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label class="col-form-label text-dark" for="enderecoCliente">ENDEREÇO: </label>
                  <textarea data-toggle="tooltip" data-placement="left" title="ENDEREÇO DO CLIENTE" class="form-control" name="enderecoCliente" id="enderecoCliente" rows="3" onkeydown="upperCaseF(this)"></textarea>
                </div>
                <div class="col-6">
                  <label class="col-form-label text-dark" for="referenciaCliente">REFERÊNCIA: </label>
                  <textarea class="form-control" name="referenciaCliente" id="referenciaCliente" rows="3" onkeydown="upperCaseF(this)"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col">
                  <label class=" col-form-label text-dark" for="telefoneContato">TELEFONE PARA CONTATO: </label>
                  <input data-toggle="tooltip" data-placement="left" title="TELEFONE PARA CONTATO" class="form-control " type="tel" name="telefoneContato" id="telefoneContato">
                </div>
                <div class="col">
                  <label class=" col-form-label text-dark" for="nomeContato">QUEM CONTATAR: </label>
                  <input data-toggle="tooltip" data-placement="left" title="QUEM CONTATAR" class="form-control " type="text" name="nomeContato" id="nomeContato" onkeydown="upperCaseF(this)">
                </div>
              </div>
              <div class="form-group row">
                <div class="col">
                  <label class=" col-form-label text-dark" for="redeSocial">REDES SOCIAIS: </label>
                  <textarea class="form-control " name="redeSocial" id="redeSocial" cols="3" rows="1" onkeydown="upperCaseF(this)"></textarea>
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