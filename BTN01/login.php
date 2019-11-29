<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header-first.php'; ?>
<?php if (isset($_POST['email']) && isset($_POST['password'])): ?>
    <?php
      $email = $_POST['email'];
      $password = $_POST['password'];
      $success = false;
      $user = findUserByEmail($email);
      if ($user && $user['Status'] == 1 && password_verify($password, $user['Pass'])) {
        $success = true;
        $_SESSION['userId'] = $user['ID'];
      }
    ?>
    <?php if ($success): ?>
    <?php header('Location: index.php'); ?>
    <?php else: ?>
		<div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">
								<ul class="sign-control">
									<li data-tab="tab-1" class="current"><a href="#" title="">Login</a></li>
									<li data-tab="tab-2"><a href="register.php" title="">Register</a></li>
								</ul>
								<div class="sign_in_sec current" id="tab-1">
									<h3>Sign in</h3>
									<form action="login.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="text" name="email" placeholder="Email">
													<i class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="password" placeholder="Password">
													<i class="la la-lock"></i>
												</div>
											</div>
											<p><a href="#" class="text-danger">*Email or Password was wrong</a></p>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                          							<button type="submit" class="btn btn-primary">Đăng nhập</button>
													<a href="forgot-password.php">Forgot password?</a>
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
		<div class="footy-sec">
			<div class="container">
				<p><img src="images/copy-icon.png" alt="">Copyright 2019</p>
			</div>
		</div>
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
								<ul class="sign-control">
									<li data-tab="tab-1" class="current"><a href="#" title="">Login</a></li>
									<li data-tab="tab-2"><a href="register.php" title="">Register</a></li>
								</ul>
								<div class="sign_in_sec current" id="tab-1">
									<h3>Sign in</h3>
									<form action="login.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="text" name="email" placeholder="Email">
													<i class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="sn-field">
													<input type="password" name="password" placeholder="Password">
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                          <button type="submit" class="btn btn-primary">Đăng nhập</button>
						  <a href="forgot-password.php">Forgot password?</a>
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
		<div class="footy-sec">
			<div class="container">
				<p><img src="images/copy-icon.png" alt="">Copyright 2019</p>
			</div>
		</div>
		<!--footy-sec end-->
	</div>
	<!--sign-in-page end-->
<?php endif; ?>
<?php include 'footer-first.php'; ?>



