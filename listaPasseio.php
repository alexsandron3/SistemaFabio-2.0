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
  
  <title>INÍCIO</title>
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
          <a class="nav-link" href="listaPasseio.php">LISTAGEM </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
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
  <div class="container-fluid">
    <form action="" method="POST" autocomplete="off">
      <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="nomePasseio">PASSEIO</label>
      <input type="hidden" name="nomePasseio" value=" ">.6
      
      <select class="form-control ml-3 col-sm-3" name="passeiosLista" id="selectIdPasseio" onchange="idPasseioSelecionado()">
        <option value="1">SELECIONAR</option>
        <?php
            $nomePasseio = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
            $resultadoBuscaNomePasseio = "SELECT * FROM passeio WHERE nomePasseio LIKE '%$nomePasseio%' ORDER BY dataPasseio";
            $resultadoNomePasseio = mysqli_query($conexao, $resultadoBuscaNomePasseio);
            while($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)){
              ?>
              <option value="<?php echo $rowNomePasseio ['idPasseio'] ;?>"><?php echo $rowNomePasseio ['nomePasseio']; echo " "; echo $rowNomePasseio ['dataPasseio'];?>  </option>    
          <?php }    
        ?>
        <input type="submit" class="btn btn-primary btn-sm ml-2" value="CARREGAR PASSEIOS" name="buscaIdPasseio">
        <input type="text" class="form-control col-sm-1 ml-3" name="passeioSelecionado" id="passeioSelecionado" 
        onchange="idPasseioSelecionado()" readonly="readonly">
      </select>                      
    </form> 
  </div>
  
    <form action="SCRIPTS/incluirClienteLista.php" autocomplet="off" method="POST">
      <?php
        $passeioSelecionado = filter_input(INPUT_POST, 'passeioSelecionado', FILTER_SANITIZE_NUMBER_INT);
        $clienteSelecionado = "SELECT * FROM cliente_passeio WHERE idPasseio='$passeioSelecionado'";
        $resultadoClienteSelecionado = mysqli_query($conexao, $clienteSelecionado);
        $rowClienteSelecionado = mysqli_fetch_assoc($resultadoClienteSelecionado);
        
        $idCliente = $rowClienteSelecionado ['idCliente'];
        $idClienteSelecionado = "SELECT nomeCliente FROM cliente WHERE idCliente='$idCliente'";
        $resultadoIdClienteSelecionado = mysqli_query($conexao, $idClienteSelecionado);
        $rowIdClienteSelecionado = mysqli_fetch_assoc($resultadoIdClienteSelecionado);
        
        
        

        $buscaIdPasseio = filter_input(INPUT_POST, 'buscaIdPasseio', FILTER_SANITIZE_STRING);

        if($buscaIdPasseio){
          if($rowClienteSelecionado !=0){
            while ($rowClienteSelecionado = mysqli_fetch_assoc($resultadoClienteSelecionado)){
              echo $rowClienteSelecionado ['idCliente'];
              echo $rowIdClienteSelecionado ['nomeCliente'];
              echo "<BR/>";
              while($rowIdClienteSelecionado = mysqli_fetch_assoc($resultadoIdClienteSelecionado)){
                echo $rowClienteSelecionado ['idCliente'];
                echo $rowIdClienteSelecionado ['nomeCliente']; 
                echo "<BR/>";
              }     
            }
            
          echo"</table>";
          }else{
            echo"<p class='h2 text-center alert-danger'>NENHUM PASSEIO SELECIONADO</p>";  
          }
        }
      ?>
    </form>     
  
<script src="config/script.php"></script>
</body>

</html>