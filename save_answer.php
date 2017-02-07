<?php
require_once 'core/init.php';
$user=new user();
if(isset($_POST['question_id'])&&isset($_POST['type_id'])&&isset($_POST['answer']))
{
	$question_id=escape($_POST['question_id']);
	$type_id=escape($_POST['type_id']);
	$answer=escape($_POST['answer']);
	$validate =new Validate();
	$validation=$validate->check($_POST,array('question_id'=>array('required'=>true,'is_num'=>true),
	                                          'type_id'=>array('required'=>true,'is_num'=>true),
											  'answer'=>array('required'=>true)
                       ));
      if($validation->passed())
      {
		  $query="Select id , num_submissions , COUNT(id) as sum from participants_answers where question_id = ? and type_id = ?";
		  $conn=DB::getInstance()->query($query,array($question_id,$type_id));
		  if(!$conn->error())
		  {
			  $num=$conn->first()->sum;
			  if($num==0)
			  {
				  if($conn=DB::getInstance()->insert('participants_answers',array(
                                   'user_id'=>$user->data()->id,
                                   'question_id'=>$question_id,
                                   'type_id'=>$type_id,
                                   'answer'=>$answer,
                                   'contest_id'=>Session::get(Config::get('session/contest_session_participate'))								   
		          )))
		          echo 'Saved';
		          else
			          echo 'Some error occured in saving';
			  }
			  else if($num==1)
			  {
				  $id=$conn->first()->id;
				  $num_submissions=$conn->first()->num_submissions;
				  if($conn=DB::getInstance()->update('participants_answers',$id,array(
                                   'answer'=>$answer,
								   'num_submissions'=>$num_submissions+1
                               )))
		          echo 'Saved';
		          else
			          echo 'Some error occured in saving';
			  }
			  else;
		  }
		  else
		  {
			  echo 'Some error occured in saving';
			  die();
		  }
	  }
}