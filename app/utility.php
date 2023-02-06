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

function redirect($url = null)
{
    if (!$url) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: $url", true, 303);
    exit();
}

?>
