<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/database.php';
    include_once '../../models/User.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new User($db);


echo $last_inserted_id;


    ?>