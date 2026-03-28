<?php
namespace App\Database;

abstract class AbstractDatabase {
    protected $pdo;

    abstract public function connect();

    public function getPdo() {
        return $this->pdo;
    }
}