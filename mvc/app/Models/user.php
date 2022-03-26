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
                email = :email,
                password = :password" 
               
                ;

        $stmt = $this->connect()->prepare($sqlQuery);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

 

        if($stmt->execute()){
       
           return true;
         
      

        }
        return false;
    }
public function check_email(){
    $sqlQuery = "SELECT * from ".$this->table." WHERE email = :email";

    $stmt = $this->connect()->prepare($sqlQuery);
    
  
    $stmt->bindParam(":email", $this->email);


    $stmt->execute();
    return $stmt;

}
    


public function check_login(){
    $sqlQuery = "SELECT * from ".$this->table." WHERE email = :email";


    $stmt = $this->connect()->prepare($sqlQuery);
    
  
    $stmt->bindParam(":email", $this->email);
    //$stmt->bindParam(":password", $this->password);



    $stmt->execute();
   
    
  
      
    if ( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      
        return $row;

    } else {
        
       
        return false;
    }

    return false;

}











    public function update(){
        $sqlQuery = "UPDATE
                    ". $this->table ."
                SET
                    name = :name, 
                    email = :email
           
                   
                WHERE 
                id = :id";
    
        $stmt = $this->connect()->prepare($sqlQuery);
    
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
        $sqlQuery = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->connect()->prepare($sqlQuery);
    
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
            $sqlQuery = "SELECT MAX(id) AS max_id FROM " . $this->table . "";
            $stmt = $this->connect()->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
}








?>