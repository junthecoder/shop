<?php
require_once('utility.php');
session_start();

try {
    $dsn = 'mysql:dbname=shop;host=db-1;charset=utf8';
    $user = 'test';
    $password = 'test';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $items = get_all_items($dbh);
} catch (Exception $e) {
    print $e;
} finally {
    $dbh = null;
}

?>

<?php include_template('pre_body.php', ['title' => 'トップページ']) ?>
  <?php include 'header.php' ?>
  <div class="container">
    <div class="row">
      <?php foreach ($items as $item): ?>
        <div class="col">
          <div class="card my-2" style="width: 12rem;">
            <img src="/images/200x200.png" class="card-img-top" alt="<?= $item['name'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $item['name'] ?></h5>
              <p class="card-text">¥<?= $item['price'] ?></p>
            </div>
            <form action="cart.php" method="post">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-warning">カートに入れる</button>
            </form>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
