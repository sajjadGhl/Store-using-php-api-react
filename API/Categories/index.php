<?php

// Checked, this API works fine, time: 2024.03.11 17:56

require_once 'Categories.php';
$token = require_once '../token.php';

require_once '../headers.php';

$method = $_SERVER['REQUEST_METHOD'];

$categories = new Categories();

switch (strtolower($method)) {
    case 'get':
        $id = trim($_GET['id'] ?? null);
        if (empty($id)) {
            // GET /api/Categories/
            echo $categories->readAll();
        } else {
            // GET /api/Categories/?id=:id
            echo $categories->read($id);
        }
        break;

    case 'post':
        // POST /api/Categories/
        // Admin Token
        $token['admin']();

        $title = trim($_POST['title'] ?? null);
        if (Helper::multiple_empty($title)) {
            echo Helper::response(400, 'Bad request, You have to pass all data (title)');
        } else {
            echo $categories->create($title);
        }
        break;

    case 'patch':
        // PATCH /api/Categories
        // Admin Token
        $token['admin']();

        parse_str(file_get_contents('php://input'), $_PATCH);
        $id = trim($_PATCH['id'] ?? null);
        $title = trim($_PATCH['title'] ?? null);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (!$categories->isIdExist($id)) {
            echo Helper::response(404, 'Category not found');
        } elseif (empty($title)) {
            echo Helper::response(406, 'No field to update, Not acceptable request');
        } else {
            echo $categories->update($id, $_PATCH);
        }
        break;

    case 'delete':
        // DELETE /api/Categories
        // Admin Token
        $token['admin']();

        parse_str(file_get_contents('php://input'), $_DELETE);
        $id = trim($_DELETE['id'] ?? null);
        if (empty($id)) {
            echo Helper::response(400, 'Bad request, id is required');
        } elseif (!$categories->isIdExist($id)) {
            echo Helper::response(404, 'Category not found');
        } else {
            echo $categories->delete($id);
        }
        break;

    default:
        echo Helper::response(405, "Bad request, {$method} method is invalid");
        break;
}
