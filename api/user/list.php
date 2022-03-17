<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../models/User.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new User($db);


    if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $items->getAllUsers();
    $itemCount = $stmt->rowCount();

   
    if($itemCount > 0){
        
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
        http_response_code(200);
        echo json_encode($userArr);

    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }}
    else{
        http_response_code(405);
        echo json_encode( array("message" => "Method not allowed"));
    }
?>