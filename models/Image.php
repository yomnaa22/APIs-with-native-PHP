<?php
class Image {
    // DB stuff
    private $conn;
    private $table = 'images';

    // Post Properties
    public $id;
    public $user_id;
    public $user_name;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT u.name as user_name, i.id, i.img, i.user_id, i.created_at
                                FROM ' . $this->table . ' i
                                LEFT JOIN
                                users u ON i.user_id = u.id
                                ORDER BY
                                  i.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    public function create() {




        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET img = :img, user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->img = htmlspecialchars(strip_tags($this->img));
         $this->user_id = $this->user_id;
     
        
        $stmt->bindParam(':img', $this->img);
        $stmt->bindParam(':user_id', $this->user_id);
        

     

        // Execute query
        if($stmt->execute()) {
          return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
  public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . '
     SET img = :img, user_id = :user_id
     WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->img = htmlspecialchars(strip_tags($this->img));
   
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':img', $this->img);
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}
public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

  
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}
}


  ?>


<?php

