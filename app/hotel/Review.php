<?php

namespace app\hotel;

use app\hotel\BaseService;

class Review extends BaseService {


    public function PostReview($roomId, $userId, $rating, $comment) {

        $this->getPdo()->beginTransaction();
        $safeComment = htmlentities($comment);

        $parameters = [
            ':roomId' => $roomId,
            ':userId' => $userId,
            ':rate' => $rating,
            ':comment' => $safeComment,
        ];
        $this->execute('INSERT INTO review (room_id, user_id, rate, comment) VALUES (:roomId, :userId, :rate, :comment)', $parameters);
        $this->updateRoomRating($roomId);
        return $this->getPdo()->commit();
    }


    public function getReviews($roomId) {
        return $this->fetchAll('SELECT review.room_id, review.user_id, rate, comment, review_id, name, review.created_time FROM review 
        LEFT JOIN user ON review.user_id = user.user_id 
        WHERE room_id = :roomId 
        ORDER BY review.updated_time DESC', [':roomId' => $roomId]);
    }

    public function getUserReviews($userId) {
        $parameters = [
            ':userId' => $userId,
        ];
        return $this->fetchAll('SELECT review.room_id, rate, name FROM review
        LEFT JOIN room ON review.room_id = room.room_id
        WHERE user_id = :userId
        LIMIT 4', $parameters);
    }

    public function loadMoreReviews($userId, $resultsNumber) {
        $parameters = [
            ':userId' => $userId,
        ];
        return $this->fetchAll('SELECT review.room_id, rate, name FROM review
        LEFT JOIN room ON review.room_id = room.room_id
        WHERE user_id = :userId
        LIMIT 4 OFFSET '.$resultsNumber, $parameters);
    }

    public function deleteReview($reviewId, $userId, $reviewUserId, $roomId)  {

        $this->getPdo()->beginTransaction();

        if ($userId != $reviewUserId) {
            return;
        }
        $parameters = [
            ':reviewId' => $reviewId,
        ];
        
        $this->execute('DELETE FROM review WHERE review_id = :reviewId', $parameters);
        $this->updateRoomRating($roomId);
        return $this->getPdo()->commit();
    }

    private function updateRoomRating($roomId) {
        $parameters = [
            ':roomId' => $roomId,
        ];

        $this->execute('UPDATE room  SET count_reviews = (SELECT COUNT(*) FROM review WHERE room_id = :roomId) WHERE room_id = :roomId ;
                        UPDATE room SET avg_reviews = (SELECT SUM(rate) FROM review WHERE room_id = :roomId) / count_reviews WHERE room_id = :roomId', $parameters);
    }
    
}
