<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if ($_POST) {
    try {
        $db = new Database;

        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add':
                    $_SESSION['cart'][] = ['id' => $_POST['item_id'], 'count' => 1];
                    break;
                case 'change_count':
                    foreach ($_SESSION['cart'] as $key => $item) {
                        if ($item['id'] == $_POST['item_id']) {
                            $_SESSION['cart'][$key]['count'] = $_POST['count'];
                            break;
                        }
                    }
                    break;
                case 'delete':
                    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['item_id']);
                    break;
            }
        }
    } catch (Exception $e) {
        print $e;
    } finally {
        $db = null;
    }

    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    exit();
}

?>

<?php include_template('pre_body.php', ['title' => 'ショッピングカート']) ?>
  <?php include 'header.php' ?>
  <div class="container m-5">
    <div class="row">
      <h3 class="p-3">ショッピングカート</h3>
    </div>
    <?php if (empty($_SESSION['cart'])): ?>
      <p>カートに商品はありません</p>
    <?php else: ?>
      <?php include_template('cart_items.php', ['deletable' => true, 'count_changeable' => true]) ?>
      <div class="row p-2 float-end">
        <form action="checkout.php" method="post">
          <input type="hidden" name="action" value="default">
          <button type="submit" class="btn btn-warning py-2">レジに進む</button>
        </form>
      </div>
    <?php endif ?>
  </div>
<?php include_template('post_body.php') ?>
