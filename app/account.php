<?php

require_once 'init.php';

ensure_login();

echo load_twig()->render('account.html.twig');
