<?php

require __DIR__ . '/../../boot/boot.php';

use app\hotel\Room;



$rooms = new Room();
$results = $rooms->getRooms($_GET['city'], $_GET['room_type'], $_GET['checkin'], $_GET['checkout'], $_GET['minPrice'], $_GET['maxPrice']);
$cities= $rooms->getCities();




?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font_general.css">
    <link rel="stylesheet" href="css/search_results.css">

</head>

<body>

    <?php include './header.php' ?>

    <div class="container" style="max-width:55%">
        <div class="row">

            <div class="col-lg-3">
                <h4 class="left-title">FIND YOUR PERFECT STAY </h4>

            <div class="register-photo">
        <div class="form-container text-center">
            <form class="searchForm" method="get" action="/../public/assets/search_results.php">
                <div class="dropdown drop-menu" >
                    <button class="btn btn-primary btn-block dropdown-toggle drop-btn drop-btn-1" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_GET['city'] ?></button>
                    <input class="chosenCity" type="hidden" name="city" value="<?php echo $_GET['city'] ?>">
                    <ul class="dropdown-menu">
                        
                        <?php foreach ($cities as $city) { ?>
                            <li><a class="dropdown-item pick-city" href="#"><?php echo $city['city'] ?></a></li>
                        <?php } ?>
                        

                    </ul>
                </div>

                <div class="dropdown drop-menu">
                    <button class="btn btn-primary btn-block dropdown-toggle drop-btn drop-btn-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_GET['room_str'] ?></button>
                    <input class="chosenRoom" type="hidden" name="room_type" value="<?php echo $_GET['room_type'] ?>">
                    <input class="roomStr" type="hidden" name="room_str" value="<?php echo $_GET['room_str'] ?>">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item pick-room" href="#">Single Room</a></li>
                        <li><a class="dropdown-item pick-room" href="#">Double Room</a></li>
                        <li><a class="dropdown-item pick-room" href="#">Triple Room</a></li>
                        <li><a class="dropdown-item pick-room" href="#">Fourfold Room</a></li>
                    </ul>
                </div>

                            <div class="container card">
            
                    <div class="price-content">
                    <div>
                        <label>Min</label>
                        <p id="min-value">$50</p>
                    </div>
            
                    <div>
                        <label>Max</label>
                        <p id="max-value">$500</p>
                    </div>
                    </div>
            
                    <div class="range-slider">
                        <input type="range" name="minPrice" class="min-price price-range" value="10" min="10" max="1000" step="10">
                        <input type="range" name="maxPrice" class="max-price price-range" value="1000" min="10" max="1000" step="10">
                    </div>
                </div>

                <div class="form-group date-input"><input class="form-control date in" type="text" name="checkin" placeholder="Check-in Date" onblur="(this.type='text')" onfocus="(this.type='date')" value="<?php echo $_GET['checkin'] ?>"></div>
                <div class="form-group date-input"><input class="form-control date out" type="text" name="checkout" placeholder="Check-out Date" onblur="(this.type='text')" onfocus="(this.type='date')" value="<?php echo $_GET['checkout'] ?>" ></div>
                <div class="form-group">
                    <!-- <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div> -->
                </div>
                <div class="form-group"><button class="btn search disabled btn-primary btn-block" type="submit">Search</button></div>
            </form>
        </div>
    </div>
       
            </div>
            <div class="col-lg-9 results-div    "> 
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
                <h2 class="inactive"><a  href="#"><?php echo $room['name'] ?></a></h2>
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
                    
                    <button type="submit" class="btn btn-primary book-button">Book now!</button>
                </form>
                <p class="price"><?php echo $room['price'].'€' ?><em> per night</em></p>
                
            </div>
        </li>

        <?php } ?>

    </ul>
                
            


            </div> 



        

   
   

        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="results.js"></script>

</body>

</html>