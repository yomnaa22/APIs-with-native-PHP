
<?php
class img extends database{
    private $table = "images";
    private $conn;

    public function __construct()
    {
       // var_dump($this->connect());
        
    }
    public function getAllImages(){
        global $pdo;
        $query = 'SELECT u.name as user_name, i.id, i.img, i.user_id, i.created_at
                                FROM ' . $this->table . ' i
                                LEFT JOIN
                                users u ON i.user_id = u.id
                                ORDER BY
                                  i.created_at DESC';
      
    
      $stmt = $this->connect()->prepare($query);
      $stmt->execute();
      return $stmt;
      
    }

    public function create() {

        $query = 'INSERT INTO ' . $this->table . " SET img = :img, user_id = :user_id";

        $stmt = $this->connect()->prepare($query);
        
     
        
        $stmt->bindParam(':img', $this->img);
        $stmt->bindParam(':user_id', $this->user_id);
        
        if($stmt->execute()) {
          return true;
    }

    return false;
  }
  



  public function update() {
  
    $query = 'UPDATE ' . $this->table . '
     SET img = :img, user_id = :user_id
     WHERE id = :id';

   
    $stmt = $this->connect()->prepare($query);

    
    $this->img = htmlspecialchars(strip_tags($this->img));
   
   $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    
    $stmt->bindParam(':img', $this->img);

    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':id', $this->id);

    $stmt->execute();
    $count = $stmt->rowCount();
           
            if ($count > 0) {
                echo 'Success - The record for has been updated.';
                return true;
            } else {
                
                echo 'noupdate';
                return false;
            }

   
    printf("Error: %s.\n", $stmt->error);

    return false;
}
public function delete() {

  $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';


  $stmt = $this->connect()->prepare($query);

  
  $this->id = htmlspecialchars(strip_tags($this->id));

  
  $stmt->bindParam(':id', $this->id);

 
  if($stmt->execute()) {
    return true;
  }

 
  printf("Error: %s.\n", $stmt->error);

  return false;
}
}