<?php
    session_start();
    include_once("PHP/conexao.php");
/* -----------------------------------------------------------------------------------------------------  */
    $idPasseio = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
    if(!empty($idPasseio)){
      $nenhumPasseioSelecionado = false;
/* -----------------------------------------------------------------------------------------------------  */
        $relatoriosPasseio =    "SELECT SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente, AVG(pp.valorVendido) AS valorMediaVendido, FORMAT(SUM(pp.valorSeguroViagemCliente), 2) AS totalSeguroViagem,
                                p.nomePasseio, p.dataPasseio, p.valorPasseio
                                FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND pp.idPasseio=$idPasseio";
                                $resultadoRelatoriosPasseio     = mysqli_query($conexao, $relatoriosPasseio);
                                $rowResultadoRelatoriosPasseio  = mysqli_fetch_assoc($resultadoRelatoriosPasseio);
                                
                                $lucroBruto                     = $rowResultadoRelatoriosPasseio['somarValorPago'];
                                $valorPendente                  = $rowResultadoRelatoriosPasseio['valorPendente'];
                                $qtdCliente                     = $rowResultadoRelatoriosPasseio['qtdCliente'];
                                $valorTotalSeguroViagem         = $rowResultadoRelatoriosPasseio['totalSeguroViagem'];
                                $valorPasseio                   = $rowResultadoRelatoriosPasseio['valorPasseio'];
                                $valorMediaVendido              = $rowResultadoRelatoriosPasseio['valorMediaVendido'];
                                $nomePasseio = $rowResultadoRelatoriosPasseio['nomePasseio'];
                                $dataPasseio = date_create($rowResultadoRelatoriosPasseio['dataPasseio']);
/* -----------------------------------------------------------------------------------------------------  */
        
        $totalDespesas =        "SELECT (valorIngresso * quantidadeIngresso) + (valorOnibus * quantidadeOnibus) + (valorMicro * quantidadeMicro) + (valorVan * quantidadeVan) + (valorEscuna * quantidadeEscuna) + (valorAlmocoCliente * quantidadeAlmocoCliente)
                                + (valorAlmocoMotorista * quantidadeAlmocoMotorista)+ (valorEstacionamento * quantidadeEstacionamento)+ (valorGuia * quantidadeGuia) + (valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte) + (valorTaxi * quantidadeTaxi)
                                + (valorKitLanche * quantidadeKitLanche)+ (valorMarketing * quantidadeMarketing) + (valorImpulsionamento * quantidadeImpulsionamento) + outros 
                                AS totalDespesas FROM despesa WHERE idPasseio=$idPasseio"; 
                                $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                                $rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas);
                                $valorTotalDespesas             = $rowTotalDespesa ['totalDespesas'] + $valorTotalSeguroViagem;
/* -----------------------------------------------------------------------------------------------------  */
        
        $lucroLiquido                   = $lucroBruto + $valorPendente;
        $lucroDespesas                  = $lucroBruto + $valorPendente - $valorTotalDespesas;
        $lucroEstimado                  = $valorPasseio * $qtdCliente;
/* -----------------------------------------------------------------------------------------------------  */

       
    }else{
      $nenhumPasseioSelecionado = true;
      $valorPendente            = 0;
      $lucroBruto               = 0; 
      $valorMediaVendido        = 0; 
      $lucroLiquido             = 0; 
      $lucroDespesas            = 0; 
      $totalDespesas            = 0; 
      $qtdCliente               = 0; 
      $lucroEstimado            = 0; 
      $valorTotalDespesas       = 0;
      $valorPasseio             = 0;

    }
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>RELATÓRIOS</title>
</head>

<body>
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
          <a class="nav-link" href="#">RELATÓRIOS </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
          </div>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            LISTAGEM
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="">CLIENTE</a>
            <a class="dropdown-item" href="">PASSEIO</a>
            <a class="dropdown-item" href="">PAGAMENTO</a>
          </div> -->
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
  ?>
  <div class="container-fluid mt-3">
    <p class="h4 text-center alert-info">
        <?php  
            if($nenhumPasseioSelecionado){
                echo"<p class='h4 text-center alert-info'> SELECIONE O INTERVALO</p>";
                echo"<form action='' method='GET' autocomplete='OFF'>";
                  echo"<div class='form-group row mb-5'>";
                    echo"<label class='col-sm-2 col-form-label' for='inicioDataPasseio'>DE:</label>";
                    echo"<input type='date' class='form-control col-sm-2' name='inicioDataPasseio' id='inicioDataPasseio'>";

                    echo"<label class='col-sm-2 col-form-label' for='fimDataPasseio'>ATÉ:</label>";
                    echo"<input type='date' class='form-control col-sm-2' name='fimDataPasseio' id='fimDataPasseio' >";
                    echo"<input type='submit' class='btn btn-primary btn-sm ml-5' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>";
                  echo"</div>";
                echo"</form>";
/* -----------------------------------------------------------------------------------------------------  */
                $buttonEviaDataPasseio = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
                $inicioDataPasseio     = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
                $fimDataPasseio        = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
/* -----------------------------------------------------------------------------------------------------  */
                if($buttonEviaDataPasseio){
                  if(!empty($inicioDataPasseio) && !empty($fimDataPasseio)){
/* -----------------------------------------------------------------------------------------------------  */
                    $pesquisaIntervaloData ="SELECT DISTINCT p.idPasseio, p.nomePasseio, SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente, AVG(pp.valorVendido) AS valorMediaVendido,
                                            p.nomePasseio, p.dataPasseio, p.valorPasseio
                                            FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'";
                                            $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
                                            while($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)){
                                              echo"
                                              <div class='text-center alert-info'>" .$rowPesquisaIntervaloData ['nomePasseio']. 
                                              "<a target='_blank' href='listaPasseio.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> LISTA </a> |
                                              <a target='_blank' href='editaDespesas.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> DESPESAS </a> | 
                                              <a  target='_blank' href='relatoriosPasseio.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> RELATÓRIO </a>  </div>";
                                        
                                            $lucroBruto                    = $rowPesquisaIntervaloData['somarValorPago'];
                                            $valorPendente                 = $rowPesquisaIntervaloData['valorPendente'];
                                            $qtdCliente                    = $rowPesquisaIntervaloData['qtdCliente'];
                                            $valorPasseio                  = $rowPesquisaIntervaloData['valorPasseio'];
                                            $valorMediaVendido             = $rowPesquisaIntervaloData['valorMediaVendido'];
/* -----------------------------------------------------------------------------------------------------  */
                                            }
/* -----------------------------------------------------------------------------------------------------  */

                    $valorTotalSeguroViagem =    "SELECT  FORMAT(SUM(pp.valorSeguroViagemCliente),2) AS totalSeguroViagem FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'";
                                                  $resultadovalorTotalSeguroViagem = mysqli_query($conexao, $valorTotalSeguroViagem);
                                                  $rowvalorTotalSeguroViagem = mysqli_fetch_assoc($resultadovalorTotalSeguroViagem);
                                                  $valorTotalSeguroViagem = $rowvalorTotalSeguroViagem['totalSeguroViagem'];
/* -----------------------------------------------------------------------------------------------------  */

                    $totalDespesas =        "SELECT DISTINCT p.idPasseio, p.nomePasseio, (valorIngresso * quantidadeIngresso) + (valorOnibus * quantidadeOnibus) + (valorMicro * quantidadeMicro) + (valorVan * quantidadeVan) + (valorEscuna * quantidadeEscuna) + (valorAlmocoCliente * quantidadeAlmocoCliente)
                                            + (valorAlmocoMotorista * quantidadeAlmocoMotorista)+ (valorEstacionamento * quantidadeEstacionamento)+ (valorGuia * quantidadeGuia) + (valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte) + (valorTaxi * quantidadeTaxi)
                                            + (valorKitLanche * quantidadeKitLanche)+ (valorMarketing * quantidadeMarketing) + (valorImpulsionamento * quantidadeImpulsionamento) + outros 
                                            AS totalDespesas FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'"; 
                                            $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                                            while($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)){
                                              
                                            
                                              $valorTotalDespesas             = $rowTotalDespesa ['totalDespesas']+ $valorTotalSeguroViagem ;
                        
/* -----------------------------------------------------------------------------------------------------  */
          
                                              $lucroLiquido                   = $lucroBruto + $valorPendente;
                                              $lucroDespesas                  = $lucroBruto + $valorPendente - $valorTotalDespesas;
                                              $lucroEstimado                  = $valorPasseio * $qtdCliente;
/* -----------------------------------------------------------------------------------------------------  */
                                            }

                  }else{
                    echo"<p class='h4 text-center alert-warning'> SELECIONE O INTERVALO</p>";
                  }
                }else{
                  //
                }
            }else{ 
                echo $nomePasseio." ", date_format($dataPasseio, "d/m/Y");
            } 
        ?>
    </p>
    <div class="form-group row mt-3">
        <label class="col-sm-2 col-form-label" for="valorPendente">VALOR PENDENTE</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorPendente" id="valorPendente" placeholder="R$" value="<?php echo $valorPendente?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="lucroBruto">LUCRO BRUTO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroBruto" id="lucroBruto" placeholder="R$" value="<?php echo $lucroBruto?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" for="valorMediaVendido">VALOR MÉDIO VENDIDO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorMediaVendido" id="valorMediaVendido" placeholder="R$" value="<?php echo $valorMediaVendido?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="lucroBrutoSemDespesas">LUCRO SEM DESPESAS</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroBrutoSemDespesas" id="lucroBrutoSemDespesas" placeholder="R$" value="<?php echo $lucroLiquido?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="lucroDespesas">LUCRO COM DESPESAS</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroDespesas" id="lucroDespesas" placeholder="R$" value="<?php echo $lucroDespesas?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" for="totalDespesas"> <a target="_blank" rel="noopener noreferrer" href="editaDespesas.php?id=<?php echo $idPasseio ?>">TOTAL DESPESAS</a> </label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="totalDespesas" id="totalDespesas" placeholder="R$" value="<?php echo $valorTotalDespesas?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="qtdCliente"> <a target="_blank" rel="noopener noreferrer" href="listaPasseio.php?id=<?php echo $idPasseio ?>"> QTD DE CLIENTES</a></label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="qtdCliente" id="qtdCliente" placeholder="0" value="<?php echo $qtdCliente?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="lucroEstimado">LUCROS ESTIMADOS</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroEstimado" id="lucroEstimado" placeholder="0" value="<?php echo $lucroEstimado?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" for="valorPasseio">VALOR DO PASSEIO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorPasseio" id="valorPasseio" placeholder="0" value="<?php echo $valorPasseio?>" readonly>
        </div>
    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>