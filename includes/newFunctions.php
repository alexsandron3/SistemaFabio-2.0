<?php
// Função de cadastro
function insert($stmt)
{
	// $permissaoParaCadatrar    = retornaPermissao('cadastrar');
	if ($stmt->execute()) {
		$msg = array();
		$msg['status'] = 1;
		$msg['msg'] = "CADASTRADO(A) com sucesso";
		print_r(json_encode($msg));
	
	} else {
		$msg = array();
		$msg['status'] = 0;
		$msg['msg'] = "FALHA ao cadastrar";
		print_r(json_encode($msg));
	}
}

function select($stmt) {
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    print_r($result); 
  }else{
    echo "ops";
  }
}

function verifyIfExists () {
  "SELECT ";
}

?>