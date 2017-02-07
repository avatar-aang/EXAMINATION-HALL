<?php
$message="";
$my_self=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
require_once 'core/init.php';
$user=new user();
if(Input::exits()&&isset($_POST['update_admin_account_form']))
{
   if(Token::check(Input::get('token')))
   {
      if(empty(Input::get('password'))&&empty(Input::get('re_password')))
	  {
		  $validate=new Validate();
		  if(escape(Input::get('username'))===$user->data()->username)
		  {
			  $validation=$validate->check($_POST,
	           array('username'=>array('required'=>true,'max'=>20,'min'=>3),
		      'fullname'=>array('required'=>true,'max'=>35,'min'=>3),
			  'email'=>array('required'=>true,'max'=>50,'min'=>5),
			  'country'=>array('required'=>true),
 	           )
	                                   );
		  }
		  else
		  {
			  $validation=$validate->check($_POST,
	          array('username'=>array('required'=>true,'max'=>20,'min'=>3,'unique'=>'users'),
		      'fullname'=>array('required'=>true,'max'=>35,'min'=>3),
			  'email'=>array('required'=>true,'max'=>50,'min'=>5),
			  'country'=>array('required'=>true),
 	           )
	                                   );
		  }
          if($validation->passed())
          {
		      try
		      {
			    $user->update(array(
			                         'username'=>Input::get('username'),
									 'name'=>Input::get('fullname'),
									  'country_id'=>Input::get('country'),
									 'email'=>Input::get('email')
			                            )
								  );
                $message.='Details updated successfully</br>';			 
		      }
		      catch(Exception $e)
		      {
			     $message=$message.$e->getMessage().'</br>';
		      }
	      }
	      else
	      {
		      foreach($validation->errors() as $error)
		      {
			     $message.=$error.'</br>';
		      }
	      }
	  }
	  else
	  {
		  $validate=new Validate();
		  if(escape(Input::get('username'))===$user->data()->username)
		  {
			  $validation=$validate->check($_POST,
	           array('username'=>array('required'=>true,'max'=>20,'min'=>3),
		      'fullname'=>array('required'=>true,'max'=>35,'min'=>3),
			  'email'=>array('required'=>true,'max'=>50,'min'=>5),
			  'country'=>array('required'=>true),
			  'password'=>array('required'=>true,'max'=>15,'min'=>4),
			  're_password'=>array('required'=>true,'max'=>15,'min'=>4,'matches'=>'password')
 	           )
	                                   );
		  }
		  else
		  {
			  $validation=$validate->check($_POST,
	          array('username'=>array('required'=>true,'max'=>20,'min'=>3,'unique'=>'users'),
		      'fullname'=>array('required'=>true,'max'=>35,'min'=>3),
			  'email'=>array('required'=>true,'max'=>50,'min'=>5),
			  'country'=>array('required'=>true),
			  'password'=>array('required'=>true,'max'=>15,'min'=>4),
			  're_password'=>array('required'=>true,'max'=>15,'min'=>4,'matches'=>'password')
 	           )
	                                   );
		  }
          if($validation->passed())
          {
		      try
		      {
			    $user->update(array(
			                         'username'=>Input::get('username'),
									 'name'=>Input::get('fullname'),
									 'country_id'=>Input::get('country'),
									 'password'=>Hash::make(Input::get('password'),$user->data()->salt),
									 'email'=>Input::get('email')
			                            )
								  );
                $message.='Details updated successfully</br>';			 
		      }
		      catch(Exception $e)
		      {
			     $message=$message.$e->getMessage().'</br>';
		      }
	      }
	      else
	      {
		      foreach($validation->errors() as $error)
		      {
			     $message.=$error.'</br>';
		      }
	      }
	  }
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Exam Hall </title>
    <meta name="description" content="Exam Hall">
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/css/bootstrap-theme.min.css" >
    <script type="text/javascript" src="style/js/jquery-2.2.4.min.js"></script>
    <script src="style/js/jquery.min.js"></script>
    <script src="style/js/bootstrap.min.js"></script>
    <style type="text/css">
    	.giveborder{
    		border: 5px;
    		border-style: solid;
    		border-radius: 4%;
    		border-color: #5cb85c;
    		padding: 30px;
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
if(Session::exits(Config::get('session/session_name'))){
	$user=new user();
	if($flash=Session::flash('change_password'))
		echo '<h2 align="center">'.$flash.'</h2>';
?>
<div class="container">
	<div class="giveborder col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
	<h2 style="text-align:center">My Profile</h2>
	<form role="form" class="form-horizontal" action="my_profile.php" method="post">
        <div id="message" class="form-group">
            <?php
            if($message != "")
               echo '</strong><div class="row" style="text-align:center; background-color:green">'.$message.'</strong></div>';
            ?>
	    </div>
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo escape($user->data()->username) ;?>">
        </div>
        <div class="form-group">
            <label for="fullname" class="control-label">Full name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo escape($user->data()->name) ;?>">
        </div> 
        <div class="form-group">
            <label for="email" class="control-label">Email</label>
			<input type="mail" class="form-control" id="email" name="email" value="<?php echo escape($user->data()->email) ;?>">
        </div>        
		<div class="form-group has-success">
	        <label for="country" class="control-label">Country</label>
	        <select class="form-control" id="country" name="country" size="1">
			<?php
				$countries=get_countries();
				foreach($countries as $country){
				?>
			<option class="form-control" value="<?php echo $country->id;?>" <?php if($country->id==escape($user->data()->country_id)) echo "selected";?> ><?php echo $country->iso_code_3;?>
			</option>
			<?php
			}
			?>
			</select>
	        </div>
		<div class="form-group">
            <label for="password" class="control-label">Password</label>    
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="re_password" class="<strong></h4>control-label">Re-enter password</label>
            <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Password">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">&nbsp;&nbsp;
        <input type="submit" class="btn btn-success center-block" name="update_admin_account_form" value="Update Account" id="update_admin_account_form">
	</form>
	</div>
</div>
<?php
}
else
{
    
}
?>