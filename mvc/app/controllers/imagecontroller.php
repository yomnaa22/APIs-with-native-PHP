<?php




class imagecontroller
{

    public function index()
    {

        $image = new img();

        if ($_SERVER["REQUEST_METHOD"] != "GET") {

            http_response_code(405);
            echo json_encode(array("message" => "Method not allowed"));
        } else {

            $result = $image->getAllImages();

            $num = $result->rowCount();


            if ($num = 0) {


                http_response_code(404);
                echo json_encode(
                    array("message" => "No record found.")
                );
            } else {

                $images_arr = array();


                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $image_item = array(
                        'id' => $id,
                        'img' => $img,
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'created_at' => $created_at
                    );

                    array_push($images_arr, $image_item);
                }

                http_response_code(200);
                echo json_encode($images_arr);
            }
        }
    }

    public function create()
    {
        $items = new User();

        if ($_SERVER["REQUEST_METHOD"] != "POST") {

            http_response_code(405);
            array('message' => 'method not allowed');
        } else {



            $stmt = $items->getLast();

            $Num = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($_POST['user_id'])) {
                $last_inserted_id = $_POST['user_id'];
            } else {
                $last_inserted_id = $Num['max_id'];
            }
            //echo $last_inserted_id;

            $img_name = count($_FILES['img']['name']);


            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

            for ($i = 0; $i < $img_name; $i++) {


                $image = new img();


                $image->created_at = date('Y');
                $image->created_at_month = date('M');
                $image->created_at_day = date('D');


                $image->user_id = $last_inserted_id;

                $img = (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'][$i];

                $fileExt = strtolower(pathinfo($img, PATHINFO_EXTENSION));

                $tempPath  =  $_FILES['img']['tmp_name'][$i];



                $upload_path = dirname(__DIR__, 2) . "//public//uploads//$image->created_at//$image->created_at_month//$image->created_at_day//$last_inserted_id//";
                var_dump($upload_path);
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

                if ($image->create()) {
                    http_response_code(200);
                    echo json_encode(

                        array('message' => 'Image Added')
                    );
                } else {

                    http_response_code(422);
                    array('message' => 'unprocessable content');
                }
            }
        }
    }

    public function update()
    {

$image = new img();
if ($_SERVER["REQUEST_METHOD"] != "POST") {

  http_response_code(405);
  array('message' => 'method not allowed');
} else {

  // if(!empty(isset($_POST['user_id'])))
  // {
    $image->user_id = $_POST['user_id'];
  // }
  // else 
  // {
  //   $image->user_id = $image->user_id;
  // }
 
  $image->id = $_POST['id'];

  $image->created_at = date('Y');

  $image->created_at_month = date('M');
  $image->created_at_day = date('D');



  $img_name = $_FILES['img']['name'];
  $fileExt = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

  if (in_array($fileExt, $valid_extensions)) {

    $upload_path = dirname(__FILE__) . "//uploads//$image->created_at//$image->created_at_month//$image->created_at_day//$image->user_id//";

    $tempPath  =  $_FILES['img']['tmp_name'];

    $img = (floor(microtime(true)) + 1) . "_" . $_FILES['img']['name'];

    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $uploadPath = $upload_path . $img;
    $image->img = $img;

    move_uploaded_file($tempPath, $uploadPath);
  } else {

    $errorMsg = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed"));
  }


  if ($image->update()) {
    http_response_code(200);
    echo json_encode(

      array('message' => 'Image updded')
    );
  } else {

    http_response_code(404);
    echo json_encode(

      array('message' => 'image to update is not found')
    );
  }
}
    }

    public function delete()
    {
        $img = new img();


$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
  http_response_code(405);
  echo "method not allow";
} else {


  $img->id = $data->id;

  if ($img->delete()) {
    http_response_code(200);


    echo json_encode(
      array('message' => 'Image Deleted')
    );
  } else {
    http_response_code(404);
    echo json_encode(
      array('message' => 'Image Not found')
    );
  }
}

    }
}
