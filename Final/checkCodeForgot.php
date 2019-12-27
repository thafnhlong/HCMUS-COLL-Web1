<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header-first.php'; ?>
<?php if (isset($_GET['code'])): ?>
<?php
  $success = false;
  if($code = $_GET['code'])
  {
    $success = true;
  }
?>
<?php if ($success): ?>
<?php header('Location: reset-password.php'); ?>
<?php else: ?>
    <div class="wrapper">
        <div class="sign-in-page">
            <div class="signin-popup">
                <div class="signin-pop">
                    <div class="row">
                        <div class="col-lg">
                            <div class="login-sec">
                                <ul class="sign-control">
                                    <div class="sign_in_sec current" id="tab-2">
                                          <h3 style="text-align: left;">Activate User</h3>
                                        <div class="dff-tab current" id="tab-3">
                                          <form method="GET">
                                                <div class="row">
                                                    <div class="col-lg-12 no-pdd">
                                                        <div class="sn-field">
                                                            <input type="text" name="code" placeholder="Activation Code">
                                                            <i class="la la-barcode"></i>
                                                        </div>
                                                    </div>
                                                    <span style="color:red">* Activate fail</span>
                                                    <div class="col-lg-12 no-pdd">
                                                      <button type="submit" class="btn btn-primary">Activation account</button>
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
                                    <div class="sign_in_sec current" id="tab-2">
                                          <h3 style="text-align: left;">Activate User</h3>
                                        <div class="dff-tab current" id="tab-3">
                                          <form method="GET">
                                                <div class="row">
                                                    <div class="col-lg-12 no-pdd">
                                                        <div class="sn-field">
                                                            <input type="text" name="code" placeholder="Activation Code">
                                                            <i class="la la-barcode"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 no-pdd">
                                                      <button type="submit" class="btn btn-primary">Activation account</button>
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
<?php endif; ?>
<?php include 'footer-first.php'; ?>



