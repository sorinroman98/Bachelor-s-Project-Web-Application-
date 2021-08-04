<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findUserByEmail($email)
    {

        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind('email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {

        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function userbyid($id)
    {
        $this->db->query("SELECT * FROM users_info WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }


    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE email =:email");
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        $hased_password = $row->password;

        if (password_verify($password, $hased_password)) {

            return $row;
        } else {
            return false;
        }

    }

    public function getLastId(){


         $this->db->query("SELECT * FROM Users ORDER BY id DESC LIMIT 1");
        $row = $this->db->single();
        return $row->id+1;
    }

    public function register($data)
    {
        $id_user =  $this->getLastId();

        $this->db->query('INSERT INTO users (id,name,email,password,privilege_level) VALUES (:id,:name, :email, :password,"student")');
        $this->db->bind(':id',$id_user);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
           return true;
        } else {
            return false;
        }
    }

    public function insertUserInfo($data){
        $fullname = explode(" ", $data['name']);
        $id_user =  $this->getLastId()-1;
        $this->db->query('INSERT INTO users_info (id,fname,lname,faculty,year,phone,type_of_study,status,email,img,profile_status) VALUES 
                                                                                          (:id,:fname,:lname, :faculty, :year,:phone, :type_of_study, :status, :email,:img_name,:profile_status)');
        $this->db->bind(':id',$id_user);
        $this->db->bind(':fname', $fullname[0]);
        $this->db->bind(':lname', $fullname[1]);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':faculty', $data['faculty']);
        $this->db->bind(':year', $data['year']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':status', "Offline now");
        $this->db->bind(':type_of_study', $data['type_of_study']);
        $this->db->bind(':img_name', $data['img_name']);
        $this->db->bind(':profile_status', "0");


        if($this->db->execute()){
            return true;
        }else{
            return  false;
        }
    }

    public function creatUserPanel($data){
        $id_user =  $this->getLastId()-1;
        $this->db->query('INSERT INTO studentstatus (id,id_student,categorie,data_plata,nr_chitanta,nr_plati_restante) VALUES 
                                                                                          (:id,:id,:categorie, :data_plata, :chiatata, :nr_plati)');
        $this->db->bind(':id',$id_user);
        $this->db->bind(':categorie', "Taxa");
        $this->db->bind(':data_plata', "1004-0-0");
        $this->db->bind(':chiatata', "00000000");
        $this->db->bind(':nr_plati', 1);

        if($this->db->execute()){
            return true;
        }else{
            return  false;
        }
    }


    public function getUserKey($id){
        $this->db->query("SELECT * FROM cheiemsh WHERE id_user =:id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getPublicKey($id){
        $this->db->query("SELECT * FROM cheiepublicauser WHERE id_user =:id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function insertprivateKeyandPublic($data){
        $this->db->query("SELECT * FROM users WHERE email =:email");
        $this->db->bind(':email', $data['email']);
        $row = $this->db->single();
        $idd = $row->id;
        $data = generate_public_pvkey();

        $this->db->query("INSERT INTO cheiemsh(id_user,privat_key) VALUES (:id,:cheie)");
        $this->db->bind(':cheie', $data['pvKey'], PDO::PARAM_LOB);
        $this->db->bind(':id', $idd);


        if($this->db->execute()){
          $this->db->query("INSERT INTO cheiepublicauser(id_user,cheie_publica) VALUES (:id,:cheie)");
          $this->db->bind(':cheie', $data['pubKey'], PDO::PARAM_LOB);
            $this->db->bind(':id', $idd);
      if($this->db->execute()){
          return true;
      }else{
          return false;
      }
      }else{
          return false;
      }
    }



    public function updateUser($data){
        $this->db->query('UPDATE users_info SET fname = :fname, lname = :lname, phone = :phone, social_media_link = :social_media, profile_status = :profile_status,img = :img WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':fname', $data['fname']);
        $this->db->bind(':lname', $data['lname']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':img', $data['img_name']);
        $this->db->bind(':social_media', $data['social_media']);
        $this->db->bind(':profile_status', $data['profile_status']);
        $this->db->execute();

        $fname = $data['fname'];
        $lname = $data['lname'];
        $fname = $fname . " ";
        $fullname =$fname . $lname;
        $this->db->query('UPDATE users SET name = :fullname WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':fullname', $fullname);
        $this->db->execute();

        return true;

    }
    public function offline_User($id_user){
        $this->db->query('UPDATE users_info SET status ="Offline now" WHERE id = :id');
        $this->db->bind(':id', $id_user);
        $this->db->execute();
    }

    public function online_User($id_user){
        $this->db->query('UPDATE users_info SET status ="Online now" WHERE id= :id');
        $this->db->bind(':id', $id_user);
        $this->db->execute();
    }
}