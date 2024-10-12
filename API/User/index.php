<?php

// Checked, this API works fine, time: 2024.03.11 17:47

require_once 'User.php';
// Admin Token
//$token = require_once '../token.php';
//$token['admin']();

require_once '../headers.php';

$method = $_SERVER['REQUEST_METHOD'];

switch (strtolower($method)) {
    case 'post':
        // POST /api/User/
        $_DATA = json_decode(file_get_contents('php://input'), true);
        $email = trim($_DATA['email'] ?? null);
        $password = trim($_DATA['password'] ?? null);
        $token = trim($_DATA['token'] ?? null);
        $user = new User();
        if (Helper::multiple_empty($email, $password) && empty($token)) {
            echo Helper::response(400, 'Bad request, (email and password) or (token) is required');
        } elseif (!empty($token)) {
            echo $user->checkToken($token);
        } else {
            echo $user->login($email, $password);
        }
        break;

    default:
        echo Helper::response(405, "Bad request, {$method} method is invalid");
        break;
}
