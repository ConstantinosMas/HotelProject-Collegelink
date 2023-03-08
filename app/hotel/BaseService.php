<?php

namespace app\hotel;

use Exception;
use PDO;
use app\support\configuration\Configuration;

class BaseService {

    private static $pdo;

    public function __construct() {
        $this->InitializePdo();
    }

    protected function InitializePdo() {

        if (!empty(self::$pdo)) {
            return;
        }

        $config = Configuration::getInstance();
        $databaseConfig = $config->getConfig()['database'];
        
        try {
            self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $databaseConfig['host'], $databaseConfig['dbname']), 
                        $databaseConfig['username'], 
                        $databaseConfig['password'], 
                        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
        } catch (\PDOException $ex) {
            throw new \Exception(sprintf('Could not connect to database. Error: $%s', $ex->getMessage()));

            }
    }

    protected function getPdo() {
        return self::$pdo;
    }

    protected function fetchAll($query, $parameters = [], $type = PDO::FETCH_ASSOC) {
        $statement = $this->getPdo()->prepare($query);
        $statement->execute($parameters);
        return $statement->fetchAll($type);

    }

    protected function fetch($query, $parameters = [], $type = PDO::FETCH_ASSOC) {
        $statement = $this->getPdo()->prepare($query);

        $statement->execute($parameters);
        return $statement->fetch($type);

    }

    // ALL FUNCTIONS EXCEPT FROM FETCH AND FETCHALL SHOULD USE THIS ONE
    protected function execute($sql, $parameters) {
        $statement = $this->getPdo()->prepare($sql);
        $status = $statement->execute($parameters);
        if (!$status) {
            throw new Exception($statement->errorInfo()[2]);
        }

        return $status;
    }
    

    }
