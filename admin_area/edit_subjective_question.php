<?php
require_once '../core/init.php';
$message="";
$validate1=1;
$validate2=1;
$conn=DB::getInstance();
if(Token::check(Input::get('token'))){
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('question'=>array('required'=>true,'min'=>'1'),
			 'points'=>array('required'=>true,'is_num'=>true)
	  ));
	  if(!$validation->passed()){
		  $validate1=0;
		  foreach($validation->errors() as $error){
		   $message=$message.$error.'</br>';
		 }
	  }
	  $validate_image=new Validate();
	  $validation_image;
	  if(!empty(Input::fget('image','tmp_name'))){
	      $validation_image=$validate_image->check($_FILES,
	       array('image'=>array('required'=>true,'maxsize'=>3713052,'extension'=>'jpg')
	       ));
		   if(!$validation_image->passed()){
			   $validate2=0;
		       foreach($validation_image->errors() as $error){
		        $message=$message.$error.'</br>';
		       }
	        }
	  }
	  if($validate1==1&&$validate2==1){
		   $input_temp_name=INPUT::fget('image','tmp_name');
		   $input_name="";
		   if(!empty(Input::fget('image','tmp_name'))){
			   $input_name=uniqid();
			   $status=move_uploaded_file($input_temp_name,'image/'.$input_name.'.jpg');
		   }
		   $message="";
		   $param=array();
		   $param['question']=Input::get('question');
		   $param['points']=Input::get('points');
		   if($input_name!="")
		   $param['image']='image/'.$input_name.'.jpg';
		   $instance=DB::getInstance()->update('subjective_questions',Input::get('id'),$param);
			if($instance){
				$message="successfullly saved";
			}
			else{
				$message="some error occured";
			}
	  }
    }
     if(isset($_GET['id'])||isset($_POST['id']))
     	$conn=DB::getInstance()->get('subjective_questions',array('id','=',Input::get('id')));
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
	<div class="giveborder col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
    <?php
	   ?>
	    <form role="form" class="form-horizontal" action="edit_subjective_question.php" method="post" enctype="multipart/form-data">
	    </br></br>
        <div id="message" class="form-group">
        <?php
          if($message != "")
            echo '<label>'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="question" class="control-label">Question</label>
            <div>
                <textarea class="form-control" id="question" name="question"><?php echo $result->question;?></textarea>
            </div>            
        </div>
		<?php
		if($result->image != ""){
		?>
		<div class="form-group">
	        <label for="image_disp" class="control-label">Image</label>
	        <div>
	            <image class="img-responsive" height="300" width="300"  style="border-radius:4%" alt="image not found" src="<?php echo $result->image; ?>">
	        </div>
		</div>
        <?php
		}
        ?>		
		<div class="form-group">
            <label for="image" class="ontrol-label">Upload Image (if any)</label>
            <div>
                <input type="file" class="form-control" id="image" name="image">
            </div> 
        </div>
		<div class="form-group">
            <label for="points" class="control-label">Points</label>
            <div>
                <input type="text" class="form-control" id="points" name="points" value="<?php echo $result->points ;?>">
            </div>            
        </div>
		<input type="hidden" name="id" value="<?php echo Input::get('id');?>">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Save Question" name="next" id="next" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_questions.php?subjective">Go Back</a>		
    </form>
    </div>
    </div>
</body>
</html>