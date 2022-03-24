<?php
 class usercontroller {
     
    public function index ()
    {
        echo "useeeers";
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
 }

?>