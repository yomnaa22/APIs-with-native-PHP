<?php
    class User{
        
        private $conn;

        private $db_table = "users";

        public $id;
        public $name;
        public $email;
        public $created_at;
        public $last;
       
        public function __construct($db){
        $this->conn = $db;
               }
    
    public function getAllUsers(){
        global $pdo;
        $sqlQuery = "SELECT id, name, email , created_at  FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    
    
    public function create(){
        $sqlQuery = "INSERT INTO
                ". $this->db_table ."
            SET
                name = :name, 
                email = :email" 
               
                ;

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
 

        if($stmt->execute()){
       
           return true;
         
      

        }
        return false;
    }
    
  
   
    public function update(){
        $sqlQuery = "UPDATE
                    ". $this->db_table ."
                SET
                    name = :name, 
                    email = :email
           
                   
                WHERE 
                id = :id";
    
        $stmt = $this->conn->prepare($sqlQuery);
    
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);
    
        $stmt->execute();
        $count = $stmt->rowCount();
      
        if ($count > 0) {
            
            return true;
        } else {
            
            
            return false;
        }
    
        
        return false;
    }
   

    function delete(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
    
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $count = $stmt->rowCount();
           
            if ($count > 0) {
                
                return true;
            } else {
                
                return false;
            }
        

        return false;
        }

        function getLast()

        {  
             global $pdo;
            $sqlQuery = "SELECT MAX(id) AS max_id FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
    }
?>























