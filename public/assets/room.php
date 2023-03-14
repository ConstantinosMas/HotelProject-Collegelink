<?php
require __DIR__ . '/../../boot/boot.php';

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");

use app\hotel\Booking;
use app\hotel\Room;
use app\hotel\Favorite;
use app\hotel\Review;
use app\hotel\User;

$room = new Room();
$favorite = new Favorite();
$review = new Review();
$booking = new Booking();

$currentRoom = $room->getRoomById($_REQUEST['roomId']);
if (empty($currentRoom)) {
    header('Location: index.php');
    die;
}
$roomReviews = $review->getReviews($_REQUEST['roomId']);
$avgRoomRating = round($currentRoom['avg_reviews']);
$remainingStars = 5 - $avgRoomRating;

$userId = User::getCurrentUserId();



$roomIsFav = $favorite->checkFavorite($userId, $_REQUEST['roomId']);
$alreadyBooked = empty($_REQUEST['checkin']) || empty($_REQUEST['checkout']);
if (!$alreadyBooked) {
    $alreadyBooked = $booking->checkRoomAvailibility($_REQUEST['roomId'], $_REQUEST['checkin'], $_REQUEST['checkout'] ); // If the function returns true, its booked; if false, its available
}

$roomPrice = $currentRoom['price'];
$checkinDateTime = new DateTime($_REQUEST['checkin']);
$checkoutDateTime = new DateTime($_REQUEST['checkout']);
$daysDiff = $checkoutDateTime->diff($checkinDateTime)->days;
$totalPrice = $roomPrice * $daysDiff;

$roomLat = $currentRoom['location_lat'];
$roomLong = $currentRoom['location_long'];


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Page - NexTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="css/font_general.css">
    <link rel="stylesheet" href="css/room.css">
</head>

<body>


    <?php include './header.php'
    ?>

    <div class="container-fluid"> 
        <div class="container top-bar">
            <section style="display:inline-block" class="top-rating">
                <h3 class="top-details"><?php echo $currentRoom['name'].' -'; echo ' '.$currentRoom['city'].','; echo ' '.$currentRoom['area'].' | ' ?></h3>
                <h3 class="top-details"><?php for ($i = 0; $i < $avgRoomRating; $i++) { ?> <i class="fa-solid fa-star" style="color:rgb(255, 153, 0)"></i> <?php } ?> </h3>
                <h3 class="top-details"><?php for ($i = 0; $i < $remainingStars; $i++) { ?> <i class="fa-solid fa-star" style="color:white"></i> <?php } ?> | </h3>            
            </section>
            <section style="display:inline-block" class="favoriteButton">
                <?php if ($userId) { ?>
                <form class="favoriteForm" action="/../public/actions/Favorites.php" method="post">
                    <input type="hidden" name="isFav" value="<?php echo $roomIsFav ?>">
                    <input type="hidden" name="userId" value="<?php echo $userId ?>">
                    <input type="hidden" name="roomId" value="<?php echo $currentRoom['room_id'] ?>">
                    <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                    <button type="submit" role="button">
                    <i class="fa-heart fa-xl fa-solid" style="<?php echo $roomIsFav ? 'color:#f00000;' : 'color:white;' ?>"></i>        
                    </button>
                </form>

                <?php } ?>

            </section>
            </h2> 
            <h4 class="per-night"><?php echo 'Per Night: '.$currentRoom['price'].'€' ?></h4>
        </div>
        <div class="container img-box">
            <img src="/public/assets/img/rooms/<?php echo $currentRoom['photo_url']?>" style="max-width: 500px;"/>
        </div>
        <div class="container details-bar"> 
            <div class="row">

                <div class="col-lg-3 col-md-6"> 
                    <div class="container text-center dottedborder">
                        <i class="fa-solid fa-user"></i> <h6><?php echo $currentRoom['count_of_guests'] ?></h6>
                        <h5>COUNT OF GUESTS</h5> 
                    </div>
                </div>

                <div class="col-lg-3 col-md-6"> 
                    <div class="container text-center dottedborder">
                        <i class="fa-solid fa-bed"></i> <h6>Single</h6>
                        <h5>ROOM TYPE</h5> 
                    </div>
                </div>

                <div class="col-lg-2 col-md-4"> 
                    <div class="container text-center dottedborder">
                        <i class="fa-solid fa-square-parking"></i> <h6>
                        <?php if ($currentRoom['parking'] == 1) {echo 'Yes';} else {echo 'No';}?></h6> 
                        <h5>PARKING</h5> 
                    </div>
                </div>

                <div class="col-lg-2 col-md-4"> 
                    <div class="container text-center dottedborder">
                        <i class="fa-solid fa-wifi"></i> <h6>
                        <?php if ($currentRoom['wifi'] == 1) {echo 'Yes';} else {echo 'No';}?></h6> 
                        <h5>WIFI</h5> 
                    </div>
                </div>

                <div class="col-lg-2 col-md-4"> 
                    <div class="container text-center">
                        <?php
                        if ($currentRoom['pet_friendly'] == 1) { ?>
                            <i class="fa-solid fa-face-smile"></i>
                        <?php } else { ?> <i class="fa-solid fa-face-frown-open"></i> 
                        <?php } ?> 
                        <h5>PET FRIENDLY</h5> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container description">
            <h4> Room Description </h4>
            <p><?php echo $currentRoom['description_long'] ?> </p>
        </div>

        <?php if (!empty($_REQUEST['checkin']) and !empty($_REQUEST['checkout'])) { ?>

        <div class="container reservation">      
            <div class="d-flex flex-row res-dates">
                <i class="fa-regular fa-calendar"></i>
                <p>Selected Dates: <b><?php echo $_REQUEST['checkin']?></b> to <b><?php echo $_REQUEST['checkout']?></b></p>
            </div>

            <div class="d-flex flex-row res-nights">
                <i class="fa-regular fa-moon"></i>
                <p><b><?php echo $daysDiff.' Nights' ?></b></p>
            </div>

            <div class="d-flex flex-row res-price">
                <i class="fa-solid fa-tag"></i>
                <p>Total Price: <b><?php echo $totalPrice.'€' ?> </b></p>
            </div>

            <div class="d-flex flex-row res-line">
                <hr/>
            </div>
        </div>

        <?php } ?>

        <?php if ($alreadyBooked) { ?>

        <div class="booked">
            <button type="submit" role="button" class="btn btn-danger disabled" > Already booked </button>
        </div> 

        <?php }  else { ?>

        <form method="post" action="/../public/actions/BookRoom.php">
            <div class="d-flex flex-row-reverse">
                <input type="hidden" name="userId" value="<?php echo $userId ?>">
                <input type="hidden" name="roomId" value="<?php echo $currentRoom['room_id'] ?>">
                <input type="hidden" name="checkin" value="<?php echo $_GET['checkin'] ?>">
                <input type="hidden" name="checkout" value="<?php echo $_GET['checkout'] ?>">
                <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                <button type="submit" id="booknow" role="button"  class="btn btn-primary book-now"> Book now </button>
            </div>
        </form> 

        <?php } ?>  

        <hr class="hr" />

        <div data-hotel="<?php echo $currentRoom['name'] ?>" data-lat="<?php echo $roomLat ?>" data-long="<?php echo $roomLong ?>" id="map" class="container text-center map-box">
        </div>

        <?php if ($userId) { ?>

        <h5 id="leave-a-review"> Leave a review </h5> 
        <div class="rating">
            <i class="bi rating-star bi-star"></i> 
            <i class="bi rating-star bi-star"></i> 
            <i class="bi rating-star bi-star"></i> 
            <i class="bi rating-star bi-star"></i> 
            <i class="bi rating-star bi-star"></i>
        </div>

        <form class="postReview" method="post" action="/../public/actions/PostReview.php">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <input type="hidden" name="roomId" value="<?php echo $_REQUEST['roomId'] ?>">
                <input type="hidden" name="userId" value="<?php echo $userId ?>">
                <input type="hidden" name="checkin" value="<?php echo $_REQUEST['checkin'] ?>">
                <input type="hidden" name="checkout" value="<?php echo $_REQUEST['checkout'] ?>">
                <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                <input class="stars-count" type="hidden" name="reviewStars" value="">
                <textarea id="review-text" name="reviewText" maxlength="800" placeholder="Write your review here" class="form-control" id="review-text" rows="3" required></textarea>
            </div>
            <h6 class="char-limit hidden">You have reached the character limit. <i class="fa-solid fa-lg fa-circle-exclamation"></i></h6> 
            <button type="submit" class="review-btn btn btn-primary">Submit</button>
        </form>

        <hr class="hr" />

        <?php } ?>

        <h4 style="margin-bottom:30px"> Reviews </h4>
        <section class="reviews-section">

            <?php 

            if (empty($roomReviews)) { ?>
            <div class="text-center no-results">
                <h4> No reviews yet.</h4>
            </div>
            <?php }

            foreach ($roomReviews as $review) { ?>
            <div class="container review">
                <h3><?php echo $review['name'] ?> </h3>

                <h3><?php for ($i = 0; $i < $review['rate']; $i++) { ?> <i class="fa-solid fa-star"></i> <?php } ?> </h3>
                <h3><?php for ($i = 0; $i < 5 - $review['rate']; $i++) { ?> <i class="fa-regular fa-star"></i> <?php } ?> </h3>
                <?php if ($userId == $review['user_id']) { ?>
                <form class="deleteReview" method="post" action="/../public/actions/DeleteReview.php">
                    <input type="hidden" name="reviewId" value="<?php echo $review['review_id']?>">
                    <input type="hidden" name="roomId" value="<?php echo $_REQUEST['roomId'] ?>">
                    <input type="hidden" name="userId" value="<?php echo $userId ?>">
                    <input type="hidden" name="reviewUserId" value="<?php echo $review['user_id'] ?>">
                    <input type="hidden" name="checkin" value="<?php echo $_REQUEST['checkin'] ?>">
                    <input type="hidden" name="checkout" value="<?php echo $_REQUEST['checkout'] ?>">
                    <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                    <button class="trash-review" type="submit"><h6><i class="fa-solid fa-trash"></i></h6></button>
                </form>

                <?php } ?>

                <p><em>At: </em><?php echo explode(' ', $review['created_time'])[0] ?>
                <div class="container"><p><?php echo htmlentities($review['comment']) ?></p></div>
            </div>
            <hr class="hr" />
            <?php } ?>

        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
    <script src="room.js"></script>
    <script src="room_ajax.js"></script>

</body>

</html>