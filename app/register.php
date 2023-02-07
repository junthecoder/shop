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
    redirect('register.php?check');
}

if (isset($_POST['register'])) {
    $_SESSION['post'] = $_POST;
    redirect('register.php?register');
}

$check = isset($_GET['check']);
$register = isset($_GET['register']);

$post = isset($_SESSION['post']) ? $_SESSION['post'] : [];

if ($register) {
    $db = new Database;
    $db->add_user($post['name'], $post['email'], $post['password']);

    session_regenerate_id(true);
    $_SESSION['user'] = $db->get_user($post['email']);
    redirect('index.php');
}

?>

<?php include_template('pre_body.php', ['title' => 'ユーザ登録']) ?>
  <div class="container p-5" style="width: 450px;">
    <?php if ($register): ?>
      <p>ユーザ登録を完了しました。</p>
      <a href="/">トップページへ</a>
    <?php else: ?>
      <form class="container p-5 needs-validation" style="width: 450px;" action="register.php" method="post" id="registration-form" novalidate>
        <div class="row mb-4">
          <h3>ユーザ登録</h3>
        </div>
        <div class="row mb-3">
          <label for="name-input" class="form-label">氏名</label>
          <?php if ($check): ?>
            <p><?= $post['name'] ?></p>
            <input type="hidden" name="name" value="<?= $post['name'] ?>">
          <?php else: ?>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="山田 太郎" required>
            <div class="invalid-feedback d-block" id="name-feedback"></div>
          <?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="email-input" class="form-label">メールアドレス</label>
          <?php if ($check): ?>
            <p><?= $post['email'] ?></p>
            <input type="hidden" name="email" value="<?= $post['email'] ?>">
          <?php else: ?>
            <input type="email" name="email" class="form-control" id="email-input" placeholder="name@example.com" required>
            <div class="invalid-feedback d-block" id="email-feedback"></div>
          <?php endif ?>
        </div>
        <div class="row mb-3">
          <label for="password-input" class="form-label">パスワード</label>
          <?php if ($check): ?>
            <p>****</p>
            <input type="hidden" name="password" value="<?= $post['password'] ?>">
          <?php else: ?>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="8文字以上" required>
            <div class="invalid-feedback d-block" id="password-feedback"></div>
          <?php endif ?>
        </div>
      <?php if ($check): ?>
      <?php else: ?>
          <div class="row mb-3">
            <label for="password-check-input" class="form-label">もう一度パスワードを入力してください</label>
            <input type="password" name="password-check" class="form-control" id="password-check-input" required>
            <div class="invalid-feedback d-block" id="password-check-feedback"></div>
          </div>
      <?php endif ?>
        <div class="row my-4">
          <?php if ($check): ?>
            <input type="hidden" name="register" value="1">
            <input type="submit" class="btn btn-primary" value="登録する">
          <?php else: ?>
            <input type="hidden" name="check" value="1">
            <input type="submit" class="btn btn-primary" name="submit" value="次に進む">
          <?php endif ?>
        </div>
      </form>
    <?php endif ?>
  </div>

  <script>
    'use strict';

    function validateName() {
      let name = $('#name-input').val();

      let errors = [];
      if (!/\S/.test(name)) {
        errors.push('名前を入力してください');
      }
      $('#name-feedback').html(errors.join('<br>'));

      return errors.length === 0;
    }

    function validateEmail() {
      let email = $('#email-input').val();

      let errors = [];
      if (!/^\S+@\S+$/.test(email)) {
        errors.push('メールアドレスを入力してください');
      }
      $('#email-feedback').html(errors.join('<br>'));

      $.ajax({
        type: 'POST',
        url: 'validation.php',
        data: { email }
      })
      .done(data => {
        $('#email-feedback').html(JSON.parse(data)).join('<br>');
      });

      return errors.length === 0;
    }

    function validatePassword() {
      let password = $('#password-input').val();

      let errors = [];
      if (password.length === 0) {
        errors.push('パスワードを入力してください');
      }
      if (!/[a-zA-Z]/.test(password)) {
        errors.push('アルファベットが含まれていません');
      }
      if (!/\d/.test(password)) {
        errors.push('数字が含まれていません');
      }
      $('#password-feedback').html(errors.join('<br>'));

      return errors.length === 0;
    }

    function validatePasswordCheck() {
      let password = $('#password-input').val();
      let passwordCheck = $('#password-check-input').val();

      let errors = [];
      if (password !== passwordCheck) {
        errors.push('パスワードが一致しません')
      }
      $('#password-check-feedback').html(errors.join('<br>'));

      return errors.length === 0;
    }

    $('#name-input')[0].addEventListener('input', validateName);
    $('#email-input')[0].addEventListener('input', validateEmail);
    $('#password-input')[0].addEventListener('input', validatePassword);
    $('#password-check-input')[0].addEventListener('input', validatePasswordCheck);

    $('#registration-form')[0].addEventListener('submit', event => {
      if (!(validateName() & validateEmail() & validatePassword() & validatePasswordCheck())) {
        event.preventDefault();
        event.stopPropagation();
      }
    });
  </script>
<?php include_template('post_body.php') ?>
