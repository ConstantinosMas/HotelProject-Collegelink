<?php

namespace app\hotel;

use app\hotel\BaseService;
use DateTime;

class Booking extends BaseService {

    public function BookRoom($userId, $roomId, $checkin, $checkout) {

        $this->getPdo()->beginTransaction();

        $parameters = [
            ':roomId' => $roomId,
        ];
        $roomInfo = $this->fetch('SELECT * FROM room WHERE room_id = :roomId', $parameters);
        $price = $roomInfo['price'];
        $checkinDateTime = new DateTime($checkin);
        $checkoutDateTime = new DateTime($checkout);
        $daysDiff = $checkoutDateTime->diff($checkinDateTime)->days;
        $totalPrice = $price * $daysDiff;

        $parameters = [
            ':userId' => $userId,
            ':roomId' => $roomId,
            ':checkin' => $checkin,
            ':checkout' => $checkout,
            ':totalprice' => $totalPrice,
        ];
        $this->execute('INSERT INTO booking (user_id, room_id, check_in_date, check_out_date, total_price) VALUES (:userId, :roomId, :checkin, :checkout, :totalprice)', $parameters);
        
        return $this->getPdo()->commit();
    }
    
    public function checkRoomAvailibility($roomId, $checkin, $checkout) {
        $parameters = [
            ':roomId' => $roomId,
            ':checkin' => $checkin,
            ':checkout' => $checkout,
        ];
        return $this->fetch('SELECT * FROM booking WHERE room_id = :roomId AND check_in_date <= :checkout AND check_out_date >= :checkin', $parameters);
    }

    public function getBookings($userId) {
        $parameters = [
            ':userId' => $userId,
        ];

        return $this->fetchAll('SELECT * FROM booking
        LEFT JOIN room ON booking.room_id = room.room_id
        LEFT JOIN room_type on room.type_id = room_type.type_id
        WHERE user_id = :userId', $parameters);
    }

    public function DeleteBooking($userId, $bookingId) {
        $parameters = [
            ':bookingId' => $bookingId,
        ];

        $currentBooking = $this->fetch('SELECT user_id FROM booking WHERE booking_id = :bookingId', $parameters);
        if ($userId != $currentBooking['user_id']) {
            return;
        }

        $parameters = [
            ':bookingId' => $bookingId,
        ];

        $this->execute('DELETE FROM booking WHERE booking.booking_id = :bookingId', $parameters);
    }
    
}
