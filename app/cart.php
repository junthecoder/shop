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
                $_SESSION['cart'][] = ['id' => $_POST['item_id'], 'count' => 1];
                break;
            case 'change_count':
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] == $_POST['item_id']) {
                        $_SESSION['cart'][$key]['count'] = $_POST['count'];
                        break;
                    }
                  }
                break;
            case 'delete':
                $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['item_id']);
                break;
        }
    }

    $items = [];
    foreach ($_SESSION['cart'] as $cart_item) {
        $items[$cart_item['id']] = get_item_by_id($dbh, $cart_item['id']);
    }
} catch (Exception $e) {
    print $e;
} finally {
    $dbh = null;
}

?>

<?php include_template('pre_body.php', ['title' => 'ショッピングカート']) ?>
  <?php include 'header.php' ?>
  <script>
    function changeCount(event) {
      event.target.getAttribute('data-itemid');
    }
  </script>
  <div class="container m-5">
    <div class="row">
      <h3 class="p-3">ショッピングカート</h3>
    </div>
    <?php if (empty($_SESSION['cart'])): ?>
      <p>カートに商品はありません</p>
    <?php else: ?>
      <div class="row">
        <div class="col">
          <?php foreach ($_SESSION['cart'] as $cart_item): ?>
            <?php $item = $items[$cart_item['id']]; ?>
            <div class="card">
              <div class="d-flex justify-content-between">
                <img src="/images/200x200.png" class="card-img-left" alt="<?= $item['name'] ?>" style="width: 160px; height: 160px">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h5 class="card-title"><?= $item['name'] ?></h5>
                    <p class="">¥<?= $item['price'] * $cart_item['count'] ?></p>
                  </div>
                  <form action="cart.php" method="post">
                    <input type="hidden" name="action" value="change_count">
                    <input type="hidden" name="item_id" value="<?= $cart_item['id'] ?>">
                    <select name="count" class="form-select form-select-sm" style="width: 5em" value="<?= $cart_item['count'] ?>" onchange="this.form.submit()">
                      <?php for ($i = 1; $i <= 10; ++$i): ?>
                        <option
                          value="<?= $i ?>"
                          <?php if ($i == $cart_item['count']): ?>
                              selected="selected"
                          <?php endif ?>
                        >
                          <?= $i ?>
                        </option>
                      <?php endfor ?>
                    </select>
                  </form>
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
    <?php endif ?>
  </div>
<?php include_template('post_body.php') ?>
