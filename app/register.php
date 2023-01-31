<?php
require_once('utility.php');
session_start();

default_value($_POST, 'check', 0);
default_value($_POST, 'register', 0);
default_value($_POST, 'name', '');
default_value($_POST, 'email', '');
default_value($_POST, 'password', '');
default_value($_POST, 'password-check', '');

$check = $_POST['check'];
$register = $_POST['register'];

if ($register == 1) {
    try {
        $dsn = 'mysql:dbname=shop;host=db-1;charset=utf8';
        $user = 'test';
        $password = 'test';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'INSERT INTO user (name, email, password) VALUES (?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->execute([$_POST['name'], $_POST['email'], $password_hash]);
    } catch (Exception $e) {
        print $e;
    } finally {
        $dbh = null;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-5" style="width: 450px;">

<?php if ($register): ?>
      <p>ユーザ登録を完了しました。</p>
      <a href="/">トップページへ</a>
<?php else: ?>
      <form class="container p-5" style="width: 450px;" action="register.php" method="post">
        <div class="row mb-4">
          <h3>ユーザ登録</h3>
        </div>
        <div class="row mb-3">
          <label for="name-input" class="form-label">氏名</label>
<?php if ($check): ?>
            <p><?= $_POST['name'] ?></p>
            <input type="hidden" name="name" value="<?= $_POST['name'] ?>">
<?php else: ?>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="山田 太郎">
<?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="email-input" class="form-label">メールアドレス</label>
<?php if ($check): ?>
            <p><?= $_POST['email'] ?></p>
            <input type="hidden" name="email" value="<?= $_POST['email'] ?>">
<?php else: ?>
            <input type="email" name="email" class="form-control" id="email-input" placeholder="name@example.com">
<?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="password-input" class="form-label">パスワード</label>
<?php if ($check): ?>
            <p>****</p>
            <input type="hidden" name="password" value="<?= $_POST['password'] ?>">
<?php else: ?>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="8文字以上">
<?php endif ?>
        </div>
<?php if ($check): ?>
<?php else: ?>
          <div class="row mb-3">
            <label for="password-check-input" class="form-label">もう一度パスワードを入力してください</label>
            <input type="password" name="password-check" class="form-control" id="password-check-input">
          </div>
<?php endif ?>
        <div class="row my-4">
<?php if ($check): ?>
            <input type="hidden" name="register" value="1">
            <input type="submit" class="btn btn-primary" value="登録する">
<?php else: ?>
            <input type="hidden" name="check" value="1">
            <input type="submit" class="btn btn-primary" value="次に進む">
<?php endif ?>
        </div>
      </form>
<?php endif ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
