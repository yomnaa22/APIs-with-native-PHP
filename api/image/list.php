<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 //header(':', true, 404);

 include_once '../../config/database.php';
 include_once '../../models/Image.php';
 $database = new Database();
 $db = $database->getConnection();

  // Instantiate blog post object
  $post = new Image($db);

  // Blog post query
  $result = $post->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id' => $id,
        'img' => $img,
      
        'user_id' => $user_id,
        'user_name' => $user_name,
        'created_at' => $created_at
      );

      // Push to "data"
      array_push($posts_arr, $post_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    // No Posts
   
        http_response_code(404);
    
  }
  ?>