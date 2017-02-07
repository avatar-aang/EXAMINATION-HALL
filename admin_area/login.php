<?php
$message="";
$my_self=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
require_once 'core/init.php';
if(isset($_SERVER['HTTP_REFERER']))
{
	if($my_self!==$_SERVER['HTTP_REFERER'])
	{
		Session::flash('redirect',$_SERVER['HTTP_REFERER']);
	}
}
if(isset($_POST['user_login']))
{
  if(Token::check(Input::get('token')))
   {
      $validate=new Validate();
      $validation=$validate->check($_POST,array('username'=>array('required'=>true,'min'=>5,'max'=>25),'password'=>array('required'=>true,'min'=>4,'max'=>25)
                       ));
      if($validation->passed())
      {
	     $user=new user();
		 $remember=false;
		 $login=$user->login(Input::get('username'),Input::get('password'),$remember,0);
		 if($login)
		 {
		       if($redirect=Session::flash('redirect'))
			   {
				   echo 'ref'.$redirect;
				   Redirect::to($redirect);
				   die();
			   }
			   else
			   {
				   Redirect::to('index.php');
				   die();
			   }
		 }
		 else
		 {
		    $message='Either password did not match or you are not registered';
		 }
	  }
	  else
	  {
	     foreach($validation->errors() as $error)
		 {
		    $message=$message.$error.'</br>';
		 }
	  }
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> online judge </title>
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
<div class="container-fluid">
	<?php
	if(!Session::exits(Config::get('session/session_name')))
	{
	?>
	<div class="giveborder col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
		</br>
		</br>
		<h1 style="text-align:center; color: #5cb85c"> Log In </h1>
		</br>
		<form role="form" class="form-horizontal"  action="login.php" method="POST" enctype="multipart/form-data">
	        <div class="form-group has-success">
	        	<div class="col-sm-4">
	            	<label for="username" class="control-label">Username: </label>
	            </div>
	            <div class="col-sm-8">
	                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
	            </div>            
	        </div>
	        <div class="form-group has-warning">
	        	<div class="col-sm-4">
	            	<label for="password" class="control-label">Password: </label>
	            </div>
	            <div class="col-sm-8">
	                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
	            </div>        
	        </div>
	        <button type="submit" value="Login" name="user_login" id="user_login" class="btn btn-success btn-lg">Login</button>
		    <a href="register.php" class="btn btn-default btn-lg">Sign Up</a>
	        <a href="change_password_page.php" class="btn btn-md btn-link">Forgot password <span class="glyphicon glyphicon-question-sign"></span></a>
			<div>
		        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		    </div>
    	</form>
    	</br>
    	</br>
    </div>
<?php
}
else
	$message='Already logged in';
if($message != ""){
	?>
		</br>
		</br>
		<div class="giveborder col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
		</br>
		<?php
			echo '<h4>Log In failed</h4>';
			echo '<i>'.$message.'</i>';
		?>
		</br>
		</div>
	<?php
	}
?>
</div>
</body>
</html>
