<?php

function default_value(&$arr, $key, $value) {
    if (!isset($arr[$key])) {
        $arr[$key] = $value;
    }
}

function include_template($filename, $variables = []) {
    extract($variables);
    include $filename;
}

?>
