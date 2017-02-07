<?php
require_once '../core/init.php';
$message="";
$conn=DB::getInstance();
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
		    $param['time_limit']=Input::get('time_limit');
		    $input_temp_name=INPUT::fget('input_file','tmp_name');
		    $input_name=uniqid();
		    $output_name=uniqid();
		    $output_temp_name=INPUT::fget('output_file','tmp_name');
		    if(move_uploaded_file($input_temp_name,'inputs/'.$input_name)&&move_uploaded_file($output_temp_name,'outputs/'.$output_name)){
			   $param['input_path']='inputs/'.$input_name;
			   $param['output_path']='outputs/'.$output_name;
			   $instance=DB::getInstance()->update('coding_questions',Input::get('id'),$param);
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
if(isset($_GET['id'])||isset($_POST['id']))
  	$conn=DB::getInstance()->get('coding_questions',array('id','=',Input::get('id')));
if($conn->count()!=0){
    $result=$conn->first();   
}
else
	die();
?>
<html>
<head>
    <title>Admin Area</title>
    <link rel="stylesheet" href="../style/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/css/bootstrap.min.css" >
	<script src="../style/js/jquery.min.js"></script>
    <script src="../style/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../functions/functions.js"></script>
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
	<div class="container">
	<div class="giveborder col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
	</br></br>
    <?php
	   ?>
	   <form role="form" class="form-horizontal" action="edit_coding_question.php" method="post" enctype="multipart/form-data">
        <div id="message" class="form-group">
        <?php
		echo 'Please dont forget to upload input and output file';
          if($message!="")
            echo '<label class="control-label">'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="question" class="control-label">Question</label>
            <textarea class="form-control" id="question" name="question"><?php echo $result->question;?></textarea>           
        </div>
		<div class="form-group">
            <label for="points" class="control-label">Points</label>
            <input type="text" class="form-control" id="points" name="points" value="<?php echo $result->points ;?>">          
        </div>
		<div class="form-group">
            <label for="input_file" class="control-label">Input file</label>
            <input type="file" class="form-control" id="input_file" name="input_file"> 
        </div>
		<div class="form-group">
            <label for="output_file" class="control-label">Output file</label>
            <input type="file" class="form-control" id="output_file" name="output_file">
        </div>
		<div class="form-group">
            <label for="time_limit" class="control-label">Time limit in seconds</label>
            <input type="text" class="form-control" id="time_limit" name="time_limit" value="<?php echo $result->time_limit;?>">
        </div>
		<input type="hidden" name="id" value="<?php echo Input::get('id');?>">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Save Question" name="next" id="next" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_questions.php?coding">Go Back</a>		
    	</form>
    </div>
    </div>
</body>
</html>