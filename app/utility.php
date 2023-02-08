<?php

function default_value(&$arr, $key, $value)
{
    if (!isset($arr[$key])) {
        $arr[$key] = $value;
    }
}

function include_template($filename, $variables = [])
{
    extract($variables);
    include $filename;
}

function redirect($url = null, $add_to_history = true)
{
    if (!$url) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: $url", true, $add_to_history ? 303 : 302);
    exit();
}

function ensure_login()
{
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
}
