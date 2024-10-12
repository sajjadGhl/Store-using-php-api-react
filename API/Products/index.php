<?php

// Checked, this API works fine, time: 2024.03.10 21:37

require_once 'Products.php';
require_once '../Categories/Categories.php';
$token = require_once '../token.php';

require_once '../headers.php';

$method = $_SERVER['REQUEST_METHOD'];

$products = new Products();

switch (strtolower($method)) {
    case 'get':
        $id = trim($_GET['id'] ?? null);
        if (empty($id)) {
            // GET /api/Products/
            echo $products->readAll();
        } else {
            // GET /api/Products/?id=:id
            echo $products->read($id);
        }
        break;

    case 'post':
        // POST /api/Products/
        // Admin Token
        $token['admin']();

        $title = trim($_POST['title'] ?? null);
        $price = floatval(trim($_POST['price']) ?? null);
        if (!is_float($price) && !is_int($price)) {
            echo Helper::response(400, 'Bad request, price should be float or integer');
            break;
        }
        $description = trim($_POST['description'] ?? null);
        $category_id = trim($_POST['category_id'] ?? null);
        if (!$products->isCategoryIdExist($category_id)) {
            echo Helper::response(400, 'Bad request, there is no category with this id');
            break;
        }
        $image_url = trim($_POST['image_url'] ?? null);
        if (Helper::multiple_empty($title, $price, $description, $category_id, $image_url)) {
            echo Helper::response(400, 'Bad request, You have to pass all data (title, price, description, category_id, image_url)');
        } else {
            echo $products->create($title, $price, $description, $category_id, $image_url);
        }
        break;

    case 'patch':
        // PATCH /api/Products/
        // Admin Token
        $token['admin']();

        parse_str(file_get_contents('php://input'), $_PATCH);
        $id = trim($_PATCH['id'] ?? null);
        $title = trim($_PATCH['title'] ?? null);
        $price = floatval(trim($_PATCH['price']) ?? null);
        if (!is_float($price) && !is_int($price)) {
            echo Helper::response(400, 'Bad request, price should be float or integer');
            break;
        }
        $description = trim($_PATCH['description'] ?? null);
        $category_id = trim($_PATCH['category_id'] ?? null);
        if ($category_id !== null && !$products->isCategoryIdExist($category_id)) {
            echo Helper::response(400, 'Bad request, there is no category with this id');
            break;
        }
        $image_url = trim($_PATCH['image_url'] ?? null);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (empty($title) && empty($price) && empty($description) && empty($category_id) && empty($image_url)) {
            echo Helper::response(406, 'No field to update, Not acceptable request');
        } elseif (!$products->isProductIdExist($id)) {
            echo Helper::response(400, 'Bad request, there is no product with this id');
        } else {
            echo $products->update($id, $_PATCH);
        }
        break;

    case 'delete':
        // DELETE /api/Products/
        // Admin Token
        $token['admin']();

        parse_str(file_get_contents('php://input'), $_DELETE);
        $id = trim($_DELETE['id'] ?? null);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif(!$products->isProductIdExist($id)) {
            echo Helper::response(400, 'Bad request, there is no product with this id');
        } else {
            echo $products->delete($id);
        }
        break;

    default:
        // Admin Token
        $token['admin']();
        echo Helper::response(405, "Bad request, {$method} method is invalid");
        break;
}
