<?php

namespace app\hotel;

use PDO;
// use app\support\configuration\Configuration;
use app\hotel\BaseService;

class User extends BaseService
{

    const TOKEN_KEY = "unj29_8d;ad-18z__2";

    private static $currentUserId;

    public function getAllUsers() {
        return $this->fetchAll('SELECT * from User');
    }

    

    public function addNewUser($name, $email, $password) {
        try {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->getPdo()->prepare('INSERT INTO User (name, email, password) VALUES (:name, :email, :password)');
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);  
        $statement->execute();
        $userInfo = $this->getByEmail($email);
        $this->establishCurrentUser($userInfo);
        } catch (\PDOException $ex) {
            if (str_contains($ex, '1062 Duplicate')) {
                header('Location: /public/assets/register.php?' . http_build_query(['registerError' => true, 'currentName' => $name, 'currentEmail' => $email]));
            }
        }
        

    }

    public function getByEmail($email) {
        return $this->fetch('SELECT * from User WHERE email = :email', [':email' => $email]);
    }

    public function verifyPass($email, $password) {
        $requestingUser = $this->getByEmail($email);
        return password_verify($password, $requestingUser['password']);

    }

    public function generateToken($userId, $csrf = '') {
        $payload = [
            'user_id' => $userId,
            'csrf' => $csrf ?: md5(time()),
        ];

        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);
        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public static function getTokenPayload($token) {
        [$payloadEncoded] = explode('.', $token);
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token) {
        $payload = self::getTokenPayload($token);
        $userId = $payload['user_id'];
        $csrf = $payload['csrf'];

        return $this->generateToken($userId, $csrf) == $token;
    }

    public static function getCsrf() {
        $token = $_COOKIE['user_token'];
        $payload = self::getTokenPayload($token);
        return $payload['csrf'];
    }

    public static function verifyCsrf($csrf) {
        return self::getCsrf() == $csrf;
    }

    public static function getCurrentUserId() {
        return self::$currentUserId;
    } 

    public static function setCurrentUserId($userId) {
        self::$currentUserId = $userId;
    }

    public function establishCurrentUser($userInfo) {
        $token = $this->generateToken($userInfo['user_id']);
        setcookie('user_token', $token, time() + (7 * 24 * 60 * 60), '/');
        User::setCurrentUserId($userInfo['user_id']);
        header('Location: /public/assets/index.php');
    }


}

