<script src="../functions/functions.js"></script>
<link rel="stylesheet" href="../style/css/bootstrap.min.css">
<link rel="stylesheet" href="../style/css/bootstrap-theme.min.css" >
<script type="text/javascript" src="../style/js/jquery-2.2.4.min.js"></script>
<script src="../style/js/jquery.min.js"></script>
<script src="../style/js/bootstrap.min.js"></script>
<script src="../functions/functions.js"></script>
<?php
require_once '../core/init.php';
getHeader();
if(isset($_GET['user_id'])&&isset($_GET['contest_id'])){
	$validate=new Validate();
	$validation=$validate->check($_GET,array(
	                             "user_id"=>array("required"=>true,"is_num"=>true),
								 "contest_id"=>array("required"=>true,"is_num"=>true)
	  ));
	  if($validation->passed()){
		  $contest_id=escape($_GET['contest_id']);
		  $user_id=escape($_GET['user_id']);
		  $sql="Select * from subjective_questions where contest_id = ?";
	      $conn=DB::getInstance()->query($sql,array($contest_id));
		  $rows1=$conn->results();
		  $sql="Select * from mcq_questions where contest_id = ?";
		  $conn=DB::getInstance()->query($sql,array($contest_id));
		  $rows2=$conn->results();
		  $sql="Select * from coding_questions where contest_id = ?";
		  $conn=DB::getInstance()->query($sql,array($contest_id));
		  $rows3=$conn->results();
		  $sql="Select id from contest_type where type = ?";
		  $type1=DB::getInstance()->query($sql,array('subjective'))->first()->id;
		  $type2=DB::getInstance()->query($sql,array('objective'))->first()->id;
		  $type3=DB::getInstance()->query($sql,array('coding'))->first()->id;
	      $i=1;
		  $totalg1=0;
		  $total1=0;
		  $total2=0;
		  $totalg2=0;
		  $total3=0;
		  $totalg3=0;
		  $total=0;
		  $totalg=0;
		  ?>
		  <button onclick="printDiv('printableArea');">Print</button>
		  <?php
		  
		  echo '<div id="printableArea">';
		  if(count($rows1)!=0)
		  {
			   echo 'Subjective questions:</br>';
			   foreach($rows1 as $row)
			   {
				  echo 'Question'.$i.' : ['.$row->points.']';
				  $query="Select * from participants_answers where question_id = ? and type_id = ? and user_id = ? ";
			      $question_id=$row->id;
			      $conn=DB::getInstance()->query($query,array($question_id,$type1,$user_id));
			      if($conn->count()==1)
			      {
					  echo '<textarea col="20" rows="3">'.$conn->first()->answer.'</textarea></br>';
					  echo '<input type="text" id="submarks'.$conn->first()->id.'" value="'.$conn->first()->setter_points.'">';
					  echo '<button onclick="insertSubMarks('.$conn->first()->id.','.$row->points.')">Save</button>';
					  $totalg1=$totalg1+$conn->first()->setter_points;
			      }
			      else
			      {
					  echo '<textarea col="20" rows="1">Not attepted</textarea></br>';
			      }
				  $i++;
				  $total1=$total1+$row->points;
			  }
			  echo 'Marks gained in this section  <span id="subjective_marks">'.get_my_sub_marks($contest_id,$user_id).'</span> out of total '.$total1;
			  echo '</br>';
		  }
		  if(count($rows2)!=0)
		  {
		      echo 'Objective questions:</br>';
		      foreach($rows2 as $row)
	          {
				  echo 'Question'.$i.' : '.$row->answer.' - ';
			      $query="Select * from participants_answers where question_id = ? and type_id = ? and user_id = ? ";
			      $question_id=$row->id;
			      $conn=DB::getInstance()->query($query,array($question_id,$type2,$user_id));
			      if($conn->count()==1)
			      {
					  echo $conn->first()->answer;
				      if(trim($conn->first()->answer)==trim($row->answer))
				      {
						  $totalg2=$totalg2+$row->points;
				      }
			      }
			      else
			      {
					  echo 'Not attempted';
			      }
			      echo '</br>';
			      $i++;
				  $total2=$total2+$row->points;
		      }
			  echo "Marks gained in this section  ".$totalg2.' out of total '.$total2;
			  echo '</br>';
		  }
		  if(count($rows3)!=0)
		  {
			  echo 'Coding questions</br>';
		      foreach($rows3 as $row)
	          {
				  echo 'Question'.$i.' : ';
			      $query="Select * from participants_answers where question_id = ? and type_id = ? and user_id = ? ";
			      $question_id=$row->id;
			      $conn=DB::getInstance()->query($query,array($question_id,$type3,$user_id));
			      if($conn->count()==1)
			      {
					  echo $conn->first()->answer;
				      if(trim($conn->first()->answer)=="accepted")
				      {
						  $totalg3=$totalg3+$row->points;
				      }
			      }
			      else
			      {
					  echo 'Not attempted';
			      }
			      echo '</br>';
			      $i++;
				  $total3=$total3+$row->points;
		      }
			  echo "Marks gained in this section  ".$totalg3.' out of total '.$total3;
			  echo '</br>';
		  }
		  $total=$total1+$total2+$total3;
		  $totalg=$totalg1+$totalg2+$totalg3;
			  echo 'Total marks got <span id="total_marks">'.$totalg.'</span> out of '.$total;
			  echo '<a href="show_participants.php?id='.$contest_id.'">Back</a>';
			  echo '</div>';
	  }
	  else
	  {
		  echo 'err';
	  }
}
else
	echo 'Some  error occured';

?>