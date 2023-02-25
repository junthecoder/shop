<?php

require_once 'init.php';

ensure_login();

if (isset($_POST['cancel_button'])) {
    redirect('/addresses');
}

if (isset($_POST['save_button'])) {
    if (isset($_POST['id'])) {
        DB->update_address($_POST['id'], $_POST);
    } else {
        DB->add_address($_SESSION['user']['id'], $_POST);
    }
    redirect('/addresses');
}

if (isset($_GET['id'])) {
    $address = DB->get_address($_GET['id']);
    if ($address === false) {
        die("住所のIDが不正です。");
    }
} else {
    $address = [
        'id' => null,
        'full_name' => $_SESSION['user']['name'],
        'phone_number' => '',
        'postal_code' => '',
        'prefecture_id' => '',
        'address_line1' => '',
        'address_line2' => '',
        'address_line3' => '',
        'address_line4' => '',
    ];
}

$prefectures = DB->get_prefectures();

echo load_twig()->render('address_edit.html.twig', [
    'prefectures' => $prefectures,
    'address' => $address,
]);
