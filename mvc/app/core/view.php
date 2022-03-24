<?php 



class view 
{
 


    public static function load($view_name,$data=[])
    {
        $file = VIEWS.$view_name.'.php';
        if(file_exists($file))
        {   extract($data);
            ob_start();
            require($file);
            ob_end_flush();
        }
        else{
            echo "this view ".$view_name."doesnot exist";
        }

    }


}