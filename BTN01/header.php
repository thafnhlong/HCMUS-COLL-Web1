<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/1e69072511.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <link rel="stylesheet" href="App/modals.css">
    <title>BTN01-SBTC</title>
  </head>
  <?php //require_once 'css-header.php'; ?>
  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Lập trình Web 1</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo $CurrentPage == 'index' ? 'active' : '' ?>">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <?php if ($currentUser): ?>
            <li class="nav-item <?php echo $CurrentPage == 'create-profile' ? 'active' : '' ?>">
              <a class="nav-link" href="create-profile.php">Cập nhật thông tin cá nhân</a>
            </li>
            <li class="nav-item <?php echo $CurrentPage == 'profile' ? 'active' : '' ?>">
              <a class="nav-link" href="profile.php">Trang cá nhân</a>
            </li>
            <?php endif; ?>
            <?php if (!$currentUser): ?>
            <li class="nav-item <?php echo $CurrentPage == 'register' ? 'active' : '' ?>">
              <a class="nav-link" href="register.php">Đăng ký</a>
            </li>
            <li class="nav-item <?php echo $CurrentPage == 'login' ? 'active' : '' ?>">
              <a class="nav-link" href="login.php">Đăng nhập</a>
            </li>
            <li class="nav-item <?php echo $CurrentPage == 'forgot_password' ? 'active' : '' ?>">
              <a class="nav-link" href="forgot_password.php">Quên mật khẩu</a>
            </li>
            <?php else: ?>
            <li class="nav-item <?php echo $CurrentPage == 'change-password' ? 'active' : '' ?>">
              <a class="nav-link" href="change-password.php">Đổi mật khẩu</a>
            </li>
            <li class="nav-item <?php echo $CurrentPage == 'logout' ? 'active' : '' ?>">
              <a class="nav-link" href="logout.php">Đăng xuất<?php echo $currentUser ? ' (' . $currentUser['Name'] . ') ' : '' ?></a>
            </li>
            <?php endif; ?>
        </div>
      </nav>