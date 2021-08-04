
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
    <section class="chat-area">
        <header>

            <a href="<?php echo URLROOT;?>/chat/index" class="back-icon"><i class="fas fa-arrow-left"></i></a>

            <img src="<?php echo URLROOT; ?>/img/<?php echo $data['user_info']->img ?>" alt="">
            <div class="details">
                <span><?php echo $data["user_info"]->fname; ?> <?php echo $data["user_info"]->lname; ?></span>
                <p><?php echo $data["user_info"]->status; ?></p>
            </div>

            <div class="btn-group ">
                    <button id="dropdown-chat" role="button" type="button" class="btn dropdown" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
                </button>
                <div class="dropdown-menu ">
                    <a class="dropdown-item" href="<?php echo URLROOT ?>/chat/view_profile/<?php echo $data["user_info"]->id;?>">View Profile</a>
                    <a class="dropdown-item" href="<?php echo URLROOT ?>/chat/delete_conversation/<?php echo $data["user_info"]->id;?>">Delete Conversation</a>
                    <a class="dropdown-item" href="<?php echo URLROOT ?>/chat/block_user/<?php echo $data["user_info"]->id;?>">Block</a>
                    <a class="dropdown-item" href="<?php echo URLROOT ?>/chat/unblock_user/<?php echo $data["user_info"]->id;?>">UnBlock</a>
                </div>
            </div>
        </header>

        <div class="chat-box">

        </div>
        <form method="post" class="typing-area" autocomplete="off">
            <input type="text" name="outgoing_id" value="<?php echo $_SESSION['user_id'];?>" hidden>
            <input type="text" name="incoming_id" value="<?php echo $data["user_info"]->id;?>" hidden>
            <input type="text" name="message"     class="input-field" placeholder="Type a message here...">
            <button><i class="fab fa-telegram-plane"></i></button>
        </form>
    </section>
</div>
<script src="<?php echo URLROOT; ?>/js/chat.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>