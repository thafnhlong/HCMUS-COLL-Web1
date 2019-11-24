<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<h1>Quên mật khẩu</h1>
<?php if (isset($_POST['email'])): ?>
<?php
  $email = $_POST['email'];
  $_SESSION['EmailForgot']=$email;
  $success = false;
  $success = checkEmail($email);
?>
<?php if ($success): ?>
    <?php SendMailFogetPasss($currentUser['Name'],$email) ?>
    <div class="alert alert-danger" role="alert">
        Vui lòng vào email để thiết lập lại mật khẩu
    </div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
  Không tìm thấy địa chỉ email
</div>
<?php endif; ?>
<?php else: ?>
<form method="POST" action="forgot_password.php">
  <div class="form-group">
    <label for="code">Nhập địa chỉ email để thiết lập lại mật khẩu</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
  </div>
  <button type="submit" class="btn btn-primary">Thiết lập lại mật khẩu</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
