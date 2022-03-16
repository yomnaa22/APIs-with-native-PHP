<?php 
    class Database {
        private $host = "localhost";
        private $dbname = "file";
        private $username = "yomna";
        private $password = "Yomna@123";
        private $dbtype = "mysql";
        private $charset = 'urf8';
        private $pdo;
        private $error;
        public $conn;

        public function getConnection(){
            $this->conn = null;

            try { 
              $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
              echo 'Connection Error: ' . $e->getMessage();
            }
      
            return $this->conn;
    }  }
?>