<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
    <a class="navbar-brand" href="<?php echo URLROOT ?>"><?php echo SITENAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav navbar-left">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>">Home </a>
            </li>
            <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>/chat/index">Chat</a>
            </li>
            <?php endif;    ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>/pages/about">About</a>
            </li>

        </ul>

        <ul class="navbar-nav navbar-right" ">
            <?php if(isset($_SESSION['user_id'])) : ?>

                <?php if(($_SESSION['user_lvl']) == "admin") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT ?>/adminPanel/index">Panel </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT ?>/profile/index">Profile</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT ?>/profile/index   ">Welcome <?php echo $_SESSION['user_name']; ?> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT ?>/users/logout">Logout </a>
                </li>

            <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>/users/register">Register </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT ?>/users/Login">Login</a>
            </li>
            <?php endif;    ?>
        </ul>
    </div>
    </div>
</nav>