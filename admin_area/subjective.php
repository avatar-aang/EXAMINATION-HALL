<?php
require_once '../core/init.php';
$user=new User();
if(!$user->isloggedIn()||!Session::exits(Config::get('session/contest_session')))
	die('Some error occured');
$message="";
$validate1=1;
$validate2=1;
if(Token::check(Input::get('token'))){
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('question'=>array('required'=>true,'min'=>'1'),
			 'points'=>array('required'=>true,'is_num'=>true)
	  ));
	  if(!$validation->passed()){
		  $validate1=0;
		  foreach($validation->errors() as $error)
		 {
		   $message=$message.$error.'</br>';
		 }
	  }
	  $validate_image=new Validate();
	  $validation_image;
	  if(!empty(Input::fget('image','tmp_name')))
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
		   $param=array();
		   $param['question']=Input::get('question');
		   $param['points']=Input::get('points');
		   $param['contest_id']=Session::get(Config::get('session/contest_session'));
		   if($input_name!="")
		   $param['image']='image/'.$input_name.'.jpg';
	       else
		   $param['image']="";
		   $instance=DB::getInstance()->insert('subjective_questions',$param);
			if($instance){
				$message="successfullly saved";
			}
			else{
				$message="some error occured";
			}
	  }
   }
?>
<head>
	<style>
	.givepad{
		padding:30px;
	}
	</style>
</head>
	<div class="row">
      <form role="form" class="givepad form-horizontal" action="add_questions.php?subjective" method="post" enctype="multipart/form-data"
        <div id="message" class="form-group">
        <?php
          if($message!="")
            echo '<label>'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="question" class="control-label">Question</label>
            <textarea class="form-control" id="question" name="question"></textarea>            
        </div>
		<div class="form-group">
	        <label for="image" class="control-label">Upload Image (if any)</label>
	        <input type="file" class="form-control" id="image" name="image">
        </div>
		<div class="form-group">
            <label for="points" class="control-label">Points</label>
            <input type="text" class="form-control" id="points" name="points">
        </div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Next" name="next" id="next" class="btn btn-success">
    </form>
    </div>