<script type="text/javascript" src="functions/functions.js"></script>
<link rel="stylesheet" href="style/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="style/css/bootstrap-theme.min.css" >
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <script type="text/javascript" src="style/js/jquery-2.2.4.min.js"></script>
    <script src="style/js/jquery.min.js"></script>
    <!-- Latest  compiled and minified JavaScript -->
    <script src="style/js/bootstrap.min.js"></script>
<?php
require_once 'core/init.php';
$user =new user();
if($user->isLoggedIn()&&Session::exits(Config::get('session/contest_session_participate')))
{
	$conn=DB::getInstance()->get('contests',array('id','=',Session::get(Config::get('session/contest_session_participate'))));
	if($conn)
	{
	    $row=$conn->first();
		if(time()<= strtotime($row->ending_time))
		{
			get_all_questions_in_test();
			?>
			    <div id = "question_container">
				      
				</div>
				<div id = "status_save">
				      
				</div>
				<a href="end_test.php">End contest</a>
			<?php
		}
		else
		{
			echo 'contest over';
		}
	}
	else
		echo 'Some error occured';
}
else
	echo 'not logged in or session does not exits';
?>