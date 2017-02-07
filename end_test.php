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
	<script src="functions/functions.js"></script>
	<style type="text/css">
.giveborder{
    		border: 5px;
    		border-style: solid;
    		border-radius: 4%;
    		border-color: #5cb85c;
			
}
</style>
<?php
require_once 'core/init.php';
$user=new user();
?>
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
  <?php
if($user->isloggedIn()&&Session::exits(Config::get('session/contest_session_participate')))
{
	    $contest_id=Session::get(Config::get('session/contest_session_participate'));
		$user_id=$user->data()->id;
		echo '<div class="giveborder col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">';
		echo '<h2 align="center">Total questions attempted = '.get_my_questions($contest_id,$user_id).' from total questions '.get_total_questions($contest_id).'</h2></br>';
		echo '<h2 align="center">Total points attempted '.get_my_points($contest_id,$user_id).' from total points '.get_total_points($contest_id).'</h2></br>';
		?>
		<div class="form-group">
        <label for="feedback">Feedback:</label>
		<textarea class="form-control" rows="10" id="feedback"></textarea>
		</div>
		</br>
		<button class="btn btn-primary" onclick="save_feedback('<?php echo $user_id ?>','<?php echo $contest_id?>')">Give feedback</button>
		<?php
		if(Session::delete(Config::get('session/contest_session_participate'))&&Session::delete(Config::get('session/contest_end_time')))
     	{
			
	    }
	    else
		    echo 'Some error occured';
		echo '</div>';
}
	