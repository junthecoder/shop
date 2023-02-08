<?php
require_once('utility.php');
require_once('database.php');
session_start();
ensure_login();

$links = [
  ['title' => '注文履歴', 'href' => 'orders.php'],
  ['title' => 'アドレス帳', 'href' => 'addresses.php'],
  ['title' => 'アカウント情報の変更', 'href' => '#']
]
?>

<?php include_template('pre_body.php', ['title' => 'アカウント']) ?>
  <?php include 'header.php' ?>
  <div class="container px-3 py-5">
    <div class="row row-cols-auto g-4">
      <?php foreach ($links as $link): ?>
        <div class="col">
          <div class="card mb-3" style="width: 320px; height: 80px;">
            <div class="row g-0">
              <div class="card-body">
                <h6 class="card-title fw-bold" style="font-family: Meiryo;"><?= $link['title'] ?></h6>
                <a href="<?= $link['href'] ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
