<?php
  class Database {
    private $db_host = "mysql742.umbler.com";
    private $db_name = "fabiopasseios";
    private $db_username = "adminfabio";
    private $db_password = "ZgvwRP0R";

    public function dbConnection() {
      try {
        $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch (PDOException $e) {
        echo "Connection error ".$e->getMessage(); 
        exit;
      }
    }
    
  }