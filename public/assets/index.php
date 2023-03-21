<?php

require __DIR__ . '/../../boot/boot.php';

use app\hotel\Room;


$rooms = new Room();
$cities= $rooms->getCities();


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font_general.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/favicon.png">
</head>

<body>

    <div class="container bg">

        <?php include './header.php' ?>




        <div class="register-photo">
            <div class="form-container text-center" style="text-align:center;">
                <form method="get" action="/../public/assets/search_results.php">
                    <div class="dropdown drop-menu">
                        <button class="btn btn-primary btn-block dropdown-toggle drop-btn drop-btn-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">City</button>
                        <input class="chosenCity" type="hidden" name="city" value="">
                        <ul class="dropdown-menu">

                            <?php foreach ($cities as $city) { ?>
                            <li><a class="dropdown-item pick-city" href="#"><?php echo $city['city'] ?></a></li>
                            <?php } ?>

                        </ul>
                    </div>

                    <div class="dropdown drop-menu">
                        <button class="btn btn-primary btn-block dropdown-toggle drop-btn drop-btn-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">Room Type</button>
                        <input class="chosenRoom" type="hidden" name="room_type" value="">
                        <input class="roomStr" type="hidden" name="room_str" value="">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item pick-room" href="#">Single Room</a></li>
                            <li><a class="dropdown-item pick-room" href="#">Double Room</a></li>
                            <li><a class="dropdown-item pick-room" href="#">Triple Room</a></li>
                            <li><a class="dropdown-item pick-room" href="#">Fourfold Room</a></li>
                        </ul>
                    </div>
                    <div class="form-group date-input"><input class="form-control date in" type="text" name="checkin" placeholder="Check-in Date" onblur="(this.type='text')" onfocus="(this.type='date')"></div>
                    <div class="form-group date-input"><input class="form-control date out" type="text" name="checkout" placeholder="Check-out Date" onblur="(this.type='text')" onfocus="(this.type='date')"></div>
                    <input type="hidden" name="minPrice" value=1>
                    <input type="hidden" name="maxPrice" value=1000>
                    <div class="form-group"><button class="btn search disabled btn-primary btn-block" type="submit">Search</button></div>
                </form>
            </div>
        </div>

        <div class="container text-center">
            <h1 id="page-title" style="text-shadow:5px 10px 10px rgba(0, 0, 0, 0.697);color:white;font-size:80px;margin-top:80px;"><span style="color:#ff6427">N</span>ex<span style="color:#ff6427">T</span>rip</h1>
            <h6 style="color:white;margin-top:15px"><em>If you can dream it, you can find it.</em></h6>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f15bf32ba9.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="index-bg.js"></script>

</body>

</html>