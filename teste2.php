<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
// 
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once("./includes/mdbcss.php"); ?>
  <title>RELATÓRIO DE VENDAS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-3">
    <div class="col-10 mx-auto">
      <div class="card rounded shadow border-0">
        <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESsSO -->
        <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
        <div class="card-body p-5 bg-white rounded">
          <p class="h2 text-center">RELATÓRIO DE VENDAS</p>
          <form action='' method='GET' autocomplete='OFF'>
            <div class="form-row">
              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O INÍCIO DO PERÍODO" type='date' class='form-control' name='inicioDataPasseio' id='inicioDataPasseio' value="">
              </div>

              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O FIM DO PERÍODO" type='date' class='form-control' name='fimDataPasseio' id='fimDataPasseio' value="">
              </div>

            </div>
            <div class="form-row">
              <div class="col">
                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio' id="buttonEviaDataPasseio">
              </div>
            </div>
            <p class="text-center" id="refreshText"> </p>
          </form>
          <div class="table-responsive mt-3">
            <!-- Date Filter -->
            <table>
              <tr>
                <td>
                  <input type='date'  id='inicio' class="datepicker" placeholder='From date'>
                </td>
                <td>
                  <input type='date'  id='fim' class="datepicker" placeholder='To date'>
                </td>
                <td>
                  <input type='button' id="btn_search" value="Search">
                </td>
              </tr>
            </table>
            <table style="width:100%" class="table table-striped table-bordered" id="relatorioVendasTable">
              <thead>
                <tr>
                  <th scope="col">PASSEIO</th>
                  <th scope="col">DATA</th>
                  <th scope="col">Nº VENDAS</th>
                  <th scope="col">VALOR VENDA</th>
                  <th scope="col">VALOR PAGO</th>
                </tr>
              </thead>
              <tbody id="tbodyTeste">

              </tbody>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>

</body>

</html>