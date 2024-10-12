<?php
require 'Install.php';
[
    'tables' => $tables,
    'categories' => $categories,
    'products' => $products
] = require __DIR__.'/constants.php';

require __DIR__.'/../Helper.php';

try {
    new Install($tables, Helper::jsonNormalize($categories), Helper::jsonNormalize($products));
} catch (Exception $e) {
}
