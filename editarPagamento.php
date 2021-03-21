<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPagamento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
$queryBuscaIdPagamento = "    SELECT DISTINCT c.nomeCliente, c.referencia, c.idadeCliente , p.idPasseio, p.nomePasseio, p.dataPasseio, pp.idPagamento, pp.transporte , pp.idPasseio, pp.valorPago, pp.valorVendido, 
                                  pp.previsaoPagamento, pp.anotacoes, pp.valorPendente, pp.statusPagamento, pp.seguroViagem, pp.taxaPagamento, pp.localEmbarque, pp.clienteParceiro, pp.historicoPagamento, pp.idCliente, pp.clienteDesistente 
                                  FROM cliente c, passeio p, pagamento_passeio pp WHERE idPagamento='$idPagamento' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
$resultadoIdPagamento = mysqli_query($conexao, $queryBuscaIdPagamento);
$rowIdPagamento = mysqli_fetch_assoc($resultadoIdPagamento);
/* -----------------------------------------------------------------------------------------------------  */
$idPasseio = $rowIdPagamento['idPasseio'];
$statusSeguroViagem = $rowIdPagamento['seguroViagem'];
$clienteParceiro = $rowIdPagamento['clienteParceiro'];
$transporte = $rowIdPagamento['transporte'];


?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>EDITAR PAGAMENTO</title>
</head>

<body onload="verificaDePrevisaoPagamento()">
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
                  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                  <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaPagamento.php" method="post" autocomplete="OFF" onclick="calculoPagamentoCliente()">
            <div class="form-group-row">
              <?php
              $dataPasseio = date_create($rowIdPagamento['dataPasseio']);

              $nomePasseioSelelecionado = $rowIdPagamento['nomePasseio'];
              $valorVendido  = $rowIdPagamento['valorVendido'];
              $anotacoes  = $rowIdPagamento['anotacoes'];
              $valorPago     = $rowIdPagamento['valorPago'];
              $valorPendente = $rowIdPagamento['valorPendente'];
              $taxaPagamento = $rowIdPagamento['taxaPagamento'];
              $localEmbarque = $rowIdPagamento['localEmbarque'];
              $historicoPagamento = $rowIdPagamento['historicoPagamento'];
              $clienteParceiro = $rowIdPagamento['statusPagamento'];
              $idCliente = $rowIdPagamento['idCliente'];
              $idadeCliente = calcularIdade($idCliente, $conn, "");
              mensagensInfoNoSession("". $rowIdPagamento['nomeCliente'] . " | " . $rowIdPagamento['nomePasseio'] . " " . date_format($dataPasseio, "d/m/Y"));
              #echo "<p class='h4 text-center alert-info'> " . $rowIdPagamento['nomeCliente'] . " | " . $rowIdPagamento['nomePasseio'] . " " . date_format($dataPasseio, "d/m/Y") . "</p>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='valorVendido'>VALOR VENDIDO</label>";
              echo "<div class='col-sm-6'>";
              echo "<input type='text' class='form-control' name='valorVendido' id='valorVendido' placeholder='VALOR VENDIDO' value='$valorVendido' >";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='valorPago'>VALOR PAGO</label>";
              echo "<div class='col-sm-6'>";
              echo "<input type='text' class='form-control' name='valorPago' id='valorPago' placeholder='VALOR PAGO' value='$valorPago' >";
              echo "</div>";
              echo "<div class='col-sm-2'>";
              echo "<input type='text' class='form-control' name='novoValorPago' id='novoValorPago' placeholder='NOVO PAGAMENTO' value='0' onblur='(new calculoPagamentoCliente()).novoValorPago()'>";
              echo "<input type='hidden' class='form-control' name='valorAntigo' id='valorAntigo' placeholder='valorAntigo' value='$valorPago' >";
              echo "<input type='hidden' class='form-control' name='idCliente' id='idCliente' placeholder='idCliente' value='$idCliente' >";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='valorPendenteCliente'>VALOR PENDENTE</label>";
              echo "<div class='col-sm-6'>";
              echo "<input type='text' class='form-control' name='valorPendenteCliente' id='valorPendenteCliente' placeholder='VALOR PENDENTE' value='$valorPendente' readonly='readonly' >";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='taxaPagamento'>TAXA DE PAGAMENTO</label>";
              echo "<div class='col-sm-6'>";
              echo "<input type='text' class='form-control' name='taxaPagamento' id='taxaPagamento' value='$taxaPagamento'  placeholder='TAXA DE PAGAMENTO' >";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='localEmbarque'>LOCAL DE EMBARQUE</label>";
              echo "<div class='col-sm-6'>";
              echo "<input type='text' class='form-control' name='localEmbarque' id='localEmbarque'  placeholder='LOCAL DE EMBARQUE' value='$localEmbarque' required='required' autocomplete='on'>";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='previsaoPagamento'>PREVISÃO PAGAMENTO</label>";
              echo "<div class='col-sm-3'>";
              echo "<input type='date' class='form-control' name='previsaoPagamento' id='previsaoPagamento' value='" . $rowIdPagamento['previsaoPagamento'] . "' placeholder='PREVISÃO PAGAMENTO' onblur='verificaDataDePrevisaoPagamento()'>";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='meioTransporte'>TRANSPORTE</label>";
              echo "<div class='col-sm-3'>";
              echo "<input type='text' class='form-control' name='meioTransporte' id='meioTransporte' value='" . $transporte . "' placeholder='TRANSPORTE' autocomplete='on'>";
              echo "</div>";
              echo "</div>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='idadeCliente'>IDADE</label>";
              echo "<div class='col-sm-1'>";
              echo "<input type='text' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='' value='$idadeCliente'>";
              echo "</div>";
              echo "</div>";
              echo "<input type='hidden' class='form-control' name='statusPagamento' id='statusPagamento' placeholder='statusPagamento'  onchange='calculoPagamentoCliente()'>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='referenciaCliente'>REFERÊNCIA</label>";
              echo "<textarea class='form-control col-sm-3 ml-3' name='referenciaCliente' id='referenciaCliente' cols='3' rows='1' disabled='disabled'
                placeholder='INFORMAÇÕES' onkeydown='upperCaseF(this)'>" . $rowIdPagamento['referencia'] .  "</textarea> ";
              echo "</div>";
              echo "<fieldset class='form-group'>";
              $statusSeguroViagemtrue = '';
              $statusSeguroViagemfalse = '';
              if ($statusSeguroViagem == 1) {
                $statusSeguroViagemtrue = 'checked';
              } else {
                $statusSeguroViagemfalse = 'checked';
              }
              echo "<div class='row'>";
              echo "<legend class='col-form-label col-sm-2 pt-0'>SEGURO VIAGEM</legend>";
              echo "<div class='col-sm-5'>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim'
                value='1'  $statusSeguroViagemtrue '>";
              echo "<label class='form-check-label' for='seguroViagemClienteSim' >
                  SIM
                </label>";
              echo "</div>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao'
                value='0' $statusSeguroViagemfalse >";
              echo "<label class='form-check-label' for='seguroViagemClientenao'>
                  NÃO
                </label>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "<input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente'  value='" . $idadeCliente . "'>";
              echo "<input type='hidden' class='form-control' name='idPasseioSelecionado' id='idPasseioSelecionado' placeholder='idPasseioSelecionado'  value='" . $idPasseio . "'>";
              $clienteDesistenteTrue = '';
              $clienteDesistenteFalse = '';
              if ($rowIdPagamento['clienteDesistente'] == 1) {
                $clienteDesistenteTrue = 'checked';
              } else {
                $clienteDesistenteFalse = 'checked';
              }
              echo "<div class='row'>";
              echo "<legend class='col-form-label col-sm-2 pt-0'>DESISTENTE</legend>";
              echo "<div class='col-sm-5'>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='clienteDesistente' id='clienteDesistenteSim'
                value='1'  $clienteDesistenteTrue >";
              echo "<label class='form-check-label' for='clienteDesistenteSim'>
                  SIM
                </label>";
              echo "</div>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='clienteDesistente' id='clienteDesistenteoNao'
                value='0'  $clienteDesistenteFalse >";
              echo "<label class='form-check-label' for='clienteDesistenteNao'>
                  NÃO
                </label>";
              echo "</div>";
              echo "</div>";
              echo "</div>";


              $clienteParceiroTrue = '';
              $clienteParceiroFalse = '';

              if ($clienteParceiro == 3) {
                $clienteParceiroTrue = 'checked';
              } else {
                $clienteParceiroFalse = 'checked';
              }
              echo "<div class='row'>";
              echo "<legend class='col-form-label col-sm-2 pt-0'>CLIENTE PARCEIRO</legend>";
              echo "<div class='col-sm-5'>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceiroSim'
                value='1'  $clienteParceiroTrue onclick='calculoPagamentoCliente()'>";
              echo "<label class='form-check-label' for='clienteParceiroSim'>
                  SIM
                </label>";
              echo "</div>";
              echo "<div class='form-check'>";
              echo "<input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceironao'
                value='0'  $clienteParceiroFalse onclick='calculoPagamentoCliente()'>";
              echo "<label class='form-check-label' for='clienteParceironao'>
                  NÃO
                </label>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "</fieldset>";
              echo "<div class='form-group row'>";
              echo "<label class='col-sm-2 col-form-label' for='anotacoes'>ANOTAÇÕES</label>";
              echo "<textarea class='form-control col-sm-3 ml-3' name='anotacoes' id='anotacoes' cols='6' rows='3'
              placeholder='ANOTAÇÕES' onkeydown='upperCaseF(this)' maxlength='500'> $anotacoes</textarea>";
              echo "<label class='col-sm-2 col-form-label' for='anotacoes'>HISTÓRICO</label>";
              echo "<textarea class='form-control col-sm-3 ml-3' name='historicoPagamento' id='historicoPagamento' cols='6' rows='3'
              placeholder='historicoPagamento' maxlength='500'> $historicoPagamento </textarea>";
              echo "<textarea style='display:none;' class='form-control col-sm-3 ml-3' name='historicoPagamentoAntigo' id='historicoPagamentoAntigo' cols='6' rows='3'
              placeholder='historicoPagamentoAntigo' maxlength='500' disabled='disabled' onblur='(new calculoPagamentoCliente()).novoValorPago()'> $historicoPagamento </textarea>";
              echo "</div>";
              ?>

              </select>
            </div>
            <input type="submit" class="btn btn-info btn-sm" value="FINALIZAR PAGAMENTO" name="buttonFinalizarPagamento">

            <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamento" id="idPagamento" readonly="readonly" value="<?php echo $idPagamento ?>">
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>