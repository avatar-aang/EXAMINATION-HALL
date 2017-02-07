<script src="../functions/functions.js"></script>
<link rel="stylesheet" href="../style/css/bootstrap.min.css">
<link rel="stylesheet" href="../style/css/bootstrap-theme.min.css" >
<script type="text/javascript" src="../style/js/jquery-2.2.4.min.js"></script>
<script src="../style/js/jquery.min.js"></script>
<script src="../style/js/bootstrap.min.js"></script>
<script src="../functions/functions.js"></script>
<style type="text/css">
.giveborder{
    		border: 5px;
    		border-style: solid;
    		border-radius: 4%;
    		border-color: #5cb85c;
			
}
</style>
<?php

require_once '../core/init.php';
getHeader();
if(isset($_GET['id'])){
	$contest_id=escape($_GET['id']);
	$query="Select feedback.*,users.name,users.email from feedback ,users where contest_id = ? and users.id = feedback.user_id ";
	$conn=DB::getInstance()->query($query,array($contest_id));
    if(!$conn->error()){
		echo '<div class ="container">';
		echo '<h2 align="center">Response of contestents</h2>';
		echo '<div class="giveborder col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">';
		if($conn->count()==0)
			echo '<div class="row">No feedback</row></br></hr>';
		else
		{
			$rows=$conn->results();
			foreach($rows as $row)
			{
				echo '<div class="container" id="feedback">';
				     echo '<div class="row">';
				     echo '@'.$row->name;
				     echo '</div>';
					 echo '<div class="row">';
				     echo "\t\t".$row->feedback_time;
				     echo '</div>';
					 echo '<div class="row">';
					 echo $row->feedback;
			         echo '</div>';
					 echo '<div class="row">';
				     echo $row->email;
				     echo '</div>';
				echo '</div>';
				echo '</br>';
				echo '<div class="divider"></div>';
			}
		}
		echo '<a class="btn btn-danger" href="index.php">back</a>';
		echo '</div>';
		echo '</div>';

	}		
}
else
	die();
?>