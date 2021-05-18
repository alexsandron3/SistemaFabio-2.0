<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
// =================================================================================================================================
$query = " SELECT pp.historicoPagamento, pp.idPagamento, c.nomeCliente, p.nomePasseio, p.dataPasseio 
            FROM pagamento_passeio pp, cliente c, passeio p 
            WHERE pp.idCliente=c.idCliente AND pp.idPasseio=p.idPasseio AND historicoPagamento REGEXP '\r\n'";
$executaQuery = mysqli_query($conn, $query);

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
                    <!-- <form action='' method='GET' autocomplete='OFF'>
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
                    </form> -->
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-striped table-bordered" id="tabelasPadrao">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data do último pagamento</th>
                                    <th scope="col">Último pagamento</th>
                                    <th scope="col">Passeio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $indexHistoricoPagamento = 0;
                                while ($resultadoQuery = mysqli_fetch_assoc($executaQuery)) {
                                    $ultimaLinha = substr_count($resultadoQuery['historicoPagamento'], "\n");
                                    $string = $resultadoQuery['historicoPagamento'];
                                    $nomeCliente = $resultadoQuery['nomeCliente'];
                                    $passeio = $resultadoQuery['nomePasseio'];
                                    list($sentence[]) = array_slice(explode(PHP_EOL, $string), -1, $ultimaLinha);
                                ?>
                                    <tr>
                                        <td><?php
                                            echo $nomeCliente;
                                            ?>
                                        </td>
                                        <td><?php
                                            $pesquisarData = $sentence[$indexHistoricoPagamento];
                                            $data = substr($sentence[$indexHistoricoPagamento],0, strpos($sentence[$indexHistoricoPagamento], "R$"));
                                            $valor =strstr($sentence[$indexHistoricoPagamento], 'R$');
                                            echo $data;
                                            $dataFormatada = new DateTime($data);
                                            $dataFormatada = $dataFormatada->format('n');
                                            

                                            ?>
                                            <span class="d-none d-print-none"><?php echo MESES_DO_ANO[$dataFormatada-1] ?></span>
                                        </td>
                                        <td><?php
                                            echo $valor;
                                            $indexHistoricoPagamento++;                         

                                            ?>
                                        </td>
                                        <td><?php
                                            echo $passeio;
                                            ?>
                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                                
                            <tfoot>
                                <tr>

                                </tr>

                            </tfoot>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>