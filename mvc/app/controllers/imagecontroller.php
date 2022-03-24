<?php




class imagecontroller {

public function index()
{
    
  $image = new img();


  if ($_SERVER["REQUEST_METHOD"] != "GET"){
  
    http_response_code(405);
    echo json_encode( array("message" => "Method not allowed"));
  
  }
    else
    {
  
      $result = $image->getAllImages();
  
      $num = $result->rowCount();
    
    
      if($num = 0) {
    
    
        http_response_code(404);
        echo json_encode(
         array("message" => "No record found.")
           );
    
      } 
      else {
  
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
  
    }
  
}


}









?>