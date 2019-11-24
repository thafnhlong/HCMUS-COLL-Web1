<?php
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    include "header.php";
    ?>
DANG NHAP DE SU DUNG DICH VU...
    <?php
    include "footer.php";
    die();
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
      <textarea name="content" rows="4" cols="50" placeholder="<?php echo $currentUser['Name']?> ơi, bạn đang nghĩ gì?"></textarea>
      <br>
      <br>
      <input type="file" name="file">
      <br>
      <p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 50kb.</p>
      <br>
      <input type="submit" name="submit" value="Đăng bài viết">
    </form>
  </div>
  
  <hr>
  
  <div>
    <h2>Danh sách bài viết</h2>
    <div>
<?php
$countPost = getCountPost()['num'];
$countPage = (int)(($countPost-1) / $numPostofPage+1);
$pagenum = 1;

if (!empty($_GET['num']))
{
    $num = $_GET['num'];    
    $pagenum = $num < 1 ? 1 : ($num > $countPage ? $countPage : $num);
}

foreach(loadPost($pagenum) as $post):
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
<?php
if ($countPage > 0):
?>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
      
        <li class="page-item <?php if ($pagenum==1) echo "disabled"; ?>">
          <a class="page-link" href="?num=<?php echo $pagenum-1?>" tabindex="-1">Quay lại</a>
        </li>
<?php
    for($i = 1; $i <= $countPage;$i++):
?>        
        <li class="page-item <?php if ($i == $pagenum) echo "active";?>"><a class="page-link" href="?num=<?php echo $i?>"><?php echo $i?></a></li>
<?php
    endfor;
?>        
        <li class="page-item <?php if ($pagenum==$countPage) echo "disabled" ?>">
          <a class="page-link" href="?num=<?php echo $pagenum+1?>">Tiếp theo</a>
        </li>
        
      </ul>
    </nav>
<?php
endif;
?>    
  </div>
</div>

<?php          
include "footer.php"; 