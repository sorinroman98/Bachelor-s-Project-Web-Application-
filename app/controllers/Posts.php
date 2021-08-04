<?php

class Posts extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->returnmodel('Post');
        $this->userModel = $this->returnmodel('User');
    }

    public function index()
    {

        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];

        $this->returnview('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(isset($_POST['checkboxAnounce'])){
                $anounce = 1;
            }
            else{
                $anounce = 0;

            }
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $new_img_name ="not_Set";
            if(isset($_FILES['imagePosts'])){
                $img_name = $_FILES['imagePosts']['name'];
                $tmp_name = $_FILES['imagePosts']['tmp_name'];

                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);

                $extension = ['png','jpeg','jpg'];
                if(in_array($img_ext, $extension) === true){
                    $time = time();

                    $new_img_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name,"img/".$new_img_name)){
                        $new_img_name = $time.$img_name;
                    }else{
                        $new_img_name="not_Set";
                    }
                }
             }else{
                $new_img_name="not_Set";
            }



            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'img_name' => $new_img_name,
                'anounce' => $anounce,
                'title_err' => '',
                'body_err' => ''
            ];


            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please fill the body';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {

                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post Added');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->returnview('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->returnview('posts/add', $data);
        }

    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $new_img_name ="not_Set";
            if(isset($_FILES['imagePosts'])){
                $img_name = $_FILES['imagePosts']['name'];
                $tmp_name = $_FILES['imagePosts']['tmp_name'];

                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);

                $extension = ['png','jpeg','jpg'];
                if(in_array($img_ext, $extension) === true){
                    $time = time();

                    $new_img_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name,"img/".$new_img_name)){
                        $new_img_name = $time.$img_name;
                    }else{
                        $new_img_name="";
                    }
                }
            }else{
                $new_img_name="not_Set";
            }

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'privilege_level' => $_SESSION['privilege_level'],
                'img_name' => $new_img_name,
                'title_err' => '',
                'body_err' => ''
            ];


            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please fill the body';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {


                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post Updated');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->returnview('posts/edit', $data);
            }

        } else {

            $post = $this->postModel->getPostById($id);
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
                'img' => $post->img
            ];
            $this->returnview('posts/edit', $data);
        }

    }


    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $user_inf = $this->userModel->getUserById($_SESSION['user_id']);

        $data = [
            'post' => $post,
            'user' => $user,
            'user_inf'=>$user_inf
        ];

        $this->returnview('posts/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->postModel->getPostById($id);

            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die("Something went wrong");
            }
        } else {
            redirect('posts');
        }
    }

}