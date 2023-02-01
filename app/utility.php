<?php

function get_all_items($dbh) {
    $sql = 'SELECT id, name, price FROM item';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $items = [];
    while ($rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $rec;
    }
    return $items;
}

function get_items_by_ids($dbh, $item_ids) {
    $sql = 'SELECT id, name, price FROM item WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $items = [];
    foreach ($item_ids as $item_id) {
        $stmt->execute([$item_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $items[] = $row;
    }
    return $items;
}

function get_item_by_id($dbh, $item_id) {
    return get_items_by_ids($dbh, [$item_id])[0];
}

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
