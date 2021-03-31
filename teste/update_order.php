<?php
include_once("../includes/header.php");
if(isset($_GET["order"])) {
	$order  = explode(",",$_GET["order"]);
	for($i=0; $i < count($order);$i++) {
		$sql = "UPDATE pagamento_passeio SET ordemPoltrona='" . $i . "' WHERE idCliente=". $order[$i];		
		echo $sql;
		mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));	
	}
}
?>