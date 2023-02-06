<?php
require_once('utility.php');
require_once('database.php');
session_start();

default_value($_POST, 'name', '');
default_value($_POST, 'email', '');
default_value($_POST, 'password', '');
default_value($_POST, 'password-check', '');

if (isset($_POST['check'])) {
    $_SESSION['post'] = $_POST;
    header('Location: register.php?check');
}

if (isset($_POST['register'])) {
    $_SESSION['post'] = $_POST;
    header('Location: register.php?register');
}

$check = isset($_GET['check']);
$register = isset($_GET['register']);

$post = isset($_SESSION['post']) ? $_SESSION['post'] : [];

if ($register) {
    $db = new Database;
    $db->add_user($post['name'], $post['email'], $post['password']);

    session_regenerate_id(true);
    $_SESSION['user'] = $db->get_user($post['email']);
    header('Location: index.php');
}

?>

<?php include_template('pre_body.php', ['title' => 'ユーザ登録']) ?>
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
            <p><?= $post['name'] ?></p>
            <input type="hidden" name="name" value="<?= $post['name'] ?>">
          <?php else: ?>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="山田 太郎">
          <?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="email-input" class="form-label">メールアドレス</label>
          <?php if ($check): ?>
            <p><?= $post['email'] ?></p>
            <input type="hidden" name="email" value="<?= $post['email'] ?>">
          <?php else: ?>
            <input type="email" name="email" class="form-control" id="email-input" placeholder="name@example.com">
          <?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="password-input" class="form-label">パスワード</label>
          <?php if ($check): ?>
            <p>****</p>
            <input type="hidden" name="password" value="<?= $post['password'] ?>">
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
<?php include_template('post_body.php') ?>

