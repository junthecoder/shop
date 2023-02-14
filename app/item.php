<?php

require_once 'utility.php';
require_once 'database.php';

session_start();

$db = new Database;
$item = $db->get_item_by_id($_GET['id']);
$item_images = $db->get_item_images($_GET['id']);

echo load_twig()->render('item.html.twig', [
    'item' => $item,
    'item_images' => $item_images,
]);
