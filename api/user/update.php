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

    $error_array=[];

    if(strlen(validation($data->name)) < 3 ||  (is_int($data->name)))
    {
      $error_array["name"]="name is invalid";
     
    }
    if(strlen(validation($data->email))<5 ||  (is_int($data->email)))
    {
      $error_array["email"]="email is inavlid";
  
    }
    if(sizeof($error_array)==0){
        $item->id = $data->id;
        $item->name = $data->name;
        $item->email = $data->email;
    
        
        if($item->update()){
          http_response_code(200);
          echo 'user created successfully.';
        } 
        else {
          echo json_encode( array("error" => "the user you're trying to update is not found"));

          http_response_code(404);

        }
    }
    else{

    http_response_code(422);
   
    $err = array_values($error_array);

     echo json_encode($err);
    }
  
 }
 else 
{
    http_response_code(405);
    echo json_encode( array("error" => "Method not allowed"));
}
    

  function validation($data)
  {
      $data=trim($data);
      $data=stripslashes($data);
      $data=htmlspecialchars($data);
      return $data;
  }
?>