<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = (!empty($idPasseioGet)) ?
    "SELECT  c.dataNascimento, c.nomeCliente, c.telefoneContato, c.referencia 
                                FROM cliente c, pagamento_passeio pp 
                                WHERE statusCliente = 1 AND pp.idPasseio = $idPasseioGet AND c.idCliente = pp.idCliente AND dataNascimento NOT IN (' ')"
    :
    "SELECT  dataNascimento, nomeCliente, telefoneContato, referencia FROM cliente WHERE statusCliente = 1 AND dataNascimento NOT IN (' ')";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once("./includes/head.php"); ?>

    <title>Document</title>
</head>

<body>
    <!-- INCLUSÃO DA NAVBAR -->
    <?php include_once("./includes/htmlElements/navbar.php"); ?>

    <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
    <?php include_once("./includes/servicos/servicoMensagens.php"); ?>

    <?php
    $dataDeHoje = new DateTime('today');
    $mesAtual = $dataDeHoje->format('n');
    if (empty($idPasseioGet)) {
        echo "<p class='h4 text-center alert-info mt-2'> ANIVERSARIANTES DO MÊS DE  " . MESES_DO_ANO[$mesAtual] . "</p>";
    } else {
        $queryInformacoesPasseio = "SELECT nomePasseio, dataPasseio FROM passeio WHERE idPasseio=$idPasseioGet";
        $executaQueryInformacoesPasseio = mysqli_query($conexao, $queryInformacoesPasseio);
        $rowInformacoesPasseio = mysqli_fetch_assoc($executaQueryInformacoesPasseio);
        $nomePasseio = $rowInformacoesPasseio['nomePasseio'];
        $dataPasseio = $rowInformacoesPasseio['dataPasseio'];
        $dataPasseio = new DateTime($dataPasseio);
        $dataPasseio = $dataPasseio->format('d/m/Y');
        echo "<p class='h4 text-center alert-info mt-2'> ANIVERSARIANTES DO PASSEIO: $nomePasseio $dataPasseio</p>";
    }
    ?>

    <div class="row py-2">
        <div class="col-lg-10 mx-auto">
            <div class="card rounded shadow border-0">
                <div class="card-body p-5 bg-white rounded">
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-striped table-bordered" id="userTable">
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
                                $diaAtual = $dataDeHoje->format('d');


                                if ($mesAniversariante == $mesAtual) {
                                    $nomeClienteAniversario[] = $rowInfoormacoesCliente['nomeCliente'];
                                    $dataClienteAniversario[] =  $dataAniversariante->format('d/m/Y');
                                    $telefoneContato[] = $rowInfoormacoesCliente['telefoneContato'];
                                    $referencia[] = $rowInfoormacoesCliente['referencia'];
                                }
                            }
                            $A = 0;
                            $count = count($nomeClienteAniversario);
                            echo $count;
                            ?>

                            <tbody>

                                <?php

                                foreach ($nomeClienteAniversario as $indice => $valor) {
                                ?>
                                    <tr>

                                        <td><?php echo ++$A . " </br>"; ?></td>
                                        <td><?php echo "$valor </br>"; ?></td>
                                        <td><?php echo $dataClienteAniversario[$indice] . " </br>"; ?></td>
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


    </div>

    <script src="./includes/dataTables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</body>

</html>