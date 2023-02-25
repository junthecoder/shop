<?php

require_once 'init.php';

$success = false;

if ($_POST) {
    $db = new Database;
    $row = $db->get_user($_POST['email']);
    $success = ($row !== false and password_verify($_POST['password'], $row['password']));
    if ($success) {
        session_regenerate_id(true);
        $_SESSION['user'] = $row;
        redirect($_POST['redirect_url'] ?? 'index.php');
    } else {
        redirect(add_to_history: false);
    }
}

echo load_twig()->render('login.html.twig', [
    'success' => $success,
    'redirect_url' => $_SERVER['HTTP_REFERER'] ?? null,
]);
