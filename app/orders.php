<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

$db = new Database;
$purchases = $db->get_purchases($_SESSION['user']['id']);

?>

<?php include_template('pre_body.php', ['title' => '注文履歴']) ?>
  <?php include 'header.php' ?>
  <div class="container px-3 py-5 g-4">
    <div class="row">
      <?php foreach ($purchases as $purchase): ?>
        <div class="col">
          <div class="card">
            <div class="card-header">
              <div class="container">
                <div class="row">
                  <div class="col-6">
                    注文日<br>
                    <?= date("Y年m月d日", strtotime($purchase['purchase_time'])) ?>
                  </div>
                  <div class="col-6 text-end">
                    合計<br>
                    ¥
                    <?php
                      echo array_reduce(
                          $purchase['items'],
                          fn ($total, $item) => $total + $item['price'] * $item['count'])
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="container g-4">
              <?php foreach ($purchase['items'] as $item): ?>
                <div class="row row-cols-auto py-1">
                  <div class="col-4">
                    <img src="/images/200x200.png" class="rounded" alt="<?= $item['name'] ?>" style="width: 120px; height: 120px">
                  </div>
                  <div class="col-4">
                    <h6 class="card-text"><?= $item['name'] ?></h6>
                    <p class="card-text">数量: <?= $item['count'] ?></p>
                  </div>
                  <div class="col-4">
                    <p class="card-text text-end">¥<?= $item['price'] * $item['count'] ?></p>
                  </div>
                </div>
              <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
