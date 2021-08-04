<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="container-fluid">
    <div class="main">
        <div class="row">
            <div class="col-md-4 mt-1">
                <div class="card text-center sidebar">
                    <div class="card-body">
                        <img src="<?php echo URLROOT; ?>/img/<?php echo $data['user_info']->img ?>" class="img-thumbnail">
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-1">
                <div class="card mb-3 content">
                    <h1 class="m-2 pt-3">About </h1>
                    <?php if($data['user_info']->id == $_SESSION['user_id']): ?>
                    <div class="col-md-12 text-secondary text-right">
                        <a href="<?php echo URLROOT; ?>/profile/edit" class = "col-md-12 glyphicon glyphicon-pencil"> </a>
                    </div>
                    <?php endif ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Full Name</h5>
                            </div>
                            <div class="col-md-9 text-secondary">
                                <h5><?php echo $data['user_info']->fname;?> <?php echo $data['user_info']->lname;  ?></h5>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Email</h5>
                            </div>
                            <div class="col-md-9 text-secondary">
                                <h5> <?php echo $data['user_info']->email; ?> </h5>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Phone</h5>
                            </div>
                            <div class="col-md-9 text-secondary">
                                <?php echo $data['user_info']->phone; ?>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <h5>Specializare</h5>
                            </div>
                            <div class="col-md-9 text-secondary">
                                <?php echo $data['user_info']->faculty;?> Anul <?php  echo $data['user_info']->year;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Social Media</h5>
                            </div>
                            <div class="col-md-9 text-secondary">
                                <a href="<?php echo $data['user_info']->social_media_link;?>" target="_blank"> <?php echo $data['user_info']->social_media_link;?> </a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
