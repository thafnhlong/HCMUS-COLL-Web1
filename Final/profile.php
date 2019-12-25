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
			<img style="max-height:337px;" src="<?php echo getImage($profile['ID'],1)[1] ?>" alt="">
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
											<img width="180px" height="180px" src="<?php echo getImage($profile['ID'],0)[1]?>" alt="">
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
    $src = "deleteFriend.php?id={$profile['ID']}";
    $valueAnchor = "Hủy";
?>
                                                <li><a href="<?php echo $src?>" title="" class="hre"> <?php echo $valueAnchor?></a></li>
                                                
<?php                                           
    $src = "sendRequest.php?id={$profile['ID']}";
    $valueAnchor = "Đồng ý";
} elseif ($me2you){
    $src = "deleteRequest.php?id={$profile['ID']}";
    $valueAnchor = "Xóa lời mời kết bạn";
    $valueFollowing="Theo dõi";
} else {
    $src = "sendRequest.php?id={$profile['ID']}&s";
    $valueAnchor = "Thêm bạn"; 
}
?>
												<li>
                                                    <a href="<?php echo $src?>" title="" class="flww"><i class="la la-plus"></i> <?php echo $valueAnchor?></a>
                                                </li>     
<?php 
$me_you=isfollow($currentUser['ID'],$profile['ID']);
if($me_you ){
    $valueFL="Hủy theo dõi";
    $srcfl="deleteFollowing.php?id={$profile['ID']}";
}
else
{
    $valueFL="Theo dõi";
    $srcfl="sendFollowing.php?id={$profile['ID']}&s=";
}
?>
                                                <li style="display: block;" >
                                                    <a style="margin-top: 10px;width: 150px;" href="<?php echo $srcfl?>" title="" class="flww"><i class="la la-plus"></i> <?php echo $valueFL?></a>
                                                </li>   
                                                                                     
                                                          
												<!--<li><a href="#" title="" class="hre">Hire</a></li>-->
											</ul>
											<ul class="flw-status">
												<li>
<?php 
	$dem1=0;
	if(countFollowing($profile['ID'])==null)
		$dem1=0;
	else
	{
		foreach(countFollowing($profile['ID']) as $d1)
		{
			$dem1=$dem1+1;
		}
	}
?>
													<span>Following</span>
													<b><?php echo $dem1 ?></b>
												</li>
												<li>
<?php 
	$dem2=0;
	if(countFollower($profile['ID'])==null)
		$dem2=0;
	else
	{
		foreach(countFollower($profile['ID']) as $d1)
		{
			$dem2=$dem2+1;
		}
	}
?>
													<span>Followers</span>
													<b><?php echo $dem2 ?></b>
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
$postdem  = -1;
foreach(GetStatusByUserID($profile['ID']) as $post):  
    if($post['Privacy'] == 2 || ($post['Privacy'] == 1 && $me2you && $you2me)):
        $postdem ++;
?>
                                            <div class="posty" style="margin-bottom: 25px;">
                                            
                                                <div class="post-bar no-margin">
                                                    <div class="post_topbar">
                                                        <div class="usy-dt">
                                                            <img style="width: 50px;height: 50px;" src="<?php echo getImage($profile['ID'],0)[1]?>" alt="">
                                                            <div class="usy-name">
                                                                <h3><a href="profile.php?id=<?php echo $profile['ID']?>"><?php echo $profile['Name']?></a></h3>
                                                                <span><img src="images/clock.png" alt=""><?php echo $post['Time']?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="epi-sec">
                                                        <ul class="bk-links">
                                                            <li><a href="message.php?toid=<?=$profile['ID']?>" title=""><i class="la la-envelope"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="job_descp">
<?php
    if ($post['Privacy']==2)
        $typeprivacy = "EveryOne";
    elseif ($post['Privacy']==1)
        $typeprivacy = "Friend";
    else
        $typeprivacy = "OnlyMe";
?>                                                
                                                        <h3><i class="fas fa-lock"></i> <?php echo $typeprivacy ?></h3>
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
                                                    
                                                    <div class="job-status-bar">
                                                        <ul class="like-com">
                                                            <li>
<?php
        $likesnum = countLike($post['ID']);

        $prefix="";
        if (isLike($currentUser['ID'],$post['ID'])){
            $likecss = " style='color:blue;' ";
            $likecontent = "UnLike";
            $prefix = "un";
        }
        else{
            $likecss = "";
            $likecontent = "Like";
        }
?>
                                                                <a href="<?php echo $prefix?>like.php?postid=<?php echo $post['ID']?>" <?php echo $likecss?>><i class="fas fa-heart"></i> <?php echo $likecontent?></a>
<?php
        if ($likesnum>0):                                                            
?>
                                                                <img src="images/liked-img.png" alt="">
                                                                <span><?php echo $likesnum?></span>
<?php
        endif;
?>
                                                            </li> 
                                                        </ul>
<?php
        $cmtnum = countComment($post['ID']);
?>                                                    
                                                        <a onclick="triggerComment(<?php echo $postdem ?>)" class="com"><i class="fas fa-comment-alt"></i> Comment <?php echo $cmtnum?></a>
                                                    </div>
                                                    
                                                    
                                                </div><!--post-bar end-->
                                                
                                                
                                                <div style="display:none" class="comment-section">
<?php
        if ($cmtnum > 0):
?> 
                                                    <div class="comment-sec">
                                                        <ul>
<?php
            foreach(loadComment($post['ID']) as $cmt):
?>                                                        
                                                            <li>
                                                                <div class="comment-list">
                                                                    <div class="comment">
                                                                        <div>
                                                                            <img width="40px" height="40px" src="<?php echo getImage($cmt['uid'],0)[1]?>" alt="">
                                                                        </div>
                                                                        <h3><a href="profile.php?id=<?php echo $cmt['uid']?>"><?php echo $cmt['Name']?></a></h3>
                                                                        <span><img src="images/clock.png" alt=""> <?php echo $cmt['CreateAt']?></span>
                                                                        <p style="word-break: break-all;" ><?php echo $cmt['Content']?></p>
                                                                    </div>
                                                                </div><!--comment-list end-->
                                                            </li>
<?php
            endforeach;
?>
                                                            
                                                        </ul>
                                                    </div><!--comment-sec end-->
<?php
        endif;
?>                                                
                                                    
                                                    <div class="post-comment">
                                                        <div class="cm_img">
                                                            <img width="40px" height="40px" src="<?php echo getImage($currentUser['ID'],0)[1]?>" alt="">
                                                        </div>
                                                        <div class="comment_box">
                                                            <form action="comment.php" method="post">
                                                                <input hidden="true" name="postid" value="<?php echo $post['ID']?>"/>
                                                                <input type="text" name="content" placeholder="Post a comment">
                                                                <button type="submit" name="cmtsend">Send</button>
                                                            </form>
                                                        </div>
                                                    </div><!--post-comment end-->
                                                </div>
                                            </div><!--post-bar end-->
<?php								
	endif;
										
endforeach;
?>


                                            
                                            
										</div><!--posts-section end-->
									</div><!--product-feed-tab end-->
								</div><!--main-ws-sec end-->
							</div>
							<div class="col-lg-3">
								<div class="right-sidebar">
									<div class="message-btn">
										<a href="message.php?toid=<?=$profile['ID']?>" title=""><i class="fa fa-envelope"></i> Message</a>
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
        
        <script>
            function triggerComment(id){
                old = document.getElementsByClassName("comment-section")[id].style.display;
                newcss = old == "none" ? "block" : "none";
                document.getElementsByClassName("comment-section")[id].style.display = newcss;
            }
        </script>
<?php 
include 'footer.php'; 