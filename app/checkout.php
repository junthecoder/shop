<?php

require_once 'init.php';

ensure_login();

if (empty($_SESSION['cart'])) {
    redirect('/cart');
}

$db = new Database;

$items = [];
foreach ($_SESSION['cart'] as $cart_item) {
    $items[$cart_item['id']] = $db->get_item_by_id($cart_item['id']);
}

$_POST['action'] ??= 'default';

if ($_POST['action'] == 'confirm') {
    $stmt = $db->prepare('INSERT INTO purchase (user_id, address_id) VALUES (?, ?)');
    $stmt->execute([$_SESSION['user']['id'], $_POST['address_id']]);
    $purchase_id = $db->lastInsertId();

    $stmt = $db->prepare('INSERT INTO purchase_item (purchase_id, item_id, count) VALUES (?, ?, ?)');
    foreach ($_SESSION['cart'] as $cart_item) {
        $stmt->execute([$purchase_id, $cart_item['id'], $cart_item['count']]);
    }

    $_SESSION['cart'] = [];
}

function concat_address($a)
{
    return sprintf(
        '%s, 〒%s, %s %s %s %s %s, 電話番号: %s',
        $a['full_name'],
        $a['postal_code'],
        $a['prefecture'],
        $a['address_line1'],
        $a['address_line2'],
        $a['address_line3'],
        $a['address_line4'],
        $a['phone_number']
    );
}

$addresses = $db->get_addresses($_SESSION['user']['id']);
$default_address_id = $db->get_default_address_id($_SESSION['user']['id']);

foreach ($addresses as $key => $address) {
    $addresses[$key]['summary'] = concat_address($address);
}

echo load_twig()->render('checkout.html.twig', [
    'items' => $db->get_items_in_cart(),
    'addresses' => $addresses,
    'default_address_id' => $default_address_id,
    'post' => $_POST,
]);
