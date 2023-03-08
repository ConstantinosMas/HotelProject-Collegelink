<?php

namespace app\hotel;

use PDO;
use app\hotel\BaseService;

class Favorite extends BaseService {

    public function checkFavorite($userId, $roomId) {
        $params = [
            ':userId' => $userId,
            ':roomId' => $roomId,
        ];
        return $this->fetch('SELECT * FROM favorite WHERE user_id = :userId AND room_id = :roomId', $params);
    }

    public function removeFavorite($userId, $roomId) {
        $parameters = [
            ':userId' => $userId,
            ':roomId' => $roomId,
        ];
        return $this->execute('DELETE FROM favorite WHERE user_id = :userId AND room_id = :roomId', $parameters);
    }

    public function addToFavorite($userId, $roomId) {
        $parameters = [
            ':userId' => $userId,
            ':roomId' => $roomId,
        ];
        return $this->execute('INSERT INTO favorite (user_id, room_id) VALUES (:userId, :roomId)', $parameters);
    }

    public function getUserFavorites($userId) {
        $parameters = [
            ':userId' => $userId,
        ];
        return $this->fetchAll('SELECT favorite.room_id, name FROM favorite
        LEFT JOIN room ON favorite.room_id = room.room_id
        WHERE user_id = :userId', $parameters);
    }




}
