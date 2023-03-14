<?php
require __DIR__ . '/../../boot/boot.php';


use app\hotel\Booking;
use app\hotel\User;
use app\hotel\Favorite;
use app\hotel\Review;

if (empty(User::getCurrentUserId())) {
    header('Location: /public/assets/login.php');
    return;
}

$userId = User::getCurrentUserId();


$review = new Review();
$resultNumber = $_REQUEST['nrOfResults'];


$userReviews = $review->loadMoreReviews($userId, $resultNumber);


?>

<?php foreach ($userReviews as $index => $review) { ?>
<li class="review-li">
    <h5><a class="test" href="/public/assets/room.php?roomId=<?php echo $review['room_id'] ?>"><?php echo sprintf('%s. %s', $index + $resultNumber + 1, $review['name']) ?> </a></h5> 
    <h5 style="display:inline-block;"><?php for ($i = 0; $i < $review['rate']; $i++) { ?> <i class="fa-solid fa-star fa-lg"></i> <?php } ?> </h5>
<h5 style="display:inline-block;"><?php for ($i = 0; $i < 5 - $review['rate']; $i++) { ?> <i class="fa-regular fa-star fa-lg"></i> <?php } ?> </h5>
</li>
<?php } ?>