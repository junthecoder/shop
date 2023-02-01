<?php

session_start();

if (isset($_SESSION['user'])) {
    $_SESSION = [];
    if (session_id() != '' || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 2592000, '/');
    }
    session_destroy();
}

?>

<?php include_template('pre_body.php', ['title' => 'ログアウト']) ?>
  <div class="container p-5" style="width: 450px;">
    <p>ログアウトしました</p>
    <a href="/">トップページへ</a>
  </div>
<?php include_template('post_body.php') ?>
