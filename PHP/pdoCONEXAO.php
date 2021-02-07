<?php $conn = new mysqli("mysql742.umbler.com", "adminfabio", "mengo007", "fabiosistema");
        if($conn->connect_errno){
            echo"FALHA AO SE CONECTAR COM O MYSQL: " . $conn->connect_error;
            exit();
        }

?>

