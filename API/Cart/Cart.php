<?php

require_once '../Database/Database.php';
require_once '../Helper.php';


class Cart extends Database
{
    // Method: POST
    public function create($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `cart` (user_id, product_id, quantity) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $product_id, $quantity])) {
            return Helper::response(201, 'Product added to cart successfully', ['id' => $this->pdo->lastInsertId()]);
        }
        return Helper::response(400, 'Error adding product to cart');
    }

    // Method: GET
    public function read($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT cart.id as cid, products.id, products.title, products.price, products.description, products.category_id, products.image_url, cart.quantity FROM `cart` JOIN products ON cart.product_id = products.id WHERE cart.user_id=?");
        if (!$stmt->execute([$user_id])) return Helper::response(400, 'Error getting cart');
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return Helper::response(200, 'successful', ['body' => $cart]);
    }

    // Method: GET
    public function readAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cart` GROUP BY user_id ORDER BY id DESC");
        if (!$stmt->execute()) return Helper::response(400, 'Error getting carts');
        $carts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return Helper::response(200, 'successful', ['body' => $carts]);
    }

    // HTTP Method: PATCH
    public function updateQuantity($id, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE `cart` SET quantity=? WHERE id=?");
        if (!$stmt->execute([$quantity, $id])) return Helper::response(400, 'Error updating cart item');
        return Helper::response(200, 'Cart item updated successfully');
    }

    // Method: DELETE
    public function delete($id)
    {
        // 200 ok, 404 id not found
        $stmt = $this->pdo->prepare("DELETE FROM `cart` WHERE id=?");
        if ($stmt->execute([$id])) return Helper::response(200, 'Product deleted from cart successfully');
        return Helper::response(400, 'Error deleting product from cart');
    }

    public function empty($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `cart` WHERE user_id=?");
        if ($stmt->execute([$user_id])) return Helper::response(200, 'Cart got empty');
        return Helper::response(400, 'Error while do emptying cart');
    }

    public function isUserIdExist($user_id)
    {
        return Helper::checkRowExist($this->pdo, 'users', 'id', 'id', $user_id);
    }

    public function isProductIdExist($product_id)
    {
        return Helper::checkRowExist($this->pdo, 'products', 'id', 'id', $product_id);
    }

    public function isCartIdExist($id, $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cart` WHERE id=? AND user_id=?");
        if (!$stmt->execute([$id, $user_id])) return Helper::response(400, 'Error while processing request');
        return $stmt->rowCount();
    }

    public function isProductInCart($product_id, $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cart` WHERE product_id=? AND user_id=?");
        if (!$stmt->execute([$product_id, $user_id])) return Helper::response(400, 'Error while processing request');
        if ($stmt->rowCount() === 0) return Helper::response(200, 'not in cart', ['body' => ['ok' => false]]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart['ok'] = true;
        return Helper::response(200, 'successful', ['body' => $cart]);
    }
}