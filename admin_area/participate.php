<?php
require_once 'core/init.php';
$user=new user();
if(!$user->isloggedIn())
	echo 'You need to logged in';
else
{
	if(isset($_GET['contest_id'])&&!empty($_GET['contest_id']))
	{
		$contest_id=escape($_GET['contest_id']);
		
		$sql="Select * from contest_register where user_id = ? and contest_id = ? ";
		$param=array($user->data()->id,$contest_id);
		$conn=DB::getInstance()->query($sql,$param);
		$id=$conn->first()->id;
		if(!$conn->error())
		{
			if($conn->count()==0)
			{
				echo 'Sorry not registered';
			}
			else if($conn->first()->participated=='y')
			{
				echo 'Already given test';
			}
			else
			{
				if(DB::getInstance()->update('contest_register',$id,
				       array('participated'=>'y')
					   ))
					   {
						   $contest_end_time=getContestEndTime($contest_id);
						   if($contest_end_time)
						   {
							   Session::put(Config::get('session/contest_session_participate'),escape($contest_id));
							   Session::put(Config::get('session/contest_end_time'),escape($contest_end_time));
				               Redirect::to('test.php');
						   }
						   else
							   echo 'Some error occured';
					   }
					   else
					   {
						   echo 'Some error occured';
					   }
				
			}
		}
		else
		echo 'Some error occured';
	}
	else
		echo 'Some error occured';
}
?>