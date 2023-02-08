<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

$db = new Database;

if (isset($_GET['delete'])) {
  $db->delete_address($_GET['id']);
  redirect();
}

if (isset($_GET['set_default'])) {
    $db->set_default_address($_SESSION['user']['id'], $_GET['id']);
    redirect();
}

$addresses = $db->get_addresses($_SESSION['user']['id']);
$default_address_id = $db->get_default_address_id($_SESSION['user']['id']);

?>

<?php include_template('pre_body.php', ['title' => '住所']) ?>
  <?php include 'header.php' ?>
  <div class="container p-4">
    <div class="row row-cols-auto py-4 g-4">
      <div class="col">
        <a href="address_edit.php" class="btn btn-primary">追加</a>
      </div>
    </div>
    <div class="row row-cols-auto g-4">
      <?php foreach ($addresses as $address): ?>
        <?php $is_default_address = ($address['id'] == $default_address_id) ?>
        <div class="col">
          <div class="card <?= $is_default_address ? 'border-primary' : ''?>" style="width: 18rem;">
            <div class="card-body">
              <h6 class="card-title fw-bold">
                <?= $address['full_name'] ?>
              </h6>
              <p class="card-text">
                <?= $address['postal_code'] ?><br>
                <?= $address['prefecture'] ?><br>
                <?= $address['address_line1'] ?>
                <?= $address['address_line2'] ?><br>
                <?= $address['address_line3'] ?>
                <?= $address['address_line4'] ?><br>
                <?= $address['phone_number'] ?>
              </p>
              <a class="fs-7" href="addresses_edit.php?id=<?= $address['id'] ?>">変更</a>
              <?php if (!$is_default_address): ?>
                <a href="/addresses.php/?delete=1&id=<?= $address['id'] ?>">削除</a>
                <a href="/addresses.php/?set_default=1&id=<?= $address['id'] ?>">規定の住所に設定</a>
              <?php endif ?>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
