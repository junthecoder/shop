<?php

require_once 'init.php';

$db = new Database;
$item = $db->get_item_by_id($_GET['id']);

echo load_twig()->render('item.html.twig', [
    'item' => $item,
]);
