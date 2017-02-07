<?php
require_once 'core/init.php';
if(isset($_POST['question_id'])&&isset($_POST['type_id']))
{
	$question_id=escape($_POST['question_id']);
	$type_id=escape($_POST['type_id']);
	$validate =new Validate();
	$validation=$validate->check($_POST,array('question_id'=>array('required'=>true,'is_num'=>true),'type_id'=>array('required'=>true,'is_num'=>true)
                       ));
      if($validation->passed())
      {
		  if($type_id==1)
		  {
			  $sql="Select * from subjective_questions where id = ? ";
			  $conn=DB::getInstance()->get('subjective_questions',array('id','=',$question_id));
			  if($conn)
			  {
				  $row=$conn->first();
				  echo $row->question.'</br>';
			      if(!empty($row->image))
				  echo '<image width="250" height="250" src="admin_area/'.$row->image.'" alt="image not found"></br>';
			      echo '<textarea cols="50" rows="15" id="subjective_answer" name="subjective_answer" ></textarea>';
			  }
			  echo '<button onclick="saveAnswer('.$question_id.','.$type_id.')">Save</button>';
		  }
		  else if($type_id==2)
		  {
              $sql="Select * from mcq_questions where id = ? ";
			  $conn=DB::getInstance()->get('mcq_questions',array('id','=',$question_id));
			  if($conn)
			  {
				  $row=$conn->first();
			      echo $row->question.'</br>';
			      if(!empty($row->image))
				      echo '<image width="250" height="250" src="admin_area/'.$row->image.'"></br>';
			      if($row->noptions==2)
			      {
					  echo '
					  <div class="btn-group" data-toggle="buttons">
                           <label class="radio-inline">
                                 <input type="radio" id="option1" name="mcq_answer" value="1" />'.$row->option1.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option2" name="mcq_answer" value="2" />'.$row->option2.'
                           </label> 
                      </div>';
			      }
			      else if($row->noptions==3)
			      {
					  echo '
					  <div class="btn-group" data-toggle="buttons">
                           <label class="radio-inline">
                                 <input type="radio" id="option1" name="mcq_answer" value="1" />'.$row->option1.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option2" name="mcq_answer" value="2" />'.$row->option2.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option3" name="mcq_answer" value="3" />'.$row->option3.'
                           </label> 
                      </div>';
			      }
			      else if($row->options==4)
			      {
					  echo '
					  <div class="btn-group" data-toggle="buttons">
                           <label class="radio-inline">
                                 <input type="radio" id="option1" name="mcq_answer" value="1" />'.$row->option1.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option2" name="mcq_answer" value="2" />'.$row->option2.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option3" name="mcq_answer" value="3" />'.$row->option3.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option4" name="mcq_answer" value="4" />'.$row->option4.'
                           </label> 
                      </div>';
			      }
			      else
			      {
					  echo '
					  <div class="btn-group" data-toggle="buttons">
                           <label class="radio-inline">
                                 <input type="radio" id="option1" name="mcq_answer" value="1" />'.$row->option1.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option2" name="mcq_answer" value="2" />'.$row->option2.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option3" name="mcq_answer" value="3" />'.$row->option3.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option4" name="mcq_answer" value="4" />'.$row->option4.'
                           </label> 
                           <label class="radio-inline">
                                 <input type="radio" id="option5" name="mcq_answer" value="5" />'.$row->option5.'
                           </label>
                      </div>';
				  }
			  }
			  echo '<button onclick="saveAnswer('.$question_id.','.$type_id.')">Save</button>';
		  }
		  else if($type_id==3)
		  {
			  $sql="Select * from mcq_questions where id = ? ";
			  $conn=DB::getInstance()->get('mcq_questions',array('id','=',$question_id));
			  if($conn)
			  {
				  $row=$conn->first();
			      $row=$conn->results();
			      echo $row->question.'</br>';
			      //getTextAreaForCoding(); and status  should  be some special symbol and stored in filed name coding_answer 
			  }
		  }
		  else
		  {
			  die();
		  }
	  }
}
?>