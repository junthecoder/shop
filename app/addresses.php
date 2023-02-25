<?php

require_once 'init.php';

ensure_login();

if (isset($_GET['delete'])) {
    DB->delete_address($_GET['id']);
    redirect('/addresses');
}

if (isset($_GET['set_default'])) {
    DB->set_default_address($_SESSION['user']['id'], $_GET['id']);
    redirect('/addresses');
}

$addresses = DB->get_addresses($_SESSION['user']['id']);
$default_address_id = DB->get_default_address_id($_SESSION['user']['id']);

echo load_twig()->render('addresses.html.twig', [
    'addresses' => $addresses,
    'default_address_id' => $default_address_id,
]);
