<?php

require_once 'utility.php';
require_once 'database.php';

session_start();

$db = new Database;

$num_items_per_page = 10;
$num_items = $db->count_items();
$num_pages = ceil($num_items / $num_items_per_page);
$current_page = $_GET['page'] ?? 1;
$sort_type = $_GET['sort'] ?? 'recommended';

switch ($sort_type) {
    case 'price-asc':
        $order = 'price';
        break;
    case 'price-desc':
        $order = 'price DESC';
        break;
    case 'date-asc':
        $order = 'time_created';
        break;
    case 'date-desc':
        $order = 'time_created DESC';
        break;
    case 'recommended':
    default:
        $order = 'id';
        break;
}
$items = $db->get_items_batch($num_items_per_page * ($current_page - 1), $num_items_per_page, $order);

echo load_twig()->render('index.html.twig', [
    'items' => $items,
    'num_items_per_page' => $num_items_per_page,
    'num_pages' => $num_pages,
    'current_page' => $current_page,
    'sort_type' => $sort_type,
]);
