<?php


 class homecontroller {
     
    public function index ()
    {
        $data['title'] = "title of home";
        $data['content'] = "content of home";
        view::load('home',$data);
    }
 }



?>