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
<?php if( isset($_POST['Name'])): ?>
<?php
    $NameUD=$_POST['Name'];
    $PhoneUD=$_POST['PhoneNumber'];
    $temp=false;

    if($NameUD!='')
    {
        updateProfile($NameUD,$PhoneUD,$currentUser['ID']);
        if($_FILES['file']['tmp_name']!=null)
        {
            uploadFileToSql($currentUser['ID']);
        }
        $temp=true;
    }
?>
<?php if($temp ): ?>
<?php header('Location: index.php') ?>
<?php else: ?>
    <div class="alert alert-primary" role="alert">
    Cập nhật thông tin cá nhân thất bại
    </div>
<?php endif; ?> 
<?php else: ?>
<h1>Cập nhật thông tin cá nhân</h1>
<br>
<form action="create-profile.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label ></label><strong>Họ và tên </strong></label>
        <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $currentUser['Name'] ?>" placeholder="Nhập tên mới ...">
    </div>
    <div class="form-group">
    <div class="form-group">
        <label ></label><strong>Số điện thoại </strong></label>
        <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" value="<?php echo $currentUser['PhoneNumber'] ?>" placeholder="Nhập số điện thoại ...">
    </div>
    <div class="form-group">
      <label for="fileSelect"><strong>Avatar</strong></label>
      <br>
      <!-- -->
      <img id="avatarImg" >
      <!-- -->
      <br>
      <input type="file" name="file" id="fileSelect">
      <br>
      <p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 5MB.</p>
      <br>
    </div>
    <button  type="submit" class="btn btn-primary">Cập nhật </button>
</form>
<?php endif; ?>  
<?php include 'footer.php' ?>

<script>
    $('#fileSelect').change(function(e){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#avatarImg").fadeIn("fast").attr('src',tmppath);
    })
</script>