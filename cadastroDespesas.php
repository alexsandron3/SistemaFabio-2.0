<?php
    session_start();
    include_once("PHP/conexao.php");
    

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
  <title>CADASTRAR DESPESAS</title>
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
            <a class="dropdown-item" href="">Despesa</a>
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
      <form action="" method="POST" autocomplete="OFF">
        <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="nomePasseio">PASSEIO</label>
        <input type="hidden" name="nomePasseio" value=" ">
        
        <select class="form-control ml-3 col-sm-3" name="idPasseioLista" id="selectIdPasseio" onchange="idPasseioSelecionadoFun()">
          <option value="1">SELECIONAR</option>
        
        <?php
          
            $pegaNomePasseio = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
            $queryBuscaPeloNomePasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio FROM passeio p WHERE nomePasseio LIKE '%$pegaNomePasseio%' ORDER BY dataPasseio";
            $resultadoNomePasseio = mysqli_query($conexao, $queryBuscaPeloNomePasseio);
            while($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)){
              $dataPasseioLista =  date_create($rowNomePasseio['dataPasseio']);

              
        ?>
              <option value="<?php echo $rowNomePasseio ['idPasseio'] ;?>"><?php echo $rowNomePasseio ['nomePasseio']; echo " "; echo date_format($dataPasseioLista, "d/m/Y") ;?>  </option>    
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
            if($buttonEnviaNomePasseio){
              if($idPasseioLista != 0){
                if($rowBuscaDespesa == 0){
                  $queryBuscaInformacoesPasseio = "SELECT p.nomePasseio, p.dataPasseio FROM passeio p WHERE idPasseio='$idPasseioLista'";
                  $resultadoBuscaInformacoesPasseio = mysqli_query($conexao, $queryBuscaInformacoesPasseio);
                  $rowBuscaInformacoesPasseio = mysqli_fetch_assoc($resultadoBuscaInformacoesPasseio);
                  $data =  date_create($rowBuscaInformacoesPasseio['dataPasseio']);
                  echo"<p class='h4 text-center alert-info'>". $rowBuscaInformacoesPasseio  ['nomePasseio']. " ".date_format($data, "d/m/Y") ."</p>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorIngresso'>INGRESSO</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorIngresso' id='valorIngresso' placeholder='VALOR DO INGRESSO' value='' onchange='calculoTotalDespesas()' >";
                      echo"<input type='hidden' class='form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO INGRESSO' value='' onchange='calculoTotalDespesas()' >";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeIngresso' id='quantidadeIngresso' placeholder='QTD'  value='1' onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorOnibus'>ONIBUS</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorOnibus' id='valorOnibus' placeholder='VALOR DO ONIBUS' value='' onchange='calculoTotalDespesas()' >";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeOnibus' id='quantidadeOnibus' placeholder='QTD' value='1'onchange='calculoTotalDespesas()' >";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorMicro'>MICRO</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorMicro' id='valorMicro' placeholder='VALOR DO MICRO' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeMicro' id='quantidadeMicro' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorVan'>VAN</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorVan' id='valorVan' placeholder='VALOR DO VAN' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeVan' id='quantidadeVan' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorEscuna'>ESCUNA</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorEscuna' id='valorEscuna' placeholder='VALOR DO ESCUNA' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeEscuna' id='quantidadeEscuna' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  /* echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorSeguroViagem'>SEGURO VIAGEM</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO SEGURO VIAGEM' value=''onchange='calculoTotalDespesas()' >";
                    echo"</div>";
                  echo"</div>"; */
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorAlmocoCliente'>ALMOCO CLIENTE</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorAlmocoCliente' id='valorAlmocoCliente' placeholder='ALMOCO CLIENTE' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeAlmocoCliente' id='quantidadeAlmocoCliente' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorAlmocoMotorista'>ALMOCO MOTORISTA</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorAlmocoMotorista' id='valorAlmocoMotorista' placeholder='ALMOCO MOTORISTA' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeAlmocoMotorista' id='quantidadeAlmocoMotorista' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorEstacionamento'>ESTACIONAMENTO</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorEstacionamento' id='valorEstacionamento' placeholder='ESTACIONAMENTO' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeEstacionamento' id='quantidadeEstacionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorGuia'>GUIA</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorGuia' id='valorGuia' placeholder='VALOR GUIA' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeGuia' id='quantidadeGuia' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorAutorizacaoTransporte'>TRANSPORTE</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorAutorizacaoTransporte' id='valorAutorizacaoTransporte' placeholder='AUTORIZACAO TRANSPORTE' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeAutorizacaoTransporte' id='quantidadeAutorizacaoTransporte' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorTaxi'>TAXI</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorTaxi' id='valorTaxi' placeholder='TAXI' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeTaxi' id='quantidadeTaxi' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorMarketing'>MARKETING</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorMarketing' id='valorMarketing' placeholder='MARKETING' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeMarketing' id='quantidadeMarketing' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorKitLanche'>KIT LANCHE</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorKitLanche' id='valorKitLanche' placeholder='KIT LANCHE' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeKitLanche' id='quantidadeKitLanche' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='valorImpulsionamento'>IMPULSIONAMENTO</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='valorImpulsionamento' id='valorImpulsionamento' placeholder='IMPULSIONAMENTO' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                    echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeImpulsionamento' id='quantidadeImpulsionamento' placeholder='QTD' value='1'onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='outros'>OUTROS</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='outros' id='outros' placeholder='OUTROS' value=''onchange='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<div class='form-group row'>";
                    echo"<label class='col-sm-2 col-form-label' for='totalDespesas'>TOTAL DESPESAS</label>";
                    echo"<div class='col-sm-6'>";
                      echo"<input type='text' class='form-control' name='totalDespesas' id='totalDespesas' placeholder='TOTAL DESPESAS' value='' readonly='readonly' onblur='calculoTotalDespesas()'>";
                    echo"</div>";
                  echo"</div>";
                  echo"<button type='submit' name='cadastrarClienteBtn' id='submit' class='btn btn-primary btn-lg'>CADASTRAR</button>";
                }else{
                  echo"<p class='h4 text-center alert-warning'>JÁ EXISTEM DESPESAS CADASTRADAS PARA ESSE PASSEIO, REDIRECIONANDO PARA A ÁREA DE DESPESAS </p>";
                  echo" <script>
                              setTimeout(function () {
                                window.location.href = 'editaDespesas.php?id=".$idPasseioLista."';
                            }, 5000);
                          </script>
                    ";
                }  

              }else{
                echo"<p class='h2 text-center alert-danger'>NENHUM PASSEIO SELECIONADO</p>";
              }
            }else{

            }    
          ?>
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $idPasseioLista?>">
         
      </form>
  </div>
  <script src="config/script.php"></script>
</body>

</html>