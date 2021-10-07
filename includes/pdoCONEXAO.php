<?php $conn = new mysqli("mysql742.umbler.com", "adminfabio", "ZgvwRP0R", "fabiopasseios");
        if($conn->connect_errno){
            echo"FALHA AO SE CONECTAR COM O MYSQL: " . $conn->connect_error;
            exit();
        }

?>