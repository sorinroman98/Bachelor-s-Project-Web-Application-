<?php

class Profile extends Controller{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->userModel = $this->returnmodel('User');
    }

    public function index()
    {
        $user_info = $this->userModel->userbyid($_SESSION['user_id']);

        $data =[
            'user_info'=> $user_info
        ];

        $this->returnview('profile/index', $data);
    }


    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if(isset($_FILES['image'])){
                $img_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];

                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);

                $extension = ['png','jpeg','jpg'];
                if(in_array($img_ext, $extension) === true){
                    $time = time();

                    $new_img_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name,"img/".$new_img_name)){

                    }else{
                        $new_img_name = null;
                    }
                }
            }

            $data = [
                'id' => $_SESSION['user_id'],
                'fname' => trim($_POST['fname']),
                'lname' => trim($_POST['lname']),
                'phone' =>$_POST['phone'],
                'img_name' => $new_img_name,
                'social_media' => $_POST['social_media'],
                'profile_status' => $_POST['profile_status']
            ];

            if ($this->userModel->updateUser($data)) {
                flash('post_message', 'User Updated');
                redirect('posts');
            } else {
                die('Something went wrong');
            }


        }else{
            $user_info = $this->userModel->userbyid($_SESSION['user_id']);

            $data =[
                'user_info'=> $user_info
            ];

            $this->returnview('profile/edit', $data);
        }

    }
}
