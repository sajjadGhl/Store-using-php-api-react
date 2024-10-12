<?php

['db' => ['host' => $host, 'dbname' => $dbname, 'username' => $username, 'password' => $password]] = require 'config.php';
if (!class_exists('Connection')) {
    class Connection
    {
        public static function make($host, $dbname, $username, $password)
        {
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                die(json_encode(['status' => 500, 'message' => "Unable to connect to database, " . $e->getMessage()]));
            }
        }
    }
}

return Connection::make($host, $dbname, $username, $password);
