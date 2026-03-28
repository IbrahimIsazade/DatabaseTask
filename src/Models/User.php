<?php
namespace App\Models;

use App\Interfaces\UserInterface;
use App\Traits\Logger;
use App\Database\AbstractDatabase;

class User implements UserInterface {
    use Logger; // Pull in the logging trait

    private $db;

    public function __construct(AbstractDatabase $db) {
        $this->db = $db;
    }

    public function register($username, $password) {
        $pdo = $this->db->getPdo();
        // Securely hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
            $this->logMessage("User '{$username}' successfully registered.");
            return true;
        } catch (\PDOException $e) {
            $this->logMessage("Registration failed for '{$username}'. Username might already exist.");
            return false;
        }
    }

    public function login($username, $password) {
        $pdo = $this->db->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verify the provided password against the stored hash
        if ($user && password_verify($password, $user['password'])) {
            $this->logMessage("User '{$username}' successfully logged in.");
            return true;
        }

        $this->logMessage("Login failed for '{$username}'. Incorrect credentials.");
        return false;
    }
}