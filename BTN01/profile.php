<?php
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: index.php');
    exit();
}

$error = 0;

if (isset($_POST['submit']) )
{
    if (!empty($_POST['content']))
    {
        $content = $_POST['content'];
        
        $haveimage = true;
        if (!empty($_FILES['file'])){
            $fileupload = $_FILES['file'];
            if (!$fileupload["error"])
            {
                if (!checkImageType($fileupload['type']))
                    $error =1;
                else if ($fileupload['size'] > 50*1024)
                    $error =2;
            }
            else $haveimage = false;
        }
        $image = "";
        
        if (!$error){
        
            $user = $currentUser;
            
            if ($haveimage)
                $image = file_get_contents($fileupload['tmp_name']);
            
            userPost($user,$content,$image);
        }
    } else 
        $error = -1;
} else 
    $error = -3;

include "header.php";
?>
<div>
  <div style="margin:5px;">
    <div>
      <img style="width:100%;height:500px;" src="https://i.imgur.com/r9FGLUv.jpg" alt="Smiley face">
      <div style="bottom: 240px;left: 350px;position: absolute;">
        <h1 style="color:white">Nguyen Van A</h1>
      </div>
      <img src="getImage.php?type=avatar&id=87&<?php echo $currentUser['ID']?>" style="
      left: 150px;
      top: 270px;
      position: absolute;
      border-radius: 100%;">
    </div>
    
    
    <div style="display:flex;margin-top:20px;">
      <div style="float:left;width:54.0%;padding:10px;">
        <h2 style="margin:auto;width:50%">Thong tin ca nhan</h2>
        <hr>
        <ul>
          <li>Ho ten: Nguyen Van A</li>
          <li>SDT: 09821323456</li>
          <li>Email: sss@sss.com</li>
          <li>Dia chi: 123 Su van Hanh Phuong 2 Quan 10 TP HO CHI MINH </li>
          <li>So nguoi theo doi: 100 nguoi</li>
        </ul>
        <hr>
      </div>
      
      <div style="float:left;width:45.0%;border-left:1px solid;padding-left:5px;">
        <h1>Đăng bài viết</h1>
<?php
if (!$error):
?>
        <h3 style="color:chartreuse;">Dang tin thanh cong</h3>
<?php
elseif ($error == 1) :
?>
        <h3 style="color:red;">Dinh dang tap tin khong chinh xac</h3>
<?php
elseif ($error == 2) :
?>
        <h3 style="color:red;">Kich thuoc tap tin vuot qua muc quy dinh</h3>
<?php
elseif ($error == -1):
?>
        <h3 style="color:red;">Ban phai nhap du lieu de dang bai</h3>
<?php
endif;
?>    
        <form action="index.php" method="post" enctype="multipart/form-data">
          <textarea style="width:100%;" name="content" rows="4" placeholder="<?php echo $currentUser['Name']?> ơi, bạn đang nghĩ gì?"></textarea>
          <br>
          <br>
          <input type="file" name="file">
          <br>
          <p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 50kb.</p>
          <br>
          <input type="submit" name="submit" value="Đăng bài viết">
        </form>
      </div>
      <div style="clear:both"></div>
    </div>
    
    
  </div>
  
  <hr>
  
  <div>
    <h2>Danh sách bài viết</h2>
    <div>
<?php
foreach(loadPost() as $post):
?>
      <div style="padding: 20px;overflow:auto;border:2px solid;margin:5px;">
        <img style="float:left" src="getImage.php?type=avatar&id=<?php echo $post['uid']?>" width="42" height="42">
        <span><?php echo $post['Name']?></span><br>
        <span><?php echo $post['Time']?></span>
        <pre><?php echo $post['Content']?>
        </pre>
        <img style="max-width: 500px;max-height: 200px;" src="getImage.php?type=post&id=<?php echo $post['ID']?>">
      </div>
<?php
endforeach;
?>
    </div>
  </div>
</div>

<?php          
include "footer.php"; 