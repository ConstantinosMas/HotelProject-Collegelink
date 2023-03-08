<?php

require __DIR__ . '/../../boot/boot.php';

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");


use app\hotel\Booking;
use app\hotel\User;
use app\hotel\Favorite;
use app\hotel\Review;

if (empty(User::getCurrentUserId())) {
    header('Location: /public/assets/login.php');
    return;
}

$userId = User::getCurrentUserId();

$booking = new Booking();
$review = new Review();
$favorite = new Favorite();

$userBookings = $booking->getBookings($userId);
$userReviews = $review->getUserReviews($userId);
$userFavorites = $favorite->getUserFavorites($userId);
$today = new DateTime();

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

    <?php include './header.php' ?>

    <div class="container parent-div" style="max-width:55%">

        <div class="row">
         <div class="col-lg-3">
            <div class="favorites fav-rev">
                <h2> Favorites </h2>

                <?php if (empty($userFavorites)) { ?>
                    <h5 style="color:rgba(0, 0, 0, 0.308)"> You dont have any favorites.</h5>
                <?php } ?>

                <ul style="list-style:none;">
                    <?php foreach ($userFavorites as $index => $favorite) { ?>
                        <li><h5> <a href="/public/assets/room.php?roomId=<?php echo $favorite['room_id'] ?>"><?php echo sprintf('%s. %s', $index + 1, $favorite['name']) ?> </a></h5> </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="reviews fav-rev">
                <h2> Reviews </h2>

                <?php if (empty($userReviews)) { ?>
                    <h5 style="color:rgba(0, 0, 0, 0.308)"> You dont have any reviews.</h5>
                <?php } ?>

                <ul id="reviewsList" style="list-style:none;">
                    <?php foreach ($userReviews as $index => $review) { ?>
                        <li class="review-li">
                            <h5><a href="/public/assets/room.php?roomId=<?php echo $review['room_id'] ?>"><?php echo sprintf('%s. %s', $index + 1, $review['name']) ?> </a></h5> 
                            <h5 style="display:inline-block;"><?php for ($i = 0; $i < $review['rate']; $i++) { ?> <i class="fa-solid fa-star fa-lg"></i> <?php } ?> </h5>
                            <h5 style="display:inline-block;"><?php for ($i = 0; $i < 5 - $review['rate']; $i++) { ?> <i class="fa-regular fa-star fa-lg"></i> <?php } ?> </h5>
                        </li>
                    <?php } ?>
                </ul>
                
                <?php if (count($userReviews) == 4) { ?>
                    <div class="container text-center">
                    <form class="loadReviews" action="/../public/assets/profile.php">
                        <input class="resultsNumber" type="hidden" name="nrOfResults" value="0">
                        <button type="submit" class="btn btn-primary showmore"><i class="fa-solid fa-caret-down"></i> Show more</button>
                    </form>
                </div>

                <?php } ?>
                
            </div>

            </div>

        <div class="col-lg-9">
                <div class="container my-bookings"> 
                    <h2>My bookings</h2>
                </div>

                <?php if (empty($userBookings)) { ?>
                    <div class="no-results container text-center">
                        <i class="fa-solid fa-mountain-city"></i>
                        <h3>You have no bookings.. <em>Yet!</em></h3>
                    </div>

                <?php } ?>

             <ul class="room-list">

            <?php foreach ($userBookings as $booking) { ?>
        
                <li style="<?php 
                    $checkoutDT = new DateTime($booking['check_out_date']);
                    if ($today > $checkoutDT) { ?>
                        background:#d2e1f34f;border-radius:5px;
                    <?php } ?>">
                    <div class="img-box">
                    <a href="/public/assets/room.php?roomId=<?php echo $booking['room_id'] ?>" >
                        <img src="/public/assets/img/rooms/<?php echo $booking['photo_url'] ?>" height="160" alt="room" />
                    </a>
                    </div>

    
                    <div class="container-fluid details">                        
                        <h2><?php echo $booking['name'] ?></h2>
                        <h6><i class="fa-solid fa-location-dot"></i><?php echo sprintf('%s, %s', strtoupper($booking['city']), strtoupper($booking['area'])) ?></h6>
                        <p><?php echo $booking['description_short'] ?></p>
                        
                        <div class="container room-btn">               
                                <a href= "/public/assets/room.php?roomId=<?php echo $booking['room_id'] ?>"> <button type="submit" class="btn btn-primary gotoroom">Go to room page</button></a>
                        </div>             
                    </div>

                    <div class="container about-booking">
                        <div class="price">
                            <h5><?php echo sprintf('Total price: %s€', $booking['total_price']) ?></h5>
                        </div>

                        <div class="dates">
                            <h5><?php echo sprintf('Check-in Date: %s | Check-out Date: %s', $booking['check_in_date'], $booking['check_out_date']) ?></h5>
                        </div>
                    </div>
                    <hr> 
                </li>

            <?php } ?>

    </ul>
            </div> 

        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
    <script src="profReviews.js"></script>

</body>

</html>