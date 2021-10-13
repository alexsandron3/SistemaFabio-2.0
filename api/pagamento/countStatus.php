<?php
  include_once("../includes/header_copy.php");

  function countStatus($conn, $id) {

    $time_start = microtime(true);
    $interessados = 0;
    $quitados = 0;
    $confirmados = 0;
    $parceiros = 0;
    $criancas = 0;
    $query = 'SELECT pp.statusPagamento, pp.idPasseio, p.nomePasseio, p.dataPasseio, p.lotacao FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio= ? AND p.idPasseio = pp.idPasseio';
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $id);
      $response = executeSelect($stmt);
      $apiAnswer = $response;

      if ($response['serverResponse']['sql']->num_rows > 0) {
        while ($row = $response['serverResponse']['sql']->fetch_array(MYSQLI_ASSOC)) {

          switch ($row['statusPagamento']) {
            case CLIENTE_INTERESSADO:
              $interessados += 1;
              break;
            case PAGAMENTO_QUITADO:
              $quitados += 1;
              break;
            case CLIENTE_CONFIRMADO:
              $confirmados += 1;
              break;
            case CLIENTE_PARCEIRO:
              $parceiros += 1;
              break;
            case CLIENTE_CRIANCA:
              $criancas += 1;
              break;
          }
          
        }
        $apiAnswer['passeio']['info'] = $row;
        $apiAnswer['passeio']['interessados'][] = $interessados;
        $apiAnswer['passeio']['quitados'][] = $quitados;
        $apiAnswer['passeio']['confirmados'][] = $confirmados;
        $apiAnswer['passeio']['parceiros'][] = $parceiros;
        $apiAnswer['passeio']['criancas'][] = $criancas;
        // $apiAnswer['passeio']['passeio'][] = $row;
        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);
  
        $apiAnswer['serverResponse']['execTime'] = $execution_time;
        return $apiAnswer;
      }
    }
  
  }
  
?>