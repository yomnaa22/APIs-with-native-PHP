<?php 
 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/Image.php';

  $database = new Database();
  $db = $database->getConnection();


  $image = new Image($db);

  //$data = json_decode(file_get_contents("php://input"));
  if ($_SERVER["REQUEST_METHOD"] == "PUT"){
  $image->id = $_POST['id'];
  $image->user_id = $_POST['user_id'];
  $image->created_at = date('Y');
  
  
  
  $img_name=$_FILES['img']['name'];
  $fileExt = strtolower(pathinfo($img_name,PATHINFO_EXTENSION)); 
  
  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
  
  if(in_array($fileExt, $valid_extensions))
  {
  
  $upload_path = dirname(__FILE__) . "//uploads//$image->created_at//";
  
  $tempPath  =  $_FILES['img']['tmp_name'];
  
  $img= (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'];
  
  if (!is_dir($upload_path)) {
    mkdir($upload_path, 0777, true);
  
  }
  
  $uploadPath = $upload_path . $img;
  $image->img=$img; 
  
  move_uploaded_file($tempPath, $uploadPath);
  
  }
  else{
    $errorMsg = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed"));	
      
  }



  if($image->update()) {
    http_response_code(200);

    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    http_response_code(404);
    echo json_encode(
   

      array('message' => 'Post Not Updated')
    );
  }}
  else
  {
    //405
  }