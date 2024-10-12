<?php

class Helper
{
    public static function jsonNormalize($data)
    {
        $result = [];
        foreach ($data as $d) {
            $result[] = array_values($d);
        }
        return $result;
    }

    public static function response($status, $message, $other = [], $json=true)
    {
        $res = ['status' => $status, 'message' => $message];
        foreach ($other as $key => $value) $res[$key] = $value;
        return $json ? json_encode($res) : $res;
    }

    public static function multiple_empty(...$args)
    {
        foreach ($args as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }

    public static function checkRowExist($pdo, $tbl, $field_name, $cond_field, $cond_value)
    {
        $stmt = $pdo->prepare("SELECT $field_name FROM `$tbl` WHERE $cond_field=?");
        if (!$stmt->execute([$cond_value])) return Helper::response(422, 'Error while processing your request');
        return $stmt->rowCount(); // true if a row with email exist, otherwise false
    }

    public static function checkAdminToken($token)
    {
        $sha1_token = (require_once '../Database/config.php')['token'];
        if (sha1($token) === $sha1_token) return true;

        return false; // 401
    }

    public static function checkUserToken($pdo, $token)
    {
        $stmt = $pdo->prepare('SELECT * FROM `token` WHERE token=?');
        if (!$stmt->execute([$token])) return Helper::response(422, 'Error while processing your request', [], false);

        if ($stmt->rowCount() < 1) return Helper::response(401, 'Unauthorized, token is invalid', [], false);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['valid_until'] < time()) return Helper::response(401, 'Token expired', [], false);

        return Helper::response(200, 'Auth ok', ['body' => $row], false);
    }
}