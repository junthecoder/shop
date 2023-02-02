<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
}

try {
    $db = new Database;

    $items = [];
    foreach ($_SESSION['cart'] as $cart_item) {
        $items[$cart_item['id']] = $db->get_item_by_id($cart_item['id']);
    }

    if (!isset($_POST['action'])) {
        $_POST['action'] = 'default';
    }
    if ($_POST['action'] == 'confirm') {
        $stmt = $db->prepare('INSERT INTO purchase (user_id) VALUES (?)');
        $stmt->execute([$_SESSION['user']['id']]);
        $purchase_id = $db->lastInsertId();

        $stmt = $db->prepare('INSERT INTO purchase_item (purchase_id, item_id, count) VALUES (?, ?, ?)');
        foreach ($_SESSION['cart'] as $cart_item) {
            $stmt->execute([$purchase_id, $cart_item['id'], $cart_item['count']]);
        }

        $_SESSION['cart'] = [];
    }
} catch (Exception $e) {
    print $e;
} finally {
    $db = null;
}

?>

<?php include_template('pre_body.php', ['title' => '注文']) ?>
  <?php if ($_POST['action'] == 'confirm'): ?>
    <div class="container p-5" style="width: 450px;">
      <p>注文を完了しました。</p>
      <p><a href="/">トップページへ</a></p>
    </div>
  <?php else: ?>
    <div class="container m-5">
      <div class="row">
        <h3 class="p-3">注文</h3>
      </div>
      <?php if (empty($_SESSION['cart'])): ?>
        <p>カートに商品はありません</p>
      <?php else: ?>
        <?php include_template('cart_items.php', ['deletable' => false, 'count_changeable' => false]) ?>
        <div class="row">
          <div class="row p-3 float-end">
            <form action="checkout.php" method="post">
              <input type="hidden" name="action" value="confirm">
              <button type="submit" class="btn btn-warning py-2">注文を確定する</button>
            </form>
          </div>
        </div>
      </div>
    <?php endif ?>
  <?php endif ?>
<?php include_template('post_body.php') ?>
