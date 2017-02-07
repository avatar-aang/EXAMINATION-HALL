<html>
<head>
	<title>Modify Contest</title>
	<meta name="description" content="Code Editor">
    <link rel="stylesheet" href="../style/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/css/bootstrap-theme.min.css" >
    <script type="text/javascript" src="../style/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="../style/js/jquery.min.js"></script>
    <script type="text/javascript" src="../style/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../functions/functions.js"></script>
</head>
<body>
<div class="container-fluid">
<?php
require_once '../core/init.php';
getHeader();
$user = new user();
if(!$user->isloggedIn()||!Session::exits(Config::get('session/contest_session')))
	die('Either not logged in or not created any contest');
?>
<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
	</br>
	<div class="row">
		<div class="col-lg-4 col-md-4"><h4><a class="btn btn-success center-block" href="add_questions.php?mcq">Add MCQ</a></h4></div>
		<div class="col-lg-4 col-md-4"><h4><a class="btn btn-success center-block" href="add_questions.php?subjective">Add Subjective Question</a></h4></div>
		<div class="col-lg-4 col-md-4"><h4><a class="btn btn-success center-block" href="add_questions.php?coding">Add Coding Question</a></h4></div>
	</div></br></br>
	<div>
<?php
if(isset($_GET['mcq']))
	require_once 'mcq.php';
else if(isset($_GET['coding']))
	require_once 'coding.php';
else if(isset($_GET['subjective']))
	require_once 'subjective.php';
else;
get_all_questions2(Session::get(Config::get('session/contest_session')));
?>
</div>
</br></br><a href="end_contest.php?id='.<?php echo Session::get(Config::get('session/contest_session'))?>.'" name="end" id="end" class="btn btn-success">End Contest</a></br></br>
</div>
</body>
<html>