<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>CADASTRAR DESPESAS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

  <div class="row py-5">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
          <form action="" method="POST" autocomplete="OFF">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="nomePasseio">PASSEIO</label>
              <input type="hidden" name="nomePasseio" value=" ">

              <select class="form-control ml-3 col-sm-3" name="idPasseioLista" id="selectIdPasseio" onchange="idPasseioSelecionadoFun()">
                <option value="1">SELECIONAR</option>

                <?php

                $nomePasseioPost = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
                $queryBuscaPeloNomePasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio FROM passeio p WHERE nomePasseio LIKE '%$nomePasseioPost%' AND statusPasseio NOT IN (0) ORDER BY dataPasseio";
                /* -----------------------------------------------------------------------------------------------------  */
                $resultadoNomePasseio = mysqli_query($conexao, $queryBuscaPeloNomePasseio);
                /* -----------------------------------------------------------------------------------------------------  */
                while ($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)) {
                  $dataPasseioLista =  date_create($rowNomePasseio['dataPasseio']);
                ?>
                  <option value="<?php echo $rowNomePasseio['idPasseio']; ?>"><?php echo $rowNomePasseio['nomePasseio'];
                                                                              echo " ";
                                                                              echo date_format($dataPasseioLista, "d/m/Y"); ?> </option>
                <?php
                }
                ?>
                <input type="submit" class="btn btn-primary btn-sm ml-2" value="CARREGAR PASSEIOS" name="buttonEnviaNomePasseio">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" onchange="idPasseioSelecionadoFun()" readonly="readonly">
              </select>

          </form>
        </div>
        <form action="SCRIPTS/registroDespesas.php" autocomplete="off" method="POST" onclick="calculoTotalDespesas()">
          <?php
          $idPasseioLista = filter_input(INPUT_POST, 'idPasseioSelecionado', FILTER_SANITIZE_NUMBER_INT);


          $queryBuscaDespesa = "SELECT idPasseio FROM despesa WHERE idPasseio='$idPasseioLista'";
          $resultadoBuscaDespesa = mysqli_query($conexao, $queryBuscaDespesa);
          $rowBuscaDespesa = mysqli_fetch_assoc($resultadoBuscaDespesa);
          $buttonEnviaNomePasseio = filter_input(INPUT_POST, 'buttonEnviaNomePasseio', FILTER_SANITIZE_STRING);
          if ($buttonEnviaNomePasseio) {
            if ($idPasseioLista != 0) {
              if ($rowBuscaDespesa == 0) {
                $queryBuscaInformacoesPasseio = "SELECT p.nomePasseio, p.dataPasseio FROM passeio p WHERE idPasseio='$idPasseioLista'";
                $resultadoBuscaInformacoesPasseio = mysqli_query($conexao, $queryBuscaInformacoesPasseio);
                $rowBuscaInformacoesPasseio = mysqli_fetch_assoc($resultadoBuscaInformacoesPasseio);
                $data =  date_create($rowBuscaInformacoesPasseio['dataPasseio']);


                echo "<p class='h4 text-center alert-info'>" . $rowBuscaInformacoesPasseio['nomePasseio'] . " " . date_format($data, "d/m/Y") . "</p>";
                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorIngresso'>INGRESSO</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorIngresso' id='valorIngresso' placeholder='VALOR DO INGRESSO' value='0' onchange='calculoTotalDespesas()' >";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeIngresso' id='quantidadeIngresso' placeholder='QTD'  value='1' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalIngresso' id='valorTotalIngresso' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorOnibus'>ONIBUS</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorOnibus' id='valorOnibus' placeholder='VALOR DO ONIBUS' value='0' onchange='calculoTotalDespesas()' >";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeOnibus' id='quantidadeOnibus' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalOnibus' id='valorTotalOnibus' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorMicro'>MICRO</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorMicro' id='valorMicro' placeholder='VALOR DO MICRO' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeMicro' id='quantidadeMicro' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalMicro' id='valorTotalMicro' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorVan'>VAN</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorVan' id='valorVan' placeholder='VALOR DO VAN' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeVan' id='quantidadeVan' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalVan' id='valorTotalVan' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorEscuna'>ESCUNA</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorEscuna' id='valorEscuna' placeholder='VALOR DO ESCUNA' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeEscuna' id='quantidadeEscuna' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalEscuna' id='valorTotalEscuna' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorSeguroViagem'>SEGURO VIAGEM</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO SEGURO VIAGEM' value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeSeguroViagem' id='quantidadeSeguroViagem' placeholder='QTD' value='1' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalSeguroViagem' id='valorTotalSeguroViagem' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorAlmocoCliente'>ALMOCO CLIENTE</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorAlmocoCliente' id='valorAlmocoCliente' placeholder='ALMOCO CLIENTE' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeAlmocoCliente' id='quantidadeAlmocoCliente' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoCliente' id='valorTotalAlmocoCliente' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorAlmocoMotorista'>ALMOCO MOTORISTA</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorAlmocoMotorista' id='valorAlmocoMotorista' placeholder='ALMOCO MOTORISTA' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeAlmocoMotorista' id='quantidadeAlmocoMotorista' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoMotorista' id='valorTotalAlmocoMotorista' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorEstacionamento'>ESTACIONAMENTO</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorEstacionamento' id='valorEstacionamento' placeholder='ESTACIONAMENTO' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeEstacionamento' id='quantidadeEstacionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalEstacionamento' id='valorTotalEstacionamento' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorGuia'>GUIA</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorGuia' id='valorGuia' placeholder='VALOR GUIA' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeGuia' id='quantidadeGuia' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalGuia' id='valorTotalGuia' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorAutorizacaoTransporte'>TRANSPORTE</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorAutorizacaoTransporte' id='valorAutorizacaoTransporte' placeholder='AUTORIZACAO TRANSPORTE' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeAutorizacaoTransporte' id='quantidadeAutorizacaoTransporte' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalTransporte' id='valorTotalTransporte' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorTaxi'>TAXI</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorTaxi' id='valorTaxi' placeholder='TAXI' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeTaxi' id='quantidadeTaxi' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalTaxi' id='valorTotalTaxi' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorMarketing'>MARKETING</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorMarketing' id='valorMarketing' placeholder='MARKETING' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeMarketing' id='quantidadeMarketing' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalMarketing' id='valorTotalMarketing' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorKitLanche'>KIT LANCHE</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorKitLanche' id='valorKitLanche' placeholder='KIT LANCHE' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeKitLanche' id='quantidadeKitLanche' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalKitLanche' id='valorTotalKitLanche' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorImpulsionamento'>IMPULSIONAMENTO</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorImpulsionamento' id='valorImpulsionamento' placeholder='IMPULSIONAMENTO' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeImpulsionamento' id='quantidadeImpulsionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalImpulsionamento' id='valorTotalImpulsionamento' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorPulseira'>PULSEIRAS</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorPulseira' id='valorPulseira' placeholder='PULSEIRA' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadePulseira' id='quantidadePulseira' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalPulseira' id='valorTotalPulseira' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorHospedagem'>HOSPEDAGEM</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorHospedagem' id='valorHospedagem' placeholder='HOSPEDAGEM' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeHospedagem' id='quantidadeHospedagem' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalHospedagem' id='valorTotalHospedagem' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorAereo'>AÉREO</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorAereo' id='valorAereo' placeholder='AEREO' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeAereo' id='quantidadeAereo' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalAereo' id='valorTotalAereo' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='valorServicos'>SERVIÇOS</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='valorServicos' id='valorServicos' placeholder='SERVIÇOS' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-1'>";
                echo "<input type='text' class='form-control' name='quantidadeServicos' id='quantidadeServicos' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "<div class='col-sm-2'>";
                echo "<input type='text' readonly class='form-control col-sm-8' name='valorTotalServicos' id='valorTotalServicos' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='outros'>OUTROS</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='outros' id='outros' placeholder='OUTROS' value='0'onchange='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='totalDespesas'>TOTAL DESPESAS</label>";
                echo "<div class='col-sm-6'>";
                echo "<input type='text' class='form-control' name='totalDespesas' id='totalDespesas' placeholder='TOTAL DESPESAS' value='' readonly='readonly' onblur='calculoTotalDespesas()'>";
                echo "</div>";
                echo "</div>";

                echo "<button type='submit' name='cadastrarClienteBtn' id='submit' class='btn btn-primary btn-lg'>CADASTRAR</button>";
              } else {
                echo "<p class='h4 text-center alert-warning'>JÁ EXISTEM DESPESAS CADASTRADAS PARA ESSE PASSEIO, REDIRECIONANDO PARA A ÁREA DE DESPESAS </p>";
                echo " <script>
                              setTimeout(function () {
                                window.location.href = 'editaDespesas.php?id=" . $idPasseioLista . "';
                            }, 5000);
                          </script>
                    ";
              }
            } else {
              echo "<p class='h2 text-center alert-danger'>NENHUM PASSEIO SELECIONADO</p>";
            }
          } else {
          }
          ?>
          <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $idPasseioLista ?>">
          <input type="hidden" class="form-control col-sm-1 ml-3" name="nomePassseio" id="nomePasseio" value="<?php echo  $rowBuscaInformacoesPasseio['nomePasseio'] ?>">
          <input type="hidden" class="form-control col-sm-1 ml-3" name="dataPasseio" id="dataPasseio" value="<?php echo $rowBuscaInformacoesPasseio['dataPasseio'] ?>">

        </form>
      </div>
    </div>
  </div>

  <script src="config/script.php"></script>
</body>

</html>