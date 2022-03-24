
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
}