<?php
require_once('utility.php');
require_once('database.php');
session_start();

$success = false;

if ($_POST) {
    $db = new Database;
    $row = $db->get_user($_POST['email']);
    $success = ($row !== false and password_verify($_POST['password'], $row['password']));
    if ($success) {
        session_regenerate_id(true);
        $_SESSION['user'] = $row;
        redirect('index.php');
    } else {
        redirect(add_to_history: false);
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
          <input type="submit" class="btn btn-primary" value="ログイン">
        </div>
      </form>
      <div class="container px-5" style="width: 350px;">
        <div class="row">
          <a href="register.php" class="btn btn-secondary">アカウントを作成する</a>
        </div>
      </form>
    <?php endif ?>
  </div>
<?php include_template('post_body.php') ?>
