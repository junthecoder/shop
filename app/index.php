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

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
