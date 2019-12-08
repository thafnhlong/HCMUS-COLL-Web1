<?php
require_once("init.php");
require_once("function.php");
if(!$currentUser)
{
    header('Location: login.php');
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
                else if ($fileupload['size'] > 5*1024*1024)
                    $error =2;
            }
            else $haveimage = false;
        }       
        if (!$error){
        
            $user = $currentUser;
            $id = userPost($user,$content);
            if ($haveimage)
                move_uploaded_file($_FILES['file']['tmp_name'], 'images/post/'.$id.'.jpg');
        }
    } else 
        $error = -1;
} else 
    $error = -3;
include "header.php";
?>

		<main>
			<div class="main-section">
				<div class="container">
					<div class="main-section-data">
						<div class="row">
							<div class="col-lg-3 col-md-4 pd-left-none no-pd">
								<div class="main-left-sidebar no-margin">
									<div class="user-data full-width">
										<div class="user-profile">
											<div class="username-dt">
												<div class="usr-pic">
													<img style="border-radius: 100%;" src="<?php echo getImage($currentUser['ID'],0)[1]?>" alt="">
												</div>
											</div><!--username-dt end-->
											<div class="user-specs">
												<h3><?php echo $currentUser['Name']?></h3>
												<span><?php echo $currentUser['Job']?></span>
											</div>
										</div><!--user-profile end-->
										<ul class="user-fw-status">
											<li>
												<h4>Following</h4>
												<span>0</span>
											</li>
											<li>
												<h4>Followers</h4>
												<span>0</span>
											</li>
											<li>
												<a href="my-account.php" title="">View Profile</a>
											</li>
										</ul>
									</div><!--user-data end-->
									<div class="suggestions full-width">
										<div class="sd-title">
											<h3>Suggestions</h3>
											<i class="la la-ellipsis-v"></i>
										</div><!--sd-title end-->
										<div class="suggestions-list">
											<!--
                                            <div class="suggestion-usd">
												<img src="images/resources/s1.png" alt="">
												<div class="sgt-text">
													<h4>Jessica William</h4>
													<span>Graphic Designer</span>
												</div>
												<span><i class="la la-plus"></i></span>
											</div>
											-->
                                        </div><!--suggestions-list end-->
									</div><!--suggestions end-->
									<div class="tags-sec full-width">
										<ul>
                                            <!--
											<li><a href="#" title="">Help Center</a></li>
                                            -->
										</ul>
										<div class="cp-sec">
											<img src="images/logo2.png" alt="">
											<p><img src="images/cp.png" alt="">Copyright 2019</p>
										</div>
									</div><!--tags-sec end-->
								</div><!--main-left-sidebar end-->
							</div>
							<div class="col-lg-6 col-md-8 no-pd">
								<div class="main-ws-sec">
									<div class="post-topbar">
										<div class="user-picy">
											<img src="<?php echo getImage($currentUser['ID'],0)[1]?>" alt="">
										</div>
										<div class="post-st">
											<ul>
												<li><a class="post_project" href="#" title="">What's on your mind?</a></li>
												<!--<li><a class="post-jb active" href="#" title="">Post a Job</a></li>-->
											</ul>
										</div><!--post-st end-->
									</div><!--post-topbar end-->

									<div class="posts-section">
<?php
$countPost = getCountPost()['num'];
$countPage = (int)(($countPost-1) / $numPostOfPage+1);
$pagenum = 1;
if (!empty($_GET['num']))
{
    $num = $_GET['num'];    
    $pagenum = $num < 1 ? 1 : ($num > $countPage ? $countPage : $num);
}
foreach(loadPost($pagenum) as $post):
?>
										<div class="post-bar">
											<div class="post_topbar">
												<div class="usy-dt">
													<img style="width: 50px;height: 50px;" src="<?php echo getImage($post['uid'],0)[1]?>" alt="">
													<div class="usy-name">
														<h3><?php echo $post['Name']?></h3>
														<span><img src="images/clock.png" alt=""><?php echo $post['Time']?></span>
													</div>
												</div>
											</div>
											<div class="epi-sec">
												<ul class="bk-links">
													<li><a href="#" title=""><i class="la la-envelope"></i></a></li>
												</ul>
											</div>
											<div class="job_descp">
												<h3>Title</h3>
												<p><?php echo $post['Content']?></p>
<?php
    $imagePostResult = getImage($post['ID']);
    if ($imagePostResult[0]):
?>                                                
                                                <img style="margin: 0 2px 2px 0" src="<?php echo $imagePostResult[1]?>" />
<?php 
    endif;
?>
											</div>
										</div><!--post-bar end-->
<?php
endforeach;
?>
										<!--
                                        <div class="process-comm">
											<div class="spinner">
												<div class="bounce1"></div>
												<div class="bounce2"></div>
												<div class="bounce3"></div>
											</div>
										</div>
                                        -->
<?php
if ($countPage > 0):
?>
                                        <div class="process-comm">
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
                                        </div>
<?php
endif;
?>
                                        
									</div><!--posts-section end-->
								</div><!--main-ws-sec end-->
							</div>
							<div class="col-lg-3 pd-right-none no-pd">
								<div class="right-sidebar">
									<div class="widget widget-about">
										<img src="images/wd-logo.png" alt="">
										<h3>Welcome to SBTC-LTWEB1</h3>
										<span>Member list:</span>
										<div class="sign_link">
											<h4><a>1760357-Nguyễn Thành Long</a></h4>
											<h4><a>1760387-Nguyễn Thanh Phong</a></h4>
                                            <h4><a>1760422-La Chí Thành</a></h4>
										</div>
									</div><!--widget-about end-->
									<div class="widget widget-jobs">
										<div class="sd-title">
											<h3>ADS</h3>
											<i class="la la-ellipsis-v"></i>
										</div>
										<div class="jobs-list"></div><!--jobs-list end-->
									</div><!--widget-jobs end-->
									<div class="widget suggestions full-width">
										<div class="sd-title">
											<h3>Most Viewed People</h3>
											<i class="la la-ellipsis-v"></i>
										</div><!--sd-title end-->
										<div class="suggestions-list">
                                            <!--
											<div class="suggestion-usd">
												<img src="images/resources/s1.png" alt="">
												<div class="sgt-text">
													<h4>Jessica William</h4>
													<span>Graphic Designer</span>
												</div>
												<span><i class="la la-plus"></i></span>
											</div>
                                            -->
										</div><!--suggestions-list end-->
									</div>
								</div><!--right-sidebar end-->
							</div>
						</div>
					</div><!-- main-section-data end-->
				</div> 
			</div>
		</main>

        <div class="post-popup pst-pj">
			<div class="post-project">
				<h3>What's on your mind?</h3>
				<div class="post-project-fields">
					<form id='form1' action="index.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<input disabled type="text" name="title" placeholder="Title">
							</div>
							<div class="col-lg-12">
								<textarea name="content" name="description" placeholder="Description"></textarea>
							</div>
                            <div class="col-lg-12 custom-file">
                                <div class="add-dp" id="OpenImgUpload">
                                    <input type="file" name="file" id="file" onchange="if (this.files.length > 0) document.getElementById('OpenImgUpload').getElementsByTagName('span')[0].innerHTML = this.files[0].name"
                                        onclick="document.getElementById('OpenImgUpload').getElementsByTagName('span')[0].innerHTML = 'Image size must be < 50kb'">
                                    <label style="margin: 20px 0 0 20px;" for="file"><i class="fas fa-camera"></i></label>												
                                    <span>Image size must be <= 5MB, allow JPG,PNG,GIF</span>
                                </div>
							</div>
							<div class="col-lg-12">
								<ul>
                                    <input type="hidden" name="submit">
									<li><button form='form1' class="active" type="submit" value="submit">Post</button></li>
								</ul>
							</div>
						</div>
					</form>
				</div><!--post-project-fields end-->
				<a href="#" title=""><i class="la la-times-circle-o"></i></a>
			</div><!--post-project end-->
		</div><!--post-project-popup end-->




<?php
if (!$error):
?>
    <script>alert('Post successfully!')</script>
<?php
elseif ($error == 1) :
?>
    <script>alert('Image type is wrong!')</script>
<?php
elseif ($error == 2) :
?>
    <script>alert('Image size is over limit!')</script>
<?php
elseif ($error == -1):
?>
    <script>alert('Content empty!')</script>
<?php
endif;
          
include "footer.php"; 