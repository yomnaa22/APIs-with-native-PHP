<?php

class database {
    private $host = HOST;
    private $user = USER;
    private $password = PASS;
    private $db_name = DBNAME;

    private $pdo;
    private $stmt;
      private $conn;
      public function connect(){
        $this->conn = null;
       
        try { 
            $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
          } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
          }
        
    }
}













?>