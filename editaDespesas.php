<?php
    session_start();
    include_once("PHP/conexao.php");
    $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_FLOAT);
    $buscaDespesa = "SELECT DISTINCT d.valorIngresso, d.valorOnibus, d.valorMicro, d.valorVan, d.valorEscuna, d.valorSeguroViagem, d.valorAlmocoCliente, d.valorAlmocoMotorista, d.valorEstacionamento, d.valorGuia, d.valorAutorizacaoTransporte,
                     d.valorTaxi, d.valorKitLanche, d.valorMarketing, d.valorImpulsionamento, d.outros, d.idPasseio,  d.totalDespesas, d.idDespesa, p.nomePasseio, p.dataPasseio, p.qtdCliente   FROM despesa d, passeio p WHERE d.idpasseio='$idPasseioGet' AND d.idPasseio=p.idPasseio";
    $resultadoBuscaDespesa = mysqli_query($conexao, $buscaDespesa);
    $rowDespesa = mysqli_fetch_assoc($resultadoBuscaDespesa);
    $dataPasseio =  date_create($rowDespesa['dataPasseio']);

    

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
  <title>ATUALIZAR DESPESAS</title>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
            <!-- <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a> -->
          </div>
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
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item " href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item active" href="cadastroDespesas.php">DESPESAS</a>
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
      <form action="SCRIPTS/atualizarDespesas.php" autocomplete="off" method="POST" onclick="calculoTotalDespesas()">
          <?php
            echo"<p class='h4 text-center alert-info'>". $rowDespesa  ['nomePasseio']. " ".date_format($dataPasseio, "d/m/Y") ."</p>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorIngresso'>INGRESSO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorIngresso' id='valorIngresso' placeholder='VALOR DO INGRESSO' value='". $rowDespesa['valorIngresso']. "' onchange='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeCliente' id='quantidadeCliente' placeholder='QTD'  value='". $rowDespesa ['qtdCliente']."'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorOnibus'>ONIBUS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorOnibus' id='valorOnibus' placeholder='VALOR DO ONIBUS' value='". $rowDespesa['valorOnibus']. "'onchange='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeOnibus' id='quantidadeOnibus' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorMicro'>MICRO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorMicro' id='valorMicro' placeholder='VALOR DO MICRO' value='". $rowDespesa['valorMicro']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeMicro' id='quantidadeMicro' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorVan'>VAN</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorVan' id='valorVan' placeholder='VALOR DO VAN' value='". $rowDespesa['valorVan']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeVan' id='quantidadeVan' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' > ";
              echo"</div>"; 
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorEscuna'>ESCUNA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorEscuna' id='valorEscuna' placeholder='VALOR DO ESCUNA' value='". $rowDespesa['valorEscuna']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeEscuna' id='quantidadeEscuna' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorSeguroViagem'>SEGURO VIAGEM</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO SEGURO VIAGEM' value='". $rowDespesa['valorSeguroViagem']. "'onchange='calculoTotalDespesas()' disabled='disabled' >";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='' id='' placeholder='QTD' value='".$rowDespesa['qtdCliente'] ."'onchange='calculoTotalDespesas()' disabled='disabled'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAlmocoCliente'>ALMOCO CLIENTE</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAlmocoCliente' id='valorAlmocoCliente' placeholder='ALMOCO CLIENTE' value='". $rowDespesa['valorAlmocoCliente']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAlmocoCliente' id='quantidadeAlmocoCliente' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAlmocoMotorista'>ALMOCO MOTORISTA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAlmocoMotorista' id='valorAlmocoMotorista' placeholder='ALMOCO MOTORISTA' value='". $rowDespesa['valorAlmocoMotorista']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAlmocoMotorista' id='quantidadeAlmocoMotorista' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorEstacionamento'>ESTACIONAMENTO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorEstacionamento' id='valorEstacionamento' placeholder='ESTACIONAMENTO' value='". $rowDespesa['valorEstacionamento']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeEstacionamento' id='quantidadeEstacionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorGuia'>GUIA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorGuia' id='valorGuia' placeholder='VALOR GUIA' value='". $rowDespesa['valorGuia']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeGuia' id='quantidadeGuia' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAutorizacaoTransporte'>AUTORIZAÇÃO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAutorizacaoTransporte' id='valorAutorizacaoTransporte' placeholder='AUTORIZACAO TRANSPORTE' value='". $rowDespesa['valorAutorizacaoTransporte']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAutorizacaoTransporte' id='quantidadeAutorizacaoTransporte' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorTaxi'>TAXI</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorTaxi' id='valorTaxi' placeholder='TAXI' value='". $rowDespesa['valorTaxi']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeTaxi' id='quantidadeTaxi' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorMarketing'>MARKETING</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorMarketing' id='valorMarketing' placeholder='MARKETING' value='". $rowDespesa['valorMarketing']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeMarketing' id='quantidadeMarketing' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorKitLanche'>KIT LANCHE</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorKitLanche' id='valorKitLanche' placeholder='KIT LANCHE' value='". $rowDespesa['valorKitLanche']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeKitLanche' id='quantidadeKitLanche' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorImpulsionamento'>IMPULSIONAMENTO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorImpulsionamento' id='valorImpulsionamento' placeholder='INMPULSIONAMENTO' value='". $rowDespesa['valorImpulsionamento']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeImpulsionamento' id='quantidadeImpulsionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
              echo"</div>";  
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='outros'>OUTROS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='outros' id='outros' placeholder='OUTROS' value='". $rowDespesa['outros']. "'onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='totalDespesas'>TOTAL DESPESAS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='totalDespesas' id='totalDespesas' placeholder='TOTAL DESPESAS' value='". $rowDespesa['totalDespesas']. "'readonly='readonly' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<button type='submit' name='cadastrarClienteBtn' id='submit' class='btn btn-primary btn-lg'>ATUALIZAR</button>";  
          ?>
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $rowDespesa ['idPasseio']?>">
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idDespesa" id="idDespesa" value="<?php echo $rowDespesa ['idDespesa']?>">
         
      </form>
  </div>
  <script src="config/script.php"></script>
</body>

</html>