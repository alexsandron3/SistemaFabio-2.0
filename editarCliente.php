<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idClienteGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
$queryBuscaPeloIdCliente = "SELECT * FROM cliente WHERE idCliente='$idClienteGet'";
$resultadoBuscaPeloIdCliente = mysqli_query($conexao, $queryBuscaPeloIdCliente);
$rowResultadoBuscaPeloIdCliente = mysqli_fetch_assoc($resultadoBuscaPeloIdCliente);
/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/head.php"); ?>

  <title>EDITAR CLIENTE</title>
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
           <form action="SCRIPTS/atualizaCliente.php" autocomplete="off" method="POST" onclick=ageCount()>
            <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['idCliente'] ?>">
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="nomeCliente">NOME</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" placeholder="NOME COMPLETO" onkeydown="upperCaseF(this)" value="<?php echo $rowResultadoBuscaPeloIdCliente['nomeCliente']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="emailCliente">EMAIL</label>
              <div class="col-sm-6">
                <input type="email" class="form-control" name="emailCliente" id="emailCliente" placeholder="EMAIL DO CLIENTE" value="<?php echo $rowResultadoBuscaPeloIdCliente['emailCliente']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="rgCliente">RG</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="rgCliente" id="rgCliente" placeholder="RG" value="<?php echo $rowResultadoBuscaPeloIdCliente['rgCliente']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="orgaoEmissor">EMISSOR</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="orgaoEmissor" id="orgaoEmissor" placeholder="ORGÃO EMISSOR" autocomplete="ON" onkeydown="upperCaseF(this)" value="<?php echo $rowResultadoBuscaPeloIdCliente['orgaoEmissor']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="cpfCliente">CPF</label>
              <div class="col-sm-6">
                <input type="text" class="form-control " name="cpfCliente" id="cpfCliente" placeholder="CPF DO CLIENTE" value="<?php echo $rowResultadoBuscaPeloIdCliente['cpfCliente']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="telefoneCliente">TELEFONE</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="telefoneCliente" id="telefoneCliente" placeholder="XX 9 XXXX-XXXX" value="<?php echo $rowResultadoBuscaPeloIdCliente['telefoneCliente']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="dataNascimento">NASCIMENTO</label>
              <input type="date" class="form-control col-sm-3 ml-3" name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)" value="<?php echo $rowResultadoBuscaPeloIdCliente['dataNascimento']; ?>">
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label " for="idadeCliente">IDADE</label>
              <input type="text" class="form-control col-sm-3 ml-3" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-1 pt-0">CPF CONSULTADO</legend>
                <div class="col-sm-5">
                  <div class="ml-3">
                    <?php
                    if ($rowResultadoBuscaPeloIdCliente['cpfConsultado'] == 1) {
                      echo "
                    <div class='ml-3'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1'
                      onclick='changeInputDate()' checked>
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='ml-3'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0'
                      onclick='changeInputDate()' >
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>";
                    } else {
                      echo "
                    <div class='ml-3'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1'
                      onclick='changeInputDate()' >
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='ml-3'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0'
                      onclick='changeInputDate()' checked >
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>";
                    }
                    ?>
                  </div>
                </div>

              </div>
            </fieldset>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="dataCpfConsultado">DATA DA CONSULTA</label>
              <input type="date" class="form-control col-sm-3 ml-3" name="dataCpfConsultado" id="dataCpfConsultado" placeholder="MM/DD/AAAA" onclick="setInputDate()" value="<?php echo $rowResultadoBuscaPeloIdCliente['dataCpfConsultado']; ?>">
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="referenciaCliente">REFERÊNCIA</label>
              <textarea class="form-control col-sm-3 ml-3" name="referenciaCliente" id="referenciaCliente" cols="3" rows="1" placeholder="INFORMAÇÕES" onkeydown="upperCaseF(this)"><?php echo $rowResultadoBuscaPeloIdCliente['referencia'] ?></textarea>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="telefoneContato">TELEF. CONTATO</label>
              <input class="form-control col-sm-3 ml-3" type="tel" name="telefoneContato" id="telefoneContato" placeholder="XX 9 XXXX-XXXX" value="<?php echo $rowResultadoBuscaPeloIdCliente['telefoneContato']; ?>">
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="nomeContato">PESSOA CONTATO</label>
              <input class="form-control col-sm-3 ml-3" type="text" name="nomeContato" id="nomeContato" placeholder="QUEM CONTATAR" onkeydown="upperCaseF(this)" value="<?php echo $rowResultadoBuscaPeloIdCliente['pessoaContato']; ?>">
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label" for="redeSocial">REDES SOCIAIS</label>
              <textarea class="form-control col-sm-3 ml-3" name="redeSocial" id="redeSocial" cols="10" rows="5" placeholder="REDES SOCIAIS" onkeydown="upperCaseF(this)"><?php echo $rowResultadoBuscaPeloIdCliente['redeSocial'] ?></textarea>
            </div>
            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg">ATUALIZAR</button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info btn-lg ml-5" data-toggle="modal" data-target="#exampleModal">
              HISTÓRICO
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">PAGAMENTOS DESTE CLIENTE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-hover table-dark">
                      <thead>
                        <tr>
                          <th>PASSEIO</th>
                          <th>DATA</th>
                          <th>STATUS</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $queryBuscaPagamentoCliente = "SELECT pp.idPasseio, pp.statusPagamento, p.nomePasseio, p.dataPasseio FROM pagamento_passeio pp, passeio p WHERE idCliente=$idClienteGet AND pp.idPasseio=p.idPasseio ORDER BY p.dataPasseio DESC ";
                        $resultadoBuscaPagamentoCliente = mysqli_query($conexao, $queryBuscaPagamentoCliente);
                        while ($rowPagamentoCliente = mysqli_fetch_assoc($resultadoBuscaPagamentoCliente)) {
                          $dataPasseio =  date_create($rowPagamentoCliente['dataPasseio']);
                          if ($rowPagamentoCliente['statusPagamento'] == 0) {
                            $statusPagamento = "QUITADO";
                          } else {
                            $statusPagamento = "NÃO QUITADO";
                          }
                        ?>
                          <tr>
                            <th><?php echo $rowPagamentoCliente['nomePasseio'] . "</br>"; ?></th>
                            <td><?php echo date_format($dataPasseio, "d/m/Y") . "</br>"; ?></td>
                            <td><?php echo $statusPagamento . "</br>"; ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>