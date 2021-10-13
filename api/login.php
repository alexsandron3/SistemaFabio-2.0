<?php
  include_once('../includes/header.php');
  include_once('passeio/selectAll.php');
  include_once('passeio/select.php');
  // required headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: POST');
  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
  function msg ($success, $status, $message, $extra= []) {
    return array_merge([
      'succes' => $success,
      'status' => $status,
      'message' => $message
    ], $extra);
  }
  require __DIR__.'/classes/Database.php';
  require __DIR__.'/classes/JwtHandler.php';
  
  $db_connection = new Database();
  $conn = $db_connection->dbConnection();

  $data = json_decode(file_get_contents("php://input"));
  $returnData = [];

  if($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    $returnData = msg(0, 404, 'Page Not Foud!');
  }elseif (!isset($data->email) 
  || !isset($data->password)
  || empty(trim($data->email))
  || empty(trim($data->password))) {
    $fields = ['fields' => ['email','password']];
    $returnData = msg(0,422,'Please Fill in all Required Fields!',$fields);
  }else {
    $email = trim($data->email);
    $password = trim($data->password);
    if(!$email){
      $returnData = msg(0,422,'Invalid Email Address!');
    }elseif (strlen($password) < 2) {
      $returnData = msg(0,422,'Your password must be at least 8 characters long!');

    }else {
      try {
        $fetch_user_by_email = "SELECT * FROM `users` WHERE `username`=:email";
        $query_stmt = $conn->prepare($fetch_user_by_email);
        $query_stmt->bindValue(':email', $email,PDO::PARAM_STR);
        $query_stmt->execute();

        // IF FINDS A USER BY NAME

        if($query_stmt->rowCount()) {
          $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
          $check_password = password_verify($password, $row['password']);
          if($check_password) {
            $jwt = new JwtHandler();
            $token = $jwt->_jwt_encode_data('http://localhost/php_auth_api/',
            array("user_id"=> $row['id']));
            $returnData = [
              "success" => 1,
              "message" => 'Logado com sucesso',
              "token" => $token
            ];
          }else {
            $returnData = msg(0, 422, 'Senha inválida!');
          }
        }else {
          $returnData = msg(0,422,'Invalid Email Address!');

        }
      } catch (\Throwable $th) {
        $returnData = msg(0,500,$e->getMessage());
      }
    }
  }

  echo json_encode($returnData);


  