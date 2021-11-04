<?php
  function select($conn, $id) {
    $time_start = microtime(true);

    $query = 'SELECT * FROM pagamento_passeio WHERE idPasseio= ?';

    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $id);
      $response = executeSelect($stmt);
      $apiAnswer = $response;

      if ($response['serverResponse']['sql']->num_rows > 0) {
        while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
          $apiAnswer['pagamentos'][] = $row;
          
        }
        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);
  
        $apiAnswer['serverResponse']['execTime'] = $execution_time;
        return $apiAnswer;
      }
    }
  
  }
?>