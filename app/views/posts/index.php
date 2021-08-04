<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>

<div class="row mb-3">
    <div class="col-md-4">
        <h1>Post</h1>
    </div>


    <div class="col-md-8">
        <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i>Add Post
        </a>
    </div>
</div>

<?php foreach($data['posts'] as $post) : ?>

    <div class="card card-body mb-3">
        <h4 class="card-title text-center"> <?php echo $post->title; ?> </h4>
        <div class="bg-light p-2 mb-3 text-right">
            Written by <?php echo $post->name; ?> on <?php echo $post->postCreated;  ?>
        </div>
        <p class="card-text text-left ml-5"><?php echo $post->body; ?> </p>

        <?php  if( $post->imagepost  != "not_Set"):?>
        <img src="<?php echo URLROOT; ?>/img/<?php echo $post->imagepost ?>" class="img-thumbnail img-fluid mx-auto d-block" alt="">
        <?php endif ?>
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">More</a>
    </div>

    <?php endforeach;
 ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>

