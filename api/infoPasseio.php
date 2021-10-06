<?php
  include_once("../includes/header.php");
  if (isset($_REQUEST["id"])) {
    $query = "SELECT * FROM passeio WHERE idPasseio= ?";
    if ($stmt = mysqli_prepare($conexao, $query)) {
      mysqli_stmt_bind_param($stmt, "i", $idPasseio);
      $idPasseio = $_REQUEST['id'];
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          print_r( json_encode($row));
        }
      }
      
    }
  }
?>