<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container bootstrap snippets bootdey">
    <h1 class="text-primary"><span class="glyphicon glyphicon-user"></span>Edit Profile</h1>
    <hr>
    <div class="row">

        <form action="<?php echo URLROOT; ?>/Profile/edit" method="post" class="form-horizontal"  role="form"  enctype="multipart/form-data">
        <div class="col-md-3">
            <div class="text-center">
                <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                <h6>Upload a different photo...</h6>

                <input type="file" name="image" class="form-control">
            </div>
        </div>


        <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                Chane you'r  <strong>profile information</strong>
            </div>
            <h3>Personal info</h3>

                <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="fname" type="text" value="<?php echo $data['user_info']->fname; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="lname" type="text" value="<?php echo $data['user_info']->lname; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Phone:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="phone" type="text" placeholder="07" value="<?php echo $data['user_info']->phone; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Social Media:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="social_media" type="text" placeholder="ex. www.facebook.com/your_account_name"  value="<?php echo $data['user_info']->social_media_link; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Profile Status:</label>
                    <div class="col-md-7">
                        <select class="form-control" name="profile_status" style="width:auto;">
                            <option value="1">Public</option>
                            <option value="0">Private</option>
                        </select>
                    </div>


                <input type="submit" class="btn btn-success" value="Submit">
            </form>
        </div>
    </div>
</div>
<hr>
<?php require APPROOT . '/views/inc/footer.php'; ?>
