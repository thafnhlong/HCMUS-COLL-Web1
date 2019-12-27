<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header-first.php'; ?>
<?php if (isset($_POST['email'])): ?>
<?php
  $email = $_POST['email'];
  $_SESSION['EmailForgot']=$email;
  $success = false;
  $success = checkEmail($email);
?>
<?php if ($success): ?>
    <?php SendMailFogetPasss($currentUser['Name'],$email) ?>
    <div class="wrapper">  
      <div class="sign-in-page">
        <div class="signin-popup">
          <div class="signin-pop">
            <div class="row">
              <div class="col-lg">
                <div class="login-sec">                
                  <div class="sign_in_sec current" id="tab-1">
                    <p style="color:green;margin-bottom: 10px;">*Vui lòng vào email để cập nhật mật khẩu</p>
                    <h3>Quên mật khẩu</h3>
                    <form action="forgot-password.php" method="POST">
                      <div class="row">
                        <div class="col-lg-12 no-pdd">
                            <label style="margin-bottom: 10px" ><strong>Email </strong></label>
                          <div class="sn-field">                                  
                              <input type="text" class="form-control" name="email" id="email"  placeholder="Nhập emai để lấy lại mật khẩu ...">
                            <i  class="la la-user"></i>
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

<?php else: ?>
  <div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">
								<div class="sign_in_sec current" id="tab-1">
									<h3>Quên mật khẩu</h3>
									<form action="forgot-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                          <label style="margin-bottom: 10px" ><strong>Email </strong></label>
												<div class="sn-field">                                  
                            <input type="text" class="form-control" name="email" id="email"  placeholder="Nhập emai để lấy lại mật khẩu ...">
													<i  class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>										
											<div class="col-lg-12 no-pdd">
                        <span style="color:red">*Không tìm thấy email</span>
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
									<h3>Quên mật khẩu</h3>
									<form action="forgot-password.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                          <label style="margin-bottom: 10px" ><strong>Email </strong></label>
												<div class="sn-field">                                  
                            <input type="text" class="form-control" name="email" id="email"  placeholder="Nhập emai để lấy lại mật khẩu ...">
													<i  class="la la-user"></i>
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
	<!--sign-in-page end-->
<?php endif; ?>
<?php include 'footer-first.php'; ?>



