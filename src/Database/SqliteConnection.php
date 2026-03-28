<?php
namespace App\Database;

class SqliteConnection extends AbstractDatabase {
    private $dbPath;

    public function __construct($dbPath) {
        $this->dbPath = $dbPath;
        $this->connect();
    }

    public function connect() {
        try {
            $this->pdo = new \PDO("sqlite:" . $this->dbPath);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->setupTable();
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    private function setupTable() {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        )";
        $this->pdo->exec($query);
    }
}