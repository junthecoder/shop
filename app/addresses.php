<?php

require_once 'utility.php';
require_once 'database.php';

session_start();
ensure_login();

$db = new Database;

if (isset($_GET['delete'])) {
    $db->delete_address($_GET['id']);
    redirect('address.php');
}

if (isset($_GET['set_default'])) {
    $db->set_default_address($_SESSION['user']['id'], $_GET['id']);
    redirect('address.php');
}

$addresses = $db->get_addresses($_SESSION['user']['id']);
$default_address_id = $db->get_default_address_id($_SESSION['user']['id']);

echo load_twig()->render('addresses.html.twig', [
    'addresses' => $addresses,
    'default_address_id' => $default_address_id,
]);
