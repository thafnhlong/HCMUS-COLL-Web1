<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<h1>Kích hoạt mật khẩu</h1>
<?php if (isset($_GET['code'])): ?>
<?php
  $success = false;
  if($code = $_GET['code'])
  {
    $success = true;
  }
?>
<?php if ($success): ?>
<?php header('Location: reset_password.php'); ?>
<?php else: ?>
<div class="alert alert-danger" role="alert">
  Kích hoạt mật khẩu thất bại
</div>
<?php endif; ?>
<?php else: ?>
<form method="GET">
  <div class="form-group">
    <label for="code">Mã kích hoạt</label>
    <input type="text" class="form-control" id="code" name="code" placeholder="Mã kích hoạt">
  </div>
  <button type="submit" class="btn btn-primary">Kích hoạt mật khẩu</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
