<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/database.php';
include_once '../../models/Image.php';


$database = new Database();
$db = $database->getConnection();


if ($_SERVER["REQUEST_METHOD"] != "POST") {

  http_response_code(405);
  array('message' => 'method not allowed');
 
} else {


  


 // $img_name = $_FILES['img']['name'];
  $img_name = count($_FILES['img']['name']);


  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
  for($i=0;$i<$img_name ;$i++){


    $image = new Image($db);
    $image->user_id = $_POST['user_id'];
  $image->created_at = date('Y');

    $img = (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'][$i];

    $fileExt = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    $tempPath  =  $_FILES['img']['tmp_name'][$i];

    
    $upload_path = dirname(__FILE__) . "//uploads//$image->created_at//";

  if (in_array($fileExt, $valid_extensions)) {

    
 


    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $uploadPath = $upload_path . $img;
    $image->img = $img;

    move_uploaded_file($tempPath, $uploadPath);
  } else {
    $errorMsg = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed"));
  }
  $values[] = (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'][$i];

 
  }
  $values = implode('m',$values);
  var_dump(($values));

 
  if ($image->try($values)) {
    http_response_code(200);
    echo json_encode(

      array('message' => 'Image Added')
    );
  } else {

    http_response_code(422);
    array('message' => 'unprocessable content');
  }
  
}














// $countfiles = count($_FILES['file']['name']);
// $file = $_FILES['file']['name'][0]; // getting first file

// if(empty($file))
// {
//     // if file is empty show error
// 	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
// 	echo $errorMSG;
// }
// else
// {

// $upload_path = 'upload/'; // declare file upload path
// $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid image extensions - file extensions

// // Looping all files 
// for($i=0;$i<$countfiles;$i++){
//     $fileName = $_FILES['file']['name'][$i];
//     $tempPath = $_FILES['file']['tmp_name'][$i];
//     $fileSize  =  $_FILES['file']['size'][$i];

//     $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension

//     // check if the files are contain the vALID  extensions
//     if(in_array($fileExt, $valid_extensions))
// 	{				
// 		//check file not exist our upload folder path
// 		if(!file_exists($upload_path . $fileName))
// 		{
// 			// check file size '5MB' - 5MegaByte is allowed
// 			if($fileSize < 5000000){

//                 //built-in method to move file to directory
// 				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
                
//                 //insert into database table
//                 $query =  mysqli_query($conn,'INSERT into tbl_image (name) VALUES("'.$fileName.'")');
                
//             }
// 			else{		
// 				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
// 				echo $errorMSG;
// 			}
// 		}
// 		else
// 		{		
// 			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
// 			echo $errorMSG;
// 		}
// 	}
// 	else
// 	{		
// 		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
// 		echo $errorMSG;		
// 	}
   
//    }
// }

// //if no error message show response
// if(!isset($errorMSG))
// {	
// 	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true));	
// }

?>
