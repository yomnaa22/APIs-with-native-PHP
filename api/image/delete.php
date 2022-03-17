<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/Image.php';

  
  $database = new Database();
  $db = $database->getConnection();


  $img = new Image($db);

 
  $data = json_decode(file_get_contents("php://input"));

  if ($_SERVER["REQUEST_METHOD"] == "DELETE"){
  $img->id = $data->id;

  
  if($img->delete()) {
    echo json_encode(
      array('message' => 'Image Deleted')
    );
  } else {
    http_response_code(404);
    echo json_encode(
      array('message' => 'Image Not Deleted')
    );
  }}

else {

  http_response_code(405);
  echo "method not allow";
}