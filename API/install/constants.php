<?php
$tables = [
    'products' => [
        'name' => 'products',
        'fields' => [
            'id INT(11) AUTO_INCREMENT PRIMARY KEY',
            'title VARCHAR(255) NOT NULL',
            'price FLOAT NOT NULL',
            'description TEXT',
            'category_id INT(11) NOT NULL',
            'image_url VARCHAR(255)',
        ],
    ],
    'users' => [
        'name' => 'users',
        'fields' => [
            'id INT(11) AUTO_INCREMENT PRIMARY KEY',
            'email VARCHAR(255) NOT NULL',
            'password VARCHAR(255) NOT NULL',
            'first_name VARCHAR(63) NOT NULL',
            'last_name VARCHAR(63) NOT NULL',
            'phone VARCHAR(11)',
        ],
    ],
    'categories' => [
        'name' => 'categories',
        'fields' => [
            'id INT(11) AUTO_INCREMENT PRIMARY KEY',
            'title VARCHAR(255) NOT NULL',
        ],
    ],
    'cart' => [
        'name' => 'cart',
        'fields' => [
            'id INT(11) AUTO_INCREMENT PRIMARY KEY',
            'user_id INT(11) NOT NULL',
            'product_id INT(11) NOT NULL',
            'quantity INT(11) NOT NULL DEFAULT 1',
        ],
    ],
    'token' => [
        'name' => 'token',
        'fields' => [
            'id INT(11) AUTO_INCREMENT PRIMARY KEY',
            'token VARCHAR(255) NOT NULL',
            'user_id INT(11) NOT NULL',
            'valid_until VARCHAR(15) NOT NULL',
        ],
    ],
];
$categories = json_decode(file_get_contents('data/categories.json'), true);

$products = json_decode(file_get_contents('data/products.json'), true);

return ['tables' => $tables, 'categories' => $categories, 'products' => $products];