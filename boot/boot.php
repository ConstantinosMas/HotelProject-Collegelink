<?php
error_reporting(E_ERROR);

header('Access-Control-Allow-Origin: *');

spl_autoload_register(function ($class) {
    $class = str_replace('\\', "/", $class);
    require_once sprintf(__DIR__.'/../%s.php', $class);
});

use app\hotel\User;

$user = new User();
$userToken = $_COOKIE['user_token'];
if ($userToken) {
    if ($user->verifyToken($userToken)) {
        $userInfo = $user->getTokenPayload($userToken);
        User::setCurrentUserId($userInfo['user_id']);
    }
}