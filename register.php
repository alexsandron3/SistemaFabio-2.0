<?php


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="SCRIPTS/register.php" method="post">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control" value="">
            </div>    
            <div class="form-group ">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="confirm_password" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>NIVEL DE ACESSO</label>
                <input type="number" name="nivelAcces" class="form-control" required>
                <p>

            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <!-- <p>Already have an account? <a href="login.php">Login here</a>.</p> -->
        </form>
    </div>
    <pre>
 O sistema irá reagir de forma diferente baseado no seu nivel de acesso.
 0 Todas funcionalidades permitidas e acesso ao LOG do sistema;
 1 Usuário que atuaria com vendas, fazendo alterações em todas áreas do sistema;
 2 Usuário que poderá apenas visualizar o conteúdo, restrição para alteração e inserção de dados.
 -------------------------------------------------------------------------------
 0 ADMINISTRADOR 
 1 USUÁRIO SEM RESTRIÇÃO
 2 USUÁRIO COM RESTRIÇÃO
 -------------------------------------------------------------------------------
Nesse sistema você poderá fazer: 
    CADASTRO de PESSOAS;
    CRIAÇÃO de EVENTOS;
    CRIAÇÃO de DESPESA de EVENTOS;
    CRIAÇÃO de PAGAMENTOS;
    ATUALIZAÇÃO e REMOÇÃO de todas informações;
    TRANSFERÊNCIA de PAGAMENTOS;
    Entre outras várias funcionalidades para controle.
    

                </pre>
                
                </p>    
</body>
</html>

