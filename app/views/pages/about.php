<?php require APPROOT . '/views/inc/header.php'; ?>
    <h1> <?php if (isset($data)) {
            echo $data['title'];
        } ?> </h1>
        <p><?php echo $data['description'];?></p>
        <p>Version: <strong><?php echo APPVERSION?></strong></p>
<?php require APPROOT . '/views/inc/footer.php'; ?>