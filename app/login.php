<?php

require_once 'init.php';

$success = false;

if ($_POST) {
    $row = DB->get_user($_POST['email']);
    $success = ($row !== false and password_verify($_POST['password'], $row['password']));
    if ($success) {
        session_regenerate_id(true);
        $_SESSION['user'] = $row;
        redirect($_POST['redirect_url'] ?? '/');
    } else {
        redirect(add_to_history: false);
    }
}

echo load_twig()->render('login.html.twig', [
    'success' => $success,
    'redirect_url' => $_SERVER['HTTP_REFERER'] ?? null,
]);
