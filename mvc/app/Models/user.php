<?php 

class user extends database{
    private $table = "users";
    private $conn;

    public function __construct()
    {
        var_dump($this->connect());
        
    }
    public function getAllUsers(){
        global $pdo;
        $sqlQuery = "SELECT id, name, email , created_at  FROM " . $this->table . "";
        $stmt = $this->connect()->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
      
    }
}








?>