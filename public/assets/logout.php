<?php

require __DIR__ . '/../../boot/boot.php';

use app\hotel\User;

if (empty(User::getCurrentUserId())) {
    header('Location: /public/assets/index.php');
}

User::setCurrentUserId(0);
unset($_COOKIE['user_token']);
setcookie('user_token', '', time() - 3600, '/');
header('Location: /public/assets/index.php');
