<?php
  include_once("../includes/header.php");
  if (isset($_REQUEST["id"]) && isset($_REQUEST["idCliente"] )) {
    $query = "SELECT * FROM passeio p, pagamento_passeio pp, cliente c WHERE p.idPasseio= ? and pp.idPasseio=p.idPasseio and pp.idCliente=c.idCliente and pp.idCliente= ?";
    if ($stmt = mysqli_prepare($conexao, $query)) {
      mysqli_stmt_bind_param($stmt, "ii", $idPasseio, $idCliente);
      $idPasseio = $_REQUEST['id'];
      $idCliente = $_REQUEST['idCliente'];
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          print_r(json_encode($row));
        }
    
      }else {
        print_r(json_encode(array (
          "status" => 0
        )));

      }

      }
      
    }
  }
?>