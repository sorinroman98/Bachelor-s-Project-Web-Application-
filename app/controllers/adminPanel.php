<?php

class adminPanel extends Controller {
    public function __construct(){
        $this->modelAdmin = $this->returnmodel('adminPanelModel');
    }

    public function index(){
        if(!isLoggedIn() && $_SESSION['user_lvl'] != "admin" || $_SESSION['user_lvl'] != "admin" ){
            redirect('posts');
        }


        $userlist = $this->modelAdmin->getUsers();

        $data = [
            'users' => $userlist
        ];

        $this->returnview('adminPanel/index', $data);
    }

    public function edit(){

        $data = [
            'id'    => $_POST['id'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'Categorie' => $_POST['Categorie'],
            'Data_plata' => $_POST['Data_plata'],
            'Nr_chitanta' => $_POST['Nr_chitanta'],
            'Nr_plati_restante' => $_POST['Nr_plati_restante']
        ];

            $this->modelAdmin->editUser($data);



        echo json_encode($_POST['id']);

    }



}