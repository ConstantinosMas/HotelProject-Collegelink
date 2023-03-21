<?php

require_once __DIR__.'/../../boot/boot.php';

use app\hotel\Review;
use app\hotel\Room;
use app\hotel\Favorite;
use app\hotel\User;

$review = new Review();
$room = new Room();
$favorite = new Favorite();

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    die;
}

$csrf = $_REQUEST['csrf'];
    if (empty($csrf) || !User::verifyCsrf($csrf)) {
        return;
    }

// These if statements check which function the ajax call should do: addreview, deletereview or toggle favorite
if (!empty($_REQUEST['isAddReview'])) { 

    if ($_REQUEST['userId']) {
        $review->PostReview($_REQUEST['roomId'], $_REQUEST['userId'], $_REQUEST['reviewStars'], $_REQUEST['reviewText']);
    } else {
        die;
    }
} 

if (!empty($_REQUEST['isDeleteReview'])) {
    if ($_REQUEST['userId']) {
        $review->deleteReview($_REQUEST['reviewId'], $_REQUEST['userId'], $_REQUEST['reviewUserId'], $_REQUEST['roomId']);
    } else {
        die;
    }
}

if (!empty($_REQUEST['favoriteCall'])) {
    if (empty($_REQUEST['isFav'])) {
        $favorite->addToFavorite($_REQUEST['userId'], $_REQUEST['roomId']);  
    } else {
        $favorite->removeFavorite($_REQUEST['userId'], $_REQUEST['roomId']);
    }
}


$currentRoom = $room->getRoomById($_REQUEST['roomId']);
if (empty($currentRoom)) {
    header('Location: index.php');
    die;
}

$roomReviews = $review->getReviews($_REQUEST['roomId']);
$avgRoomRating = round($currentRoom['avg_reviews']);
$remainingStars = 5 - $avgRoomRating;
$userId = $user::getCurrentUserId();
$roomIsFav = $favorite->checkFavorite($userId, $_REQUEST['roomId']);

?>

<span id="reviews">
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

        <p><?php echo htmlentities($review['comment']) ?></p>
    </div>
    <hr class="hr" />
    <?php } ?>

</span>


<span id="rating">
    <h3 class="top-details"><?php echo $currentRoom['name'].' -'; echo ' '.$currentRoom['city'].','; echo ' '.$currentRoom['area'].' | ' ?></h3>
    <h3 class="top-details"><?php for ($i = 0; $i < $avgRoomRating; $i++) { ?> <i class="fa-solid fa-star" style="color:rgb(255, 153, 0)"></i> <?php } ?> </h3>
    <h3 class="top-details"><?php for ($i = 0; $i < $remainingStars; $i++) { ?> <i class="fa-solid fa-star" style="color:white"></i> <?php } ?> | </h3>   
</span>


<span id="favs">
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
</span>