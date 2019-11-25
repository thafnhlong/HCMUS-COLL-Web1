
<?php 
ob_start();
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<!-- Xử lý -->
<?php if( isset($_POST['submit'])): ?>
<?php saveCoverImage($currentUser['ID']); ?>
<?php endif; ?>

<?php if( isset($_POST['aboutme'])): ?>
<?php updateAboutMe($_POST['aboutme'],$currentUser['ID']) ?>
<?php header('Location: profile.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['phonenumber'])): ?>
<?php updatePhoneNumber($_POST['phonenumber'],$currentUser['ID']) ?>
<?php header('Location: profile.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['email'])): ?>
<?php updateEmail($_POST['email'],$currentUser['ID']) ?>
<?php header('Location: profile.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['facebook'])): ?>
<?php updateFaceBook($_POST['facebook'],$currentUser['ID']) ?>
<?php header('Location: profile.php'); ?>
<?php endif; ?>

<?php if( isset($_POST['submitprofile'],$_POST['address'])): ?>
<?php updateAddress($_POST['address'],$currentUser['ID']) ?>
<?php header('Location: profile.php'); ?>
<?php endif; ?>

<!-- Kết thúc xử lý -->

    <link rel="stylesheet" href="Apps/global/vendor/plyr/plyr.css">
    <link rel="stylesheet" href="Apps/global/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="Apps/assets/examples/css/pages/profile_v3.css">
    <link rel="stylesheet" href="Apps/assets/examples/css/uikit/modals.css">

    <div class="page">
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <!-- onclick="document.getElementById('coverimage').click()" -->
              <i class="fas fa-2x fa-camera" data-target="#exampleFormModal" data-toggle="modal"
                        style="display: inline-block;position: absolute; top: 10px; left:10px; cursor: pointer"></i>          
              
              <?php if(isset($currentUser['CoverImage'])): ?>
                <img id="imgcover" style="width:700px;height:250px" src="getImage.php?type=coverimage&id=<?php echo $currentUser['ID']?>" >
              <?php else:?>
                <img id="imgcover" style="width:700px;height:250px" src="image/defaultCoverIMG.jpg" >
              <?php endif; ?>
              <!--<input type="file" name="cover" id="coverimage" style="display: none;">-->    
              <div class="card-block wall-person-info">
                <a class="avatar bg-white img-bordered person-avatar">
                  <img src="getImage.php?type=avatar&id=<?php echo $currentUser['ID']?>">
                </a>
                <h2 class="person-name">
                  <a href="#"><?php echo $currentUser['Name'] ?></a>
                </h2>
              </div>
            </div>
          <!---- Open Content ---->
          <?php foreach(GetStatusByUserID($currentUser['ID']) as $post): ?>
            <div class="card card-shadow">
              <div class="card-block media clearfix p-25">
                <div class="pr-20">
                  <?php if(!$currentUser['Image']): ?>
                    <a href="#" class="avatar avatar-lg">
                      <img class="img-fluid" src="getImage.php?type=avatar&id=<?php echo $currentUser['ID']?>">
                    </a>
                  <?php else: ?>
                    <a href="#" class="avatar avatar-lg">
                      <img class="img-fluid" src="image/defaultavt.png">
                    </a>
                  <?php endif; ?>
                </div>
                <div class="media-body text-middle">
                  <h4 class="mt-0 mb-5">
                    <?php echo $currentUser['Name'] ?>
                  </h4>
                  <small><?php echo $post['Time'] ?></small>
                </div>
              </div>
              <div class="card-block px-25  pt-0">
                <p class="card-text mb-20">
                   <?php echo $post['Content'] ?>
                </p>
                <div class="row imgs-gallery mb-20 no-space">
                  <div class="col-lg-12"> 
                    <?php if($post['IMGContent']!=null): ?>
                      <img style="max-width: 500px;max-height: 200px;" src="getImage.php?type=post&id=<?php echo $post['ID']?>">
                    <?php endif; ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          <!---- Open Content ---->                      
          </div>
          <!-- Open About Me -->
          <div class="col-lg-4">          
            <div class="card card-block">
              <i class="fas fa-sm fa-edit" data-target="#modalAboutMe" data-toggle="modal" style="display: inline-block;position: absolute; top: 10px; left:10px; cursor: pointer"></i>     
              <br>
              <h4 class="card-title">Tự giới thiệu bản thân</h4>   
              <p class="card-text">
              <?php echo $currentUser['AboutMe'] ?>
              </p>
            </div>
          <!-- End About Me -->
          <!-- Open Profile -->
            <div class="card p-20">
               <i class="fas fa-sm fa-edit" data-target="#modalProfile" data-toggle="modal" style="display: inline-block;position: absolute; top: 10px; left:10px; cursor: pointer"></i>     
              <br>
              <h4 class="card-title">
                Giới thiệu
              </h4>
              <p class="card-text">
                Mô tả bản thân
              </p>
              <div class="card-block p-0">
                <p data-info-type="phone" class="mb-10 text-nowrap">
                  <i class="icon wb-user mr-10"></i>
                  <span class="text-break"><?php echo $currentUser['PhoneNumber'] ?> 
                    <span>
                </p>
                <p data-info-type="email" class="mb-10 text-nowrap">
                  <i class="icon wb-envelope mr-10"></i>
                  <span class="text-break"><a href="mailto:<?php echo $currentUser['Email'] ?>?Subject=Hello%20again" target="_top"><?php echo $currentUser['Email'] ?></a>
                    <span>
                </p>
                <p data-info-type="fb" class="mb-10 text-nowrap">
                  <i class="icon bd-facebook mr-10"></i>
                  <span class="text-break"><a href="<?php echo $currentUser['FaceBook'] ?>" target="_blank" ><?php echo $currentUser['FaceBook'] ?></a>
                    <span>
                </p>
                <p data-info-type="address" class="mb-10 text-nowrap">
                  <i class="icon wb-map mr-10"></i>
                  <span class="text-break"><?php echo $currentUser['Address'] ?>
                    <span>
                </p>
              </div>
          <!-- End Profile -->
            </div>
          </div>
        </div>
        
        <!--OpenModal-->
        <div class="modal fade" id="exampleFormModal"  aria-hidden="false" aria-labelledby="exampleFormModalLabel"
                      role="dialog" tabindex="-1">
                      <div class="modal-dialog modal-simple"  >
                        <form class="modal-content" action="profile.php" method="post" enctype="multipart/form-data">
                          <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="exampleFormModalLabel">Chỉnh sửa ảnh bìa</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-xl-12 form-group">
                                <img id="coverIMG" style="width:400px;height:150px" >
                              </div>  
                              <!-- open form upload -->                         
                                <div class="form-group">
                                  <label for="fileSelect"><strong>Ảnh bìa</strong></label>
                                  <input type="file" name="fileAvatar" id="fileSelect">
                                  <br>
                                  <p><strong>Ghi chú:</strong> Chỉ cho phép định dạng .jpg, .jpeg, .gif và kích thước tối đa tệp tin là 5MB.</p>
                                  <br>
                                </div>
                                <button  type="submit" name="submit" class="btn btn-primary">Cập nhật </button>
                                
                              <!-- end form upload -->
                              <br>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
        <!--EndModal-->

        <!--OpenModal AboutMe-->
        <div class="modal fade" id="modalAboutMe"  aria-hidden="false" aria-labelledby="modalAboutMe"
                      role="dialog" tabindex="-1">
                      <div class="modal-dialog modal-simple"  >
                        <form class="modal-content" action="profile.php" method="post">
                          <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="modalAboutMe">Chỉnh sửa giới thiệu bản thân</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row"> 
                              <!-- open form  -->
                              <div class="col-xl-12 form-group">                         
                                <textarea name="aboutme" rows="4" cols="50" placeholder="<?php echo $currentUser['AboutMe']?>"></textarea>
                              </div>
                              <div class="col-md-12 float-right">
                                <button  type="submit" name="submitAboutMe" class="btn btn-primary">Cập nhật </button>        
                              </div>
                                <!-- end form  -->
                              <br>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
        <!--EndModal AboutMe-->

        <!--OpenModal Profile-->
        <div class="modal fade" id="modalProfile"  aria-hidden="false" aria-labelledby="modalProfile"
                      role="dialog" tabindex="-1">
            <div class="modal-dialog modal-simple"  >
                        <form class="modal-content" action="profile.php" method="post">
                          <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="modalProfile">Chỉnh sửa profile</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row"> 
                              <!-- open form  -->   
                              <div class="col-xl-12 form-group">
                                <label >Số điện thoại</label>                    
                                <input type="text" class="form-control" name="phonenumber" value="<?php echo $currentUser['PhoneNumber'] ?>">
                              </div>
                              <div class="col-xl-12 form-group">
                                <label >Email</label>                          
                                <input type="email" class="form-control" name="email" value="<?php echo $currentUser['Email'] ?>">
                              </div>
                              <div class="col-xl-12 form-group">  
                                <label >Trang cá nhân</label>                        
                                <input type="text" class="form-control" name="facebook" value="<?php echo $currentUser['FaceBook'] ?>">
                              </div>
                              <div class="col-xl-12 form-group">
                                <label >Địa chỉ</label>                            
                                <input type="text" class="form-control" name="address" value="<?php echo $currentUser['Address'] ?>">
                              </div>
                              <div class="col-md-12 float-right">
                                <button  type="submit" name="submitprofile" class="btn btn-primary">Cập nhật </button>        
                              </div>
                              <!-- end form  -->
                              <br>
                            </div>
                          </div>
                        </form>
                      </div>
          </div>
        <!--EndModal Profile-->
      </div>
    </div>




    <script src="Apps/global/js/Plugin/plyr.js"></script>
    <script src="Apps/global/js/Plugin/magnific-popup.js"></script>
    
    <script src="Apps/assets/examples/js/pages/profile_v3.js"></script>
    <script src="Apps/global/vendor/plyr/plyr.js"></script>
    <script src="Apps/global/vendor/magnific-popup/jquery.magnific-popup.js"></script>
    

    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>

    <script>
      $('#fileSelect').change(function(event){
          var tmppath = URL.createObjectURL(event.target.files[0]);
          $("#coverIMG").fadeIn("fast").attr('src',tmppath);
      })
    </script>

    <?php include 'footer.php'; ?>