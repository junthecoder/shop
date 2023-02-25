<?php

function include_template($filename, $variables = [])
{
    extract($variables);
    include $filename;
}

function redirect($url = null, $add_to_history = true)
{
    if (!$url) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: $url", true, $add_to_history ? 303 : 302);
    exit();
}

function ensure_login()
{
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
}

function block_csrf()
{
    if (empty($_POST)) {
        return;
    }

    if (!isset($_POST['token']) or
        !isset($_SESSION['token']) or
        !hash_equals($_POST['token'], $_SESSION['token'])) {
        die('Form expired.');
    }
}

function load_twig()
{
    require_once './vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => './cache',
        'auto_reload' => true,
    ]);
    $twig->addGlobal('session', $_SESSION);
    $twig->addFunction(new \Twig\TwigFunction('csrf_protection', function () {
        $_SESSION['token'] ??= bin2hex(random_bytes(32));
        echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '" />';
    }));

    return $twig;
}
