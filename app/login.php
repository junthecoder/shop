<?php
require_once('utility.php');
require_once('database.php');
session_start();

default_value($_POST, 'check', 0);
$success = false;

if ($_POST['check'] == 1) {
    try {
        $db = new Database;

        $sql = 'SELECT id, name, password FROM user WHERE email = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['email']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $success = ($row !== false and password_verify($_POST['password'], $row['password']));

        if ($success) {
            $_SESSION['user'] = $row;
            header('Location: index.php');
        }
    } catch (Exception $e) {
        print $e;
    } finally {
        $db = null;
    }
}

?>

<?php include_template('pre_body.php', ['title' => 'ログイン']) ?>
  <div class="container p-5" style="width: 450px;">
    <?php if ($success): ?>
      <script>
        setTimeout(() => { document.location = '/'; }, 3000);
      </script>
      <p>ログインしました</p>
      <p><a href="/">トップページへ</a></p>
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
      <form class="container px-5" style="width: 350px;" action="register.php" method="post">
        <div class="row">
          <input type="submit" class="btn btn-secondary" value="アカウントを作成する">
        </div>
      </form>
    <?php endif ?>
  </div>
<?php include_template('post_body.php') ?>
