<?php
require_once('utility.php');
require_once('database.php');

$db = new Database;
$items = [];
foreach ($_SESSION['cart'] as $cart_item) {
    $items[$cart_item['id']] = $db->get_item_by_id($cart_item['id']);
}

$total_price = 0;

?>

<div class="row">
  <div class="col">
    <?php foreach ($_SESSION['cart'] as $cart_item): ?>
      <?php
        $item = $items[$cart_item['id']];
        $total_price += $item['price'] * $cart_item['count'];
      ?>
      <div class="card">
        <div class="d-flex justify-content-between">
          <img src="/images/200x200.png" class="card-img-left" alt="<?= $item['name'] ?>" style="width: 160px; height: 160px">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h5 class="card-title"><?= $item['name'] ?></h5>
              <p class="">¥<?= $item['price'] * $cart_item['count'] ?></p>
            </div>
            <?php if ($count_changeable): ?>
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
            <?php endif ?>
            <?php if ($deletable): ?>
              <div class="float-end">
                <form action="cart.php" method="post">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                  <button type="submit" class="btn btn-danger">削除</button>
                </form>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php endforeach ?>
    <div class="fs-5 px-2 py-3 text-end">
      小計 ¥<?= $total_price ?>
    </div>
  </div>
</div>
