<?php

namespace app\hotel;

use PDO;
use app\hotel\BaseService;

class Room extends BaseService {

    public function getCities() {
        return $this->fetchAll('SELECT DISTINCT city FROM room');
    }

    public function getRooms($city, $roomTypeId, $checkin, $checkout, $minPrice, $maxPrice) {
        $search_params = [
            ':city' => $city,
            ':roomTypeId' => $roomTypeId,
            ':checkin' => $checkin,
            ':checkout' => $checkout,
            ':minprice' => $minPrice,
            ':maxprice' => $maxPrice,
        ];
        return $this->fetchAll('SELECT * FROM
        room WHERE city = :city
        AND type_id = :roomTypeId AND
        price BETWEEN :minprice AND :maxprice AND
        room_id NOT IN (SELECT room_id FROM booking WHERE check_in_date <= :checkout AND check_out_date >= :checkin)', $search_params);
    }

    public function getRoomById($roomId) {
        return $this->fetch('SELECT * FROM room WHERE room_id = :roomId', [':roomId' => $roomId]);
    }

    
}
