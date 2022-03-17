<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 //header(':', true, 404);

 include_once '../../config/database.php';
 include_once '../../models/Image.php';
 $database = new Database();
 $db = $database->getConnection();


  $image = new Image($db);


if ($_SERVER["REQUEST_METHOD"] == "GET"){

  $result = $image->read();

  $num = $result->rowCount();


  if($num > 0) {

    $images_arr = array();


    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $image_item = array(
        'id' => $id,
        'img' => $img,
        'user_id' => $user_id,
        'user_name' => $user_name,
        'created_at' => $created_at
      );

      array_push($images_arr, $image_item);
      
    }

    http_response_code(200);
    echo json_encode($images_arr);

  } 
  else {
   
   http_response_code(404);
   echo json_encode(
    array("message" => "No record found.")
      );
  
  }
}
  else
  {
    http_response_code(405);
    echo json_encode( array("message" => "Method not allowed"));

  }
  ?>