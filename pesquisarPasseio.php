<?php
    session_start();
    include_once("PHP/conexao.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="config/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RswenrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
    integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
  <title>PESQUISAR PASSEIO</title>
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
          <a class="nav-link" href="#">RELATÓRIOS </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIenTE</a>
            <a class="dropdown-item active" href="pesquisarPasseio.php">PASSEIO</a>
            <!-- <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a> -->
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="cadastroCliente.php">CLIenTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <div class="container-fluid ">
      <p class="h2 text-center">PESQUISAR PASSEIO</p>
      <form action="" autocomplete="off" method="POST">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="nomePasseio">NOME DO PASSEIO</label>
          <div class="col-sm-6">
            <input type="text" class="form-control col-sm-6" name="nomePasseio" id="" placeholder="NOME DO PASSEIO"
              onkeydown="upperCaseF(this)">
          </div>
        </div>
        <input type="submit" value="PESQUISAR" name="enviaPesqNome" class="btn btn-primary btn-lg">
        <!-- <button type="submit" name="enviaPesqNome" id="submit" class="btn btn-primary btn-lg">PESQUISAR</button> -->
      </form>
    </div>
  </div>
  <div class="table mt-5">
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>DATA</th>
          <th>LOCAL</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $enviaPesqNome = filter_input(INPUT_POST, 'enviaPesqNome', FILTER_SANITIZE_STRING);
          if($enviaPesqNome) {
              $nomePasseio = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
              $resultadoBuscaNomePasseio = "SELECT * FROM passeio WHERE nomePasseio LIKE '%$nomePasseio%' ORDER BY dataPasseio";
              $resultadoNomePasseio = mysqli_query($conexao, $resultadoBuscaNomePasseio);
              while($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)){
        ?>
        <tr>
          <th><?php echo $rowNomePasseio ['idPasseio']. "<BR/>";?></th>
          <td><?php echo $rowNomePasseio ['nomePasseio']. "<BR/>";?></td>
          <td><?php echo $rowNomePasseio ['dataPasseio']. "<BR/>";?></td>
          <td><?php echo $rowNomePasseio ['localPasseio']. "<BR/>";?></td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm' target='_blank' rel='noopener noreferrer' href='editarUsuario.php?id=" . $rowNomePasseio['idPasseio'] . "'>Editar</a><br>"; ?>
          </td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm' href='apagarUsuario.php?id="  . $rowNomePasseio['idPasseio'] . "' >Apagar</a><br><hr>";?>
          </td>
        </tr>
        <?php
              }
          };
        ?>
      </tbody>
    </table>
  </div>
  <script src="config/script.js"></script>
</body>

</html>