<?php

// Checked, this API works fine, time: 2024.03.11 17:47

require_once 'Users.php';
// Admin Token
//$token = require_once '../token.php';
//$token['admin']();
$token = require_once '../token.php';

require_once '../headers.php';

$method = $_SERVER['REQUEST_METHOD'];

$users = new Users();

switch (strtolower($method)) {
    case 'get':
        // User Token
        $user_data = $token['user']();
        $user_token = $user_data['token'];
        $token = trim($_GET['token'] ?? null);
        if ($user_token !== $token) die(Helper::response(401, 'Auth failed, try login again'));
        $user_id = $user_data['user_id'];
//        $id = trim($_GET['id'] ?? null);
        if (!$user_id) {
            // GET /api/Users/
            echo $users->readAll();
        } else {
            // GET /api/Users/?id=:id
            echo $users->read($user_id);
        }
        break;

    case 'post':
        // POST /api/Users/
        $_DATA = json_decode(file_get_contents('php://input'), true);
        $email = trim($_DATA['email'] ?? null);
        $password = trim($_DATA['password'] ?? null);
        $first_name = trim($_DATA['first_name'] ?? null);
        $last_name = trim($_DATA['last_name'] ?? null);
        $phone = trim($_DATA['phone'] ?? null);
        if (Helper::multiple_empty($email, $password, $first_name, $last_name, $phone)) {
            echo Helper::response(400, 'Bad request, You have to pass all data (email, password, first_name, last_name, phone)');
        } elseif ($users->isEmailExist($email)) {
            echo Helper::response(400, 'Bad request, email exist already');
        } elseif ($users->isPhoneExist($phone)) {
            echo Helper::response(400, 'Bad request, phone exist already');
        } else {
            echo $users->create($email, $password, $first_name, $last_name, $phone);
        }
        break;

    case 'patch':
        // PATCH /api/Users/
//        parse_str(file_get_contents('php://input'), $_PATCH);
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $email = trim($_PATCH['email'] ?? null);
        $password = trim($_PATCH['password'] ?? null);
        $confirmPassword = trim($_PATCH['confirm_password'] ?? null);
        $first_name = trim($_PATCH['first_name'] ?? null);
        $last_name = trim($_PATCH['last_name'] ?? null);
        $phone = trim($_PATCH['phone'] ?? null);
        // User Token
        $user_data = $token['user']();
        $user_token = $user_data['token'];
        $token = trim($_PATCH['token'] ?? null);
        if ($user_token !== $token) die(Helper::response(401, 'Auth failed, try login again'));
        $user_id = $user_data['user_id'];
        if (empty($user_id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (!$users->isIdExist($user_id)) {
            echo Helper::response(404, 'Bad request, id not found');
        } elseif (empty($email) && empty($password) && empty($first_name) && empty($last_name) && empty($phone)) {
            echo Helper::response(406, 'No field to update, Not acceptable request');
        } elseif ($email && $users->isEmailExist($email) && $users->getIdByEmail($email) !== $user_id) {
            echo Helper::response(400, 'Bad request, email exist already');
        } elseif ($phone && $users->isPhoneExist($phone) && $users->getIdByPhone($phone) !== $user_id) {
            echo Helper::response(400, 'Bad request, phone exist already');
        } elseif($password && $password !== $confirmPassword){
            echo Helper::response(400, 'Bad request, password and confirmation is not equal');
        } else {
            echo $users->update($user_id, $_PATCH);
        }
        break;

    case 'delete':
        // DELETE /api/Users
        parse_str(file_get_contents('php://input'), $_DELETE);
        $id = trim($_DELETE['id']);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (!$users->isIdExist($id)) {
            echo Helper::response(404, 'Bad request, id not found');
        } else {
            echo $users->delete($id);
        }
        break;

    default:
        echo Helper::response(405, "Bad request, {$method} method is invalid");
        break;
}
