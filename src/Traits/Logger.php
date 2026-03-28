<?php
namespace App\Traits;

trait Logger {
    public function logMessage($message) {
        echo "[LOG]: " . htmlspecialchars($message) . "<br>\n";
    }
}