<?PHP
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
  $idPasseioGet =1;


  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = pg_query("SELECT p.nomePasseio, p.idPasseio, c.nomeCliente, c.cpfCliente, c.dataNascimento, pp.statusPagamento, pp.idPagamento, 
                      pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, SUBSTRING_INDEX(c.nomeCliente, ' ', 1) AS primeiroNome 
                      FROM passeio p, pagamento_passeio pp, cliente c 
                      WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente") or die('Query failed!');
  while(false !== ($row = pg_fetch_assoc($result))) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
?>