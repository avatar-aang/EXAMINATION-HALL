<?php
require_once 'core/init.php';
$user=new user();
if($user->isloggedIn()&&Session::exits(Config::get('session/contest_session_participate')))
{
	    $contest_id=Session::get(Config::get('session/contest_session_participate'));
		$user_id=$user->data()->id;
		echo 'Total questions attempted = '.get_my_questions($contest_id,$user_id).' from total questions '.get_total_questions($contest_id).'</br>';
		echo 'Total points attempted '.get_my_points($contest_id,$user_id).' from total points '.get_total_points($contest_id).'</br>';
		if(Session::delete(Config::get('session/contest_session_participate'))&&Session::delete(Config::get('session/contest_end_time')))
     	{
			echo 'Succsssfully ended .';
	    }
	    else
		    echo 'Some error occured';
}
	