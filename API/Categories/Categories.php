<?php

require_once '../Database/Database.php';
require_once '../Helper.php';


class Categories extends Database
{
    // Method: POST
    public function create($title)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `categories` (title) VALUES (?)");
        if ($stmt->execute([$title])) {
            return Helper::response(201, 'Category added successfully', ['id' => $this->pdo->lastInsertId()]);
        }
        return Helper::response(400, 'Error adding category');
    }

    // Method: GET
    public function read($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `categories` WHERE id=?");
        if (!$stmt->execute([$id])) return Helper::response(400, 'Error getting category');
        if ($stmt->rowCount() > 0) {
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return Helper::response(200, 'successful', ['body' => $category]);
        }
        return Helper::response(404, 'No category found');
    }

    // Method: GET
    public function readAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `categories` ORDER BY id DESC");
        if (!$stmt->execute()) return Helper::response(400, 'Error getting categories');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return Helper::response(200, 'successful', ['body' => $categories]);
    }

    // Method: PATCH
    public function update($id, $data)
    {
        // 200 ok, 204 no content, 404 id not found
        $data['id'] = $id;
        $set = "";
        foreach ($data as $key => $value)
            if ($value !== null && $key !== 'id') $set .= "$key=:$key,";
        $set = substr($set, 0, -1);
        $stmt = $this->pdo->prepare("UPDATE `categories` SET {$set} WHERE id=:id");
        if (!$stmt->execute($data)) return Helper::response(400, 'Error updating category');
        return Helper::response(200, 'Category updated successfully');
    }

    // Method: DELETE
    public function delete($id)
    {
        // 200 ok, 404 id not found
        $stmt = $this->pdo->prepare("DELETE FROM `categories` WHERE id=?");
        if ($stmt->execute([$id])) return Helper::response(200, 'Category deleted successfully');
        return Helper::response(400, 'Error deleting category');
    }

    public function isIdExist($id) {
        $stmt = $this->pdo->prepare("SELECT id FROM `categories` WHERE id=?");
        if (!$stmt->execute([$id])) return Helper::response(422, 'Error while processing your request');
        return $stmt->rowCount(); // true if id exist, otherwise false
    }
}