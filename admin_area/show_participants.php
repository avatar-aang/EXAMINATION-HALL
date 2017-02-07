<head>
<link rel="stylesheet" href="../style/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../style/css/bootstrap.min.css" >
<script src="../style/js/jquery.min.js"></script>
<script src="../style/js/bootstrap.min.js"></script>
</head>
<?php
require_once '../core/init.php';
getHeader();
if(isset($_GET['id'])){
	$contest_id=escape($_GET['id']);
	$conn=DB::getInstance()->get('contest_register',array('contest_id','=',$contest_id));
	if($conn){
		echo '<div class="jumbotron"><div class="container">';
		if($conn->count()==0)
			echo '<h1>No one registered</h1>';
		else{
			echo '<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-12">';
			echo '<h3>'.$conn->count().' contestants have registered for the contest.'.'</h3>';
			echo '<div class="row">';
			echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4><strong>Name</strong></h4></div>';
			echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4><strong>Email</strong></h4></div>';
			echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4><strong>Show Stats</strong></h4></div>';
			echo '</div>';
			$rows=$conn->results();
			foreach($rows as $row){
				echo '<div class="row">';
				$conn=DB::getInstance()->get('users',array('id','=',$row->user_id));
				if($conn){
					$row2=$conn->first();
					echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.$row2->name.'</div>';
					echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.$row2->email.'</div>';
					echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><a href="show_stats.php?user_id='.$row2->id.'&contest_id='.$contest_id.'">Show Stats</a></div>';
				}
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div></div>';
	}
}
else
	die();
?>