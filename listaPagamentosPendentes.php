<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
    $ordemPesquisa = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
    $ordemPesquisa = (empty($ordemPesquisa))? "nomeCliente": $ordemPesquisa;
	
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>LISTA DE PAGAMENTOS PENDENTES</title>
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
        <li class="nav-item">
          <a class="nav-link " href="logout.php" >SAIR </a>
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

      <?php
$query = "SELECT c.nomeCliente, c.idCliente, pp.idPagamento, pp.valorPendente, pp.previsaoPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio FROM  pagamento_passeio pp, cliente c, passeio p WHERE statusPagamento NOT IN (0,3) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ORDER BY $ordemPesquisa ";
        $executaQuery = mysqli_query($conexao, $query);
        $quantidadePagamentoPendente = mysqli_num_rows($executaQuery);
        echo"<p class='h4 text-center alert-info mt-2'> QUANTIDADE DE PAGAMENTOS PENDENTES:  ".$quantidadePagamentoPendente ."</p>";
      ?>
    <table class="table table-sm table-dark mt-3">
        <thead>
            <tr>
                <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=nomeCliente"> NOME </a></th>
                <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=idPagamento">PAGAMENTO </a></th>
                <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=nomePasseio">PASSEIO </a></th>
                <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=valorPendente">PENDENTE </a></th>
                <th> <a href="listaPagamentosPendentes.php?ordemPesquisa=dataPagamento"> PREVISÃO PAGAMENTO </a></th>
            </tr>
        </thead>

        <tbody>
        <?php
           
            
            while($rowPagamentosPendentes = mysqli_fetch_assoc($executaQuery)){


             
        ?>
            <tr>
                <td scope="row"> <?php  echo " <a target='_blank' href='editarCliente.php?id=". $rowPagamentosPendentes['idCliente']."'>". $rowPagamentosPendentes['nomeCliente'] . "</a>";?></td>
                <td><?php   echo " <a target='_blank' href='editarPagamento.php?id=". $rowPagamentosPendentes['idPagamento']."'>".$rowPagamentosPendentes['idPagamento'] ."</a>"; ?></td>
                <td><?php   
                        $dataPasseio = date_create($rowPagamentosPendentes['dataPasseio']);
                        echo " <a target='_blank' href='listaPasseio.php?id=". $rowPagamentosPendentes['idPasseio']."'>".$rowPagamentosPendentes['nomePasseio'] ." | " . date_format($dataPasseio, "d/m/Y") ." </a>"; 
                    ?>
                </td>
                <td><?php   echo " <a target='_blank' href='editarPagamento.php?id=". $rowPagamentosPendentes['idPagamento']."'>". number_format($rowPagamentosPendentes['valorPendente'] * -1.00,2, '.', '') ."</br> </a>"; ?></td>
                <td> <?php  
                            if($rowPagamentosPendentes['previsaoPagamento'] != "0000-00-00"){
                                $dataPagamento = date_create($rowPagamentosPendentes['previsaoPagamento']);
                                
                                echo date_format($dataPagamento, 'd/m/Y') ;
                            }
                    ?>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>

    <a target="_blank" href="includes/servicos/exportarExcel/exportarTodosPagamentosPendentes.php" class="btn btn-info ml-5 mb-2">EXPORTAR</a>

</html>