<?php
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