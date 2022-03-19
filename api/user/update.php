<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../models/User.php';

    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new User($db);
    
    $data = json_decode(file_get_contents("php://input"));

 if ($_SERVER["REQUEST_METHOD"] == "PUT"){

  http_response_code(405);
  echo json_encode( array("error" => "Method not allowed"));
   
 }
 else 
{


    $error_array=[];

    if(strlen(validation($data->name)) < 3 ||   (preg_match('~[0-9]+~', $data->name))==1)

    {
      $error_array["name"]="name is invalid";
     
    }

    $sanitizedEmail = filter_var($data->email, FILTER_SANITIZE_EMAIL);
    
    if($data->email != $sanitizedEmail || !filter_var($data->email, FILTER_VALIDATE_EMAIL))
    {
      $error_array["email"]="email is inavlid";
  
    }
    if(sizeof($error_array)!=0){
      http_response_code(422);
   
      $err = array_values($error_array);
  
       echo json_encode($err);
    
    }
    else{

  
     $item->id = $data->id;
     $item->name = $data->name;
     $item->email = $data->email;
 
     
     if($item->update()){
       http_response_code(200);
       echo json_encode( array("message" => "user updated successfully"));

     } 
     else {
       echo json_encode( array("error" => "the user you're trying to update is not found"));

       http_response_code(404);

     }
    }
}
    

  function validation($data)
  {
      $data=trim($data);
      $data=stripslashes($data);
      return $data;
  }
?>