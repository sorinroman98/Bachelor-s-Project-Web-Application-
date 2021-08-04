<?php


class Chat extends Controller
{

    private $chatModel;
    private $userModel;
    public function __construct(){
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->chatModel = $this->returnmodel('ChatModel');
        $this->userModel = $this->returnmodel('User');
    }

    public function index(){
        if(!isLoggedIn()){
            redirect('users/login');
        }

        $user = $this->chatModel->userbyid($_SESSION['user_id']);
        $userList = $this->chatModel->getAllUsers();
        $data = [
            'user_info' => $user,
            'user_list' => $userList
        ];

        $this->returnview('chat/index', $data);
    }

    public function chat_info(){
        if(!isLoggedIn()){
            redirect('users/login');
        }

        $user = $this->chatModel->userbyid($_GET['user_id']);

        $data = [
            'user_info' => $user
        ];

        $this->returnview('chat/chat_info', $data);
    }

    public function curentChat(){

        if(!isLoggedIn()){
            redirect('users/login');
        }

        $flag_search= false;
        $search = "";
        if(isset($_GET['q'])){
            if($_GET['q'] != ""){
                $flag_search = true;
                $search = $_GET['q'];
            }
        }

            if($flag_search){
                $result = $this->chatModel->getSearchedUsers($search);
            }else{
                $result = $this->chatModel->getAllUsers();
            }


        echo $result;

        return $result;

    }


    public function insertChat(){

        if(!isLoggedIn()){
            redirect('users/login');
        }

        if($this->chatModel->isBlocked($_POST['outgoing_id'],$_POST['incoming_id']) == 1){
            redirect('chat/index');
        }else{
            if(trim($_POST['message']) !=''){
                $cheie_publica1 = $this->userModel->getPublicKey($_POST['incoming_id']);// luam chehia publica din baza de date a userului cu care vorbim
                $cheie_publica2 = $this->userModel->getPublicKey($_SESSION['user_id']);//luam cheia noastra din baza de date publica

                $mesaj_criptat_1 = encrypt_message($_POST['message'],$cheie_publica1->cheie_publica); // criptam mesajul cu cheia publica a userului cu care vorbim
                $mesaj_criptat_2 = encrypt_message($_POST['message'],$cheie_publica2->cheie_publica);// criptam mesajul cu cheia noastra publica

                $this->chatModel->insertMessage($_POST['outgoing_id'],$_POST['incoming_id'],$mesaj_criptat_1, $mesaj_criptat_2); // adaugam mesajele in baza de date
            }
        }

    }

    public function getChat(){

    if(!isLoggedIn()){
        redirect('users/login');
    }

        $result =  $this->chatModel->getMessage($_POST['outgoing_id'], $_POST['incoming_id']);
        echo $result;
}

    public function delete_conversation($incoming_id){

        if(!isLoggedIn()){
            redirect('users/login');
        }
        $outgoing_id = $_SESSION['user_id'];
        $this->chatModel->deleteConversation($outgoing_id,$incoming_id);

        $user = $this->chatModel->userbyid($_SESSION['user_id']);
        $data = [
            'user_info' => $user,
        ];

        $this->returnview('chat/index', $data);
    }

    public function block_user($outgoing_id){

        if(!isLoggedIn()){
            redirect('users/login');
        }

        $this->chatModel->blockUser($outgoing_id);

        $user = $this->chatModel->userbyid($_SESSION['user_id']);
        $data = [
            'user_info' => $user,
        ];

        $this->returnview('chat/index', $data);
    }
    public function unblock_user($outgoing_id){

        if(!isLoggedIn()){
            redirect('users/login');
        }

        $this->chatModel->unblockUser($outgoing_id);

        $user = $this->chatModel->userbyid($_SESSION['user_id']);
        $data = [
            'user_info' => $user,
        ];

        $this->returnview('chat/index', $data);

    }
    public function view_profile($incoming_id){

        if(!isLoggedIn()){
            redirect('users/login');
        }

        $user_info = $this->userModel->userbyid($incoming_id);
        $data =[
            'user_info'=> $user_info
        ];
        if($data['user_info']->profile_status == 1){

            $this->returnview('profile/index', $data);
        }else{
            $data=[
                'Description'=>"Profilul este privat"
            ];
            $this->returnview('profile/privat_profile', $data);
        }




    }

}