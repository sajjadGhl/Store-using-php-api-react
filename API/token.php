<?php

$adminToken = function () {
    if (!isset($_SERVER['HTTP_ADMIN_TOKEN'])) {
        die(Helper::response(401, 'Unauthorized, you have to send token in headers'));
    } elseif (!Helper::checkAdminToken($_SERVER['HTTP_ADMIN_TOKEN'])) {
        die(Helper::response(401, 'Unauthorized, token is empty or invalid'));
    }
};

$userToken = function () {
    if (!isset($_SERVER['HTTP_USER_TOKEN'])) {
        die(Helper::response(401, 'Unauthorized, you have to send token in headers'));
    }
    $tokenStatus = Helper::checkUserToken(require 'Database/Connection.php', $_SERVER['HTTP_USER_TOKEN']);
    if ($tokenStatus['status'] === 422 || $tokenStatus['status'] === 401) {
        die(json_encode($tokenStatus));
    }
    return $tokenStatus['body'];
};

return ['admin' => $adminToken, 'user' => $userToken];
