<?php
namespace App\Interfaces;

interface UserInterface {
    public function register($username, $password);
    public function login($username, $password);
}