<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

if (empty($_GET['id']))
{
    header('Location: my-account.php');
    die();
} else 
{
    $profile = findUserById($_GET['id']);
    if (!$profile || $profile['ID'] == $currentUser['ID'])
    {
        header('Location: my-account.php');
        die();
    }
}

include 'header.php'; 
?>
		<section class="cover-sec">
			<img src="images/resources/cover-img.jpg" alt="">
		</section>


		<main>
			<div class="main-section">
				<div class="container">
					<div class="main-section-data">
						<div class="row">
							<div class="col-lg-3">
								<div class="main-left-sidebar">
									<div class="user_profile">
										<div class="user-pro-img">
											<img width="180px" height="180px" src="getImage.php?type=avatar&id=<?php echo $profile['ID']?>" alt="">
										</div><!--user-pro-img end-->
										<div class="user_pro_status">
											<ul class="flw-hr">
<?php

$me2you = isRequest($currentUser['ID'],$profile['ID']);
$you2me = isRequest($profile['ID'],$currentUser['ID']);
if ($me2you && $you2me){
    $src = "deleteFriend.php?id={$profile['ID']}";
    $valueAnchor = "Xóa bạn";
} elseif ($you2me)
{
    $src = "deleteRequest.php?id={$profile['ID']}";
    $valueAnchor = "Hủy";
    
?>
                                                <li><a href="<?php echo $src?>" title="" class="hre"> <?php echo $valueAnchor?></a></li>
<?php    
    $src = "sendRequest.php?id={$profile['ID']}";
    $valueAnchor = "Đồng ý";
} elseif ($me2you){
    $src = "deleteRequest.php?id={$profile['ID']}";
    $valueAnchor = "Xóa lời mời kết bạn";
} else {
    $src = "sendRequest.php?id={$profile['ID']}";
    $valueAnchor = "Thêm bạn";   
}

?>
												<li>
                                                    <a href="<?php echo $src?>" title="" class="flww"><i class="la la-plus"></i> <?php echo $valueAnchor?></a>
                                                </li>
												<!--<li><a href="#" title="" class="hre">Hire</a></li>-->
											</ul>
											<ul class="flw-status">
												<li>
													<span>Following</span>
													<b>0</b>
												</li>
												<li>
													<span>Followers</span>
													<b>0</b>
												</li>
											</ul>
										</div><!--user_pro_status end-->
										<ul class="social_links">
											<li><a href="#" title=""><i class="la la-globe"></i> www.example.com</a></li>
											<li><a href="#" title=""><i class="fa fa-facebook-square"></i> Http://www.facebook.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-twitter"></i> Http://www.Twitter.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-google-plus-square"></i> Http://www.googleplus.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-behance-square"></i> Http://www.behance.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-pinterest"></i> Http://www.pinterest.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-instagram"></i> Http://www.instagram.com/john...</a></li>
											<li><a href="#" title=""><i class="fa fa-youtube"></i> Http://www.youtube.com/john...</a></li>
										</ul>
									</div><!--user_profile end-->
								</div><!--main-left-sidebar end-->
							</div>
							<div class="col-lg-6">
								<div class="main-ws-sec">
									<div class="user-tab-sec">
										<h3><?php echo $profile['Name'] ?></h3>
										<div class="star-descp">
											<span>Nghề nghiệp: <?php echo $profile['Job'] ?></span>
										</div><!--star-descp end-->
										<div class="tab-feed">
											
										</div><!-- tab-feed end-->
									</div><!--user-tab-sec end-->
									<div class="product-feed-tab current" id="feed-dd">
										<div class="posts-section">


											
<?php
foreach(GetStatusByUserID($profile['ID']) as $post):
?>
                                            <div class="post-bar">
                                                <div class="post_topbar">
                                                    <div class="usy-dt">
                                                        <img style="width: 50px;height: 50px;" src="getImage.php?type=avatar&id=<?php echo $profile['ID']?>" alt="">
                                                        <div class="usy-name">
                                                            <h3><?php echo $profile['Name']?></h3>
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


                                            
                                            
										</div><!--posts-section end-->
									</div><!--product-feed-tab end-->
								</div><!--main-ws-sec end-->
							</div>
							<div class="col-lg-3">
								<div class="right-sidebar">
									<div class="message-btn">
										<a href="#" title=""><i class="fa fa-envelope"></i> Message</a>
									</div>
									<div style="margin-top: 45px;" class="widget widget-portfolio">
										<div class="wd-heady">
											<h3>Thông tin cá nhân</h3>
											<img src="images/photo-icon.png" alt="">
										</div>
										<div class="pf-gallery">
											<div>
												<i class="fas fa-envelope-open"></i>
												<a style="margin-top:30px;margin-left: 10px" href="mailto:<?php echo $profile['Email'] ?>?Subject=Hello%20again" target="_top"><?php echo $profile['Email'] ?></a>
											</div>
											<div style="margin-top: 10px;">
												<i class="fas fa-phone-square-alt"></i>	
												<span style="margin-top:30px;margin-left: 10px"><?php echo $profile['PhoneNumber'] ?></span>
											</div>
											<div style="margin-top: 10px;">
												<i class="fas fa-map-marker"></i>
												<span style="margin-top:30px;margin-left: 10px"><?php echo $profile['Address'] ?></span>
											</div>
										</div><!--pf-gallery end-->
									</div><!--widget-portfolio end-->
								</div><!--right-sidebar end-->
							</div>
						</div>
					</div><!-- main-section-data end-->
				</div> 
			</div>
		</main>
<?php 
include 'footer.php'; 