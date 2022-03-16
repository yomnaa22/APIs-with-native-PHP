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


$post = new Image($db);

$post->user_id = $_POST['user_id'];
$post->created_at = date('Y');



//   $data = json_decode(file_get_contents('php://input'), true);

//   $post->img= $data->img;
//   $post->user_id = $data->user_id;
//  ;
//$post->img = $_POST['img'];
//chdir("/home");
//$currentDirectory = getcwd();

$upload_path = `/var/www/html/task/uploads/$post->created_at`;

$tempPath  =  $_FILES['img']['tmp_name'];

$img=$_FILES['img']['name'];  
$uploadDirectory = "/uploads/$post->created_at/";
$uploadPath = $tempPath . $upload_path . $img;





$fileExt = strtolower(pathinfo($img,PATHINFO_EXTENSION)); 
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
        

$post->img=$img;            


move_uploaded_file($tempPath, $uploadPath);



  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }




?>




// Get raw posted data
//   $data = json_decode(file_get_contents('php://input'), true);

//   $post->img= $data->img;
//   $post->user_id = $data->user_id;
//  ;
//$post->img = $_POST['img'];


//$upload_path = `/var/www/html/task/uploads/$post->created_at/`;


// header("Content-Type: application/json");
// header("Acess-Control-Allow-Origin: *");
// header("Acess-Control-Allow-Methods: POST");
// header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

// include 'dbconfig.php'; // include database connection file

// $data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
	
// $fileName  =  $_FILES['sendimage']['name'];
// $tempPath  =  $_FILES['sendimage']['tmp_name'];
// $fileSize  =  $_FILES['sendimage']['size'];
		
// if(empty($fileName))
// {
// 	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
// 	echo $errorMSG;
// }
// else
// {
// 	$upload_path = 'upload/'; // set upload folder path 
	
// 	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
		
// 	// valid image extensions
// 	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
// 	// allow valid image file formats
// 	if(in_array($fileExt, $valid_extensions))
// 	{				
// 		//check file not exist our upload folder path
// 		if(!file_exists($upload_path . $fileName))
// 		{
// 			// check file size '5MB'
// 			if($fileSize < 5000000){
// 				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
// 			}
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
// }
		
// // if no error caused, continue ....
// if(!isset($errorMSG))
// {
// 	$query = mysqli_query($conn,'INSERT into tbl_image (name) VALUES("'.$fileName.'")');
			
// 	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true));	
// }

?> -->