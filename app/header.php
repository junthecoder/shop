<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">ショッピングサイト（仮）</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
<?php if (isset($_SESSION['user'])): ?>
            <a class="nav-link" href="login.php"><?= $_SESSION['user']['name'] ?> さん</a>
<?php else: ?>
            <a class="nav-link" href="login.php">ログイン</a>
<?php endif ?>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">カート</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
