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
        header('Location: /login');
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
        http_response_code(403);
        die('Form expired.');
    }
}

function load_twig()
{
    $loader = new \Twig\Loader\FilesystemLoader('../views');
    $twig = new \Twig\Environment($loader, [
         # use /var/www/html/cache since directories mounted by docker are owned by root
        'cache' => __DIR__ . '/../../cache',
        'auto_reload' => true,
    ]);

    $twig->addGlobal('session', $_SESSION);
    $twig->addGlobal('app_name', $_ENV['APP_NAME']);

    $twig->addFunction(new \Twig\TwigFunction('csrf_protection', function () {
        $_SESSION['token'] ??= bin2hex(random_bytes(32));
        echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '" />';
    }));

    $twig->addFunction(new \Twig\TwigFunction('format_price', function ($price) {
        static $fmt = new NumberFormatter('ja_JP', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($price, 'JPY');
    }));

    return $twig;
}
