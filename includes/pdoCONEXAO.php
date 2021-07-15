<?php $conn = new mysqli("localhost", "root", "", "fabiopasseios");
        if($conn->connect_errno){
            echo"FALHA AO SE CONECTAR COM O MYSQL: " . $conn->connect_error;
            exit();
        }

?>