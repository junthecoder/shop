<?php
require_once('utility.php');
require_once('database.php');
session_start();

try {
    $db = new Database;
    $ids = array_map(fn($item) => $item['id'], $_SESSION['cart']);
    $items = $db->get_items_by_ids($ids);
} catch (Exception $e) {
    print $e;
} finally {
    $db = null;
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
