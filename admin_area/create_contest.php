<?php
require_once '../core/init.php';
$user=new User();
$contest_created=0;
if(!$user->isLoggedIn())
{
	die('You are not logged in');
}
$message="";
if(Token::check(Input::get('token')))
   {
	   if(isset($_POST['create_contest']))
	   {
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('name'=>array('required'=>true,'unique'=>'contests','min'=>'1','max'=>'25'),
	         'contest_description'=>array('required'=>true,'min'=>'1','max'=>'1000'),
			 'contest_start_date'=>array('required'=>true),
			 'contest_start_time'=>array('required'=>true),
			 'contest_end_date'=>array('required'=>true),
			 'contest_end_time'=>array('required'=>true),
	  ));
	  if($validation->passed())
	  {
		   $conn=DB::getInstance()->insert('contests',array('name'=>Input::get('name'),'description'=>Input::get('contest_description'),
		   'starting_time'=>Input::get('contest_start_date').' '.Input::get('contest_start_time'),
		   'ending_time'=>Input::get('contest_end_date').' '.Input::get('contest_end_time'),'user_id'=>$user->data()->id));
		   if($conn)
		   {
			   $contest_created=1;
		   }
		   else
		   {
			   echo 'some error occured ';
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
	else if(isset($_POST['continue']))
	{
		       $query="Select * from contests where user_id = ? order by created_time DESC Limit 1";
			   $conn=DB::getInstance()->query($query,array($user->data()->id));
			   if(!$conn->error()&&$conn->count()==1)
			   {
				   $contest_id=$conn->first()->id;
				   Session::put(Config::get('session/contest_session'),$contest_id);
				   print_r($conn->first());
					   header('Location:add_questions.php');
			   } 
	}
	else;
}
?>
<html>
<head>
    <title>Admin Area</title>
    <link rel="stylesheet" href="../style/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/css/bootstrap.min.css" >
	<script src="../style/js/jquery.min.js"></script>
    <script src="../style/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../functions/functions.js"></script>
</head>
<body>

	   <form role="form" class="form-horizontal" action="create_contest.php" method="post" enctype="multipart/form-data" style="align:center";>
	   <?php
	     
	     if($contest_created==0)
		 {
			 ?>
	    </br>
		</br>
        <div id="message" class="form-group">
        <?php
          if($message!="")
            echo '<label class="col-sm-offset-2 col-lg-offset-2 col-sm-10  col-lg-6">'.$message.'</label>';
        ?>
	    </div>
		<div class="form-group">
	          <label for="name" class="col-sm-2 col-lg-2 control-label">Contest_name</label>
		      <div class="col-sm-10 col-lg-6">
	           <input type="text" name="name" id="name">
		      </div>
	    </div>
        <div class="form-group">
            <label for="contest_description" class="col-sm-2 col-lg-2 control-label">Contest_Description</label>
            <div class="col-sm-10 col-lg-6">
                <textarea class="form-control" id="contest_description" name="contest_description"></textarea>
            </div>            
        </div>
		<div class="form-group">
            <label for="contest_start_date" class="col-sm-2 col-lg-2 control-label">Contest starting date</label>
            <div class="col-sm-10 col-lg-6">
                <input type="date" class="form-control" id="contest_start_date" name="contest_start_date">
            </div>            
        </div>
		<div class="form-group">
            <label for="contest_start_time" class="col-sm-2 col-lg-2 control-label">Contest starting time</label>
            <div class="col-sm-10 col-lg-6">
                <input type="time" class="form-control" id="contest_start_time" name="contest_start_time">
            </div>            
        </div>
		<div class="form-group">
            <label for="contest_end_date" class="col-sm-2 col-lg-2 control-label">Contest end date</label>
            <div class="col-sm-10 col-lg-6">
                <input type="date" class="form-control" id="contest_end_date" name="contest_end_date">
            </div>            
        </div>
		<div class="form-group">
            <label for="contest_end_time" class="col-sm-2 col-lg-2 control-label">Contest end time</label>
            <div class="col-sm-10 col-lg-6">
                <input type="time" class="form-control" id="contest_end_time" name="contest_end_time">
            </div>            
        </div>		
		<input type="submit" value="Create" name="create_contest" id="create_contest" class="btn btn-success">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<?php
		 }
		 else
		 {
			 ?>
			 <p>Contest created successfully</p>
			 <input type="submit" value="Continue" name="continue" id="continue">
			 <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			 <?php
		 }
		?>
    </form>
</body>