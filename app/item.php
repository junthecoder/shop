<?php

require_once 'utility.php';
require_once 'database.php';

session_start();

$db = new Database;
$item = $db->get_item_by_id($_GET['id']);

echo load_twig()->render('item.html.twig', [
    'item' => $item,
]);
