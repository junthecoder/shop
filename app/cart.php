<?php
require_once('utility.php');
session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

try {
    $dsn = 'mysql:dbname=shop;host=db-1;charset=utf8';
    $user = 'test';
    $password = 'test';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $_SESSION['cart'][] = get_item_by_id($dbh, $_POST['item_id']);
                break;
            case 'delete':
                $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['item_id']);
                break;
        }
    }

    $ids = array_map(fn($item) => $item['id'], $_SESSION['cart']);
    $items = get_items_by_ids($dbh, $ids);
} catch (Exception $e) {
    print $e;
} finally {
    $dbh = null;
}

?>

<?php include_template('pre_body.php', ['title' => 'ショッピングカート']) ?>
  <?php include 'header.php' ?>  
  <div class="container m-5">
    <div class="row">
      <h3 class="p-3">ショッピングカート</h3>
    </div>
    <div class="row">
      <div class="col">
        <?php foreach ($items as $item): ?>
        <div class="card">
          <div class="d-flex justify-content-between">
            <img src="/images/200x200.png" class="card-img-left" alt="<?= $item['name'] ?>" style="width: 160px; height: 160px">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <h5 class="card-title"><?= $item['name'] ?></h5>
                <p class="">¥<?= $item['price'] ?></p>
              </div>
              <div class="float-end">
                <form action="cart.php" method="post">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                  <button type="submit" class="btn btn-danger">削除</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <div class="row p-3 float-end">
      <form action="checkout.php" method="post">
        <button type="submit" class="btn btn-warning py-2">レジに進む</button>
      </form>
    </div>
  </div>
<?php include_template('post_body.php') ?>
