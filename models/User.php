<?php
    class User{
        
        private $conn;

        private $db_table = "users";

        public $id;
        public $name;
        public $email;
        public $created_at;
       
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
        // READ single
        public function getSingle(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        email, 
              
                       
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
     
            //$this->created = $dataRow['created'];
        }        
        // UPDATE
        public function update(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email
               
                       
                    WHERE 
                    id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
           
     
     
            //$this->id=htmlspecialchars(strip_tags($this->id));
        
    
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
           
      
            $stmt->bindParam(":id", $this->id);
        
            $stmt->execute();
            $count = $stmt->rowCount();
            // check affected rows using rowCount
            if ($count > 0) {
                echo 'Success - The record for has been updated.';
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
                // check affected rows using rowCount
                if ($count > 0) {
                    echo 'Success - The record for has been deleted.';
                    return true;
                } else {
                    
                    return false;
                }
            

            return false;
        }
    }
?>