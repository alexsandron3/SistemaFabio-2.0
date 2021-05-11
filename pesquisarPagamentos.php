<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$inicioPeriodoSelecionado   = filter_input(INPUT_GET, 'inicioPeriodoSelecionado',   FILTER_SANITIZE_STRING);
$fimPeriodoSelecionado      = filter_input(INPUT_GET, 'fimPeriodoSelecionado',      FILTER_SANITIZE_STRING);

$queryBuscaPagamentosRealizados         = "SELECT c.nomeCliente, pp.valorPago, pp.dataPagamento, p.nomePasseio 
                                            FROM pagamento_passeio pp, cliente c, passeio p 
                                            WHERE dataPagamento BETWEEN '$inicioPeriodoSelecionado' AND '$fimPeriodoSelecionado' AND p.idPasseio=pp.idPAsseio AND c.idCliente=pp.idCliente";
$executarQueryBuscaPagamentosRealizados = mysqli_query($conn, $queryBuscaPagamentosRealizados);
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>

    <?php include_once("./includes/dataTables/dataTablesHead.php"); ?>

    <title>Últimos Pagamentos</title>
</head>

<body>
    <!-- INCLUSÃO DA NAVBAR -->
    <?php include_once("./includes/htmlElements/navbar.php"); ?>
    <link rel="stylesheet" href="./config/style.css">
    <div class="row py-3">
        <div class="col-lg-10 mx-auto">
            <div class="card rounded shadow border-0">
                <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
                <div class="card-body p-5 bg-white rounded">
                    <p class="h2 text-center">PESQUISAR PAGAMENTOS</p>
                    <form action='' method='GET' autocomplete='OFF'>
                        <div class="form-row">
                            <div class="col">
                                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O INÍCIO DO PERÍODO" type='date' class='form-control' name='inicioPeriodoSelecionado' id='inicioPeriodoSelecionado' value="">
                            </div>

                            <div class="col">
                                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O FIM DO PERÍODO" type='date' class='form-control' name='fimPeriodoSelecionado' id='fimPeriodoSelecionado' value="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-striped table-bordered" id="tabelasPadrao">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Valor Pago</th>
                                    <th scope="col">Data do Pagamento</th>
                                    <th scope="col">Passeio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($rowQueryBuscaPagamentosRealizados = mysqli_fetch_assoc($executarQueryBuscaPagamentosRealizados)) { ?>
                                    <tr>
                                        <td><?php echo $rowQueryBuscaPagamentosRealizados['nomeCliente'] ?></td>
                                        <td><?php echo $rowQueryBuscaPagamentosRealizados['valorPago'] ?></td>
                                        <td><?php 
                                        echo $rowQueryBuscaPagamentosRealizados['dataPagamento'];
                                          ?></td>
                                        </td>
                                        <td><?php echo $rowQueryBuscaPagamentosRealizados['nomePasseio'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>