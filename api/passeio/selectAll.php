<?php
  function selectAll($conn, $showInactives = null, $data) {
    $time_start = microtime(true);

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
      for($i = 0; $passeio[$i] = $response['serverResponse']['sql']->fetch_assoc(); $i++) ;
      array_pop($passeio);
      foreach ($passeio as $key => $value) {
        $id = $passeio[$key]['idPasseio'];
        $payments = "SELECT pp.statusPagamento, pp.idPasseio FROM pagamento_passeio pp WHERE pp.idPasseio= $id";
        $stm = $conn->prepare($payments);
        $resp = executeSelect($stm);
        for($i = 0; $pagamento[$i] = $resp['serverResponse']['sql']->fetch_assoc(); $i++) ;
        array_pop($pagamento);
        $passeio[$key]['pagamentos'] = $pagamento;

      }
      $time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
      $apiAnswer['passeios'][] = $passeio;
      $apiAnswer['serverResponse']['execTime'] = $execution_time;

      return $apiAnswer;
    }
  }
  
?>