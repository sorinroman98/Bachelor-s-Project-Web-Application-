<?php

class adminPanelModel
{
    private $db;
    private $db2;
    public function __construct()
    {
        $this->db = new Database();
        $this->db2 = new Database();

    }
    public function getUsers()
    {
        $this->db->query('SELECT * ,
                                    users_info.fname as fname,
                                    users_info.lname as lname,
                                    studentstatus.id as id,
                                    studentstatus.categorie as Categorie,
                                    studentstatus.nr_chitanta as Nr_chitanta,
                                    studentstatus.nr_plati_restante as Nr_plati_restante,
                                    studentstatus.data_plata as Data_plata
                                    FROM users_info 
                                        INNER JOIN studentstatus
                                    ON users_info.id  = studentstatus.id_student
                                    ORDER BY studentstatus.id ASC 
                                    ');

        $results = $this->db->resultSet();


        return $results;
    }

    public function editUser($data){


        $this->db->query('UPDATE studentstatus SET categorie = :categorie, data_plata = :data_plata,nr_chitanta = :nr_chitanta,nr_plati_restante=:nr_plati_restante  WHERE id= '.$data["id"].' ');
        //$this->db->bind(':id', $data["id"]);
        $this->db->bind(':categorie', $data["Categorie"]);
        $this->db->bind(':data_plata', $data["Data_plata"]);
        $this->db->bind(':nr_chitanta', $data["Nr_chitanta"]);
        $this->db->bind(':nr_plati_restante', $data["Nr_plati_restante"]);

        if ($this->db->execute()) {

            $this->db2->query('UPDATE users_info SET fname=:fname, lname=:lname WHERE id=:id ');
            $this->db2->bind(':id', $data["id"]);
            $this->db2->bind(':fname', $data["fname"]);
            $this->db2->bind(':lname', $data["lname"]);
            if($this->db2->execute()){
                return true;
            }else{
                return false;
            }
            return true;
        } else {
            return false;
        }


    }

}