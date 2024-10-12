<?php

require_once '../Database/Database.php';
require_once '../Helper.php';


class Users extends Database
{
    // HTTP Method: POST
    public function create($email, $password, $first_name, $last_name, $phone)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `users` (email, password, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$email, sha1($password), $first_name, $last_name, $phone])) {
            return Helper::response(201, 'User added successfully', ['id' => $this->pdo->lastInsertId()]);
        }
        return Helper::response(400, 'Error adding user');
    }

    // HTTP Method: GET
    public function read($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, email, first_name, last_name, phone FROM `users` WHERE id=?");
        if (!$stmt->execute([$id])) return Helper::response(400, 'Error getting user');
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return Helper::response(200, 'successful', ['body' => $user]);
        }
        return Helper::response(404, 'No user found');
    }

    // HTTP Method: GET
    public function readAll()
    {
        $stmt = $this->pdo->prepare("SELECT id, email, first_name, last_name, phone FROM `users` ORDER BY id DESC");
        if (!$stmt->execute()) return Helper::response(400, 'Error getting users');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return Helper::response(200, 'successful', ['body' => $users]);
    }

    // HTTP Method: PATCH
    public function update($id, $data)
    {
        // 200 ok, 204 no content, 404 id not found
        $data['id'] = $id;
        unset($data['token']);
        $set = "";
        foreach ($data as $key => $value)
            if ($value !== null && $key !== 'id') $set .= "$key=:$key,";

        $set = substr($set, 0, -1);
        $stmt = $this->pdo->prepare("UPDATE `users` SET {$set} WHERE id=:id");
        if (!$stmt->execute($data)) return Helper::response(400, 'Error updating user');
        return Helper::response(200, 'User updated successfully');
    }

    // HTTP Method: DELETE
    public function delete($id)
    {
        // 200 ok, 404 id not found
        $stmt = $this->pdo->prepare("DELETE FROM `users` WHERE id=?");
        if ($stmt->execute([$id])) return Helper::response(200, 'User deleted successfully');
        return Helper::response(400, 'Error deleting user');
    }

    public function isIdExist($id)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM `users` WHERE id=?");
        if (!$stmt->execute([$id])) return Helper::response(422, 'Error while processing your request');
        return $stmt->rowCount(); // true if a row with email exist, otherwise false
    }

    public function isEmailExist($email)
    {
        $stmt = $this->pdo->prepare("SELECT email FROM `users` WHERE email=?");
        if (!$stmt->execute([$email])) return Helper::response(422, 'Error while processing your request');
        return $stmt->rowCount(); // true if a row with email exist, otherwise false
    }

    public function isPhoneExist($phone)
    {
        $stmt = $this->pdo->prepare("SELECT phone FROM `users` WHERE phone=?");
        if (!$stmt->execute([$phone])) return Helper::response(422, 'Error while processing your request');
        return $stmt->rowCount(); // true if a row with email exist, otherwise false
    }

    public function getIdByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT id, email FROM `users` WHERE email=?");
        if (!$stmt->execute([$email])) return Helper::response(422, 'Error while processing your request');
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'] ?? null;
    }

    public function getIdByPhone($phone)
    {
        $stmt = $this->pdo->prepare("SELECT id, phone FROM `users` WHERE phone=?");
        if (!$stmt->execute([$phone])) return Helper::response(422, 'Error while processing your request');
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'] ?? null;
    }
}