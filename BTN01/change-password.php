<?php 
ob_start();
  require_once 'init.php';
?>
<?php
    if(!$currentUser)
    {
        header('Location: index.php');
        exit();
    }
?>
<?php include 'header.php' ?>
<?php if( isset($_POST['PassNew']) && ($_POST['Pass'])): ?>
<?php
    $Passdn=$_POST['Pass'];
    $PassdnNew=$_POST['PassNew'];
    $temp=false;

    if( password_verify($Passdn, $currentUser['Pass']))
    {
        ChangePass($PassdnNew,$currentUser['ID']);
        $temp=true;
    }
?>
<?php if($temp ): ?>
<?php header('Location: index.php') ?>
<?php else: ?>
    <div class="alert alert-primary" role="alert">
    Đổi mật khẩu thất bại!!!
    </div>
<?php endif; ?> 
<?php else: ?>
<h1>Đăng mật khẩu</h1>
<br>
<form method="POST" action="change-password.php">
  <div class="form-group">
    <label ></label><strong>Mật khẩu hiện tại </strong></label>
    <input type="password" class="form-control" name="Pass" id="pass" placeholder="Nhập mật khẩu cũ ...">
  </div>
  <div class="form-group">
    <label ></label><strong>Mật khẩu mới </strong></label>
    <input type="password" class="form-control" name="PassNew" id="pass" placeholder="Nhập mật khẩu mới ...">
  </div>
  <button  type="submit" class="btn btn-primary">Đổi mật khẩu </button>
</form>
<?php endif; ?> 
<?php include 'footer.php' ?>