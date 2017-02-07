<?php
require_once '../core/init.php';
$user=new User();
if(!$user->isloggedIn()||!Session::exits(Config::get('session/contest_session')))
	die('Some error occured');
$message="";
$validate1=1;
$validate2=1;
if(Token::check(Input::get('token')))
   {
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('question'=>array('required'=>true,'min'=>'1'),
	         'noptions'=>array('required'=>true,'is_num'=>true),
			 'points'=>array('required'=>true,'is_num'=>true),
			 'answer'=>array('required'=>true,'is_num'=>true)
	  ));
	  if(!$validation->passed())
	  {
		  $validate1=0;
		  foreach($validation->errors() as $error)
		 {
		   $message=$message.$error.'</br>';
		 }
	  }
	  $validate_image=new Validate();
	  $validation_image;
	  if(!empty(Input::fget('image','tmpname')))
	  {
	      $validation_image=$validate_image->check($_FILES,
	       array('image'=>array('required'=>true,'maxsize'=>3713052,'extension'=>'jpg')
	       ));
		   if(!$validation_image->passed())
		   {
			   $validate2=0;
		       foreach($validation_image->errors() as $error)
		       {
		        $message=$message.$error.'</br>';
		       }
	        }
	  }
	  if($validate1==1&&$validate2==1)
	  {
		   $input_temp_name=INPUT::fget('image','tmp_name');
		   $input_name="";
		   if(!empty(Input::fget('image','tmp_name')))
		   {
			   $input_name=uniqid();
			   $status=move_uploaded_file($input_temp_name,'image/'.$input_name.'.jpg');
		   }
		   $message="";
		   $sql="Insert into mcq_questions (question,noptions,answer,points,image,contest_id,";
		   $i=1;
		   for($i=1;$i<Input::get('noptions');$i++)
		   {
			   $sql=$sql."option".$i.',';
		   }
		   $sql=$sql."option".$i.')';
		   $sql=$sql." values (?,?,?,?,?,?,";
		   $i=1;
		   for($i=1;$i<Input::get('noptions');$i++)
		   {
			   $sql=$sql."?,";
		   }
		   $sql=$sql."?)";
		   $param=array();
		   $param[]=Input::get('question');
		   $param[]=Input::get('noptions');
		   $param[]=Input::get('answer');
		   $param[]=Input::get('points');
		   if($input_name!="")
		   $param[]='image/'.$input_name.'.jpg';
	       else
		   $param[]="";
		   $param[]=Session::get(Config::get('session/contest_session'));
		   $i=1;
		   for($i=1;$i<=Input::get('noptions');$i++)
		   {
			   $param[]=Input::get('option'.$i);
		   }
		   $instance=DB::getInstance()->query($sql,$param);
			if(!$instance->error()&&$instance->count()==1)
			{
				$message="successfullly saved";
			}
			else
			{
				$message="some error occured";
			}
	  }
   }
?>
<head>
    <title>Admin Area</title>
    <link rel="stylesheet" href="../style/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/css/bootstrap.min.css" >
	<script src="../style/js/jquery.min.js"></script>
    <script src="../style/js/bootstrap.min.js"></script>
	<script>
	</script>
    <script type="text/javascript" src="../functions/functions.js"></script>
    <style>
        
    </style>
</head>
	<div class="col-lg-6 col-md-6 col-lg-offset-3">
      <form role="form" class="form-horizontal" action="add_questions.php?mcq" method="post" enctype="multipart/form-data">
	    </br>
		</br>
        <div id="message" class="form-group">
        <?php
          if($message!="")
            echo '<label class="">'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="question" class="control-label">Question</label>
            <div>
                <textarea class="form-control" id="question" name="question"></textarea>
            </div>            
        </div>
		<div class="form-group">
            <label for="image" class="control-label">Image if any</label>
            <div class="col-sm-10  col-lg-6">
                <input type="file" class="form-control" id="image" name="image">
            </div> 
        </div>
		<div class="form-group">
            <label for="noptions" class="control-label">No of options</label>
            <div> 
            <select class="form-control" name="noptions" id="noptions" size="1" onChange="get_options_field(this.value);">
			    <option class="form-control" value="2">2</option>
				<option class="form-control" value="3">3</option>
				<option class="form-control" value="4">4</option>
				<option class="form-control" value="5">5</option>
            </select>
            </div>
        </div>
		<div id="options">
		    <div class="form-group">
	          <label for="option1" class="control-label">Option1</label>
		      <div >
	           <input type="text" name="option1" id="option1">
		      </div>
	        </div>
			<div class="form-group">
	          <label for="option1" class="control-label">Option2</label>
		      <div >
	           <input type="text" name="option2" id="option2">
		      </div>
	        </div>
		</div>
		<div class="form-group">
            <label for="points" class="control-label">Points</label>
            <div>
                <input type="text" class="form-control" id="points" name="points">
            </div>            
        </div>
        <div class="form-group">
            <label for="answer" class="control-label">Correct option</label>
            <div> 
            <select class="form-control" name="answer" id="answer" size="1">
			    <option class="form-control" value="1">1</option>
				<option class="form-control" value="2">2</option>
				<option class="form-control" value="3">3</option>
				<option class="form-control" value="4">4</option>
                <option class="form-control" value="5">5</option>
				</select>
            </div>
        </div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Next" name="next" id="next" class="btn btn-success">
    </form>
</div>