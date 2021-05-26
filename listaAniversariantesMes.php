<?php

//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$mesEscolhido = filter_input(INPUT_GET, 'mesEscolhido', FILTER_SANITIZE_NUMBER_INT);

$query = (!empty($idPasseioGet)) ?
    "SELECT  c.dataNascimento, c.nomeCliente, c.telefoneContato, c.referencia 
                                FROM cliente c, pagamento_passeio pp 
                                WHERE statusCliente = 1 AND pp.idPasseio = $idPasseioGet AND c.idCliente = pp.idCliente AND dataNascimento NOT IN (' ')"
    :
    "SELECT  dataNascimento, nomeCliente, telefoneContato, referencia FROM cliente WHERE statusCliente = 1 AND dataNascimento NOT IN (' ')";
if (empty($mesEscolhido)) {
    $dataDeHoje = new DateTime('today');
    $mesAtual = $dataDeHoje->format('n');
} else {
    $mesAtual = $mesEscolhido;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once("./includes/novoInclude.php"); ?>

    <title>ANIVERSARIANTES</title>
</head>

<body>
    <!-- INCLUSÃO DA NAVBAR -->
    <?php include_once("./includes/htmlElements/navbar.php"); ?>



    <div class="row py-2">
        <div class="col-10 mx-auto">
            <div class="card rounded shadow border-0">
                <p class="h2 text-center">ANIVERSARIANTES</p>
                <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
                <div class="card-body p-5 bg-white rounded">
                    <?php

                    if (empty($idPasseioGet)) {
                        mensagensInfoNoSession("ANIVERSARIANTES DO MÊS DE  " . MESES_DO_ANO[$mesAtual - 1]);

                        #echo "<p class='h4 text-center alert-info mt-2'> ANIVERSARIANTES DO MÊS DE  " . MESES_DO_ANO[$mesAtual] . "</p>";
                    } else {
                        $queryInformacoesPasseio = "SELECT nomePasseio, dataPasseio FROM passeio WHERE idPasseio=$idPasseioGet";
                        $executaQueryInformacoesPasseio = mysqli_query($conexao, $queryInformacoesPasseio);
                        $rowInformacoesPasseio = mysqli_fetch_assoc($executaQueryInformacoesPasseio);
                        $nomePasseio = $rowInformacoesPasseio['nomePasseio'];
                        $dataPasseio = $rowInformacoesPasseio['dataPasseio'];
                        $dataPasseio = new DateTime($dataPasseio);
                        $dataPasseioFormatada = $dataPasseio->format('d/m/Y');
                        $mesPasseio = $dataPasseio->format('n');


                        mensagensInfoNoSession("ANIVERSARIANTES DO PASSEIO: $nomePasseio $dataPasseioFormatada");
                        #echo "<p class='h4 text-center alert-info mt-2'> ANIVERSARIANTES DO PASSEIO: $nomePasseio $dataPasseio</p>";
                    }
                    ?>
                    <form action="listaAniversariantesMes.php" action="GET">
                        <?php
                        if (empty($idPasseioGet)) {
                        ?>
                            <input type="text" name="mesEscolhido" id="" class="form-control col-2" placeholder="NÚMERO DO MÊS" data-toggle="tooltip" data-placement="left" title="AQUI VICÊ PODERÁ PESQUISAR POR UM MÊS ESPECÍFICO">
                        <?php } ?>
                    </form>
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-striped table-bordered" id="tabelaAniversariantes">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data de Nascimento</th>
                                    <th scope="col">Contato</th>
                                    <th scope="col">Referência</th>
                                </tr>
                            </thead>
                            <?php
                            $executaQuery = mysqli_query($conexao, $query);
                            $nomeClienteAniversario = array();

                            while ($rowInfoormacoesCliente = mysqli_fetch_assoc($executaQuery)) {
                                $dataNascimento = $rowInfoormacoesCliente['dataNascimento'];
                                $nomeCliente = $rowInfoormacoesCliente['nomeCliente'];


                                $dataAniversariante = new DateTime($dataNascimento);


                                $mesAniversariante = $dataAniversariante->format('n');

                                $diaAniversariante = $dataAniversariante->format('d');


                                if (!empty($idPasseioGet)) {
                                    if ($mesAniversariante == $mesPasseio) {

                                        $nomeClienteAniversario[] = $rowInfoormacoesCliente['nomeCliente'];
                                        $dataClienteAniversario[] =  $dataAniversariante->format('d/m/Y');
                                        $dataOrganizarAniversario[] =  $dataAniversariante->format('Ymd');
                                        $telefoneContato[] = $rowInfoormacoesCliente['telefoneContato'];
                                        $referencia[] = $rowInfoormacoesCliente['referencia'];
                                    }
                                } else {
                                    if ($mesAniversariante == $mesAtual) {
                                        $nomeClienteAniversario[] = $rowInfoormacoesCliente['nomeCliente'];
                                        $dataClienteAniversario[] =  $dataAniversariante->format('d/m/Y');
                                        $dataOrganizarAniversario[] =  $dataAniversariante->format('Ymd');
                                        $telefoneContato[] = $rowInfoormacoesCliente['telefoneContato'];
                                        $referencia[] = $rowInfoormacoesCliente['referencia'];
                                    }
                                }
                            }
                            $A = 0;
                            $count = count($nomeClienteAniversario);
                            ?>

                            <tbody>

                                <?php

                                foreach ($nomeClienteAniversario as $indice => $valor) {
                                ?>
                                    <tr>

                                        <td><?php echo ++$A . " </br>"; ?></td>
                                        <td><?php echo "$valor </br>"; ?></td>
                                        <td>
                                            
                                            <?php
                                            echo $dataClienteAniversario[$indice] . " </br>"; ?>
                                        </td>
                                        <td><?php echo $telefoneContato[$indice] . " </br>"; ?></td>
                                        <td><?php echo $referencia[$indice] . " </br>"; ?></td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="includes/plugins/DataTables/configFiles/dataTablesAniversariantes.js"> </script>

</body>

</html>