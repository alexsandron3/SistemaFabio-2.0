<!DOCTYPE html>
<html>

<head>
    

    <title>Dynamic Drag and Drop Table Rows In PHP Mysql</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style type="text/css">
        body {
            background: #d1d1d2;
        }

        .mian-section {
            padding: 20px 60px;
            margin-top: 100px;
            background: #fff;
        }

        .title {
            margin-bottom: 50px;
        }

        .label-success {
            position: relative;
            top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row" id="teste">
            <div class="col-md-8 col-md-offset-2 mian-section">
                <h3 class="text-center title">Dynamic Drag and Drop Table Rows In PHP Mysql <label class="label label-success">nicesnippets.com</label></h3>
                <table class="table table-bordered" id="userTable">
                    <thead>
                        <tr>
                            <th>Posição</th>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody class="row_position">
                        <?php
                        require('dbConfig.php');
                        $sql = "SELECT pp.idCliente, c.nomeCliente, c.referencia, pp.ordemPoltrona FROM pagamento_passeio pp, cliente c WHERE pp.idPasseio=34 AND pp.idCliente=c.idCliente ORDER BY ordemPoltrona , referencia";
                        $users = $mysqli->query($sql);
                        while ($user = $users->fetch_assoc()) {
                        ?>
                            <tr id="<?php echo $user['idCliente'] ?>" class="idCliente">
                                <td>
                                    <?php echo $user['ordemPoltrona'] ?>
                                </td>
                                <td>
                                    <?php echo $user['nomeCliente'] ?>
                                </td>
                                <td>
                                    <?php echo $user['referencia'] ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });



        function updateOrder(data) {
            $.ajax({
                url: "ajaxPro.php",
                type: 'post',
                data: {
                    position: data
                },
                success: function(data) {
                    toastr.success('Your Change Successfully Saved.');
                    $("#teste").load("teste3.php");

                }

            })
            /*             setInterval(function() { //setInterval() method execute on every interval until called clearInterval()
                            $('.row').load("teste3.php").fadeIn("slow");
                            //load() method fetch data from fetch.php page
                        }, 10000); */
        }
    </script>
</body>

</html>