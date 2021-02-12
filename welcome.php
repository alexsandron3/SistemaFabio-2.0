<?php
// Initialize the session
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
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
    </p>
</body>
</html>