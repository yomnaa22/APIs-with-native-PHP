<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../models/User.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new User($db);
    $stmt = $items->getAllUsers();
    $itemCount = $stmt->rowCount();

   // echo json_encode($itemCount);
    if($itemCount > 0){
        
        $employeeArr = array();
        $employeeArr["data"] = array();
       // $employeeArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
               
               
            );
            array_push($employeeArr["data"], $e);
        }
        echo json_encode($employeeArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>