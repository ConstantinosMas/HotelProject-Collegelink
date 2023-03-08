<?php

require_once __DIR__.'/../../boot/boot.php';

use app\hotel\User;


if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /public/assets/index.php?');
    return;
}



$user = new User();
$user->addNewUser($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);






