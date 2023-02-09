<?php

require_once'utility.php';
require_once 'database.php';

session_start();
ensure_login();

$db = new Database;
$purchases = $db->get_purchases($_SESSION['user']['id']);

foreach ($purchases as $key => $purchase) {
    $purchases[$key]['purchase_time'] = date("Y年m月d日", strtotime($purchase['purchase_time']));
    $purchases[$key]['total'] = array_reduce(
        $purchase['items'],
        fn ($total, $item) => $total + $item['price'] * $item['count']
    );
}

echo load_twig()->render('orders.html.twig', [
    'purchases' => $purchases,
]);
