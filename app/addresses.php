<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

if (isset($_GET['set_default'])) {
    $db = new Database;
    $stmt = $db->prepare('UPDATE user SET default_address_id = ? WHERE id = ?');
    $stmt->execute([$_GET['id'], $_SESSION['user']['id']]);
    header("Location: /addresses.php");
}

try {
    $db = new Database;
    $stmt = $db->prepare(<<<'EOT'
        SELECT address.id AS id, full_name, phone_number, postal_code, prefecture.name AS prefecture, address_line1, address_line2, address_line3, address_line4
        FROM user_address
        JOIN address
        ON user_address.address_id = address.id
        JOIN prefecture
        ON address.prefecture_id = prefecture.id
        WHERE user_address.user_id = ?
    EOT);
    $stmt->execute([$_SESSION['user']['id']]);
    $addresses = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $addresses[] = $row;
    }

    $stmt = $db->prepare('SELECT default_address_id FROM user WHERE user.id = ?');
    $stmt->execute([$_SESSION['user']['id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $default_address_id = $row['default_address_id'];
} catch (Exception $e) {
    echo $e;
}
?>

<?php include_template('pre_body.php', ['title' => '住所']) ?>
  <?php include 'header.php' ?>
  <div class="container p-4">
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
                <a href="#">削除</a>
                <a href="/addresses.php/?set_default=1&id=<?= $address['id'] ?>">規定の住所に設定</a>
              <?php endif ?>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php include_template('post_body.php') ?>
