<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header-first.php'; ?>
<?php if (isset($_POST['submit'])): ?>
<?php
  $success = false;
  if($_POST['pass']!=null)
  {
    $success=true;
    UpdatePass($_SESSION['EmailForgot'],$_POST['pass']);
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
									<h3>Cập nhật mật khẩu mới thành công</h3>							
										<div class="row">
                    <a style="font-size:50px" href="login.php" title="">Login</a>
										</div>
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
									<h3>Cập nhật mật khẩu mới</h3>
									<form action="reset-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                          <label style="margin-bottom: 10px" ><strong>New Password </strong></label>
												<div class="sn-field">                                  
                            <input type="password" class="form-control" name="pass" id="pass"  placeholder="Nhập mật khẩu mới ...">
													<i  class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>
                      <span style="color:red">*Mật khẩu không được để trống</span>										
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                          <button type="submit" name="submit" class="btn btn-primary">Tiếp theo</button>													
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
									<h3>Cập nhật mật khẩu mới</h3>
									<form action="reset-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                          <label style="margin-bottom: 10px" ><strong>New Password </strong></label>
												<div class="sn-field">                                  
                            <input type="password" class="form-control" name="pass" id="pass"  placeholder="Nhập mật khẩu mới ...">
													<i  class="la la-lock"></i>
												</div>
												<!--sn-field end-->
											</div>										
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                          <button type="submit" name="submit" class="btn btn-primary">Tiếp theo</button>													
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
<?php endif; ?>
<?php include 'footer.php'; ?>
