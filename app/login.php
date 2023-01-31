<?php
require_once('utility.php');
session_start();

default_value($_POST, 'check', 0);
$success = false;

if ($_POST['check'] == 1) {
    try {
        $dsn = 'mysql:dbname=shop;host=db-1;charset=utf8';
        $user = 'test';
        $password = 'test';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = 'SELECT name, password FROM user WHERE email = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$_POST['email']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $success = $row !== false and password_verify($_POST['password'], $row['password']);

        if ($success) {
            $_SESSION['user'] = $row;
        }
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
    <title>ログイン</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-5" style="width: 450px;">
<?php if ($success): ?>
      <p>ログインしました</p>
      <a href="/">トップページへ</a>
<?php else: ?>
      <form class="container p-5" style="width: 350px;" action="login.php" method="post">
        <div class="row mb-4">
          <h3>ログイン</h3>
        </div>
        <div class="row mb-3">
          <label for="email-input" class="form-label">メールアドレス</label>
          <input type="email" name="email" class="form-control" id="email-input" placeholder="name@example.com">
        </div>
        <div class="row mb-3">
          <label for="password-input" class="form-label">パスワード</label>
          <input type="password" name="password" class="form-control" id="password-input">
        </div>
        <div class="row my-4">
          <input type="hidden" name="check" value="1">
          <input type="submit" class="btn btn-primary" value="ログイン">
        </div>
      </form>      
<?php endif ?>        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
