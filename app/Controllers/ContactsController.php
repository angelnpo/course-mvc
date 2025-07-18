<?php

namespace App\Controllers;

use App\Models\ContactModel;

/**
 * Contacts controller.
 * @author Angel Cuenca
 */
class ContactsController extends Controller{

    /**
     * Index.
     */
    public function index() {
        $model = new ContactModel();

        //return $model
        //     ->select("id", "name")
        //     ->where("id", ">", 2)
        //     ->where("id", "<", 9)
        //     ->orderBy("id", "DESC")
        //     ->orderBy("id", "DESC")
        //     ->paginate(3);
        //     ->firts();

        if(isset($_GET["search"])) {
            $contacts = $model->where("name", "LIKE", "%" . $_GET["search"] . "%")->paginate(3);
        } else {
            $contacts = $model->paginate(3);            
        }

        return $this->view("contacts.index", compact("contacts"));
    }

    /**
     * Create.
     */
    public function create() {
        return $this->view("contacts.create");
    }

    /**
     * Store.
     */
    public function store() {
        $data = $_POST;
        $model = new ContactModel();
        $model->save($data);
        $this->redirect("/contacts");
    }

    /**
     * Show.
     */
    public function show($id) {
        $model = new ContactModel();
        $contact = $model->findById($id);        
        return $this->view("contacts.show", compact("contact"));
    }

    /**
     * Edit.
     */
    public function edit($id) {
        $model = new ContactModel();
        $contact = $model->findById($id);        
        return $this->view("contacts.edit", compact("contact"));
    }

    /**
     * Update.
     */
    public function update($id) {
        $data = $_POST;
        $model = new ContactModel();
        $model->update($id, $data);
        $this->redirect("/contacts/{$id}");
    }

    /**
     * Delete.
     */
    public function delete($id) {
        $model = new ContactModel();
        $model->delete($id);        
        return $this->redirect("/contacts");
    }
}

?>