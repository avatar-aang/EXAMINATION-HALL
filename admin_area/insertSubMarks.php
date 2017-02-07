<?php
require_once '../core/init.php';
if(isset($_POST['answer_id'])&&isset($_POST['setter_points']))
{
	$validate=new Validate();
	$validation=$validate->check($_POST,array(
	                             "answer_id"=>array("required"=>true,"is_num"=>true),
								 "setter_points"=>array("required"=>true,"is_num"=>true)
	  ));
	  if($validation->passed())
	  {
		  $answer_id=Input::get('answer_id');
		  $setter_points=Input::get('setter_points');
		  $conn=DB::getInstance()->get('participants_answers',array('id','=',$answer_id));
		  $prev=0;
		  if($conn)
		  {
			  $prev=$conn->first()->setter_points;
		  }
		  if(DB::getInstance()->update('participants_answers',$answer_id,array('setter_points'=>$setter_points)))
		  {
			  echo $prev;
		  }
		  else
		  {
			  echo 'Some error occured';
		  }
	  }
	  else
		  echo 'Some error occured';
}
else 
	echo 'Some error occured';