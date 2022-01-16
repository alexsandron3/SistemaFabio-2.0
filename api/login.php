<?php
// include_once('../includes/loginHeader.php');
  require  __DIR__ . '../../vendor/autoload.php';
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '\..');
  $dotenv->safeLoad();
  include_once('passeio/selectAll.php');
  include_once('passeio/select.php');
  function msg($success, $status, $message, $extra = [])
  {
    return array_merge([
      'success' => $success,
      'status' => $status,
      'message' => $message
    ],
      $extra
    );
  }
  // required headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: access');
  header('Access-Control-Allow-Methods: POST');
  header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
  require __DIR__.'/classes/Database.php';
  require __DIR__.'/classes/JwtHandler.php';
  
  $db_connection = new Database();
  $conn = $db_connection->dbConnection();

  $data = json_decode(file_get_contents("php://input"));
  $returnData = [];
  // return json_encode(var_dump($data));

  if($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    $returnData = msg(0, 404, 'Page Not Foud!');
  }elseif (!isset($data->username) 
  || !isset($data->password)
  || empty(trim($data->username))
  || empty(trim($data->password))) {
    $fields = ['fields' => ['username','password']];
    $returnData = msg(0,422,'Por favor, preencha todos os campos!',$fields);
  }else {
    $username = trim($data->username);
    $password = trim($data->password);
    if(!$username){
      $returnData = msg(0,422,'Usuário inválido!');
    }else {
      try {
        $fetch_user_by_username = "SELECT * FROM `users` WHERE `username`=:username";
        $query_stmt = $conn->prepare($fetch_user_by_username);
        $query_stmt->bindValue(':username', $username,PDO::PARAM_STR);
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
          $returnData = msg(0,422,'Invalid username Address!');

        }
      } catch (\Throwable $th) {
        $returnData = msg(0,500,$e->getMessage());
      }
    }
  }

  echo json_encode($returnData);


  