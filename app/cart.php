<?php

require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

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
    $db = new Database;

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $key = find_cart_item_key_by_id($_POST['item_id']);
                if ($key === false) {
                    $_SESSION['cart'][] = ['id' => $_POST['item_id'], 'count' => 1];
                } else {
                    ++$_SESSION['cart'][$key]['count'];
                }
                break;
            case 'change_count':
                $key = find_cart_item_key_by_id($_POST['item_id']);
                $_SESSION['cart'][$key]['count'] = $_POST['count'];
                break;
            case 'delete':
                $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['item_id']);
                break;
        }
    }

    redirect();
}

$db = new Database;
$items = [];
foreach ($_SESSION['cart'] as $cart_item) {
    $items[$cart_item['id']] = $db->get_item_by_id($cart_item['id']);
}

echo load_twig()->render('cart.html.twig', [
  'items' => $items,
  'total_price' => $total_price
]);
