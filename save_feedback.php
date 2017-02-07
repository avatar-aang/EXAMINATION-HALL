<?php
require_once 'core/init.php';
if(isset($_POST['contest_id'])&&isset($_POST['user_id'])&&isset($_POST['feedback']))
{
	$contest_id=escape($_POST['contest_id']);
	$user_id=escape($_POST['user_id']);
	$feedback=escape($_POST['feedback']);
	$validate=new Validate();
	$validation=$validate->check($_POST,array('contest_id'=>array('required'=>true,'is_num'=>true),
	                                          'user_id'=>array('required'=>true,'is_num'=>true),
											  'feedback'=>array('required'=>true,'max'=>"150")
                       ));
      if($validation->passed())
      {
		  
		$conn=DB::getInstance()->insert('feedback',array('user_id'=>$user_id,
		                                                 'contest_id'=>$contest_id
														 ,'feedback'=>$feedback) );
	    if(!$conn->error())
		{
			echo 'saved';
		}
		else
			echo 'Not saved';
														 
	  }
}
