<?php
  session_start();
  include_once("PHP/conexao.php");
  $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $buscaPeloIdPasseio = "SELECT DISTINCT p.nomePasseio, p.dataPasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.cpfCliente, c.orgaoEmissor, c.idadeCliente, c.dataNascimento,  pp.statusPagamento, pp.idPagamento, pp.idCliente FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
  $resultadoBuscaPasseio = mysqli_query($conexao, $buscaPeloIdPasseio);
  
  
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
  
  <title>SEGURO VIAGEM </title>
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
  <div class="table mt-3">
      <table class="table table-hover table-dark">
          <thead> 
            <tr>
                <th>NOME</th>
                <th>CPF</th>
                <th>DATA NASCIMENTO</th>
                <th>Status do Pagamento</th>
            </tr>
          </thead>
        
        <tbody>
          <?php
            $controleListaPasseio = 0;
            while( $rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)){
              $idPagamento = $rowBuscaPasseio ['idPagamento'];
              $dataNascimento =  date_create($rowBuscaPasseio['dataNascimento']);
              $idCliente = $rowBuscaPasseio['idCliente'];
              $idPasseio = $rowBuscaPasseio['idPasseio'];
              $idadeCliente = $rowBuscaPasseio['idadeCliente'];

              if ($rowBuscaPasseio ['statusPagamento'] == 0){
                $statusPagamento = "NÃO QUITADO";
              }else{
                $statusPagamento = "QUITADO";
              }
              $nomePasseio = $rowBuscaPasseio ['nomePasseio'];
            
            ?>
          <tr>
            <th><?php echo $rowBuscaPasseio ['nomeCliente']. "<BR/>";?></th>
            <th><?php echo $rowBuscaPasseio ['cpfCliente']. "<BR/>";?></th>
            <th><?php echo date_format($dataNascimento, "d/m/Y"). "<BR/>";?></th>
            
            <th><?php echo "<a class='btn btn-link' role='button' target='_blank' rel='noopener noreferrer' href='editarPagamento.php?id=". $idPagamento . "' >" .$statusPagamento."</a><BR/>"; ?></th>
            <th><?php echo "<a class='btn btn-primary btn-sm' rel='noopener noreferrer' href='SCRIPTS/apagarPagamento.php?idCliente=" . $idCliente. "&idPasseio=".$idPasseio ."&idadeCliente=" .$idadeCliente ."'>REMOVER</a><br>";?></th>
          </tr>

          <?php
          $controleListaPasseio =+1;
            }
          ?>
        </tbody>
      </table>
      <?php
        if($controleListaPasseio > 0){
          echo"<div class='text-center'>";
            echo"<a target='_blank' rel='noopener noreferrer' href='imprimirListaPasseio.php?id=".$idPasseioGet."& nomePasseio=".$nomePasseio."'class='btn btn-primary'>Imprimir Lista de Passeio</a>";
            echo"<button onclick='Export()' class='btn btn-primary ml-2'>Exportar para arquivo EXCEL</button>";
          echo"</div>";
        }else{
          echo"<div class='text-center'>";
          echo"<p class='h5 text-center alert-warning'>Nenhum PAGAMENTO foi cadastrado até o momento</p>";
          echo"</div>";

        }


      ?>
       
  </div>
<script src="config/script.php"></script>
<script>
  function Export()
        {
            var conf = confirm("Exportar para EXCEL?");
            if(conf == true)
            {
                window.open("SCRIPTS/exportarExcel.php?id=<?php echo $idPasseioGet?>", '_blank');
            }
        }

</script>
</body>

</html>