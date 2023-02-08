<?php
require_once('utility.php');
require_once('database.php');
session_start();

if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

if (isset($_POST['cancel_button'])) {
  redirect('addresses.php');
}

if (isset($_POST['save_button'])) {
    $db = new Database;
    if (isset($_POST['id'])) {
        $db->update_address($_POST['id'], $_POST);
    } else {
        $db->add_address($_SESSION['user']['id'], $_POST);
    }
    redirect('addresses.php');
}

$db = new Database;

if (isset($_GET['id'])) {
    $address = $db->get_address($_GET['id']);
    if ($address === false) {
        die("住所のIDが不正です。");
    }
} else {
  $address = [
      'id' => null,
      'full_name' => $_SESSION['user']['name'],
      'phone_number' => '',
      'postal_code' => '',
      'prefecture_id' => '',
      'address_line1' => '',
      'address_line2' => '',
      'address_line3' => '',
      'address_line4' => ''
  ];
}

$prefectures = $db->get_prefectures();

?>

<?php include_template('pre_body.php', ['title' => '住所']) ?>
  <?php include 'header.php' ?>
  <div class="container p-4">
    <form action="address_edit.php" method="post">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="full_name_input" placeholder="氏名" name="full_name" value="<?= $address['full_name'] ?>">
        <label for="full_name_input">氏名</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="postal_code_input" placeholder="郵便番号" name="postal_code" value="<?= $address['postal_code'] ?>">
        <label for="postal_code_input">郵便番号</label>
      </div>
      <!-- Use combobox -->
      <div class="form-floating mb-3">
        <select name="prefecture_id" class="form-select" style="width: 10em" id="prefecture_select" name="prefecture" placeholder="都道府県">
          <?php foreach ($prefectures as $prefecture): ?>
            <option
              value="<?= $prefecture['id'] ?>"
              <?= ($prefecture['id'] == $address['prefecture_id']) ? 'selected' : '' ?>
            >
              <?= $prefecture['name'] ?>
            </option>
          <?php endforeach ?>
        </select>
        <label for="prefecture_select">都道府県</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="address_line1_input" placeholder="市区町村" name="address_line1" value="<?= $address['address_line1'] ?>">
        <label for="address_line1_input">市区町村</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="address_line2_input" placeholder="丁目・番地" name="address_line2" value="<?= $address['address_line2'] ?>">
        <label for="address_line2_input">丁目・番地</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="address_line3_input" placeholder="建物名" name="address_line3" value="<?= $address['address_line3'] ?>">
        <label for="address_line3_input">建物名</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="address_line4_input" placeholder="部屋番号" name="address_line4" value="<?= $address['address_line4'] ?>">
        <label for="address_line4_input">部屋番号</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="phone_number_input" placeholder="電話番号" name="phone_number" value="<?= $address['phone_number'] ?>">
        <label for="phone_number_input">電話番号</label>
      </div>
      <div class="row p-2 float-end">
        <div class="col">
          <?php if (isset($_GET['id'])): ?>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
          <?php endif ?>
          <input type="submit" class="btn btn-secondary mx-1" name="cancel_button" value="キャンセル">
          <input type="submit" class="btn btn-primary mx-1" name="save_button" value="保存する">
        </div>
      </div>
    </form>
  </div>
<?php include_template('post_body.php') ?>
