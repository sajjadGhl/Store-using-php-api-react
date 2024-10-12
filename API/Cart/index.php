<?php

require_once 'Cart.php';

$token = require_once '../token.php';

require_once '../headers.php';


$method = $_SERVER['REQUEST_METHOD'];

$cart = new Cart();

switch (strtolower($method)) {
    case 'get':
        // User Token
        $user_data = $token['user']();
        $user_token = $user_data['token'];
        $token = trim($_GET['token'] ?? null);
        if ($user_token !== $token) die(Helper::response(401, 'Auth failed, try login again'));
        $user_id = $user_data['user_id'];
        $product_id = trim($_GET['product_id'] ?? null);
        if (empty($user_id)) {
            // GET /api/Cart/
            echo $cart->readAll();
        } elseif ($cart->isUserIdExist($user_id)) {
            if (!empty($product_id)) {
                echo $cart->isProductInCart($product_id, $user_id);
            } // if $_GET['empty'] not exited, trim output will be empty string
            elseif (trim($_GET['empty'] ?? null) == 'true') {
                // GET /api/Cart/?user_id=:user_id&empty=true
                echo $cart->empty($user_id);
            } else {
                // GET /api/Cart/?user_id=:user_id
                echo $cart->read($user_id);
            }
        } else {
            echo Helper::response(404, 'User not found');
        }
        break;

    case 'post':
        // POST /api/Cart/
        // User Token
        $user_data = $token['user']();
        $user_id = $user_data['user_id'];
//        $user_id = trim($_POST['user_id'] ?? null);
//        if ($token_user_id !== $user_id) die(Helper::response(401, 'Auth failed, try login again'));
        $_DATA = json_decode(file_get_contents('php://input'), true);

        $product_id = trim($_DATA['product_id'] ?? null);
        $quantity = $_DATA['quantity'] ?? null ? trim($_DATA['quantity']) : 1;
        if (Helper::multiple_empty($user_id, $product_id)) {
            echo Helper::response(400, 'Bad request, user_id, product_id are required');
        } elseif (!$cart->isUserIdExist($user_id)) {
            echo Helper::response(404, 'User not found');
        } elseif (!$cart->isProductIdExist($product_id)) {
            echo Helper::response(404, 'Product not found');
        } else {
            echo $cart->create($user_id, $product_id, $quantity);
        }
        break;

    case 'patch':
        // PATCH /api/Cart/
        // User Token
        $user_data = $token['user']();
        $token_user_id = $user_data['user_id'];

//        parse_str(json_decode(file_get_contents('php://input')), $_PATCH);
        $_PATCH = json_decode(file_get_contents('php://input'), true);

        $id = trim($_PATCH['id'] ?? null);
        $quantity = trim($_PATCH['quantity'] ?? null);

        if (Helper::multiple_empty($id, $quantity)) {
            echo Helper::response(400, 'Bad request, id, quantity is required');
        } elseif (!$cart->isCartIdExist($id, $token_user_id)) {
            echo Helper::response(404, 'Bad request, Cart item not found');
        } else {
            echo $cart->updateQuantity($id, $quantity);
        }
        break;

    case 'delete':
        // DELETE /api/Cart/
        // User Token
        $user_data = $token['user']();
        $token_user_id = $user_data['user_id'];

        $_DELETE = json_decode(file_get_contents('php://input'), true);

        $id = trim($_DELETE['id'] ?? null);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (!$cart->isCartIdExist($id, $token_user_id)) {
            echo Helper::response(404, 'Cart item not found');
        } else {
            echo $cart->delete($id);
        }
        break;

    default:
        echo Helper::response(405, "Bad request, {$method} method is invalid");
        break;
}
