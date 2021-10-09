<?php
  function select($conn, $id, $showInactives = 0) {
    $query = 'SELECT * FROM passeio WHERE idPasseio= ? ';
    if($showInactives === 1 ) $query .= 'AND statusPasseio NOT IN ($showInactives)';
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $id);
      $response = executeSelect($stmt);
      $apiAnswer = $response;

      if ($response['serverResponse']['sql']->num_rows > 0) {
        while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
          $apiAnswer['passeios'][] = $row;
          
        }
        return $apiAnswer;
      }
    }
  
  }
?>