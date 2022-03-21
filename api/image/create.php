<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/database.php';
include_once '../../models/Image.php';
include_once '../../models/User.php';



$database = new Database();
$db = $database->getConnection();
$items = new User($db);

if ($_SERVER["REQUEST_METHOD"] != "POST") {

  http_response_code(405);
  array('message' => 'method not allowed');
 
} else {


 
$stmt=$items->getLast();

$Num = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['user_id']))
{
  $last_inserted_id=$_POST['user_id'];
 
}
else{
$last_inserted_id = $Num['max_id'];
}
//echo $last_inserted_id;

  $img_name = count($_FILES['img']['name']);


  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

  for($i=0;$i<$img_name ;$i++){


    $image = new Image($db);
 
  
  $image->created_at = date('Y');
  $image->created_at_month = date('M');


  $image->user_id = $last_inserted_id;

    $img = (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'][$i];

    $fileExt = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    $tempPath  =  $_FILES['img']['tmp_name'][$i];

    
    $upload_path = dirname(__FILE__) . "//uploads//$image->created_at//$image->created_at_month//$last_inserted_id//";

  if (in_array($fileExt, $valid_extensions)) {

    
 


    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $uploadPath = $upload_path . $img;
    $image->img = $img;

    move_uploaded_file($tempPath, $uploadPath);
  } else {
    $errorMsg = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed"));
  }

  if ($image->create()) {
    http_response_code(200);
    echo json_encode(

      array('message' => 'Image Added')
    );
  } else {

    http_response_code(422);
    array('message' => 'unprocessable content');
  }

  }
  
}


?>
