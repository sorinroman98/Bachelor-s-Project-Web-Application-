
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
    <section class="users">
        <header>
            <div class="content">
            <img src="<?php echo URLROOT; ?>/img/<?php echo $data['user_info']->img ?>" alt="">
                <div class="details">
                    <span><?php echo $data["user_info"]->fname; ?> <?php echo $data["user_info"]->lname; ?></span>
                    <p> <?php echo $data["user_info"]->status; ?></p>
                </div>
            </div>
        </header>
        <div class="search">
            <span class="text">Select an users to start chat</span>
            <input type="text" placeholder="Enter a name to search...">
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">

        </div>
    </section>
</div>

<script src="<?php echo URLROOT; ?>/js/user.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>