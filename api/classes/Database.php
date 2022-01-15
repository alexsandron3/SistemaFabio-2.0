<?php
  class Database {
    // private $db_host = $_ENV['DBhost'];
    // private $db_name = "fabiopasseios";
    // private $db_username = "root";
    private $db_password = "";

    public function dbConnection() {
      try {
        $conn = new PDO('mysql:host='. $_ENV['DBhost'].';dbname='. $_ENV['DBname'],$_ENV['DBuser'], $_ENV['DBpass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'success';
        return $conn;
      } catch (PDOException $e) {
        echo "Connection error ".$e->getMessage(); 
        exit;
      }
    }
    
  }