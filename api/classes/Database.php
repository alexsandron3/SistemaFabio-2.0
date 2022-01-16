<?php
  class Database {
    public function dbConnection() {
      try {
        $conn = new PDO('mysql:host='. $_ENV['DBhost'].';dbname='. $_ENV['DBname'],$_ENV['DBuser'], $_ENV['DBpass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch (PDOException $e) {
        echo "Connection error ".$e->getMessage(); 
        exit;
      }
    }
    
  }