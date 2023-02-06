<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (empty($_SESSION['cart'])) {
    redirect('cart.php');
}

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
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
        $stmt = $db->prepare('INSERT INTO purchase (user_id, address_id) VALUES (?, ?)');
        $stmt->execute([$_SESSION['user']['id'], $_POST['address_id']]);
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

$db = new Database;
$addresses = $db->get_addresses($_SESSION['user']['id']);
$default_address_id = $db->get_default_address_id($_SESSION['user']['id']);

function concat_address($a)
{
  return sprintf(
      '%s, 〒%s, %s %s %s %s %s, 電話番号: %s',
      $a['full_name'],
      $a['postal_code'], $a['prefecture'],
      $a['address_line1'], $a['address_line2'],
      $a['address_line3'], $a['address_line4'],
      $a['phone_number']
  );
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
        <form action="checkout.php" method="post">
          <?php include_template('cart_items.php', ['deletable' => false, 'count_changeable' => false]) ?>
          <?php foreach ($addresses as $address): ?>
            <div class="form-check">
              <?php $radio_id = "address_radio<?= {$address['id']} ?>"; ?>
              <input
                class="form-check-input"
                type="radio"
                name="address_id"
                value="<?= $address['id'] ?>"
                id="<?= $radio_id ?>"
                <?= ($address['id'] == $default_address_id) ? 'checked' : '' ?>
              >
              <label class="form-check-label" for="<?= $radio_id ?>">
                <?= concat_address($address) ?>
              </label>
            </div>
          <?php endforeach ?>
          <div class="row p-2 float-end">
            <input type="hidden" name="action" value="confirm">
            <button type="submit" class="btn btn-warning py-2">注文を確定する</button>
          </div>
        </form>
      </div>
    <?php endif ?>
  <?php endif ?>
<?php include_template('post_body.php') ?>
