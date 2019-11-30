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
<?php if( isset($_POST['passnew']) && ($_POST['passval'])): ?>
<?php
    //$Passdn=$_POST['passval'];
    //$PassdnNew=$_POST['passnew'];
    $success=false;

    if( password_verify($_POST['passval'], $currentUser['Pass']))
    {
        updatePassByAccount($_POST['passnew'],$currentUser['ID']);
        $success=true;
    }
?>
<?php if ($success): ?>
    <div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">				
								<div class="sign_in_sec current" id="tab-1">
									<h3>Cập nhật mật khẩu</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Nhập mật khẩu cũ">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Nhập mật khẩu mới">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
                                                <span style="color:green">*Cập nhật mật khẩu thành công</span>
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
											</div>
										</div>
									</form>
								</div>
								<!--sign_in_sec end-->
							</div>
						</div>
						<!--login-sec end-->
					</div>
				</div>
			</div>
			<!--signin-pop end-->
		</div>
		<!--signin-popup end-->
		<!--footy-sec end-->
	</div>
<?php else: ?>
    <div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">				
								<div class="sign_in_sec current" id="tab-1">
									<h3>Cập nhật mật khẩu</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Nhập mật khẩu cũ">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Nhập mật khẩu mới">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
                                                <span style="color:red">*Cập nhật mật khẩu thất bại</span>
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
											</div>
										</div>
									</form>
								</div>
								<!--sign_in_sec end-->
							</div>
						</div>
						<!--login-sec end-->
					</div>
				</div>
			</div>
			<!--signin-pop end-->
		</div>
		<!--signin-popup end-->
		<!--footy-sec end-->
	</div>
	<!--sign-in-page end-->
<?php endif; ?>
<?php else: ?>
  	<div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">				
								<div class="sign_in_sec current" id="tab-1">
									<h3>Cập nhật mật khẩu</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Nhập mật khẩu cũ">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Nhập mật khẩu mới">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
											</div>
										</div>
									</form>
								</div>
								<!--sign_in_sec end -->
							</div>
						</div>
						<!--login-sec end-->
					</div>
				</div>
			</div>
			<!--signin-pop end-->
		</div>
		<!--signin-popup end-->
		<!--footy-sec end-->
	</div>
	<!--sign-in-page end-->
<?php endif; ?>
<?php include 'footer-first.php'; ?>



