<?php

require_once 'init.php';

$item = DB->get_item_by_id($_GET['id']);

echo load_twig()->render('item.html.twig', [
    'item' => $item,
]);
