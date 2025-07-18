<?php

namespace App\Controllers;

class Controller {

    public function view($view, $data = []) {
        //destructure array
        extract($data);        

        $view = str_replace(".", "/", $view);
        if(file_exists("../resources/views/$view.php")) {
            ob_start();
            include "../resources/views/$view.php";
            return ob_get_clean();            
        } else {
            return "View no exixts";
        }        
    }

    /**
     * Redirect.
     */
    public function redirect($route) {
        header("Location: {$route}");
    }
}

?>