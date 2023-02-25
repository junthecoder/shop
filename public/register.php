<?php

require_once 'init.php';

$_POST['name'] ??= '';
$_POST['email'] ??= '';
$_POST['password'] ??= '';
$_POST['password-check'] ??= '';

if (isset($_POST['check'])) {
    $_SESSION['post'] = $_POST;
    redirect('register.php?check');
}

if (isset($_POST['register'])) {
    $_SESSION['post'] = $_POST;
    redirect('register.php?register');
}

$check = isset($_GET['check']);
$register = isset($_GET['register']);

$post = $_SESSION['post'] ?? [];

if ($register) {
    $db = new Database;
    $db->add_user($post['name'], $post['email'], $post['password']);

    session_regenerate_id(true);
    $_SESSION['user'] = $db->get_user($post['email']);
    redirect('index.php');
}

echo load_twig()->render('register.html.twig', [
    'check' => $check,
    'register' => $register,
    'post' => $post,
]);
