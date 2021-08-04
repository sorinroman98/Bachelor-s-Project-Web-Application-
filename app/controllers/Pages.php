<?php

class Pages extends Controller {
    public function __construct(){

    }

    public function index(){
        if(isLoggedIn()){
            redirect('posts');
        }
        $data = [
            'title' => 'Welcome',
            'description' => 'Social Media'
        ];

        $this->returnview('pages/index', $data);
    }

    public function about(){
        $data =[
            'title'=>'About Us',
            'description' => 'App build on php'
        ];
        $this->returnview('pages/about',$data );
    }

    public function adminPanel(){
        $data=[
            'title'=>'admin'
        ];
        $this->returnview('pages/adminPanel',$data);
    }

}