<?php

require_once 'utility.php';

session_start();

if (isset($_SESSION['user'])) {
    $_SESSION = [];
    if (session_id() != '' || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 2592000, '/');
    }
    session_destroy();
    redirect('index.php');
}

echo load_twig()->render('logout.html.twig');
