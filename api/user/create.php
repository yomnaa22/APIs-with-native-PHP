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

   

 if ($_SERVER["REQUEST_METHOD"] == "POST"){

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
    $item->name = validation($data->name);
    $item->email = validation($data->email);
    $item->created = date('Y-m-d H:i:s');

    if($item->create()){
      http_response_code(200);
       echo 'user created successfully.';
        
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
    echo json_encode( array("message" => "Method not allowed"));
}
    

  function validation($data)
  {
      $data=trim($data);
      $data=stripslashes($data);
      $data=htmlspecialchars($data);
      return $data;
  }
?>