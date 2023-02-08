<?php
require_once('utility.php');
require_once('database.php');
session_start();

$db = new Database;

$num_items_per_page = 10;
$num_items = $db->count_items();
$num_pages = ceil($num_items / $num_items_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$items = $db->get_items_batch($num_items_per_page * ($current_page - 1), $num_items_per_page);

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
    <div class="row my-4">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="/">前へ</a>
        </li>
        <?php for ($i = 1; $i <= $num_pages; ++$i): ?>
          <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
            <a class="page-link" href="/?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor ?>
        <li class="page-item <?= ($current_page == $num_pages) ? 'disabled' : '' ?>">
          <a class="page-link" href="/?page=<?= $current_page + 1 ?>">次へ</a>
        </li>
      </ul>
    </div>
  </div>
<?php include_template('post_body.php') ?>
