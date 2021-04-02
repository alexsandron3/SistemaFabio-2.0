<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Sortable - Connect lists</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="reorder.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://demos.creative-tim.com/material-kit/assets/css/material-kit.min.css?v=2.0.7" rel="stylesheet" />
    <link rel="stylesheet" href="../config/style.css">
</head>

<body>

    <div class="container my-4">
        <div class="row mx auto">

            <div class="col-4 ">
                <ol type="1" class="reorder-gallery">
                    <div class="row dragg">

                        <?php
                        $contador = 1;
                        $poltronaLadoA = 1;
                        while ($contador <= 24) {
                            include_once("../includes/header.php");

                            $sql_query = "SELECT pp.idCliente, c.nomeCliente FROM pagamento_passeio pp, cliente c WHERE pp.idPasseio=34 AND pp.idCliente=c.idCliente ORDER BY ordemPoltrona";

                            $resultset = mysqli_query($conexao, $sql_query) or die("database error:" . mysqli_error($conexao));
                            $data_records = array();
                            $contador = 1;
                            while ($row = mysqli_fetch_assoc($resultset)) {
                        ?>
                                <div class="col-6 box ">
                                <li class="col-4 mx-auto" id="<?php echo $row['idCliente']; ?>" class="ui-sortable-handle"></li>
                                    <?php

                                    if ($contador <= 2) {
                                        echo "<span class='h6'>" . $row['nomeCliente'] . "</span>";
                                    } else {
                                        if ($contador % 2 != 0) {
                                            $poltronaLadoA = $poltronaLadoA + 2;
                                        } else {
                                            $poltronaLadoA + 1;
                                        }

                                        echo  "<span class='h6'>" . $row['nomeCliente'] . "</span>";
                                    }
                                    ?>
                                    

                                    <div class="dragg">
                                    </div>
                                </div>


                        <?php
                                $contador = $contador + 1;
                                $poltronaLadoA = $poltronaLadoA + 1;
                            }
                        } ?>


                    </div>
                </ol>
            </div>


            <div class="col-3 box-red mx-2">

            </div>

            <div class="col-4 box">
                <div class="row">
                    <?php
                    $poltronaLadoB = 4;
                    while ($contador >= 24 and $contador <= 48) {
                    ?>
                        <div class="col-6 box">
                            <?php
                            if ($contador >= 24 and $contador <= 26) {
                                if ($poltronaLadoB % 2 != 0) {
                                    echo $poltronaLadoB - 2;
                                } else {
                                    echo $poltronaLadoB;
                                }
                            } else {
                                if ($poltronaLadoB % 2 == 0) {
                                    $poltronaLadoB = $poltronaLadoB + 2;
                                    echo $poltronaLadoB;
                                } else {
                                    echo ($poltronaLadoB + 2 - 2) - 2;
                                }
                            }
                            ?>
                        </div>
                    <?php
                        $poltronaLadoB = $poltronaLadoB + 1;
                        $contador = $contador + 1;
                    } ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>