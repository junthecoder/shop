<?php

$dir = '../app';

switch (strtok($_SERVER['REQUEST_URI'], '?')) {
    case '/':
        include "$dir/index.php";
        break;
    case '/account':
        include "$dir/account.php";
        break;
    case '/address_edit':
        include "$dir/address_edit.php";
        break;
    case '/addresses':
        include "$dir/addresses.php";
        break;
    case '/cart':
        include "$dir/cart.php";
        break;
    case '/checkout':
        include "$dir/checkout.php";
        break;
    case '/item':
        include "$dir/item.php";
        break;
    case '/login':
        include "$dir/login.php";
        break;
    case '/logout':
        include "$dir/logout.php";
        break;
    case '/orders':
        include "$dir/orders.php";
        break;
    case '/register':
        include "$dir/register.php";
        break;
    case '/validation':
        include "$dir/validation.php";
        break;
    default:
        http_response_code(404);
        break;
}
