<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->returnmodel('User');

    }

    public function register()
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'faculty' => trim($_POST['faculty']),
                'phone' => trim($_POST['phone']),
                'year' => trim($_POST['year']),
                'type_of_study' => trim($_POST['type_of_study']),
                'img_name' => $new_img_name,
                'name_err' => '',
                'email_err' => '',
                'faculty_err' => '',
                'type_of_study_err' => '',
                'phone_err' => '',
                'year_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];


            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {

                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registred';
                }
            }


            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['faculty'])) {
                $data['faculty_err'] = 'Please chose faculty';
            }

            if (empty($data['year'])) {
                $data['year_err'] = 'Please chose year';
            }

            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone';
            }

            if (empty($data['type_of_study'])) {
                $data['type_of_study_err'] = 'Please chose type of study';
            }


            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } elseif ($data["password"] != $data["confirm_password"]) {
                $data['confirm_password_err'] = 'Password dosen\'t match ';
            }

            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err'])
                && empty($data['confirm_password_err']) && empty($data['faculty_err']) && empty($data['year_err'])
                        && empty($data['type_of_study_err']) && empty($data['phone_err'])){

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);


                if ($this->userModel->register($data)) {
                    if($this->userModel->insertUserInfo($data)){
                        $this->userModel->insertprivateKeyandPublic($data);
                       $this->userModel->creatUserPanel($data);
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    }
                    else{
                        die('something went wrong');
                    }
                }

            } else {
                $this->returnview('users/register', $data);
            }

        } else {


            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            $this->returnview('users/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if ($this->userModel->findUserByEmail($data['email'])) {
                if (empty($data['name_err']) && empty($data['password_err'])) {
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if ($loggedInUser) {
                        $this->createUserSession($loggedInUser);

                    } else {
                        $data['password_err'] = 'Password Incorect';

                        $this->returnview('users/login', $data);
                    }
                } else {
                    $this->returnview('users/login', $data);
                }
            } else {
                $data['email_err'] = 'No user found';
                $this->returnview('users/login', $data);
            }


        } else {

            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',

            ];

            $this->returnview('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $this->userModel->online_User($user->id);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_lvl'] = $user->privilege_level;
        $_SESSION['user_key'] =  $this->userModel->getUserKey($user->id)->privat_key;
        redirect('posts');

    }

    public function logout()
    {
        $this->userModel->offline_User($_SESSION['user_id']);
        session_unset();
        session_destroy();
        redirect('users/login');
    }



}
