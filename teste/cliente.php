<?php 
if (isset($_REQUEST['edit'])){
  echo $_REQUEST['edit'];
}else{
  echo "fail";
}
?>


<span class="invisible" id="page-type">form</span>

<p class="h2 text-center">CADASTRAR CLIENTE</p>
<form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST" id="form">
  <div class="form-row">
    <div class="col">
      <label class=" col-form-label text-dark" for="nomeCliente">NOME: </label>
      <input type="text" class="block-form campos-de-texto form-control" name="nomeCliente" id="nomeCliente" required="required" >
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="col-form-label text-dark" for="emailCliente">EMAIL: </label>
      <input type="email" class="block-form campo-de-email form-control" name="emailCliente" id="emailCliente" >
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class=" col-form-label text-dark" for="rgCliente">RG: </label>
      <input data-toggle="tooltip" data-placement="left" title="RG DO CLIENTE" type="text" class="block-form rg form-control" name="rgCliente" id="rgCliente">
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class=" col-form-label text-dark" for="orgaoEmissor">EMISSOR: </label>
      <input type="text" class="block-form campos-de-texto form-control" name="orgaoEmissor" id="orgaoEmissor" autocomplete="ON" >
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="  col-form-label text-dark" for="cpfCliente">CPF: </label>
      <input data-toggle="tooltip" data-placement="left" title="CPF DO CLIENTE" type="text" class="block-form form-control cpf " name="cpfCliente" id="cpfCliente">
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class=" col-form-label text-dark" for="telefoneCliente">TELEFONE: </label>
      <input data-toggle="tooltip" data-placement="left" title="TELEFONE DO CLIENTE" type="text" class="block-form telefone form-control" name="telefoneCliente" id="telefoneCliente">
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="col-form-label text-dark" for="dataNascimento">NASCIMENTO: </label>
      <input type="date" class="block-form form-control" name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)">
    </div>
    <div class="col">
      <label class="col-form-label text-dark" for="idadeCliente">IDADE DO CLIENTE: </label>
      <input type="text" class="block-form form-control" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="col-form-label text-dark" for="estadoCivil">ESTADO CIVIL</label>
      <select class="form-control" id="estadoCivil" name="estadoCivil">
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
      <input type="text" class="block-form campos-de-texto form-control" id="profissao" name="profissao" >
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="col-form-label text-dark" for="nacionalidade">NACIONALIDADE</label>
      <input type="text" class="block-form campos-de-texto form-control" id="nacionalidade" name="nacionalidade" >
    </div>
  </div>

  <div class="form-row my-4">
    <div class="col">
      <label class="col-form-label text-dark" for="poltrona">POLTRONA</label>
      <input type="text" class="block-form text-area form-control" id="poltrona" name="poltrona" value="" >
    </div>
  </div>
  <div class="form-group row">
    <div class="row">
      <label class="col-form-label text-dark col-lg-3 text-dark">CPF CONSULTADO: </label>
    </div>
    <div class="col">
      <div class="btn-group">
        <input class="btn-check" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1" onclick="changeInputDate()">
        <label class="btn btn-secondary" for="cpfConsultadoSim">SIM</label>

        <input class="btn-check" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0" onclick="changeInputDate()" checked>
        <label class="btn btn-secondary" for="cpfConsultadoNao">NÃO</label>
      </div>
    </div>
    <div class="col-6">
      <label class=" col-form-label text-dark" for="dataCpfConsultado">DATA DA CONSULTA: </label>
      <input type="date" class="block-form form-control" name="dataCpfConsultado" id="dataCpfConsultado" onclick="setInputDate()">
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col-6">
        <label class="col-form-label text-dark" for="enderecoCliente">ENDEREÇO: </label>
        <textarea data-toggle="tooltip" data-placement="left" title="ENDEREÇO DO CLIENTE" class="text-area form-control" name="enderecoCliente" id="enderecoCliente" rows="3" ></textarea>
      </div>
      <div class="col-6">
        <label class="col-form-label text-dark" for="referencia">REFERÊNCIA: </label>
        <textarea class="text-area form-control" name="referencia" id="referencia" rows="3" > </textarea>
      </div>
    </div>
    <div class="block-form form-group row">
      <div class="col">
        <label class=" col-form-label text-dark" for="telefoneContato">TELEFONE PARA CONTATO: </label>
        <input class="telefone form-control " type="tel" name="telefoneContato" id="telefoneContato" data-toggle="tooltip" data-placement="left" title="TELEFONE PARA CONTATO">
      </div>
      <div class="col">
        <label class=" col-form-label text-dark" for="pessoaContato">QUEM CONTATAR: </label>
        <input class="form-control campos-de-texto" type="text" name="pessoaContato" id="pessoaContato" data-toggle="tooltip" data-placement="left" title="QUEM CONTATAR" >
      </div>
    </div>
    <div class="form-group row">
      <div class="col">
        <label class="col-form-label text-dark" for="redeSocial">REDES SOCIAIS: </label>
        <textarea class="form-control " name="redeSocial" id="redeSocial" cols="3" rows="1" ></textarea>
      </div>
      <div class="col">
        <div class="row">
          <label class="col-form-label text-dark">REDES SOCIAIS: </label>
        </div>
        <div class="btn-group">
          <input class="btn-check btn-sm" type="radio" name="clienteRedeSocial" id="clienteRedeSocialSim" value="1">
          <label class="btn btn-secondary" for="clienteRedeSocialSim">SIM</label>

          <input class="btn-check" type="radio" name="clienteRedeSocial" id="clienteRedeSocialNao" value="0" checked>
          <label class="btn btn-secondary" for="clienteRedeSocialNao">NÃO</label>
        </div>
      </div>
    </div>
    <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-md">CADASTRAR</button>
  </div>
</form>