<?php


class ChatModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function userbyid($id)
    {
        $this->db->query("SELECT * FROM users_info WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

    public function getAllUsers()
    {
        $user_id = $_SESSION['user_id'];
        $stmt = $this->db->queryReturn("SELECT * FROM users_info WHERE NOT id ={$user_id}");
        $stmt->execute();
        $output = "";
        $result = "";
        if ($this->db->rowCount() == 1) {
            $output .= "No users are avabile to chat";
        } elseif ($this->db->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $stmt2 = $this->db->queryReturn("SELECT * FROM messages WHERE (incoming_msg_id = :user_id OR
                                                    outgoing_msg_id = :user_id) AND (outgoing_msg_id = :outgoing_id OR
                                                    incoming_msg_id = :outgoing_id) ORDER BY msg_id DESC LIMIT 1");
                $this->db->bind(':user_id', $row['id']);
                $this->db->bind(':outgoing_id', $user_id);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($row2 && $row2["is_deleted"] != $_SESSION['user_id']) {
                    if($user_id == $row2['incoming_msg_id']){
                        $msj_decriptat = decrypt_message($row2['msg1'], $_SESSION['user_key'] );
                    }else{
                        $msj_decriptat = decrypt_message($row2['msg'], $_SESSION['user_key'] );
                    }
                    $result = $msj_decriptat;
                } else {
                    $result = "No message available ";
                }

                (strlen($result) > 28) ? $msg = substr($result, 0, 28) . '...' : $msg = $result;
                ($result == "No message available ")?$you = "" : ($user_id == $row2['incoming_msg_id']) ? $you = "You: " : $you = "";;

                ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

                $output .= '<a href= ' . URLROOT . "/chat/chat_info?user_id=" . $row['id'] . '>
                <div class="content">
                    <img src="' . URLROOT . '/img/' . $row['img'] . ' " alt="">
                    <div class="details">
                        <span>' . $row['fname'] . ' ' . $row['lname'] . '</span>
                        <p>' . $you . $result . '</p>
                    </div>
                </div>
                <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
            </a>';
            }

        }

        return $output;
    }


    public function getSearchedUsers($search)
    {
        $user_id = $_SESSION['user_id'];
        $stmt = $this->db->queryReturn("SELECT * FROM users_info WHERE NOT id ={$user_id} AND(fname LIKE '%$search%' OR lname LIKE '%$search%')");

        $stmt->execute();
        $output = "";
        $result = "";
        if ($this->db->rowCount() < 1) {
            $output .= "No users are avabile to chat";
        } elseif ($this->db->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $stmt2 = $this->db->queryReturn("SELECT * FROM messages WHERE (incoming_msg_id = :user_id OR
                                                    outgoing_msg_id = :user_id) AND (outgoing_msg_id = :outgoing_id OR
                                                    incoming_msg_id = :outgoing_id) ORDER BY msg_id DESC LIMIT 1");
                $this->db->bind(':user_id', $row['id']);
                $this->db->bind(':outgoing_id', $user_id);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($row2) {
                    $result = $row2['msg'];
                } else {
                    $result = "No message available ";
                }

                (strlen($result) > 28) ? $msg = substr($result, 0, 28) . '...' : $msg = $result;
                ($user_id == $row2['incoming_msg_id']) ? $you = "You: " : $you = "";

                ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

                $output .= '<a href= ' . URLROOT . "/chat/chat_info?user_id=" . $row['id'] . '>
                <div class="content">
                    <img src="' . URLROOT . '/img/' . $row['img'] . ' " alt="">
                    <div class="details">
                        <span>' . $row['fname'] . ' ' . $row['lname'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                </div>
                <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
            </a>';


            }
        }
        return $output;
    }


    public function insertMessage($incoming_id, $outgoing_id, $message, $message1)
    {
        $this->db->query('INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, msg1) VALUES (:incoming_id,:outgoing_id,:message, :message1)');
        $this->db->bind(':incoming_id', $incoming_id);
        $this->db->bind(':outgoing_id', $outgoing_id);
        $this->db->bind(':message', $message);
        $this->db->bind(':message1', $message1);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessage($incoming_id, $outgoing_id)
    {
        $output = "";
        $id = $_SESSION['user_id'];
        $cheie_privata = $_SESSION['user_key'];
        $stmt = $this->db->queryReturn("SELECT * FROM messages WHERE 
                             (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                          OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id");
        $stmt->execute();
        $stmt2 = $this->db->queryReturn("SELECT * FROM users_info WHERE id ={$outgoing_id}");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($this->db->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if($row["is_deleted"] != $id){

                    if ($row['outgoing_msg_id'] === $outgoing_id) {

                        $msj_decriptat = decrypt_message($row['msg1'], $cheie_privata );
                        $output .= '<div class="chat outgoing">
                          <div class="details">
                                <p>' . $msj_decriptat. '</p>
                          </div>
                          </div>';

                    } else {
                        $mesaj_decriptat = decrypt_message($row['msg'], $cheie_privata);
                        $output .= '<div class="chat incoming">
                          <img src="' . URLROOT . '/img/' . $row2['img'] . '" alt="">
                          <div class="details">
                                <p>' . $mesaj_decriptat . '</p>
                          </div>
                          </div>';
                    }
                }
            }
            echo $output;
        }
    }

/*
    public function serachMsh($incoming_id, $outgoing_id, $msgToSearch)
    {
        $output = "";

        $stmt = $this->db->queryReturn("SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                          OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) AND msg LIKE '%$msgToSearch%' ORDER BY msg_id");
        $stmt->execute();
        $stmt2 = $this->db->queryReturn("SELECT * FROM users_info WHERE id ={$outgoing_id}");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($this->db->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['outgoing_msg_id'] === $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                          <div class="details">
                                <p>' . $row['msg'] . '</p>
                          </div>
                          </div>';

                } else {

                    $output .= '<div class="chat incoming">
                          <img src="' . URLROOT . '/img/' . $row2['img'] . '" alt="">
                          <div class="details">
                                <p>' . $row['msg'] . '</p>
                          </div>
                          </div>';
                }

            }
            echo $output;
        }
    }
*/

    public function deleteConversation($incoming_id, $outgoing_id)
    {

        $stmt = $this->db->queryReturn("SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                          OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['is_deleted'] == NULL) {

                $this->db->query('UPDATE messages SET is_deleted=:id_user WHERE msg_id = :msg_id ');
                $this->db->bind(':id_user', $_SESSION['user_id']);
                $this->db->bind(':msg_id', $row["msg_id"]);
                $this->db->execute();

            } else if($row['is_deleted'] != $_SESSION['user_id']) {

                $this->db->query('DELETE FROM messages WHERE msg_id = :msg_id ');
                $this->db->bind(':msg_id', $row['msg_id']);

               $this->db->execute();
            }
        }
        return true;

    }

    public function blockUser($outgoing_id){
        $bool = false;
        $stmt = $this->db->queryReturn("SELECT * FROM user_blocked");
        $stmt->execute();
        if ($this->db->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($row['user1_id'] == $_SESSION['user_id'] && $row['user2_id'] == $outgoing_id){
                    $bool = true;
                }
            }
        }
        if($bool){
            $this->db->query('UPDATE user_blocked SET is_block=:is_blocked WHERE user1_id=:id_user1 AND user2_id=:id_user2');
            $this->db->bind(':id_user1', $_SESSION['user_id']);
            $this->db->bind(':id_user2', $outgoing_id);
            $this->db->bind(':is_blocked', 1);
            $this->db->execute();
        }else{
            $this->db->query('INSERT INTO user_blocked (user1_id,user2_id,is_block) VALUES (:id_user1, :id_user2, :is_blocked)');
            $this->db->bind(':id_user1', $_SESSION['user_id']);
            $this->db->bind(':id_user2', $outgoing_id);
            $this->db->bind(':is_blocked', 1);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function unblockUser($outgoing_id){
        $bool = false;
        $stmt = $this->db->queryReturn("SELECT * FROM user_blocked");
        $stmt->execute();
        if ($this->db->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($row['user1_id'] == $_SESSION['user_id'] && $row['user2_id'] == $outgoing_id){
                    $bool = true;
                }
            }
        }else{
            return "User is not was blocked!";
        }
        if($bool){
            $this->db->query('UPDATE user_blocked SET is_block=:is_blocked WHERE user1_id = :id_user1 AND user2_id = :id_user2');
            $this->db->bind(':id_user1', $_SESSION['user_id']);
            $this->db->bind(':id_user2', $outgoing_id);
            $this->db->bind(':is_blocked', 0);
            $this->db->execute();
        }else{
            return "User is not was blocked!";
        }

    }

    public function isBlocked($incoming_id, $outgoing_id){
        $stmt = $this->db->queryReturn("SELECT * FROM user_blocked WHERE (user1_id = {$outgoing_id} AND user2_id = {$incoming_id})
                          OR (user1_id = {$incoming_id} AND user2_id = {$outgoing_id})");
        $stmt->execute();
        if ($this->db->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($row['is_block'] == 1){
                    return 1;
                }
            }
        }
        return 0;
    }

    public function getUserKey($id){
        $this->db->query("SELECT * FROM cheiemsh WHERE id =:id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return row;
    }




}