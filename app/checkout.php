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
} catch (Exception $e) {
    print $e;
} finally {
    $db = null;
}

?>

<?php include_template('pre_body.php', ['title' => '注文']) ?>
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
<?php include_template('post_body.php') ?>
