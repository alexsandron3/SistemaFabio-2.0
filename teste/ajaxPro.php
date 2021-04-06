<?php 
    // Include Connection File 
    require('dbConfig.php');

    $position = $_POST['position'];

    $i=1;

    // Update Orting Data 
    foreach($position as $k=>$v){

        $sql = "Update pagamento_passeio SET ordemPoltrona=".$i." WHERE idCliente=".$v;
        echo $sql;

        $mysqli->query($sql);

        $i++;
    }
?>