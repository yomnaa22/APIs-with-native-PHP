<?php

require '/var/www/html/curd-mvc/mvc/vendor/autoload.php';
//require '../../vendor/autoload.php';
use \Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 class usercontroller {
     
    public function index ()
    {
       
        $db = new user();
        $stmt = $db->getAllUsers();
        $itemCount = $stmt->rowCount();
    
        if($itemCount < 0){
          
            echo json_encode(
                array("message" => "No record found.")
            );
       
        }
        else{

            $userArr = array();
            $userArr["data"] = array();
          
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                   
                   
                );
                array_push($userArr["data"], $e);
            }
           
            echo json_encode($userArr);
    
        }
    
 }

 public function create()
 {
    
    $item = new user();
    $data = json_decode(file_get_contents("php://input"));

   

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
   
     http_response_code(405);
       echo json_encode( array("message" => "Method not allowed"));
   }
   else 
   {
     if(empty($data->name) || empty($data->email))
     {
        http_response_code(500);
        echo json_encode( array("message" => "Please fill all required data"));
     }
     else {

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
           $item->password = password_hash($data->password, PASSWORD_DEFAULT);

           $stmt = $item->check_email();

               if($row = $stmt->fetch(PDO::FETCH_ASSOC))  {
                   http_response_code(422);
             echo json_encode( array("message" => "email already exists"));

               }
               else {
           if($item->create()){
             http_response_code(200);
             echo json_encode( array("message" => "user added successfully"));
       
               
           } 
        }
        }
     }
         
   }


 
 }
public function login()
{
    $db = new user();
    $data = json_decode(file_get_contents("php://input"));
    if ($_SERVER["REQUEST_METHOD"] != "POST"){
   
        http_response_code(405);
          echo json_encode( array("message" => "Method not allowed"));
      }
      else 
      {
       
        $db->email = $data->email;
      
     
        $stmt = $db->check_login();

 
       
            if($db->check_login())  {
       
               
                $password=$stmt['password'];
              
                if(password_verify($data->password, $password)){
                  
                        $iss="localhost";
                        $iat=time();
                        $nbf=$iat + 10;
                        $exp= $iat + 30;
                        $aud = "users";
                        $user_arr_data = array(
                            "id"=> $stmt['id'],
                            "name"=> $stmt['name'],
                            "email"=> $stmt['email']
                        );

                       $secret_key="owt125";

                        $payload_info=array(
                            "iss"=>$iss,
                            "iat"=>$iat,
                            "nbf"=>$nbf,
                            "exp"=>$exp,
                            "aud"=>$aud,
                            "data"=> $user_arr_data
                        );
                        
                    

                  $jwt=JWT::encode($payload_info, $secret_key);
                    http_response_code(200);
                 echo json_encode( array("message" => "user is logged in succesffuly",
                "token" => $jwt));
                }
                else
                {
                    http_response_code(500);
                    echo json_encode( array("message" => "wrong password"));
                }
            }
            else {
       
          http_response_code(404);
          echo json_encode( array("message" => "user you are trying to login doesnot exist"));
    
            
        
    }

      }

   
}

public function update()
{
    $item = new User();
    
    $data = json_decode(file_get_contents("php://input"));

    if ($_SERVER["REQUEST_METHOD"] != "PUT"){

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
    

 
}

public function delete()
{
    $item = new User();
    $year = date('Y');
    $month = date('M');
  

    $data = json_decode(file_get_contents("php://input"));
    if ($_SERVER["REQUEST_METHOD"] != "DELETE"){
        
        http_response_code(405);
        echo json_encode(array("message" => "method not allowed"));

}
else {


    $item->id = $data->id;
 
    
    if($item->delete()){

  echo json_encode("User deleted.");
    
    } else{

        http_response_code(404);
        
        echo  json_encode( array("message" => "user not found"));
    }
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