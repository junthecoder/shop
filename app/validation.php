<?php
require_once('utility.php');
require_once('database.php');

function validate_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['メールアドレスを入力してください'];
    }

    $db = new Database;
    $stmt = $db->prepare('SELECT 1 FROM user WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch(PDO::FETCH_ASSOC) !== false) {
        return ['このメールアドレスは登録できません'];
    }

    return [];
}

if ($_POST['email']) {
    echo json_encode(array_values(validate_email($_POST['email'])));
}
