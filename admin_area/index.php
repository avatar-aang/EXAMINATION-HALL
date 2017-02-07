<?php
require_once('../core/init.php');
$message='';
if(Input::exits()&&isset($_POST['admin_login'])){
  if(Token::check(Input::get('token'))){
      $validate=new Validate();
      $validation=$validate->check($_POST,array('username'=>array('required'=>true,'min'=>5,'max'=>25),'password'=>array('required'=>true,'min'=>4,'max'=>25)
                       ));
      if($validation->passed()){
	     $user=new user();
		 $remember=(Input::get('remember')==='on')?true:false;
		 $login=$user->login(Input::get('username'),Input::get('password'),$remember,1);
		 if($login){
		    
		 }
		 else{
		    $message='Either password did not match or you are not admin';
		 }
	  }
	  else{
	     foreach($validation->errors() as $error){
		    $message=$message.$error.'</br>';
		 }
	  }
   }
}
?>
<html>
<head>
    <title>Admin Area</title>
    <link rel="stylesheet" href="../style/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/css/bootstrap.min.css" >
	<script src="../style/js/jquery.min.js"></script>
    <script src="../style/js/bootstrap.min.js"></script>
	<script>
	var show_sidebar=1;
	</script>
    <script type="text/javascript" src="../functions/functions.js"></script>
</head>
<body>
    <?php 
	getHeader();
	$user=new user();
	if(!$user->isLoggedIn()){
    	echo '<div class="content" style="margin-top:0px; left:0px;"><img id="header" src="../gallery/admin.png" width="100%" height="150px"/></div>';
		echo '<div class="container">';
		if(isset($_GET['change_password_page']))
			require('change_password_page.php');
		else{
			echo '<h1 class="text-center">Admin - login</h1>';
	        login_form($message);
		}
		echo '<div>';
	}
	else{
		$user=new user();
		echo '<div class="col-lg-8 col-lg-offset-2">';
		echo '<h1 style="text-align:center">Your Contests</h1><hr>';
		if($user->isLoggedIn()&&$user->data()->group_id!=1){
			?>
			<a href="create_contest.php" class="btn btn-success center-block">Create New Contest</a></br>
			<?php
			    $rows=get_my_contest(Session::get(Config::get('session/session_name')));
				if($rows&&count($rows)==0){
					echo '<h3>No contest created</h3>';
				}
				else{
					echo '<div class="col-lg-4 col-md-4"><h4><strong>Contest Name</h4></div>';
					echo '<div class="col-lg-2 col-md-2"><h4>Edit</h4></div>';
					echo '<div class="col-lg-2 col-md-2"><h4>Delete</h4></div>';
					echo '<div class="col-lg-2 col-md-2"><h4>Participants</h4></div>';
					echo '<div class="col-lg-2 col-md-2"><h4>Feedbacks</h4></div>';
					foreach($rows as $row){
						echo '<div class="col-lg-4 col-md-4">'.$row->name.'</div>';
				        echo '<a class="col-lg-2 col-md-2" href="edit_contest.php?id='.$row->id.'">Edit</a>';
			            echo '<a class="col-lg-2 col-md-2" href="delete_contest.php?id='.$row->id.'">Delete</a></br>';
                        echo '<a class="col-lg-2 col-md-2" href="show_participants.php?id='.$row->id.'">Participants</a>';            			
                        echo '<a class="col-lg-2 col-md-2" href="feedback.php?id='.$row->id.'">FeedBacks</a>';	
					}
					echo '</strong>';
				}
		 }
		 else
			 echo '<h2 align="center">You are not admin</h2>';
		echo '<div class="col-lg-6 col-md-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-12">';
		echo '<hr><a href="logout.php" class="btn btn-danger center-block">Logout</a>';
		echo '</div></div>';
	}
	?>
</body>   
</html>