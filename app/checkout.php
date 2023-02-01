<?php
require_once('utility.php');
session_start();

try {
    $dsn = 'mysql:dbname=shop;host=db-1;charset=utf8';
    $user = 'test';
    $password = 'test';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ids = array_map(fn($item) => $item['id'], $_SESSION['cart']);
    $items = get_items_by_ids($dbh, $ids);
} catch (Exception $e) {
    print $e;
} finally {
    $dbh = null;
}

?>

<?php include_template('pre_body.php', ['title' => '注文']) ?>
  <div class="container m-5">
    <div class="row">
      <div class="row p-3 float-end">
        <form action="order.php" method="post">
          <button type="submit" class="btn btn-warning py-2">注文を確定する</button>
        </form>
      </div>
    </div>
  </div>
<?php include_template('post_body.php') ?>
