
<?php
require_once 'core/init.php';
if(isset($_POST['question_id'])&&isset($_POST['type_id'])){
	$question_id=escape($_POST['question_id']);
	$type_id=escape($_POST['type_id']);
	$validate =new Validate();
	$validation=$validate->check($_POST,array('question_id'=>array('required'=>true,'is_num'=>true),'type_id'=>array('required'=>true,'is_num'=>true)));
    if($validation->passed()){
		if($type_id==1){
			  $sql="Select * from subjective_questions where id = ? ";
			  $conn=DB::getInstance()->get('subjective_questions',array('id','=',$question_id));
			  if($conn){
				  $row=$conn->first();
				  echo '<h3>Question</h3><p>'.$row->question.'</p>';
			      if(!empty($row->image))
				  echo '<image width="250" height="250" style="border:2px solid black; border-radius:7.5%" src="admin_area/'.$row->image.'" alt="image not found"></br></br>';
				  echo '<hr>';
			      echo '<textarea class="form-control" cols="50" rows="15" id="subjective_answer" name="subjective_answer"></textarea></br>';
			  }
			  echo '<button class="btn btn-success center-block" onclick="saveAnswer('.$question_id.','.$type_id.')">Submit Answer</button></br></br></div>';
		}
		  else if($type_id==2){
              $sql="Select * from mcq_questions where id = ? ";
			  $conn=DB::getInstance()->get('mcq_questions',array('id','=',$question_id));
			  if($conn){
				$row=$conn->first();
			    echo '<h3>Question</h3><p>'.$row->question.'</p>';
			    if(!empty($row->image))
				    echo '<image width="250" height="250" src="admin_area/'.$row->image.'"></br>';
				echo '<hr>';
			    if($row->noptions==2){
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
			      else if($row->noptions==3){
					echo '<div class="btn-group" data-toggle="buttons">
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
			      else if($row->options==4){
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
			      else{
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
			  echo '<button class="btn btn-success center-block" onclick="saveAnswer('.$question_id.','.$type_id.')">Submit Answer</button>';
		  }
		  else if($type_id==3){
				  $sql="Select * from coding_questions where id = ? ";
				  $conn=DB::getInstance()->get('coding_questions',array('id','=',$question_id));
				  if($conn){
					  $row=$conn->first();
				      echo '<h3>Question</h3><p>'.$row->question.'</p>';
				   ?>
			   		<hr>
					<h4>Submit Code</h4>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<select class="form-control" id="s_language" name="s_language">
							<?php
								$languages = get_languages();
								foreach($languages as $language){
									echo '<option class="form-control" value="'.$language->hck_id.'">'.$language->name.'</option>';
								}
							?>
							</select>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
								<label class="custom-file">
								<input type="file" name="upload_file" id="upload_file" class="custom-file-input">
								<span class="custom-file-control"></span>
								</label>
							</div>
						</div></br>
						<div class="row">
							<textarea rows="20" name="text_editor" id="text_editor">Enter your code here</textarea>
						</div></br></br>
						<button class="btn btn-success center-block" onclick="submit_code();">Submit Code <span class="glyphicon glyphicon-ok"></span></button></br></br>
						<hr>
						<div class="row">
							<textarea class="form-control" rows="1" name="output" id="output" readonly="true">Your Output</textarea>
						</div>
						<script>
							var text_editor = CodeMirror.fromTextArea(document.getElementById("text_editor"), {	
					       	lineNumbers: true,
					        mode:  "text/x-c",
					        theme: "ambiance"});
						</script>
				<?php
			  }
		  }
		  else{
			  die();
		  }
	  }
}
?>
