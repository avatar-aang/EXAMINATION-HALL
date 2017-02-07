<?php
require_once '../core/init.php';
$message="";
$conn=DB::getInstance();
$validate1=1;
$validate2=1;
if(Token::check(Input::get('token'))){
     $validate=new Validate();
     $validation=$validate->check($_POST,
	   array('question'=>array('required'=>true,'min'=>'1'),
	         'noptions'=>array('required'=>true),
			 'points'=>array('required'=>true,'is_num'=>true),
			 'answer'=>array('required'=>true)
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
		   $param['noptions']=Input::get('noptions');
		   $param['answer']=Input::get('answer');
		   $param['points']=Input::get('points');
		   if($input_name!="")
		   $param['image']='image/'.$input_name.'.jpg';
		   $i=1;
		   for($i=1;$i<=Input::get('noptions');$i++){
			   $param['option'.$i]=Input::get('option'.$i);
		   }
		   $instance=DB::getInstance()->update('mcq_questions',Input::get('id'),$param);
			if($instance){
				$message="successfullly saved";
			}
			else{
				$message="some error occured";
			}
	  }
   }
     if(isset($_GET['id'])||isset($_POST['id']))
     $conn=DB::getInstance()->get('mcq_questions',array('id','=',Input::get('id')));
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
	   <form role="form" class="form-horizontal" action="edit_mcq_question.php" method="post" enctype="multipart/form-data" style="align:center";>
	    </br>
		</br>
        <!--<div id="message" class="form-group">
        <?php
          if($message != "")
            echo '<label>'.$message.'</label>';
        ?>
	    </div>-->
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
                <image class="img-responsive" height="300" width="300" src="<?php echo $result->image;?>" alt="image not found">
        	</div>
		</div>
        <?php
		}
        ?>		
		<div class="form-group">
            <label for="image" class="control-label">Upload Image (If any)</label>
            <div>
                <input type="file" class="form-control" id="image" name="image">
            </div> 
        </div>
		<div class="form-group">
            <label for="noptions" class="control-label">No of Options</label>
            <div> 
            <select class="form-control" name="noptions" id="noptions" size="1" onChange="get_options_field(this.value);">
			    <option value="2" <?php if($result->noptions==2) echo 'selected';?> >2</option>
				<option value="3" <?php if($result->noptions==3) echo 'selected';?> >3</option>
				<option value="4" <?php if($result->noptions==4) echo 'selected';?> >4</option>
				<option value="5" <?php if($result->noptions==5) echo 'selected';?> >5</option>
            </select>
            </div>
        </div>
		<div id="options">
		    <div class="form-group">
	          <label for="option1" class="control-label">Option 1</label>
	           <input type="text" class= "form-control" name="option1" id="option1" value="<?php echo $result->option1 ;?>">
	        </div>
			<div class="form-group">
	          <label for="option1" class="control-label">Option 2</label>
	           <input type="text" class= "form-control" class= "form-control" name="option2" id="option2" value="<?php echo $result->option2 ;?>">
	        </div>
			<div class="form-group">
	          <label for="option1" class="control-label">Option 3</label>
	           <input type="text" class= "form-control" name="option3" id="option3" value="<?php echo $result->option3 ;?>">
	        </div>
			<div class="form-group">
	          <label for="option1" class="control-label">Option 4</label>
	          <input type="text" class= "form-control" name="option4" id="option4" value="<?php echo $result->option4 ;?>">
	        </div>
			<div class="form-group">
	           <label for="option1" class="control-label">Option 5</label>
	           <input type="text" class= "form-control" class= "form-control" name="option5" id="option5" value="<?php echo $result->option5 ;?>">
	        </div>
		</div>
		<div class="form-group">
            <label for="points" class="control-label">Points</label>
            <input type="text" class= "form-control" class="form-control" id="points" name="points" value="<?php echo $result->points ;?>">           
        </div>
        <div class="form-group">
            <label for="answer" class="control-label">Correct Option</label>
            <select class="form-control" name="answer" id="answer" size="1" value="<?php echo $result->answer;?>">
			    <option class= "form-control" value="1">1</option>
				<option class= "form-control" value="2">2</option>
				<option class= "form-control" value="3">3</option>
				<option class= "form-control" value="4">4</option>
                <option class= "form-control" value="5">5</option>
				</select>
        </div>
		<input type="hidden" name="id" value="<?php echo Input::get('id');?>">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Save Question" name="next" id="next" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_questions.php?mcq">Go Back</a>
    </form>
    </div>
    </div>
</body>
</html>