<?php
require_once '../core/init.php';
$user=new User();
if(!$user->isloggedIn()||!Session::exits(Config::get('session/contest_session')))
	die('Some error occured');
$message="";
if(Token::check(Input::get('token'))){
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('question'=>array('required'=>true,'min'=>'1'),
			 'points'=>array('required'=>true,'is_num'=>true),
			 'time_limit'=>array('required'=>true,'is_num'=>true)
	  ));
	  $validate_image=new Validate();
	  $validation_image=$validate_image->check($_FILES,
	    array('input_file'=>array('required'=>true,'maxsize'=>3713052,'extension'=>'txt'),
		      'output_file'=>array('required'=>true,'maxsize'=>3713052,'extension'=>'txt'))
	    );
	  if($validation->passed()&&$validation_image->passed()){
		   $message="";
		   $param=array();
		   $param['question']=Input::get('question');
		   $param['points']=Input::get('points');
		   $param['contest_id']=Session::get(Config::get('session/contest_session'));
		   $param['time_limit']=Input::get('time_limit');
		   $input_temp_name=INPUT::fget('input_file','tmp_name');
		   $input_name=uniqid();
		   $output_name=uniqid();
		   $output_temp_name=INPUT::fget('output_file','tmp_name');
		   if(move_uploaded_file($input_temp_name,'inputs/'.$input_name.'.jpg')&&move_uploaded_file($output_temp_name,'outputs/'.$output_name.'.jpg')){
			   $param['input_path']='inputs/'.$input_name.'.txt';
			   $param['output_path']='outputs/'.$output_name.'.txt';
			   $instance=DB::getInstance()->insert('coding_questions',$param);
			   if($instance){
				$message="successfullly saved";
			   }
			   else{
				$message="some error occured";
			   }   
		   }
		   else
			   echo 'Some error occured';
	  }
	   else{
	     foreach($validation->errors() as $error){
		   $message=$message.$error.'</br>';
		 }
		  foreach($validation_image->errors() as $error){
		   $message=$message.$error.'</br>';
		 }
	  }
   }
?>
<head>
	<style>
	.givepad{
		padding: 20px;
	}
	</style>
</head>
<div class="givepad col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
    <form role="form" class="form-horizontal" action="add_questions.php?coding" method="post" enctype="multipart/form-data">
        <div id="message" class="form-group">
        <?php
          if($message!="")
            echo '<label class="col-sm-offset-2 col-lg-offset-2 col-sm-10 &nbsp;&nbsp;&nbsp;&nbsp;col-lg-6">'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="question" class="col-sm-2 col-lg-2 control-label">Question</label>
            <div class="col-sm-10 col-lg-6">
                <textarea class="form-control" id="question" name="question"></textarea>
            </div>            
        </div>
		<div class="form-group">
            <label for="points" class="col-sm-2 col-lg-2 control-label">Points</label>
            <div class="col-sm-10 col-lg-6">
                <input type="text" class="form-control" id="points" name="points">
            </div>            
        </div>
		<div class="form-group">
            <label for="input_file" class="col-sm-2 col-lg-2 control-label">Input file</label>
            <div class="col-sm-10  col-lg-6">
                <input type="file" class="form-control" id="input_file" name="input_file">
            </div> 
        </div>
		<div class="form-group">
            <label for="output_file" class="col-sm-2 col-lg-2 control-label">Output file</label>
            <div class="col-sm-10  col-lg-6">
                <input type="file" class="form-control" id="output_file" name="output_file">
            </div> 
        </div>
		<div class="form-group">
            <label for="time_limit" class="col-sm-2 col-lg-2 control-label">Time limit in sec</label>
            <div class="col-sm-10 col-lg-6">
                <input type="text" class="form-control" id="time_limit" name="time_limit">
            </div>            
        </div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Next" name="next" id="next" class="btn btn-success">
    </form>
</div>