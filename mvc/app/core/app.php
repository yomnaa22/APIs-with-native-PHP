<?php 



class app 

{
    // controller
    protected $controller = "homecontroller";
    // method 
    protected $action = "index";
    // params 
    protected $params=[];

    public function __construct()
    {
        $this->prepareURL($_SERVER['REQUEST_URI']);
        // invoke controller and method
        $this->render();

    }



    /**
     * extract controller and method and all parameters
     * @param string $url -> request from url path 
     * @return 
     */
    private function prepareURL($url)
    {
        $url = trim($url,"/");
        if(!empty($url))
        {
            $url = explode('/',$url);
            // define controller 
            $this->controller = isset($url[0]) ? $url[0]."controller":"homecontroller";
            // define method 
            $this->action = isset($url[1]) ? $url[1]:"index";
            // define parameters 
            unset($url[0],$url[1]);

            $this->params = !empty($url) ? array_values($url) : [];
        }
        
    }



    /**
     * render controller and method and send parameters 
     * @return function 
     */

    private function render()
    {
        
        // chaeck if controller is exist
        if(class_exists($this->controller))
        {
            $controller = new $this->controller;
            // check if methos is exist
            if(method_exists($controller,$this->action))
            {
                call_user_func_array([$controller,$this->action],$this->params);
            }
            else 
            {
                 echo "Method : " . $this->action ." does not Exist";
               // new View('error');
            }
        }
        
        else 
        {
            echo "Class : ".$this->controller." Not Found";
           // new View('error');
        }  
        
    }
}





// if(file_exists(CONTROLLERS.$this->controller.'.php'))
// {
//     if(class_exists($this->controller))
//     {
//         if(method_exists($this->controller,$this->action))
//         {
//             call_user_func_array([$this->controller,$this->action],$this->params);
//         }
//     }
// }
// else 
// {
//     echo $this->controller." Not Found";
// }  


?>