<?php

require_once __DIR__.'/../../boot/boot.php';

use app\hotel\Booking;
use app\hotel\User;


$booking = new Booking();

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /public/assets/index.php');
    return;
}



if ($_REQUEST['userId']) {
    
    $csrf = $_REQUEST['csrf'];
    if (empty($csrf) || !User::verifyCsrf($csrf)) {
        return;
    }

    $booking->DeleteBooking($_REQUEST['userId'], $_REQUEST['bookingId']);
    header('Location: /public/assets/profile.php');
} else {
    header('Location: /public/assets/index.php');
}