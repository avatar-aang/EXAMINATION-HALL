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
		if(!$conn->error())
		{
			if($conn->count()==0)
			{
				if(DB::getInstance()->insert('contest_register',
				       array('user_id'=>$user->data()->id,'contest_id'=>$contest_id)
					   ))
					   {
						   echo 'Successfully registered';
					   }
					   else
					   {
						   echo 'Some error occured';
					   }
			}
			else
				echo 'Already registered';
		}
		else
		echo 'Some error occured';
	}
	else
		echo 'Some error occured';
}
if(isset($_SERVER['HTTP_REFERER']))
					   echo '<a href="'.$_SERVER['HTTP_REFERER'].'">Back</a>';
				       else
						   echo '<a href="index.php">Back</a>';
?>