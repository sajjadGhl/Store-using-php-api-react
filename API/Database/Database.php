<?php

class Database
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = require 'Connection.php';
    }

    public function insertCategories($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `categories` (id, title) VALUES (?, ?)");
        try {
            $this->pdo->beginTransaction();
            foreach ($data as $row) {
                $stmt->execute($row);
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollback();
            echo "Category insert Error: " . $e->getMessage();
        }
    }

    public function insertProducts($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `products` (title, price, description, category_id, image_url) VALUES (?, ?, ?, ?, ?)");
        try {
            $this->pdo->beginTransaction();
            foreach ($data as $row) {
                $stmt->execute($row);
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollback();
            echo "Product insert Error: " . $e->getMessage();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}