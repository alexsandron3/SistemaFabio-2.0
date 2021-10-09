<?php
  function selectAll($conn, $showInactives = null, $data) {
    $query = 'SELECT * FROM passeio WHERE statusPasseio NOT IN (0)';
    if($showInactives == 1 ) $query = 'SELECT * FROM passeio WHERE 1';
    $types = "";
    $params = [];
    if($data['inicio'] && $data['fim']){
      $query .= ' AND dataPasseio BETWEEN ? AND ?';
      $types .='ss';
      $params[] = $data['inicio'];
      $params[] = $data['fim'];
    } 
    if(strlen($types) > 0 ) {
      $stmt = $conn->prepare($query);
      $stmt->bind_param($types, ...$params);
      $response = executeSelect($stmt);
      
    }else {
      $stmt = $conn->prepare($query);
      $response = executeSelect($stmt);
    }
    
    $apiAnswer = $response;
    if ($response['serverResponse']['sql']->num_rows > 0) {
      while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {
        $apiAnswer['passeios'][] = $row;
      }
      return $apiAnswer;
    }
  }
  
?>