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
									<h3>Update Password</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Please write old password">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Please write new password">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
                                                <span style="color:green">*Update Password successfully</span>
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
									<h3>Update Password</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Please write old password">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Please write new password">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
                                                <span style="color:red">*Update Password fail</span>
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
									<h3>Update Password</h3>
									<form action="change-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passval" placeholder="Please write old password">
													<i class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="passnew" placeholder="Please write new password">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                                                    <button type="submit" class="btn btn-primary">Update</button>
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



