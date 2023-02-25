<?php

require_once '../vendor/autoload.php';
require_once 'utility.php';
require_once 'database.php';

session_start();
block_csrf();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
try {
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env.default');
    $dotenv->load();
}

define('DB', new Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_DATABASE']));
