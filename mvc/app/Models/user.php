<?php 

class user extends database{
    private $table = "users";
    private $conn;

    public function __construct()
    {
       // var_dump($this->connect());
        
    }
    public function getAllUsers(){
        global $pdo;
        $sqlQuery = "SELECT id, name, email , created_at  FROM " . $this->table . "";
        $stmt = $this->connect()->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
      
    }
  
          
    public function create(){
        $sqlQuery = "INSERT INTO
                ". $this->table ."
            SET
                name = :name, 
                email = :email" 
               
                ;

        $stmt = $this->connect()->prepare($sqlQuery);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
 

        if($stmt->execute()){
       
           return true;
         
      

        }
        return false;
    }

    
}








?>