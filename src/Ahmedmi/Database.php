<?php

namespace Ahmedmi;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private $pdo;


    public function __construct($dsn)
    {
        try {
            $this->pdo = new PDO($dsn);
        } catch (PDOException $e) {
            Helpers::dd("An error happened with DB connection " . $e->getMessage());
        }
    }

    public function query(string $s , array $params = null): PDOStatement
    {
        $pdoState = null;

        try {
            $pdoState = $this->pdo->prepare($s);
            $pdoState->execute($params);
        } catch (PDOException $e) {
            Helpers::dd("An error happened with DB connection " . $e->getMessage());
        }

        return $pdoState;
    }

    public function execFetch(string $s): array
    {
        $queryResult = null;

        try {
            $state = $this->pdo->prepare($s);
            $state->execute();
            $queryResult = $state->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Helpers::dd("An error happened with DB connection " . $e->getMessage());
        }

        return $queryResult;
    }
}
