<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="layout.css">

    <title>Document</title>

</head>

<body>
    <div class="container conteudo text-center">
        <div class="col-md-6">
            POLTRONAS
            <div id="restaurant" class="restaurant row">
                <?php 
                        require('dbConfig.php');
                        $sql = "SELECT pp.idCliente, c.nomeCliente, c.referencia, pp.ordemPoltrona FROM pagamento_passeio pp, cliente c WHERE pp.idPasseio=34 AND pp.idCliente=c.idCliente ORDER BY ordemPoltrona , referencia";
                        $users = $mysqli->query($sql);
                        $numeroPoltrona = 1;
                        $contador = 0;
                        while (/* $user = $users->fetch_assoc() */ $contador <10) {
                            $numeroPoltrona = $numeroPoltrona +1;
                           
                ?>

                <div class="col">

                    <div id="table-0" class="r-table top4">
                        <label class="table-name">POLTRNA <?php  $contador = $contador+1; echo $contador?></label>
                        <ul class="waiters">
                        </ul>
                    </div>
                    <div id="table-0" class="r-table top4">
                        <label class="table-name">POLTRNA <?php   $contador = $contador+1; echo $contador?></label>
                        <ul class="waiters">
                        </ul>
                    </div>
                </div>
            <?php }?>

            </div>
        </div>
    </div>


    <div class="col-md-2">
        <div>
            <span>CLIENTES</span>
        </div>
        <ul id="waiters" class="waiters" style="padding: 2px; min-height: 86px;">
            <?php 
                require('dbConfig.php');
                $sql = "SELECT pp.idCliente, c.nomeCliente, c.referencia, pp.ordemPoltrona FROM pagamento_passeio pp, cliente c WHERE pp.idPasseio=34 AND pp.idCliente=c.idCliente ORDER BY ordemPoltrona , referencia";
                $users = $mysqli->query($sql);
                while ($user = $users->fetch_assoc()) {
            ?>
            <li id="waiter-1" class="waiter">
                <!-- <img src="https://www.freeiconspng.com/uploads/bw-waiter-png-3.png" height="40px;" /> -->
                <label class="waiter-name"><?php echo $user['nomeCliente']?></label>
            </li>
            <?php }?>
        </ul>

    </div>
</body>
<script src="teste4.js"></script>
<script src="reorder.js"></script>


</html>