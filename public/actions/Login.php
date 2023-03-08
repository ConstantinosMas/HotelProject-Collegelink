<?php

require_once __DIR__.'/../../boot/boot.php';

use app\hotel\User;


if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /public/assets/index.php');
    return;
}

$user = new User();
if($userInfo = $user->getByEmail($_REQUEST['email'])) {
    if($user->verifyPass($_REQUEST['email'], $_REQUEST['password'])) {
        $user->establishCurrentUser($userInfo);
        // $token = $user->generateToken($userInfo['user_id']);
        // setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');
        // User::setCurrentUserId($userInfo['user_id']);
        // header('Location: /public/assets/index.php');
    }

    else {
        $passError = [
            'wrongPass' => true
        ];
        header('Location: /public/assets/login.php?' . http_build_query($passError));
    }
}
else {

    $emailError = [
        'emailNotFound' => true
    ];
    header('Location: /public/assets/login.php?' . http_build_query($emailError));
    

}