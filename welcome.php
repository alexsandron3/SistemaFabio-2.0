<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="420;url=logout.php" />
    <title>BEM VINDO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>OLÁ, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. BEM VINDO!</h1>
    </div>
    <p>
        <a href="index.php" class="btn btn-warning">PÁGINA INICIAL</a>
        <a href="logout.php" class="btn btn-danger">DESLOGAR</a>
        <a href="reset-password.php" class="btn btn-info">TROCAR DE SENHA</a>
        <?php 
            if($_SESSION["nivelAcesso"] == 1){
                echo "<a href='register.php' class='btn btn-warning'>GERENCIAR USUÁRIOS</a>";
            }
            if($_SESSION["nivelAcesso"] == 0){
                echo "<a href='log.php' class='btn btn-info'>LOGS</a>";
            }
            

        ?>
    </p>
</body>
</html>