<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../models/User.php';

    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new User($db);
    
    $data = json_decode(file_get_contents("php://input"));
    if ($_SERVER["REQUEST_METHOD"] == "DELETE"){
      
    $item->id = $data->id;
  
    
    if($item->delete()){
        
        echo json_encode("User deleted.");
    
    } else{

        http_response_code(404);
        
        echo  json_encode( array("message" => "user not found"));
    }
}
else {

    http_response_code(405);
    echo json_encode(array("message" => "method not allowed"));
}
?>