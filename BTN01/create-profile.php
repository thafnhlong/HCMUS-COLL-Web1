<?php 
ob_start();
?>
<?php
    if(!$current)
    {
        header('Location: index.php');
        exit();
    }
?>
<?php include 'header.php' ?>
<?php
  $nameIMG=nameIMG($current['ID']);
?>
<?php if( isset($_POST['Name'])): ?>
<?php
    $NameUD=$_POST['Name'];
    $temp=false;

    if($NameUD!='')
    {
      uploadFileToSql($current['ID']);
      UpdateProfile($NameUD,$current['ID']);
      $temp=true;
    }
?>
<?php if($temp ): ?>
<?php header('Location: index.php') ?>
<?php else: ?>
    <div class="alert alert-primary" role="alert">
    <h1>Cập nhật thông tin thất bại !!!</h1>
    </div>
<?php endif; ?> 
<?php else: ?>
<h1>Quản lý thông tin</h1>
<br>
<form action="update_profile.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label ></label><strong>Họ và tên </strong></label>
        <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $current['Name'] ?>" placeholder="Nhập tên mới ...">
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
      <button  type="submit" class="btn btn-primary">Cập nhật </button>
    </div>
</form>
<?php endif; ?>  
<script>
    $('#fileSelect').change(function(e){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#avatarImg").fadeIn("fast").attr('src',tmppath);
    })
</script>