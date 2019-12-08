<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<?php
    if(!$currentUser)
    {
        header('Location: index.php');
        exit();
    }
?>
<!-- Xử lý -->

<!-- cật nhật ảnh bìa -->
<?php if( isset($_POST['submit'])): ?>
<?php //saveCoverImage($currentUser['ID']); ?>
<?php move_uploaded_file($_FILES['fileAvatar']['tmp_name'], 'images/cover/'.$currentUser['ID'].'.jpg');  ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>

<!-- cật nhật ảnh đại diện -->
<?php if( isset($_POST['submitAvt'])): ?>
<?php //UpdateAvatar($currentUser['ID']); ?>
<?php move_uploaded_file($_FILES['filesAvt']['tmp_name'], 'images/avatar/'.$currentUser['ID'].'.jpg');  ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>

<!-- cật nhật profile -->
<?php if( isset($_POST['submitprofile'],$_POST['phonenumber'])): ?>
<?php updatePhoneNumber($_POST['phonenumber'],$currentUser['ID']) ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['email'])): ?>
<?php updateEmail($_POST['email'],$currentUser['ID']) ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['address'])): ?>
<?php updateAddress($_POST['address'],$currentUser['ID']) ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>

<!-- cập nhật công việc -->
<?php if( isset($_POST['submitjob'],$_POST['job'])): ?>
<?php updateJob($_POST['job'],$currentUser['ID']) ?>
<?php header('Location: my-account.php'); ?>
<?php endif; ?>
<!-- xử lý hình ảnh -->
<?php 
	
?>
<!-- Kết thúc xử lý -->

<body oncontextmenu="return false;">
	<!-- open CoverImage -->
	<div class="wrapper">
		<section class="cover-sec">
			<!--<img src="images/resources/cover-img.jpg" alt="">-->
<?php
	$imageCoverAvatar = getImage($currentUser['ID'],1);
?>
			<img style="height: 380px"  src="<?php echo $imageCoverAvatar[1]?>" />

			<div class="add-pic-box">
				<div class="container">
					<div class="row no-gutters">
						<div class="col-lg-12 col-sm-12">					
							<i class="fas fa-2x fa-camera" data-toggle="modal" data-target="#ModalUpdateCoverImage"
							style="display: inline-block;position: absolute; top: 10px; left:10px; cursor: pointer;margin-left: 1100px"></i> 			
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- end CoverImage -->

		<main>		
			<div class="main-section">
				<div class="container">
					<div class="main-section-data">
						<div class="row">
							<div class="col-lg-3">
								<div class="main-left-sidebar">
									<div class="user_profile">
										<div class="user-pro-img">
<?php 
	$imageAvatar = getImage($currentUser['ID'],0);
?>
											<img style="height: 200px" src="<?php echo $imageAvatar[1]?>" />	

											<div class="add-dp" id="OpenImgUpload">											
												<label data-toggle="modal" data-target="#ModalUpdateAvatar"  for="file"><i style="cursor:pointer" class="fas fa-camera"></i></label>												
											</div>
										</div>
										<!--Open khung theo doi-->
										<div class="user_pro_status">
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
										</div><!--End khung theo doi-->
										<!--Open khung thông tin mạng xã hội-->
										<ul class="social_links">
											<li><a href="<?php echo $currentUser['FaceBook'] ?>" title=""><i class="la la-globe"></i> <?php echo $currentUser['FaceBook'] ?> </a></li>	
										</ul>
										<!--End khung thông tin mạng xã hội-->
									</div>
									<!--Open khung thông tin bạn bè-->
									
									<!--End khung thông tin bạn bè-->
								</div><!--main-left-sidebar end-->
							</div>
							<!-- open khung newfeeds -->
							<div class="col-lg-6">
								<div class="main-ws-sec">
									<!--tên tài khoản -->
									<div class="user-tab-sec rewivew">									
										<h3><?php echo $currentUser['Name'] ?> </h3>
										<div class="star-descp">
											<span>
												<?php 
													if($currentUser['Job']!=null)
														echo "Nghề nghiệp: ". $currentUser['Job'];
													else
														echo "Nghề nghiệp: Chưa cập nhật";
												?>
											</span>	
											<i  data-toggle="modal" data-target="#ModalEditJob" class="fas fa-pen fa-xs" data-toggle="modal" data-target="#ModalEditProfile" style="cursor: pointer"></i>									
										</div>
                                            <div class="tab-feed st2 settingjb">										
											</div>
										
									</div>
									<!-- trang tin -->
									<!-- open foreach -->	
									<?php foreach(GetStatusByUserID($currentUser['ID']) as $post): ?>						
									<div class="product-feed-tab current" id="feed-dd">
										<div class="posts-section">
											<div class="post-bar">																								
												<div class="post_topbar">
													<div class="usy-dt">
<?php 
	$imageAvatar = getImage($currentUser['ID'],0);
?>
														<img style="height:50px" src="<?php echo $imageAvatar[1]?>" />
														<div class="usy-name">
															<h3><?php echo $currentUser['Name'] ?></h3>
															<span><img src="images/clock.png" alt=""><?php echo $post['Time'] ?></span>
														</div>
													</div>
													<!-- open edit -->
													<div class="ed-opts">
														<a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
														<ul class="ed-options">
															<li><a data-toggle="modal" data-target="#ModalEditPosts" style="cursor: pointer" >Edit Post</a></li>
															<li><a href="#" title="">Remove</a></li>															
														</ul>
													</div>
													<!-- end edit -->
												</div>											
												<div class="job_descp">																	
													<p><?php echo $post['Content'] ?></p><br>
<?php
	$imagePost = getImage($post['ID']);
	if ($imagePost[0]):
?>
												<img style="max-width: 500px;max-height: 200px;"  src="<?php echo $imagePost[1]?>"  />
<?php 
endif;
?>
												</div>																																																																	
											</div><!--post-bar end-->											
										</div><!--posts-section end-->
									</div><!--product-feed-tab end-->
									<?php endforeach ?>				
									<!-- end foreach -->																																									
								</div>
							</div>
							<!-- end khung newfeeds -->
							<div class="col-lg-3">
								<div class="right-sidebar">
									<div class="message-btn">
										<a href="profile-account-setting.html" title=""><i class="fas fa-cog"></i> Setting</a>
									</div>
									<div style="margin-top: 48px;" class="widget widget-portfolio">
										<div style="margin-left:4px" >
											
										</div>
										<div class="wd-heady">										
											<h3>Giới thiệu</h3>
											<div style="float: right">
												<i class="fas fa-pen fa-xs" data-toggle="modal" data-target="#ModalEditProfile" style="cursor: pointer"></i>
											</div>
										</div>
										<div class="pf-gallery">											
											<div>
												<i class="fas fa-envelope-open"></i>
												<a style="margin-top:30px;margin-left: 10px" href="mailto:<?php echo $currentUser['Email'] ?>?Subject=Hello%20again" target="_top"><?php echo $currentUser['Email'] ?></a>
											</div>
											<div style="margin-top: 10px;">
												<i class="fas fa-phone-square-alt"></i>	
												<span style="margin-top:30px;margin-left: 10px"><?php echo $currentUser['PhoneNumber'] ?></span>
											</div>
											<div style="margin-top: 10px;">
												<i class="fas fa-map-marker"></i>
												<span style="margin-top:30px;margin-left: 10px"><?php echo $currentUser['Address'] ?></span>
											</div>											
										</div><!--pf-gallery end-->
									</div><!--widget-portfolio end-->
								</div><!-- end profile -->
<!-- Open Modal CoverAvt -->
<div class="modal fade" id="ModalUpdateCoverImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 800px; height: 500px;">
			<div class="post-project">
					<h3 >Cập nhật ảnh bìa</h3>
						<div class="post-project-fields" >
								<form id='form1' action="my-account.php" method="post" enctype="multipart/form-data">
									<div class="row">							
										<div class="col-lg-12">
											<img id="coverIMG" style="width:600px;height:200px;margin-left: 65px" >
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:15px">
											<div class="form-group">										
												<input type="file" name="fileAvatar" id="fileSelect" style="width: 100px">						
												<br>
												<p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 5MB.</p>
												<br>
											</div>				
										<div class="col-lg-12">
											<button style="background-color: #e44d3a" type="submit" name="submit" class="btn btn-primary">Cập nhật </button>
											<button style="background-color: #e44d3a;width: 80px;margin-left: 400px;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>									       
			</div>
		</div>	
  	</div>													
</div>
<!--End Modal CoverAvt-->
<!-- Open Modal Avatar -->
<div class="modal fade" id="ModalUpdateAvatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 600px; height: 500px;">
			<div class="post-project">
					<h3 >Cập nhật Avatar</h3>
						<div class="post-project-fields" >
								<form id='form1' action="my-account.php" method="post" enctype="multipart/form-data">
									<div class="row">							
										<div class="col-lg-12">
											<img id="coverAvt" style="width:200px;height:200px;margin-left: 150px" >
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:15px">
											<div class="form-group">										
												<input type="file" name="filesAvt" id="fileSelectAvt" style="width: 100px">						
												<br>
												<p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 5MB.</p>
												<br>
											</div>
											
										<div class="col-lg-12">
											<button style="background-color: #e44d3a" type="submit" name="submitAvt" class="btn btn-primary">Cập nhật </button>
											<button style="background-color: #e44d3a;width: 80px;margin-left: 300px;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>									       
			</div>
		</div>	
  	</div>													
</div>
<!--End Modal Avatar-->
<!-- Open Modal EditProfile -->
<div class="modal fade" id="ModalEditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 600px; height: 420px;">
			<div class="post-project">
					<h3 >Cập nhật thông tin bản thân</h3>
						<div class="post-project-fields" >
								<form id='form1' action="my-account.php" method="post" >
									<div class="row">							
										<div class="col-lg-12 custom-file" style="margin-top:25px">
											<label style="margin-top:10px;margin-bottom:10px" >Số điện thoại</label>                    
											<input type="text" class="form-control" name="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>">
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:35px">
											<label style="margin-top:10px;margin-bottom:10px" >Email</label>                          
											<input type="email" class="form-control" name="email" value="<?php echo $currentUser['Email'] ?>">
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:35px">
											<label style="margin-top:10px;margin-bottom:10px" >Địa chỉ</label>                            
											<input type="text" class="form-control" name="address" value="<?php echo $currentUser['Address'] ?>">	
											
										<div class="col-lg-12">
											<button style="background-color: #e44d3a" type="submit" name="submitprofile" class="btn btn-primary">Cập nhật </button>
											<button style="background-color: #e44d3a;width: 80px;margin-left: 300px;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>									       
			</div>
		</div>	
  	</div>													
</div>
<!--End Modal EditProfile-->
<!-- Open Modal EditPosts -->
<div class="modal fade" id="ModalEditPosts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 600px; height: 420px;">
			<div class="post-project">
					<h3 >Cập nhật bài đăng</h3>
						<div class="post-project-fields" >
								<form id='form1' action="my-account.php" method="post" >
									<div class="row">							
										<div class="col-lg-12 custom-file" style="margin-top:25px">
											<label style="margin-top:10px;margin-bottom:10px" >Số điện thoại</label>                    
											<input type="text" class="form-control" name="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>">
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:35px">
											<label style="margin-top:10px;margin-bottom:10px" >Email</label>                          
											<input type="email" class="form-control" name="email" value="<?php echo $currentUser['Email'] ?>">
										</div>
										<div class="col-lg-12 custom-file" style="margin-top:35px">
											<label style="margin-top:10px;margin-bottom:10px" >Địa chỉ</label>                            
											<input type="text" class="form-control" name="address" value="<?php echo $currentUser['Address'] ?>">	
											
										<div class="col-lg-12">
											<button style="background-color: #e44d3a" type="submit" name="submitprofile" class="btn btn-primary">Cập nhật </button>
											<button style="background-color: #e44d3a;width: 80px;margin-left: 300px;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>									       
			</div>
		</div>	
  	</div>													
</div>
<!--End Modal EditPosts-->
<!-- Open Modal Edit Job -->
<div class="modal fade" id="ModalEditJob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width: 600px; height: 300px;">
			<div class="post-project">
					<h3 >Cập nhật nghề nghiệp</h3>
						<div class="post-project-fields" >
								<form id='form1' action="my-account.php" method="post" >
									<div class="row">																	
										<div class="col-lg-12 custom-file" style="margin-top:35px">
											<label style="margin-bottom:20px" >Nghề nghiệp</label>                            
											<input type="text" class="form-control" name="job" value="<?php echo $currentUser['Job'] ?>">	
										
										<div class="col-lg-12" style="margin-top: 35px">
											<button style="background-color: #e44d3a" type="submit" name="submitjob" class="btn btn-primary">Cập nhật </button>
											<button style="background-color: #e44d3a;width: 80px;margin-left: 300px;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>									       
			</div>
		</div>	
  	</div>													
</div>
<!--End Modal Edit Job-->

							</div>						
						</div>
					</div><!-- main-section-data end-->
				</div> 				
			</div>
		</main>							
	</div><!--theme-layout end-->

	

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">  
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/scrollbar.js"></script>

<script>
      $('#fileSelect').change(function(event){
          var tmppath = URL.createObjectURL(event.target.files[0]);
          $("#coverIMG").fadeIn("fast").attr('src',tmppath);
      })
</script>

<script>
      $('#fileSelectAvt').change(function(event){
          var tmppath = URL.createObjectURL(event.target.files[0]);
          $("#coverAvt").fadeIn("fast").attr('src',tmppath);
      })
</script>
	
