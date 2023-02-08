<?php
require_once('utility.php');
require_once('database.php');
session_start();

$db = new Database;
$items = $db->get_all_items();

?>

<?php include_template('pre_body.php', ['title' => 'トップページ']) ?>
  <?php include 'header.php' ?>
  <div class="container px-3 py-5">
    <div class="row row-cols-auto g-4">
      <?php foreach ($items as $item): ?>
        <div class="col">
          <div class="card" style="width: 12rem;">
            <img src="/images/200x200.png" class="card-img-top" alt="<?= $item['name'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $item['name'] ?></h5>
              <p class="card-text">¥<?= $item['price'] ?></p>
            </div>
            <form action="cart.php" method="post">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
              <div class="container">
                <div class="row">
                  <button type="submit" class="btn btn-warning mx-auto">カートに入れる</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
