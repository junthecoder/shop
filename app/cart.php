<?php

require_once 'utility.php';
require_once 'database.php';

session_start();

$db = new Database;

$_SESSION['cart'] ??= [];

function find_cart_item_key_by_id($id)
{
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $_POST['item_id']) {
            return $key;
        }
    }
    return false;
}

if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $key = find_cart_item_key_by_id($_POST['item_id']);
                $count = $_POST['count'] ?? 1;
                if ($key === false) {
                    $_SESSION['cart'][] = ['id' => $_POST['item_id'], 'count' => $count];
                } else {
                    $_SESSION['cart'][$key]['count'] += $count;
                }
                break;
            case 'change_count':
                $key = find_cart_item_key_by_id($_POST['item_id']);
                $_SESSION['cart'][$key]['count'] = $_POST['count'];
                break;
            case 'delete':
                $_SESSION['cart'] = array_filter($_SESSION['cart'], fn ($item) => $item['id'] != $_POST['item_id']);
                break;
        }
    }

    redirect();
}

echo load_twig()->render('cart.html.twig', [
    'items' => $db->get_items_in_cart(),
]);
