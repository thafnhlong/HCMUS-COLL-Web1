<?php
include 'header-first.php';
?>
<body>	

	<div class="wrapper">	
		<header>
			<div class="container">
				<div class="header-data">
					<div class="logo">
						<a href="index.php" title=""><img src="images/logo.png" alt=""></a>
					</div><!--logo end-->
					<div class="search-bar" style="visibility: hidden;"></div><!--search-bar end-->
					<div class="menu-btn">
						<a href="#" title=""><i class="fa fa-bars"></i></a>
					</div><!--menu-btn end-->
					<div class="user-account">
						<div class="user-info">
							<img src="<?php echo getImage($currentUser['ID'],0)[1]?>" alt="">
							<a href="#" title=""><?php echo $currentUser['Name']?></a></a>
							<i class="la la-sort-down"></i>
						</div><!--user-info end-->
						<div class="user-account-settingss" id="users">
							<h3>Setting</h3>
							<ul class="us-links">
								<li><a href="update-profile.php" title="">Update Profile</a></li>
								<li><a href="change-password.php" title="">Change Password</a></li>
							</ul>
							<h3 class="tc"><a href="logout.php" title="">Logout</a></h3>
						</div><!--user-account-settingss end-->
					</div><!--user-account end-->
                    <nav>
						<ul>
							<li>
								<a href="index.php" title="">
									<span><img src="images/icon1.png" alt=""></span>
									Home
								</a>
							</li><!--home end-->
                            <li>
								<a href="profiles.php" title="">
									<span><img src="images/icon2.png" alt=""></span>
									Members
								</a>
							</li><!--profiles end-->
                            <li>
								<a href="message.php" title="">
									<span><img src="images/icon6.png" alt=""></span>
									Messages
								</a>
							</li><!--profiles end-->
							<li>
								<a href="my-account.php" title="">
									<span><img src="images/icon4.png" alt=""></span>
									Profiles
								</a>
							</li><!--profile end-->
						</ul>
					</nav><!--nav end-->
					
				</div><!--header-data end-->
			</div>
		</header><!--header end-->	

