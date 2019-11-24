<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<h1>Tạo mật khẩu mới</h1>
<?php if (isset($_GET['code'])): ?>
<?php
  $pass = $_GET['code'];
  UpdatePass($_SESSION['EmailForgot'],$pass);
?>
<div class="alert alert-danger" role="alert">
  Bạn đã đổi mật khẩu thành công
</div>
<?php else: ?>
<form method="GET">
  <div class="form-group">
    <label for="code">Nhập mật khẩu mới</label>
    <input type="password" class="form-control" id="code" name="code" placeholder="Mật khẩu">
  </div>
  <button type="submit" class="btn btn-primary">Tạo mật khẩu</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
