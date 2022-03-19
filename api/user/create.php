<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  include_once '../../config/database.php';
  include_once '../../models/User.php';


 $database = new Database();
 $db = $database->getConnection();
 $item = new User($db);

 $data = json_decode(file_get_contents("php://input"));

   

 if ($_SERVER["REQUEST_METHOD"] != "POST"){

  http_response_code(405);
    echo json_encode( array("message" => "Method not allowed"));
}
else 
{;
  
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
     
     if(sizeof($error_array)>0){

      http_response_code(422);
      $err = array_values($error_array);
      echo json_encode($err);
    }
   
     else{
       
        $item->name = validation($data->name);
        $item->email = validation($data->email);
        $item->created = date('Y-m-d H:i:s');
    
        if($item->create()){
          http_response_code(200);
          echo json_encode( array("message" => "user added successfully"));
    
            
        } 
   
     }
      
}
    

  function validation($data)
  {
      $data=trim($data);
      $data=stripslashes($data);
      return $data;
  }




