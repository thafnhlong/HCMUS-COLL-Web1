<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header-first.php'; ?>
<?php if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])&& isset($_POST['phonenumber']) && isset($_POST['address'])): ?>
<?php
  $displayName = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phonenumber = $_POST['phonenumber'];
  $address = $_POST['address'];
  $success = false;
  $user = findUserByEmail($email);
  if (!$user) {
    $newUserId = createUser($displayName, $email, $password,$phonenumber,$address);
    // $_SESSION['userId'] = $newUserId;
    $success = true;
  }
?>
<?php if ($success): ?>
  <script>alert('Vui lòng kiểm tra email để kích hoạt tài khoản')</script>
  <?php header('Location: activate.php') ?>
<?php else: ?>
<div class="alert alert-danger" role="alert">
  Đăng ký thất bại
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
                <ul class="sign-control">
                  <li data-tab="tab-1"><a href="login.php" title="">Login</a></li>
                  <li data-tab="tab-2" class="current"><a href="#" title="">Register</a></li>
                  <div class="sign_in_sec current" id="tab-2">
                    <h3 style="text-align: left;"> Sign Up</h3>
                    <div class="dff-tab current" id="tab-3">
                    <form action="register.php" method="POST">
                        <div class="row">
                          <div class="col-lg-12 no-pdd">
                            <div class="sn-field">
                              <input type="text" name="name" placeholder="Full Name">
                              <i class="la la-user"></i>
                            </div>
                          </div>

                          <div class="col-lg-12 no-pdd">
                            <div class="sn-field">
                              <input type="email" name="email" placeholder="Email">
                              <i class="la la-envelope"></i>
                            </div>
                          </div>

                          <div class="col-lg-12 no-pdd">
                            <div class="sn-field">
                              <input type="password" name="password" placeholder="Password">
                              <i class="la la-lock"></i>
                            </div>
                          </div>


                          <div class="col-lg-12 no-pdd">
                            <div class="sn-field">
                              <input type="text" name="phonenumber" placeholder="Phone Number">
                              <i class="la la-phone"></i>
                            </div>
                          </div>

                          <div class="col-lg-12 no-pdd">
                            <div class="sn-field">
                              <input type="text" name="address" placeholder="Adddress">
                              <i class="la la-map-marker"></i>
                            </div>
                          </div>

                          <div class="col-lg-12 no-pdd">
                            <button type="submit" class="btn btn-primary">Get Started</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!--dff-tab end-->
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


  </div>
  <!--theme-layout end-->

<?php endif; ?>
<?php include 'footer-first.php'; ?>

