<span class="invisible" id="page-type">form</span>
<p class="h2 text-center">CADASTRAR DESPESAS</p>

<form action="" method="POST" autocomplete="OFF" class="mb-5">
  <div class="form-row mb-5">
    <label class="col-form-label" for="nomePasseio">PASSEIO</label>
    <select class="form-control ml-3 col" name="idPasseio" id="selectPasseio">
      <option value="">SELECIONAR</option>
    </select>
  </div>
</form>
<div class="inputs">
  <form action="SCRIPTS/registroDespesas.php" autocomplete="off" method="POST" class="block-form">
    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorAereo">AÉREO</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorAereo" id="valorAereo" placeholder="AEREO" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" min="1" max="200" name="quantidadeAereo" id="quantidadeAereo" placeholder="QTD" value="1">
      </div>
    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorAlmocoCliente">ALMOCO CLIENTE</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorAlmocoCliente" id="valorAlmocoCliente" placeholder="ALMOCO CLIENTE" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeAlmocoCliente" id="quantidadeAlmocoCliente" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorAlmocoMotorista">ALMOCO MOTORISTA</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorAlmocoMotorista" id="valorAlmocoMotorista" placeholder="ALMOCO MOTORISTA" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeAlmocoMotorista" id="quantidadeAlmocoMotorista" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorAutorizacaoTransporte">TRANSPORTE</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorAutorizacaoTransporte" id="valorAutorizacaoTransporte" placeholder="AUTORIZACAO TRANSPORTE" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeAutorizacaoTransporte" id="quantidadeAutorizacaoTransporte" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorEscuna">ESCUNA</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorEscuna" id="valorEscuna" placeholder="VALOR DO ESCUNA" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeEscuna" id="quantidadeEscuna" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorEstacionamento">ESTACIONAMENTO</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorEstacionamento" id="valorEstacionamento" placeholder="ESTACIONAMENTO" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeEstacionamento" id="quantidadeEstacionamento" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorGuia">GUIA</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorGuia" id="valorGuia" placeholder="VALOR GUIA" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeGuia" id="quantidadeGuia" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorHospedagem">HOSPEDAGEM</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorHospedagem" id="valorHospedagem" placeholder="HOSPEDAGEM" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeHospedagem" id="quantidadeHospedagem" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorImpulsionamento">IMPULSIONAMENTO</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorImpulsionamento" id="valorImpulsionamento" placeholder="IMPULSIONAMENTO" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeImpulsionamento" id="quantidadeImpulsionamento" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorIngresso">INGRESSO</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorIngresso" id="valorIngresso" placeholder="VALOR DO INGRESSO" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeIngresso" id="quantidadeIngresso" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorKitLanche">KIT LANCHE</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorKitLanche" id="valorKitLanche" placeholder="KIT LANCHE" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeKitLanche" id="quantidadeKitLanche" placeholder="QTD" value="1">
      </div>

    </div>


    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorMarketing">MARKETING</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorMarketing" id="valorMarketing" placeholder="MARKETING" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeMarketing" id="quantidadeMarketing" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorMicro">MICRO</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorMicro" id="valorMicro" placeholder="VALOR DO MICRO" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeMicro" id="quantidadeMicro" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorOnibus">ONIBUS</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorOnibus" id="valorOnibus" placeholder="VALOR DO ONIBUS" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeOnibus" id="quantidadeOnibus" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorPulseira">PULSEIRAS</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorPulseira" id="valorPulseira" placeholder="PULSEIRA" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadePulseira" id="quantidadePulseira" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorSeguroViagem">SEGURO VIAGEM</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorSeguroViagem" id="valorSeguroViagem" placeholder="VALOR DO SEGURO VIAGEM" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeSeguroViagem" id="quantidadeSeguroViagem" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorServicos">SERVIÇOS</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorServicos" id="valorServicos" placeholder="SERVIÇOS" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeServicos" id="quantidadeServicos" placeholder="QTD" value="1">
      </div>

    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorTaxi">TAXI</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorTaxi" id="valorTaxi" placeholder="TAXI" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeTaxi" id="quantidadeTaxi" placeholder="QTD" value="1">
      </div>

    </div>


    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="valorVan">VAN</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="valorVan" id="valorVan" placeholder="VALOR DO VAN" value="0">
      </div>
      <div class="col">
        <input type="number" class="form-control" name="quantidadeVan" id="quantidadeVan" placeholder="QTD" value="1">
      </div>

    </div>


    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="outros">OUTROS</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="outros" id="outros" placeholder="OUTROS" value="0">
      </div>
    </div>

    <div class="form-row mb-4">
      <label class="col-form-label col-3" for="totalDespesas">TOTAL DESPESAS</label>
      <div class="col-7">
        <input type="text" class="campo-monetario form-control" name="totalDespesas" id="totalDespesas" placeholder="TOTAL DESPESAS" value="" readonly="readonly">
      </div>
    </div>

    <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg" id="submit">CADASTRAR</button>
  </form>
</div>