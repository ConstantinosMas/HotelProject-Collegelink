<?php
// error_reporting(0);
require __DIR__ . '/../../boot/boot.php';

use app\hotel\User;

// Check if user is logged in
if (!empty(User::getCurrentUserId())) {
    header('Location: /public/assets/index.php');
    die;
}


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login_form.css">
</head>

<body>

    <?php include './header.php' ?>

    <div class="register-photo">
        <div class="form-container">
            <form method="post" action="/../public/actions/Login.php">
                <h2 class="text-center"><strong>Login</strong> to your account.</h2>
                <div class="form-group"><input class="form-control" id="email" type="email" name="email" required placeholder="Email"></div>

                <?php if ($_GET['emailNotFound']) { ?>
                    <h6 style="color:#f71100;">Email not found.</h6>
                <?php } ?>
 
                <div class="form-group"><input class="form-control" id="password" type="password" name="password" required placeholder="Password"></div>

                <?php if ($_GET['wrongPass']) { ?>
                    <h6 style="color:#f71100;">Wrong password! Please try again.</h6>
                <?php } ?>

                <div class="form-group">
                    <!-- <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div> -->
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div><a href="/public/assets/register.php" class="already">Not registered? Register here</a></form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
</body>

</html>