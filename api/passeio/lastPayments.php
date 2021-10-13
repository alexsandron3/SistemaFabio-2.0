<?php
  include_once("../../includes/header.php");
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  $time_start = microtime(true);
  $apiAnswer = array();
  $apiResponse = json_decode(file_get_contents('http://localhost/Projetos/SistemaFabio-2.0/api/passeio.php?inicio=2020-01-01&fim=2030-01-01'), 1);

  // print_r($response['passeios']);
  foreach ($apiResponse['passeios'] as $key => $passeio) {
    $idPasseio = $passeio['idPasseio'];
    $query = 'SELECT idPasseio FROM passeio';
    if($stmt = $conn->prepare($query)){
      $stmt->bind_param('i', $idPasseio);
      $response = executeSelect($stmt);
      // $apiAnswer = $response;
      while ($row = $response['serverResponse']['sql']->fetch_all()) {
        // $apiAnswer['payments'] = $row;
        $apiAnswer[$idPasseio] = $row;
        // array_push($apiResponse['passeios'][$key], $row);
        // $apiResponse['passeios'][$key]['pagamentos'] = $row;

        
      }
    }
  }
  array_push($apiResponse, $apiAnswer);
// print_r(json_decode($response));
$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start);
$apiAnswer['serverResponse']['execTime'] = $execution_time;
//execution time of the script
// echo '<b>Total Execution Time:</b> '.$execution_time.' Sec';

echo json_encode($apiResponse);
?>