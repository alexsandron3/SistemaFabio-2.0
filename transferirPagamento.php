<?php
    session_start();
    include_once("PHP/conexao.php");
    $idPasseioAntigo        = filter_input(INPUT_GET, 'idPasseioAntigo',   FILTER_SANITIZE_NUMBER_INT);
    $idPagamentoAntigo      = filter_input(INPUT_GET, 'idPagamentoAntigo', FILTER_SANITIZE_NUMBER_INT);
    // Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}

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
  <title>TRANSFERIR PAGAMENTO</title>
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
          </div>
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
        <li class="nav-item">
          <a class="nav-link " href="logout.php" >SAIR </a>
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
                                    $queryBuscaIdCliente = "SELECT idCliente FROM pagamento_passeio WHERE idPagamento='$idPagamentoAntigo' AND idPasseio='$idPasseioAntigo'";
                                    $resultadoBuscaIdCliente = mysqli_query($conexao, $queryBuscaIdCliente);
                                    $rowBuscaIdCliente = mysqli_fetch_assoc($resultadoBuscaIdCliente);
                                    $idCliente = $rowBuscaIdCliente ['idCliente'];

                            $nomePasseioPost = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
                            $queryBuscaPeloNomePasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio FROM passeio p WHERE statusPasseio NOT IN(0)  ORDER BY dataPasseio";
                            /* -----------------------------------------------------------------------------------------------------  */
                            $resultadoNomePasseio = mysqli_query($conexao, $queryBuscaPeloNomePasseio);
                            /* -----------------------------------------------------------------------------------------------------  */
                          while($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)){
                            $dataPasseioLista =  date_create($rowNomePasseio['dataPasseio']);
                        ?>
                            <option value="<?php echo $rowNomePasseio ['idPasseio'] ;?>"><?php echo $rowNomePasseio ['nomePasseio']; echo " "; echo date_format($dataPasseioLista, "d/m/Y") ;?>  </option>    
                        <?php 
                            }
                            
                        ?>
                    <input type="submit" class="btn btn-primary btn-sm ml-2" value="SELECIONAR PASSEIO" name="buttonEnviaNomePasseio">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" onchange="idPasseioSelecionadoFun()" readonly="readonly">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioAntigo" id="idPasseioAntigo" value="<?php echo $idPasseioAntigo;?>" readonly="readonly">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamentoAntigo" id="idPagamentoAntigo" value="<?php echo $idPagamentoAntigo;?>" readonly="readonly">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idCliente" id="idCliente" value="<?php echo $idCliente;?>" readonly="readonly">
                </select>


            </div>
      </form>

      <form action="SCRIPTS/transferePagamento.php" method="POST" autocomplete="off">
      <?php
        $buttonCarregarInformacoes = filter_input(INPUT_POST, 'buttonEnviaNomePasseio', FILTER_SANITIZE_STRING);
        $idPasseioSelecionado = filter_input(INPUT_POST, 'idPasseioLista', FILTER_SANITIZE_NUMBER_INT);
        $idCliente = filter_input(INPUT_POST, 'idCliente', FILTER_SANITIZE_NUMBER_INT);
        
        if($buttonCarregarInformacoes){
          $queryBuscaSeJaExistePagamento = "SELECT idPagamento FROM pagamento_passeio WHERE idCliente='$idCliente' AND idPasseio='$idPasseioSelecionado'";
          $resultadoqueryBuscaSeJaExistePagamento = mysqli_query($conexao, $queryBuscaSeJaExistePagamento);
          if(mysqli_num_rows($resultadoqueryBuscaSeJaExistePagamento ) == 0){
            echo "<p class='h5 text-center alert-info'> TRANSFERÊNCIA LIBERADA, CLILQUE EM 'FINALIZAR TRANSFERÊNCIA' PARA FINALIZAR O PROCESSO </p>";
            echo "<input type='submit' class='btn btn-primary btn-sm' value='FINALIZAR PAGAMENTO' name='buttonFinalizarPagamento''>";
          }else{
            echo "<p class='h5 text-center alert-danger'> TRANSFERÊNCIA NÃO LIBERADA POR ESSE CLIENTE JÁ TER UM PAGAMENTO NESTE PASSEIO </p>";
          }
        }

      ?>
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $idPasseioSelecionado;?>" onchange="idPasseioSelecionadoFun()" readonly="readonly">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioAntigo" id="idPasseioAntigo" value="<?php echo $idPasseioAntigo;?>" readonly="readonly">
                    <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamentoAntigo" id="idPagamentoAntigo" value="<?php echo $idPagamentoAntigo;?>" readonly="readonly">
      </form>
    </div>  


    <script src="config/script.php"></script>
