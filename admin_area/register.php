<?php
require_once 'core/init.php';
$message='';
if(isset($_POST['create_user_account_form']))
{
   if(Token::check(Input::get('token')))
   {
		  $validate=new Validate();
			  $validation=$validate->check($_POST,
	           array('username'=>array('required'=>true,'max'=>20,'min'=>3),
		      'fullname'=>array('required'=>true,'max'=>35,'min'=>3),
			  'email'=>array('required'=>true,'max'=>50,'min'=>5),
			  'password'=>array('required'=>true,'max'=>15,'min'=>4),
			  'country'=>array('required'=>true),
			  're_password'=>array('required'=>true,'max'=>15,'min'=>4,'matches'=>'password'),
 	           )
	                                   );
          if($validation->passed())
          {
			   $new_user=new user();
		      try
		      {
				  $salt=Hash::salt(32);
			     $new_user->create(array(
			                         'username'=>Input::get('username'),
									 'name'=>Input::get('fullname'),
									 'email'=>Input::get('email'),
									 'country_id'=>Input::get('country'),
									 'password'=>Hash::make(Input::get('password'),$salt),
									 'salt'=>$salt
			                            )
								  );
				if(isset($_POST['flash'])&&!empty(Input::get('flash')))
				{
					Session::flash('account_created','Account created successfully!');
					Redirect::to('index.php?'.escape(Input::get('flash')));
				}
				else
				{
					$message.='Account created successfully</br>';
				}
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
	<style>
		.giveborder
		{
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
		<h1 style="text-align:center; color: #5cb85c">Sign Up</h1>
		</br>
		<form role="form" class="form-horizontal" action="register.php" method="post">
	        <div class="form-group has-success">
	        	<div class="col-sm-4">
	            	<label for="username" class="control-label">Username</label>
	            </div>
	            <div class="col-sm-8">
	                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username">
	            </div>
	        </div>
	        <div class="form-group has-success">
	        	<div class="col-sm-4">
	            	<label for="fullname" class="control-label">Name</label>
	            </div>
	            <div class="col-sm-8">
	                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your Name">
	            </div> 
	        </div>
	        <div class="form-group has-success">
	        	<div class="col-sm-4">
	            	<label for="email" class="control-label">Email</label>
	            </div>
	            <div class="col-sm-8">
	                <input type="mail" class="form-control" id="email" name="email" placeholder="Enter your e-mail">
	            </div>        
	        </div>
		    <div class="form-group has-success">
	        	<div class="col-sm-4">
	           		<label for="country" class="control-label">Country</label>
	            </div>
	            <div class="col-sm-8">
	                <select class="form-control" id="country" name="country" size="1">
					    <?php
						$countries=get_countries();
						foreach($countries as $country)
						{
							?>
							
						    <option value="<?php echo $country->id;?>"><?php echo $country->iso_code_3;?>
							 </option>
							<?php
						}
						?>
					</select>
	            </div>
	        </div>
	        <div class="form-group has-warning">
	       		<div class="col-sm-4">
	            	<label for="password" class="control-label">Password</label>
	            </div>
	            <div class="col-sm-8">
	                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Password">
	            </div>
	        </div>
	        <div class="form-group has-warning">
	        	<div class="col-sm-4">
	           		<label for="re_password" class="control-label">Re-enter password</label>
	            </div>
	            <div class="col-sm-8">
	                <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Re-enter your Password">
	            </div>
	        </div>
	        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	        <button type="submit" class="btn btn-success btn-lg" name="create_user_account_form" value="Create Account" id="create_user_account_form">Sign Up</button>
			 <a href="index.php?login" class="btn btn-default btn-lg">Login</a>
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
			echo '<h4>Sign Up failed</h4>';
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