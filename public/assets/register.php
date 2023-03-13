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
    <link rel="stylesheet" href="css/font_general.css">
    <link rel="stylesheet" href="css/register_form.css">
</head>

<body>

    <?php include './header.php' ?>

    <div class="register-photo">
        <div class="form-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-holder slider">
                    </div>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="/../public/actions/Register.php">
                        <h2 class="text-center"><strong>Create</strong> an account.</h2>
                        <div class="form-group"><input class="form-control" id="name" type="text" name="name" placeholder="Your Name" required value="<?php echo $_GET['currentName'] ?>"></div>
                        <div class="form-group"><input class="form-control" id="email" type="email" name="email" placeholder="Email" required value="<?php echo $_GET['currentEmail'] ?>"></div>
                        <?php if ($_GET['registerError']) { ?> <h6 style="color:red;"> Email already exists.</h6> <?php } ?>    
                        <div class="form-group"><input class="form-control" id="password" type="password" name="password" required placeholder="Password"></div>
                        <p class="pass-warning hidden" style="color:rgb(255, 192, 56);font-size:13px"><i class="fa-solid fa-circle-exclamation"></i> Password must have at least 8 characters, and contain one or more numbers</p>
                        <div class="form-group"><input class="form-control pass-confirm" disabled id="password-confirm" type="password" name="password" required placeholder="Re-type Password"></div>
                        <p class="passwords-warning hidden" style="color:red;"><i class="fa-solid fa-circle-exclamation"></i> Passwords must match</p>
                        <div class="form-group">
                            <!-- <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div> -->
                        </div>
                        <div class="form-group"><button class="btn btn-primary btn-block disabled" type="submit">Sign Up</button></div><a href="/public/assets/login.php" class="already">You already have an account? Login here.</a></form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
    <script src="register.js"></script>
</body>

</html>