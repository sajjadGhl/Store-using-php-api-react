<?php

require_once '../Database/Database.php';
require_once '../Helper.php';


class Products extends Database
{
    public function create($title, $price, $description, $category_id, $image_url)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `products` (title, price, description, category_id, image_url) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $price, $description, $category_id, $image_url])) {
            return Helper::response(201, 'Product added successfully', ['id' => $this->pdo->lastInsertId()]);
        }
        return Helper::response(400, 'Error adding product');
    }

    public function read($id)
    {
        $stmt = $this->pdo->prepare("SELECT products.*, categories.title as category_title
                                    FROM `products`
                                    JOIN `categories` ON products.category_id = categories.id
                                    WHERE products.id=?");
        if (!$stmt->execute([$id])) return Helper::response(400, 'Error getting product');
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return Helper::response(200, 'successful', ['body' => $product]);
        }
        return Helper::response(404, 'No product found');
    }

    public function readAll()
    {
        $stmt = $this->pdo->prepare("SELECT products.*, categories.title as category_title
                                    FROM `products`
                                    JOIN `categories` ON products.category_id = categories.id
                                    ORDER BY id DESC");
        if (!$stmt->execute()) return Helper::response(400, 'Error getting products');
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return Helper::response(200, 'successful', ['body' => $product]);
    }

    public function update($id, $data)
    {
        // 200 ok, 204 no content, 404 id not found
        $data['id'] = $id;
        $set = "";
        foreach ($data as $key => $value)
            if ($value !== null && $key !== 'id') $set .= "$key=:$key,";
        $set = substr($set, 0, -1);
        $stmt = $this->pdo->prepare("UPDATE `products` SET {$set} WHERE id=:id");
        if (!$stmt->execute($data)) return Helper::response(400, 'Error updating product');
        return Helper::response(200, 'Product updated successfully');
    }

    public function delete($id)
    {
        // 200 ok, 404 id not found
        $stmt = $this->pdo->prepare("DELETE FROM `products` WHERE id=?");
        if ($stmt->execute([$id])) return Helper::response(200, 'Product deleted successfully');
        return Helper::response(400, 'Error deleting product');
    }

    public function isCategoryIdExist($category_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `categories` WHERE id=?");
        if (!$stmt->execute([$category_id])) return Helper::response(422, 'Error while creating post');
        return $stmt->rowCount(); // false if rowCount === 0 (not exist) otherwise true
    }

    public function isProductIdExist($product_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `products` WHERE id=?");
        if (!$stmt->execute([$product_id])) return Helper::response(422, 'Error while updating post');
        return $stmt->rowCount(); // false if not exist, otherwise true
    }
}