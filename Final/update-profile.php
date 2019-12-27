<?php 
ob_start();
  require_once 'init.php';
?>
<?php
    if(!$currentUser)
    {
        header('Location: index.php');
        exit();
    }
?>
<?php include 'header.php' ?>
<?php if( isset($_POST['submit'])): ?>
<?php
    $NameUD=$_POST['name'];
    $PhoneUD=$_POST['phonenumber'];
    $AddressUD=$_POST['address'];
    $JobUD=$_POST['job'];
    $temp=false;

    if($NameUD!=null && $PhoneUD!=null && $AddressUD!=null && $JobUD!=null)
    {
        updateName($NameUD,$currentUser['ID']);
        updatePhoneNumber($PhoneUD,$currentUser['ID']);
        updateAddress($AddressUD,$currentUser['ID']);
        updateJob($JobUD,$currentUser['ID']);
		$temp=true;
		header('Location: update-profile.php');
    }
?>
<?php if($temp ): ?>
    <script>alert('Update information successfully')</script>
    <div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">
								<div class="sign_in_sec current" id="tab-1">
									<h3>Update your information</h3>
									<form action="update-profile.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Yourname </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $currentUser['Name'] ?>" placeholder="Please write your name ...">
													<i  class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Phone number </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>" placeholder="Please write your phone number ...">
													<i  class="fas fa-mobile-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Address </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $currentUser['Address'] ?>" placeholder="Please write your address ...">
													<i  class="fas fa-map-marked-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Jobs </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="job" id="job" value="<?php echo $currentUser['Job'] ?>" placeholder="Please write your job ...">
													<i  class="fas fa-suitcase-rolling"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <span style="color:green">*Update information successfully</span>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>													
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
<!-- open form có span -->
    <script>alert('Update fail')</script>
    <div class="wrapper">
		<div class="sign-in-page">
			<div class="signin-popup">
				<div class="signin-pop">
					<div class="row">
						<div class="col-lg">
							<div class="login-sec">
								<div class="sign_in_sec current" id="tab-1">
									<h3>Update your information</h3>
									<form action="update-profile.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Yourname </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $currentUser['Name'] ?>" placeholder="Please write your name ...">
													<i  class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Phone number </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>" placeholder="Please write your phone number ...">
													<i  class="fas fa-mobile-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Address </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $currentUser['Address'] ?>" placeholder="Please write your address ...">
													<i  class="fas fa-map-marked-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Jobs </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="job" id="job" value="<?php echo $currentUser['Job'] ?>" placeholder="Please write your job ...">
													<i  class="fas fa-suitcase-rolling"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <span style="color:red">*Update your information fail</span>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>													
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
<!-- end form -->
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
									<h3>Update your information</h3>
									<form action="update-profile.php" method="POST">
										<div class="row">
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Your Name: </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $currentUser['Name'] ?>" placeholder="Please write your name ...">
													<i  class="la la-user"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Phone Number: </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>" placeholder="Please write your number ...">
													<i  class="fas fa-mobile-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Address: </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $currentUser['Address'] ?>" placeholder="Please write your address ...">
													<i  class="fas fa-map-marked-alt"></i>
												</div>
												<!--sn-field end-->
											</div>
                                            <div class="col-lg-12 no-pdd">
                                                <label style="margin-bottom: 10px" ><strong>Jobs: </strong></label>
												<div class="sn-field">                                  
                                                    <input type="text" class="form-control" name="job" id="job" value="<?php echo $currentUser['Job'] ?>" placeholder="Please write your jobs ...">
													<i  class="fas fa-suitcase-rolling"></i>
												</div>
												<!--sn-field end-->
											</div>
											<div class="col-lg-12 no-pdd">
												<div class="checky-sec">
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>													
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
<?php include 'footer.php'; ?>



