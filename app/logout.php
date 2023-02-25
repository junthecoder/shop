<?php

require_once 'init.php';

if (isset($_SESSION['user'])) {
    $_SESSION = [];
    if (session_id() != '' || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 2592000, '/');
    }
    session_destroy();
    redirect('/');
}

echo load_twig()->render('logout.html.twig');
