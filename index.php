<?php
require_once 'core/init.php';
ob_start();
$user=new user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> book store app</title>
    <meta name="description" content="bookstore app">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="style/css/bootstrap-theme.min.css" >
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <script type="text/javascript" src="style/js/jquery-2.2.4.min.js"></script>
    <script src="style/js/jquery.min.js"></script>
    <!-- Latest  compiled and minified JavaScript -->
    <script src="style/js/bootstrap.min.js"></script>
	<style>
	   #footer
	   {
		   background-color:black;
		   color:white;
	   }
	</style>
	<style type="text/css">
.giveborder{
    		border: 5px;
    		border-style: solid;
    		border-radius: 4%;
    		border-color: #5cb85c;
			
}
</style>
</head>
<body>	
<nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Navigation</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">     
            <ul class="nav navbar-nav navbar-left" id="menu">
			    <li><a href="index.php" id="home">Home</a></li>
                <li><a href="index.php?gallery" id="gallery">Gallery</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right" >
			    <li class="dropdown" id="dropdown-item">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                Contests<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="category-item">
                        <?php
                           $contests=get_contests();
                              foreach($contests as $contest)
                               {
                                  echo '<li class="dropdown-submenu"><a href="index.php?contestId='.$contest->id.'">'.$contest->name.'</a>';   
                                  echo '</li>';  
                                  echo '<li class="divider"></li>';
                               }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>
	                Account<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right" id="account-item">
					<?php 
					if($user->isLoggedIn())
					{
						?>
				         <li><a href="my_profile.php" id="my_profile">My profile</a></li>
	                <li class="divider"></li>
                        <li><a href="logout.php" id="logout">Logout[<?php echo $user->data()->username;?>]</a></li>
	                <li class="divider"></li>
		            <?php
					}
					else
					{
						?>
						<li><a href="register.php" id="create_account">Create account</a></li>
	                <li class="divider"></li>
                        <li><a href="login.php" id="login">Login</a></li>
	                <li class="divider"></li>
						<?php
					}
					?>
                    </ul>
              </li>
            </ul>
        </div>
  </nav>
   <!-- page body starts here -->
   <div class="container" id="body" style="padding-right: 4px;padding-left: 4px;padding-top: 6px; width:99%">
        <div id="inner_content">
		<?php
		if(Session::exits(Config::get('session/session_name')))
            {
	             $user=new user();
	             /*echo '<script>';
			     echo  'var username=\''.$user->data()->username.'\';';
		         echo  '$(\'#login\').html(\'Logout[\'+username+\']\');';
			     echo  '$(\'#login\').attr(\'href\',\'logout.php\');';
			     echo '</script>';*/
            }
					if(isset($_GET['contestId'])){
          $conn=DB::getInstance()->get('contests',array('id','=',$_GET['contestId']));
          if(!$conn->error()){ 
            $row=$conn->first();
            echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            echo '<ul style="list-style:none">';
					  echo '<li><h3><strong>Contest Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$row->name.'</h3></li></br></br>';
            echo '<li><h3><strong>Description:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<h3><p>'.$row->description.'</p></li></br></br>';
            echo '<li><h3><strong>Start Time:</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$row->starting_time.'</h3></li></br></br>';
            echo '<li><h3><strong>End Time:</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$row->ending_time.'</h3></li>';
            echo '</ul></div>';
					  if(strtotime($row->starting_time)>time())
						  echo '<a class="btn btn-success btn-lg" href="register_for_contest.php?contest_id='.$row->id.'">Register for Contest</a>';
					  else if(strtotime($row->starting_time)<=time()&&strtotime($row->ending_time)>=time())
						  echo '</br><a class="btn btn-success btn-lg" href="participate.php?contest_id='.$row->id.'">Enter Contest Area</a>';
						else
							echo '<div class="center-block">Contest ended</div>';
      }            
		}
			else
			{
				?>
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
                 <!-- Carousel indicators -->
                 <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                 </ol>
              <!-- Carousel items -->
              <div class="carousel-inner">
                  <div class="item active">
                      <img src="gallery/168908.jpg" style="width:100%;height:470px" alt="First slide">
                  </div>
                  <div class="item">
                      <img src="gallery/pexels-photo-12064.jpeg" style="width:100%;height:470px" alt="Second slide">
                  </div>
                  <div class="item">
                      <img src="gallery/creative-wallpaper-watch-globe-books-pencil-education-educational-black-board-abc-writing.jpg" style="width:100%;height:470px" alt="Third slide">
                  </div>
              </div>
              <!-- Carousel nav -->
              <a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" id="carousel-left"></span></a>
              <a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right" id="carousel-right"></span></a>
              </div>
			  	<div id="footer">
     <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="t3-module module contact-list " id="Mod108">
                        <div class="module-inner">
                            <h3 class="module-title "><span>Contact Us</span></h3>
                            <div class="module-ct">
                                <div class="custom contact-list" >
                                    
                                    <ul class="contact-list" >
                                        <li class="phone"><i class="fa fa-phone"></i><strong>Hot line: </strong><span>9044153345, 9837081128</span></li>
                                        <li class="email"><i class="fa fa-envelope"></i><strong>Email: </strong> <a href="mailto:mnnitalumni@mnnit.ac.in">mnnitalumni@mnnit.ac.in</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="t3-module module contact-list " id="Mod108">
                        <div class="module-inner">
                            <h3 class="module-title "><span>Feedback</span></h3>
                            <div class="module-ct">
                                <div class="custom contact-list" >
                                    <p>Give us your Feedbacks.</p>
                                    <a href="/feedbacks/new"><button class= 'btn btn-success'>Feedback</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="t3-module module " id="Mod109">
                        <div class="module-inner">
                            <h3 class="module-title "><span>Connect with us</span></h3>
                            <div class="module-ct">
                                <div class="custom">
                                    <p>We're on Social Networks. Follow us &amp; get in touch.</p>

                                    <div class="social-list addthis_toolbox">
                                        <a class="addthis_button_facebook_follow" href="https://www.facebook.com/MNNIT.Allahabad/"><i class="fa fa-facebook"></i></a>
                                        <a class="addthis_button_google_follow" href="https://plus.google.com/111638606512128083669" ><i class="fa fa-google-plus"></i></a>
                                        <a class="addthis_button_linkedin_follow" href="https://www.linkedin.com/company/mnnit"><i class="fa fa-linkedin"></i></a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <footer id="t3-footer" class="wrap t3-footer">
        <section class="t3-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12 copyright col-md-push-3">
                        <div class="module">
                            <small>Copyright &#169; 2016 MNNIT-Allahabad. All Rights Reserved. Designed by <a href="#" rel="nofollow">Webteam MNNIT</a>.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </footer>
	
	</div>
			  <?php
			}
		?>
        </div>
		</br>
		</br>
	</div>
</body>
</html>
