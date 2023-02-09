<?php

require_once 'utility.php';
require_once 'database.php';

session_start();
ensure_login();

echo load_twig()->render('account.html.twig');
