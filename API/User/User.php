<?php

require_once '../Database/Database.php';
require_once '../Helper.php';


class User extends Database
{
    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM `users` WHERE email=? AND password=?');
        if (!$stmt->execute([$email, sha1($password)])) return Helper::response(422, 'Error while processing your request');
        if ($stmt->rowCount() < 1) return Helper::response(404, 'User not found');
        $user_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        $token_stmt = $this->pdo->prepare('INSERT INTO `token` (token, user_id, valid_until) VALUES(?, ?, ?)');
        $token = sha1($user_id + time());
        $time = time() + 30 * 24 * 60 * 60;
        if (!$token_stmt->execute([$token, $user_id, $time])) return Helper::response(422, 'Error while processing your request');

        return Helper::response(200, 'successful', ['body' => ['user_id' => $user_id, 'token' => $token]]);
    }

    public function checkToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT user_id, valid_until FROM `token` WHERE token=?');
        if (!$stmt->execute([$token])) return Helper::response(422, 'Error while processing your request');
        if ($stmt->rowCount() < 1) return Helper::response(498, 'Invalid token');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data['valid_until'] < time()) {
            $stmt = $this->pdo->prepare('DELETE FROM `token` WHERE token=?');
            if (!$stmt->execute([$token])) return Helper::response(422, 'Error while processing your request');
            return Helper::response(498, 'token expired');
        }
        return Helper::response(200, 'successful', ['body' => $data]);
    }
}