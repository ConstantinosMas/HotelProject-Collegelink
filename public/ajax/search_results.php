<?php

require __DIR__ . '/../../boot/boot.php';

use app\hotel\Room;



$rooms = new Room();
$results = $rooms->getRooms($_REQUEST['city'], $_REQUEST['room_type'], $_REQUEST['checkin'], $_REQUEST['checkout'], $_REQUEST['minPrice'], $_REQUEST['maxPrice']);
$cities= $rooms->getCities();




?>




<div id="my-bookings" class="container">
                    <h2> Search Results </h2>
                </div>
<ul class="room-list">

    <?php
    if (empty($results)) { ?>
        <div class="no-results-div container text-center">
            <img src="/public/assets/img/noresults.png" />
            <h2>Sorry, no results found!</h2>
        </div>

    <?php }
     
     
    
    foreach ($results as $room) {
        $avgRoomRating = round($room['avg_reviews']);
        $remainingStars = 5 - $avgRoomRating;
         ?>


        <li>
            <a href="#" class="photo inactive">
                <img src="/public/assets/img/rooms/<?php echo $room['photo_url']?>" height="160" alt="room" />
            </a>
            <div class="details">
                <a href="#" class="compare inactive"><?php echo sprintf('%s, %s', $room['city'], $room['area'] ) ?></a>
                <h2 id="room-name" class="inactive"><a  href="#"><?php echo $room['name'] ?></a></h2>
                <div class="rating">
                    <div>
                        <?php for ($i = 0; $i < $avgRoomRating; $i++) { ?> <i class="fa-solid fa-star fa-lg"></i> <?php } ?>
                        <?php for ($i = 0; $i < $remainingStars; $i++) { ?> <i class="fa-regular fa-star fa-lg"></i> <?php } ?>
                    </div>
                    <span><a class="inactive" href="#"><?php echo sprintf('%s reviews', $room['count_reviews']) ?></a></span>
                </div>
                <p class="description"><?php echo $room['description_short'] ?></p>
                <form method="get" action="/../public/assets/room.php">
                    <input type="hidden" name="roomId" value="<?php echo $room['room_id'] ?>">
                    <input type="hidden" name="checkin" value="<?php echo $_GET['checkin'] ?>">
                    <input type="hidden" name="checkout" value="<?php echo $_GET['checkout'] ?>">
                    
                    <button type="submit" id="book-btn" class="btn btn-primary book-button">Book now!</button>
                </form>
                <p class="price"><?php echo $room['price'].'€' ?><em> per night</em></p>
                
            </div>
        </li>

        <?php } ?>

    </ul>

    <script src="/../index.js"></script>