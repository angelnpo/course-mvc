<?php

namespace App\Controllers;

use App\Models\ContactModel;

class HomeController extends Controller {

    public function index() {

        $contact_model = new ContactModel();        
        //return $contact_model->findById(5);
        //return $contact_model->findByFilter("name", "Dome")->get();
        /*return $contact_model->save(
            [
                "name" => "Pam",
                "email" => "email@mail",
                "phone" => "593"
            ]);*/
        /*return $contact_model->update(8,
            [
                "name" => "Soe",
                "email" => "email@mail",
                "phone" => "593"
            ]);*/

        //$contact_model->delete(8);
        //return "Deleted...";

        return $this->view("home", [
            "title" => "Home",
            "description" => "home page"
        ]);
    }    
}

?>