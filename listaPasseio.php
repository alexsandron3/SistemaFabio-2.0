<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
if (empty($ordemPesquisa)) {
  $ordemPesquisa = 'nomeCliente';
}
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.rgCliente, c.dataCpfConsultado, c.telefoneCliente, c.orgaoEmissor, c.idadeCliente, c.referencia,
                              pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, pp.dataPagamento, pp.clienteDesistente 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente ORDER BY $ordemPesquisa ";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
/* -----------------------------------------------------------------------------------------------------  */

$pegarNomePasseio = "SELECT nomePasseio, lotacao, dataPasseio FROM passeio WHERE idPasseio='$idPasseioGet'";
$resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
$rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
$nomePasseioTitulo = $rowpegarNomePasseio['nomePasseio'];
$dataPasseio = date_create($rowpegarNomePasseio['dataPasseio']);
$lotacao = $rowpegarNomePasseio['lotacao'];
/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>


  <title>LISTA CLIENTES </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-2">
    <div class="col-lg-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
                  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                  <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div> <?php 
          mensagensInfoNoSession("". $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . " <br/>
          <span class='h5'> LOTAÇÃO: $lotacao </span> 
         | <span class='h5' onclick='tituloListagem()' id='confirmados' >  CONFIRMADOS </span> 
         | <span class='h5' onclick='tituloListagem()' id='interessados'>  INTERESSADOS </span>
         | <span class='h5' onclick='tituloListagem()' id='criancas'>  CRIANÇAS </span>
         | <span class='h5' onclick='tituloListagem()' id='parceiros'>  PARCEIROS </span>
         | <span class='h5' onclick='tituloListagem()' id='desistentes'>  DESISTENTES </span>
         | <span class='h5' onclick='tituloListagem()' id='vagasDisponiveis'>  VAGAS DISPONÍVEIS </span>  ");
/*           echo "<p class='h5 text-center alert-info '>" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . " <br/>
         <span class='h5'> LOTAÇÃO: $lotacao </span> 
        | <span class='h5' onclick='tituloListagem()' id='confirmados' >  CONFIRMADOS </span> 
        | <span class='h5' onclick='tituloListagem()' id='interessados'>  INTERESSADOS </span>
        | <span class='h5' onclick='tituloListagem()' id='criancas'>  CRIANÇAS </span>
        | <span class='h5' onclick='tituloListagem()' id='parceiros'>  PARCEIROS </span>
        | <span class='h5' onclick='tituloListagem()' id='desistentes'>  DESISTENTES </span>
        | <span class='h5' onclick='tituloListagem()' id='vagasDisponiveis'>  VAGAS DISPONÍVEIS </span>  
        </p>"; */ ?>
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="userTable">
                <thead>
                  <tr>
                    <th> <a href="#"> NOME </a></th>
                    <th> <a href="#">RG </a></th>
                    <th> <a href="#">CPF CONSULTADO </a></th>
                    <th> <a href="#">REFERÊNCIA </a></th>
                    <th> <a href="#">STATUS </a></th>
                    <th> <a href="#">CONTATO </a></th>
                    <th> <a href="#">V. PAGO  </a></th>
                    <th> <a href="#">V. VENDIDO </a></th>
                    <th> <a href="#"> AÇÃO  </a></th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $controleListaPasseio = 0;
                  $interessados = 0;
                  $quantidadeClienteParceiro = 0;
                  $confirmados = 0;
                  $criancas = 0;
                  $desistentes = 0;
                  while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {

                    $idPagamento = $rowBuscaPasseio['idPagamento'];
                    $dataCpfConsultado = (empty($rowBuscaPasseio['dataCpfConsultado']) or $rowBuscaPasseio['dataCpfConsultado'] == "0000-00-00") ? "" : date_create($rowBuscaPasseio['dataCpfConsultado']);
                    $dataCpfConsultadoFormatado = (empty($dataCpfConsultado) or $dataCpfConsultado == "0000-00-00") ? "" : date_format($dataCpfConsultado, "d/m/Y");

                    $idCliente = $rowBuscaPasseio['idCliente'];
                    $idPasseio = $rowBuscaPasseio['idPasseio'];
                    $idadeCliente = $rowBuscaPasseio['idadeCliente'];
                    $clienteParceiro = $rowBuscaPasseio['clienteParceiro'];
                    $statusCliente = $rowBuscaPasseio['statusPagamento'];
                    $clienteDesistente = $rowBuscaPasseio['clienteDesistente'];


                    if ($clienteDesistente) {
                      $controleListaPasseio = 1;
                      $desistentes += 1;
                      $statusPagamento = "DESISTENTE";
                    } else {
                      if ($statusCliente == 0) {
                        $controleListaPasseio = 1;
                        $interessados = $interessados + 1;
                        $statusPagamento = "INTERESSADO";
                      } elseif ($statusCliente == 1) {
                        $controleListaPasseio = 1;
                        $confirmados = $confirmados + 1;
                        $statusPagamento = "QUITADO";
                      } elseif ($statusCliente == 2) {
                        $controleListaPasseio = 1;
                        $confirmados = $confirmados + 1;
                        $statusPagamento = "PARCIAL";
                      } elseif ($statusCliente == 3) {
                        $controleListaPasseio = 1;
                        $quantidadeClienteParceiro = $quantidadeClienteParceiro + 1;
                        $statusPagamento = "PARCEIRO";
                      } elseif ($statusCliente == 4) {
                        $controleListaPasseio = 1;
                        $criancas = $criancas + 1;
                        $statusPagamento = "CRIANÇA";
                      } else {
                        $statusPagamento = "DESCONHECIDO";
                      }
                      $nomePasseio = $rowBuscaPasseio['nomePasseio'];
                    }
                  ?>
                    <tr class="text-muted">
                      <td><?php $nomeCliente = $rowBuscaPasseio['nomeCliente'];
                          echo $nomeCliente  . "<BR/>"; ?></td>
                      <td><?php echo $rowBuscaPasseio['rgCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $dataCpfConsultadoFormatado;
                          ?></td>
                      <td><?php echo $rowBuscaPasseio['referencia'] . "<BR/>"; ?></td>

                      <td><?php echo "<a class='btn btn-link' role='button' target='_blank' rel='noopener noreferrer' href='editarPagamento.php?id=" . $idPagamento . "' >" . $statusPagamento . "</a><BR/>"; ?></td>
                      <td> <?php echo $rowBuscaPasseio['telefoneCliente'] . "<BR/>"; ?></td>
                      <?php
                      $valorPago = (empty($rowBuscaPasseio['valorPago']) ? $valorPago = 0.00 : $valorPago =  $rowBuscaPasseio['valorPago']);
                      if ($_SESSION['nivelAcesso'] == 1 or $_SESSION['nivelAcesso'] == 0) {
                        if ($rowBuscaPasseio['valorPago'] == 0) {
                          $opcao = "DELETAR";
                        } else {
                          $opcao = "TRANSFERIR";
                        }
                      } else {
                        $opcao = "";
                      }
                      ?>
                      <td><?php echo number_format($valorPago, 2, '.', '') . "<BR/>" ?></td>
                      <td><?php echo $rowBuscaPasseio['valorVendido'] . "<BR/>"; ?></td>
                      <td class="td-actions text-right"> <a target='_blank' red='noopener noreferrer' class="btn btn-info btn-just-icon btn-sm" href="editarPagamento.php?id=<?php echo $idPagamento; ?>">
                          <i class="material-icons"> edit </i> </a>
                        </a>
                        <a target='_blank' rel='noopener noreferrer' class="btn btn-warning btn-just-icon btn-sm" href="SCRIPTS/apagarPagamento.php?idPagamento=<?php echo $idPagamento; ?>&idPasseio=<?php echo $idPasseio; ?>&opcao=<?php echo $opcao ?>&confirmar=0&nomeCliente=<?php echo $nomeCliente; ?>&dataPasseio=<?php echo $rowpegarNomePasseio['dataPasseio'] ?>&nomePasseio=<?php echo $nomePasseioTitulo; ?>&valorPago=<?php echo number_format($valorPago, 2, '.', ''); ?>">
                          <i class="material-icons"><?php $iconAcao = ($opcao == "DELETAR") ? 'remove_shopping_cart' : 'swap_horiz';
                                                    echo $iconAcao; ?> </i>
                        </a>
                        <a target="_blank" href="https://wa.me/55<?php echo $rowBuscaPasseio['telefoneCliente']; ?>"> <i class="material-icons"> perm_contact_calendar </i> </a>




                      </td>


                    </tr>

                  <?php


                  }

                  ?>
                  <input class="text-invisble"  type="text" name=""  id="idPasseio" onclick="Export()" disabled="disabled" value="<?php echo $idPasseioGet;  ?>">
                  <input class="text-invisble"  type="text" name="" id="clientesConfirmados" onclick="tituloListagem()" disabled="disabled" value="<?php echo $confirmados;  ?>">
                  <input class="text-invisble"  type="text" name="" id="clientesCriancas" onclick="tituloListagem()" disabled="disabled" value="<?php echo $criancas;  ?>">
                  <input  class="text-invisble" type="text" name="" id="clientesInteressados" onclick="tituloListagem()" disabled="disabled" value="<?php echo $interessados;  ?>">
                  <input class="text-invisble"  type="text" name="" id="clientesParceiros" onclick="tituloListagem()" disabled="disabled" value="<?php echo $quantidadeClienteParceiro;  ?>">
                  <input class="text-invisble"  type="text" name="" id="clientesDesistentes" onclick="tituloListagem()" disabled="disabled" value="<?php echo $desistentes;  ?>">
                  <input class="text-invisble"  type="text" name="" id="totalVagasDisponiveis" onclick="tituloListagem()" disabled="disabled" value="<?php $vagasDisponiveis = $lotacao - $confirmados - $quantidadeClienteParceiro; echo $vagasDisponiveis;  ?>">
                </tbody>
              </table>
            </div>
            <?php
            if ($controleListaPasseio > 0) {
              echo "<div class='text-center'>";
              echo "</div>";
            } else {

              echo "<div class='text-center'>";
              mensagensWarningNoSession("Nenhum PAGAMENTO foi cadastrado até o momento");
              #echo "<p class='h5 text-center alert-warning'>Nenhum PAGAMENTO foi cadastrado até o momento</p>";
              echo "</div>";
            }


            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="config/script.php"></script>
  <script>
    function apagarPagamento() {
      var abrirJanela;
      var conf = confirm("APAGAR PAGAMENTO??");
      if (conf == true) {}
    }
  </script>
</body>

</html>