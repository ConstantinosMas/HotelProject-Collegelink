<?php
error_reporting(0);
require __DIR__ . '/../../boot/boot.php';

use app\hotel\User;

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexTrip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font_general.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid test">
        <a class="navbar-brand" href="/public/assets/index.php">
                <img src="/public/assets/img/logo.png" style="border-radius:100%;height:40px;width:70px" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                <span style="color:#ff6427">N</span>ex<span style="color:#ff6427">T</span>rip
                </a> 
            <button style="color:white;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""><i class="fa-solid fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <?php if (User::getCurrentUserId()) { ?>
                        <li class="nav-item ms-auto">
                        <a class="nav-link" aria-current="page" href="/public/assets/profile.php"><i class="fa-solid fa-user"></i> Profile</a>
                        </li>
                    <?php } ?>

                    <?php if (User::getCurrentUserId()) { ?>
                        <li class="nav-item ms-auto">
                        <a class="nav-link" href="/public/assets/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                        </li>
                    <?php } ?>

                    <?php if (empty(User::getCurrentUserId())) { ?>
                        <li class="nav-item ms-auto">
                        <a class="nav-link" href="/public/assets/login.php"><i class="fa-solid fa-right-to-bracket"></i> Log In</a>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
        </div>
    </nav>    
    <div class="container" style="width:60%">           
        <hr id="fade">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
</body>

</html>