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

<?php include_template('pre_body.php', ['title' => 'ログイン']) ?>
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

    <form class="container px-5" style="width: 350px;" action="register.php" method="post">
      <div class="row">
        <input type="submit" class="btn btn-secondary" value="アカウントを作成する">
      </div>
    </form>
  </div>
<?php include_template('post_body.php') ?>
