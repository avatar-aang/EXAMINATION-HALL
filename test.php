<html>
<head>
	<title>Contest</title>
	<link rel="stylesheet" href="style/css/bootstrap.min.css">
	<link rel="stylesheet" href="style/css/bootstrap-theme.min.css" >
	<link rel="stylesheet" href="lib/codemirror.css">
	<link rel="stylesheet" href="theme/ambiance.css">
	<script type="text/javascript" src="functions/functions.js"></script>
	<script type="text/javascript" src="style/js/jquery-2.2.4.min.js"></script>
	<script src="style/js/jquery.min.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/codemirror.js"></script>
	<script type="text/javascript" src="mode/clike/clike.js"></script>
	 <script language="javascript">
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
</script>
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
<?php
require_once('core/init.php');
$user = new user();
$contest_end_time=Session::get(Config::get('session/contest_end_time'));
if (function_exists('date_default_timezone_set'))
{
  date_default_timezone_set('Asia/Calcutta');
}
$present_time=strtotime(date('Y-m-d h:i:s'));
$contest_end_time=strtotime($contest_end_time);
$dif=$contest_end_time-$present_time;
if($dif<0)
{
	Redirect::to('end_test.php');
}
header( "refresh:".$dif.";url=end_test.php" );
if($user->isLoggedIn()&&Session::exits(Config::get('session/contest_session_participate'))){
	$conn=DB::getInstance()->get('contests',array('id','=',Session::get(Config::get('session/contest_session_participate'))));
	if($conn){
	    $row=$conn->first();
		if(time()<= strtotime($row->ending_time)){
			echo '<div class="container">';
			echo '<div class="row">';
			get_all_questions_in_test();
			?>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-right">
			    <div class="row" id="question_container"></div>
				<div class="row" id = "status_save"></div>
			</div>
			<a class="btn btn-danger" href="end_test.php">End contest</a>
			</div>
			</div>
			<?php
		}
		else{
			echo '<div>contest over</div>';
		}
	}
	else
		echo '<div>Some error occured</div>';
}
else
	echo '<div>not logged in or session does not exits</div>';
?>
</body>
<script>
        
</script>
</html>