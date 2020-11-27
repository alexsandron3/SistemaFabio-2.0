<?php
    session_start();
    include_once("PHP/conexao.php");
    $idPagamento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $resultadoBuscaIdPagamento = "SELECT DISTINCT c.nomeCliente, c.referencia, c.idadeCliente , p.idPasseio, p.nomePasseio, p.dataPasseio, pp.idPagamento, pp.transporte ,pp.idCliente, pp.idPasseio, pp.valorPago, pp.valorVendido, pp.previsaoPagamento, pp.anotacoes, pp.valorPendente, pp.statusPagamento, pp.seguroViagem FROM cliente c, passeio p, pagamento_passeio pp WHERE idPagamento='$idPagamento' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
    $resultadoIdPagamento = mysqli_query($conexao, $resultadoBuscaIdPagamento);
    $rowIdPagamento = mysqli_fetch_assoc($resultadoIdPagamento);
    $idPasseio = $rowIdPagamento ['idPasseio'];
    $statusSeguroViagem = $rowIdPagamento ['seguroViagem'];
    $idadeCliente = $rowIdPagamento ['idadeCliente'];
    $transporte = $rowIdPagamento ['transporte'];

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="config/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
    integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
  <title>PAGAMENTO</title>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">INÍCIO </a>
        </li>
        <li class="nav-item ">
        <a class="nav-link" href="relatoriosPasseio.php">RELATÓRIOS </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
            <!-- <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a> -->
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            LISTAGEM
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="">CLIENTE</a>
            <a class="dropdown-item" href="">PASSEIO</a>
            <a class="dropdown-item" href="">PAGAMENTO</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item active" href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
    
    <div class="container-fluid ">
      <form action="SCRIPTS/atualizaPagamento.php" method="post" autocomplete="OFF"  >
      <div class="form-group-row">
          <?php
            $dataPasseio = date_create($rowIdPagamento ['dataPasseio']);
            
            $nomePasseioSelelecionado = $rowIdPagamento ['nomePasseio'];
            $valorVendido  = $rowIdPagamento ['valorVendido'];
            $anotacoes  = $rowIdPagamento ['anotacoes'];
            $valorPago     = $rowIdPagamento ['valorPago'];
            $valorPendente = $rowIdPagamento ['valorPendente'];
            //$transporte = $rowIdPagamento ['transporte'];
            //echo"<p class='text-center alert-success'>SUCESSO, ESTE CLIENTE AINDA NÃO FEZ UMA COMPRA NESSE PASSEIO </p>";  
            echo"<p class='h4 text-center alert-info'> ". $rowIdPagamento ['nomeCliente']. " | ". $rowIdPagamento ['nomePasseio']. " ". date_format($dataPasseio, "d/m/Y") ."</p>";
            //echo"<p class='h4 text-center alert-info'>"</p>";
            echo"<div class='form-group row'>";
                echo"<label class='col-sm-2 col-form-label' for='valorVendido'>VALOR VENDIDO</label>";
                echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorVendido' id='valorVendido' placeholder='VALOR VENDIDO' value='$valorVendido' onblur='calculoPagamentoCliente()'>";
                echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
                echo"<label class='col-sm-2 col-form-label' for='valorPago'>VALOR PAGO</label>";
                echo"<div class='col-sm-6'>";
                  echo"<input type='text' class='form-control' name='valorPago' id='valorPago' placeholder='VALOR PAGO' value='$valorPago' onblur='calculoPagamentoCliente()'>";
                echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
                echo"<label class='col-sm-2 col-form-label' for='valorPendenteCliente'>VALOR PENDENTE</label>";
                echo"<div class='col-sm-6'>";
                  echo"<input type='text' class='form-control' name='valorPendenteCliente' id='valorPendenteCliente' placeholder='VALOR PENDENTE' value='$valorPendente' readonly='readonly' onblur='calculoPagamentoCliente()'>";
                echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
                echo"<label class='col-sm-2 col-form-label' for='previsaoPagamento'>PREVISÃO PAGAMENTO</label>";
                echo"<div class='col-sm-3'>";
                  echo"<input type='date' class='form-control' name='previsaoPagamento' id='previsaoPagamento' value='".$rowIdPagamento ['previsaoPagamento'] . "' placeholder='PREVISÃO PAGAMENTO'>";
                echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='meioTransporte'>TRANSPORTE</label>";
              echo"<select class='form-control col-sm-3 ml-3' name='meioTransporte' id='meioTransporte'>";
                echo"<option value='$transporte' selected> $transporte</option>";
                echo"<option value='' >---------------------------------------------</option>";
                echo"<option value='CARRO'>CARRO</option>";
                echo"<option value='ONIBUS'>ÔNIBUS</option>";
                echo"<option value='MICRO'>MICRO</option>";
                echo"<option value='VAN'>VAN</option>";
              echo"</select>";
              echo"</div>";
            echo"<input type='hidden' class='form-control' name='statusPagamento' id='statusPagamento' placeholder='statusPagamento'  onchange='calculoPagamentoCliente()'>";
            echo"<div class='form-group row'>";
                echo "<label class='col-sm-2 col-form-label' for='referenciaCliente'>REFERÊNCIA</label>";
                echo"<textarea class='form-control col-sm-3 ml-3' name='referenciaCliente' id='referenciaCliente' cols='3' rows='1' disabled='disabled'
                placeholder='INFORMAÇÕES' onkeydown='upperCaseF(this)'>".$rowIdPagamento ['referencia'].  "</textarea> ";
            echo"</div>";
            echo"<fieldset class='form-group'>";
            if($statusSeguroViagem == 1){
              echo"<div class='row'>";
                echo"<legend class='col-form-label col-sm-2 pt-0'>SEGURO VIAGEM</legend>";
                echo"<div class='col-sm-5'>";
                  echo"<div class='form-check'>";
                    echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim'
                    value='1'  disabled checked '>";
                    echo"<label class='form-check-label' for='seguroViagemClienteSim' >
                      SIM
                    </label>";
                  echo"</div>";
                  echo"<div class='form-check'>";
                    echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao'
                    value='0' onclick='seguroViagem()'>";
                    echo"<label class='form-check-label' for='seguroViagemClientenao'>
                      NÃO
                    </label>";
                  echo"</div>";
                echo"</div>";
              echo"</div>";
              $valorSeguroViagem = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
              $resultadoValorSeguroViagem = mysqli_query($conexao,$valorSeguroViagem);
              $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
              echo"<input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente'  value='".$idadeCliente. "'>";
              echo"<input type='hidden' class='form-control' name='idPasseioSelecionado' id='idPasseioSelecionado' placeholder='idPasseioSelecionado'  value='".$idPasseio. "'>";
              echo"<input type='hidden' value=' ".$rowSeguroViagem['valorSeguroViagem'] .  "'id='valorSeguroViagem' onclick='seguroViagem()'>";
              echo"<input type='hidden' value='' name='novoValorSeguroViagem' id='novoValorSeguroViagem'onclick='seguroViagem()'> ";
            }else{
              echo"<div class='row'>";
                echo"<legend class='col-form-label col-sm-2 pt-0'>SEGURO VIAGEM</legend>";
                echo"<div class='col-sm-5'>";
                  echo"<div class='form-check'>";
                    echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim'
                    value='1' onclick='seguroViagem()' >";
                    echo"<label class='form-check-label' for='seguroViagemClienteSim'>
                      SIM
                    </label>";
                  echo"</div>";
                  echo"<div class='form-check'>";
                    echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao'
                    value='0' onclick='seguroViagem()' checked>";
                    echo"<label class='form-check-label' for='seguroViagemClientenao'>
                      NÃO
                    </label>";
                  echo"</div>";
                echo"</div>";
              echo"</div>";
              $valorSeguroViagem = "SELECT valorSeguroViagem FROM despesa WHERE idPasseio='$idPasseio'";
              $resultadoValorSeguroViagem = mysqli_query($conexao,$valorSeguroViagem);
              $rowSeguroViagem = mysqli_fetch_assoc($resultadoValorSeguroViagem);
              echo"<input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente'  value='".$idadeCliente. "'>";
              //echo"<input type='text' name='valorPagoAtual' id='valorPagoAtual'   value='".$valorPago. "'>";
              echo"<input type='hidden' class='form-control' name='idPasseioSelecionado' id='idPasseioSelecionado' placeholder='idPasseioSelecionado'  value='".$idPasseio. "'>";
              echo"<input type='hidden' value=' ".$rowSeguroViagem['valorSeguroViagem'] .  "'id='valorSeguroViagem' onclick='seguroViagem()'>";
              echo"<input type='hidden' value='' name='novoValorSeguroViagem' id='novoValorSeguroViagem'onclick='seguroViagem()'> ";


            }
            echo"</fieldset>"; 
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='anotacoes'>ANOTAÇÕES</label>";
              echo"<textarea class='form-control col-sm-3 ml-3' name='anotacoes' id='anotacoes' cols='6' rows='3'
              placeholder='ANOTAÕES' onkeydown='upperCaseF(this)' maxlength='500'> $anotacoes</textarea>";
            echo"</div>"; 
          ?>
          
          </select>
        </div>
        <input type="submit" class="btn btn-primary btn-sm" value="FINALIZAR PAGAMENTO" name="buttonFinalizarPagamento">
        
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamento" id="idCliente" 
          readonly="readonly" value="<?php echo $idPagamento ?>">
      </form>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>