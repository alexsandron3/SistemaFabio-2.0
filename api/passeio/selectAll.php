<?php
  function selectAll($conn, $showInactives = null) {
    $query = 'SELECT * FROM passeio WHERE statusPasseio NOT IN (0)';
    if($showInactives === 1 ) $query = 'SELECT * FROM passeio';
    $stmt = $conn->prepare($query);
    $response = executeSelect($stmt);
    $apiAnswer = $response;
  
    if ($response['serverResponse']['sql']->num_rows > 0) {
      while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
        $apiAnswer['passeios'][] = $row;
      }
      return $apiAnswer;
    }
  }
?>