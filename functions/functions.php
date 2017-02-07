<?php
function get_countries()
{
	$sql="Select * from country";
	$conn=DB::getInstance()->query($sql,array());
	if(!$conn->error())
	{
		return $conn->results();
	}
	return array();
}
function get_contests()
{
  $sql="SELECT * FROM contests";
  $user=DB::getInstance()->query($sql);
  if(!$user->error())
  { 
     $contests=$user->results();
     return $contests;
  } 
  return array();  
}
function get_my_contest($user_id)
{
	$conn=DB::getInstance()->get('contests',array('user_id','=',$user_id));
	if($conn)
	{
		$rows=$conn->results();
        return $rows;		
	}
	return false;
}
function get_contest_types()
{
	$sql="Select * from contest_type";
	$conn=DB::getInstance()->query($sql,array());
	if(!$conn->error()&&$conn->count()>0)
	{
		$rows=$conn->results();
		return $rows;
	}
	return false;
}
function get_languages()
{
  $sql="SELECT * FROM languages";
  echo $sql.'</br>';
  $conn=DB::getInstance()->query($sql);
  if(!$conn->error())
  { 
     $languages=$conn->results();
     return $languages;
  } 
  return array();  
}

function get_ip()
{
  $ip=$_SERVER['REMOTE_ADDR'];
  if(!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  return $ip;
}
function get_all_questions($contest_id)
{
   if($conn=DB::getInstance()->get('contests',array('id','=',$contest_id)))
   {
	   if($conn->count()!=0)
	   {
		   $type=$conn->first()->type_id;
	       if($type==1)
		   {
			   $sql="Select * from subjective_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
		   }
		   else if($type==2)
		   {
			   $sql="Select * from mcq_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
		   }
		   else if($type==3)
		   {
			   $sql="Select * from coding_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
		   }
		   else;
		   if($conn->count()!=0)
		   {
			  $rows=$conn->results();
			  $i=1;
			  $total=0;
			  foreach($rows as $row)
			  {
				  echo 'Question'.$i.': Point = '.$row->points;
				  if($type==1)
				  echo ' <a href="edit_subjective_question.php?id='.$row->id.'">Edit</a>';
			      else if($type==2)
				  echo ' <a href="edit_mcq_question.php?id='.$row->id.'">Edit</a>';
				  else if($type==3)
			      echo ' <a href="edit_coding_question.php?id='.$row->id.'">Edit</a>';		  
				  else;
				  echo ' <a href="delete_question.php?type='.$type.'&id='.$row->id.'">Delete</a>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  echo 'Total points = '.$total.'</br>';
		   }
		   else
		   {
				echo "No questions added";  
		   }
	   }
   }
}



function get_all_questions2($contest_id)
{
			   $sql="Select * from subjective_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows1=$conn->results();
			   $sql="Select * from mcq_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows2=$conn->results();
			   $sql="Select * from coding_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows3=$conn->results();
			   $i=1;
			   $total=0;
			   $sql="Select id from contest_type where type = ?";
			   $type1=DB::getInstance()->query($sql,array('subjective'))->first()->id;
			   $type2=DB::getInstance()->query($sql,array('objective'))->first()->id;
			   $type3=DB::getInstance()->query($sql,array('coding'))->first()->id;
			   if(count($rows1)!=0)
				   echo 'Subjective questions:</br>';
			   foreach($rows1 as $row)
			   {
				  echo 'Question'.$i.': Point = '.$row->points;
				  echo ' <a href="edit_subjective_question.php?id='.$row->id.'">Edit</a>';
				  echo ' <a href="delete_question.php?type='.$type1.'&id='.$row->id.'">Delete</a>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  if(count($rows2)!=0)
				   echo 'Objective questions:</br>';
			  foreach($rows2 as $row)
			   {
				  echo 'Question'.$i.': Point = '.$row->points;
				  echo ' <a href="edit_mcq_question.php?id='.$row->id.'">Edit</a>';
				  echo ' <a href="delete_question.php?type='.$type2.'&id='.$row->id.'">Delete</a>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  if(count($rows3)!=0)
				   echo 'Coding questions:</br>';
			  foreach($rows3 as $row)
			   {
				  echo 'Question'.$i.': Point = '.$row->points;	
                  echo ' <a href="edit_coding_question.php?id='.$row->id.'">Edit</a>';				  
				  echo ' <a href="delete_question.php?type='.$type2.'&id='.$row->id.'">Delete</a>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  if($i==0) 
			  echo "No questions added";
			  echo 'Total points = '.$total.'</br>';
}

function get_my_questions($contest_id,$user_id)
{
	$total=0;
			   $sql="Select COUNT(id) as sum from  participants_answers where 
	                 user_id = ? and contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($user_id,$contest_id));
			   return $conn->first()->sum;
}
function get_total_questions($contest_id)
{
	$total=0;
			   $sql="Select COUNT(id) as sum from subjective_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   $sql="Select COUNT(id) as sum from mcq_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   $sql="Select COUNT(id) as sum from coding_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   return $total;
}

function get_total_points($contest_id)
{
	$total=0;
			   $sql="Select SUM(points) as sum from subjective_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   $sql="Select SUM(points) as sum from mcq_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   $sql="Select SUM(points) as sum from coding_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $total+=$conn->first()->sum;
			   return $total;
}

function get_my_points($contest_id,$user_id)
{
	$total=0;
			   $sql="Select question_id , type_id from participants_answers where contest_id = ? and user_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id,$user_id));
			   if(!$conn->error())
			   {
				   $questions=$conn->results();
				   foreach($questions as $question)
				   {
					   if($question->type_id==1)
					   {
						   $sql="Select points from subjective_questions where id = ?";
						   $conn=DB::getInstance()->query($sql,array($question->question_id));
			               $total=$total+$conn->first()->points;
					   }
					   else if($question->type_id==2)
					   {
						   $sql="Select points from mcq_questions where id = ?";
						   $conn=DB::getInstance()->query($sql,array($question->question_id));
			               $total=$total+$conn->first()->points;
					   }
					   else if($question->type_id==3)
					   {
						   $sql="Select points from coding_questions where id = ?";
						   $conn=DB::getInstance()->query($sql,array($question->question_id));
			               $total=$total+$conn->first()->points;
					   }
				   }   
			   }
			   return $total;
}


function get_all_questions_in_test()
{
	           $contest_id=Session::get(Config::get('session/contest_session_participate'));
			   $sql="Select * from subjective_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows1=$conn->results();
			   $sql="Select * from mcq_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows2=$conn->results();
			   $sql="Select * from coding_questions where contest_id = ?";
			   $conn=DB::getInstance()->query($sql,array($contest_id));
			   $rows3=$conn->results();
			   $i=1;
			   $total=0;
			   $sql="Select id from contest_type where type = ?";
			   $type1=DB::getInstance()->query($sql,array('subjective'))->first()->id;
			   $type2=DB::getInstance()->query($sql,array('objective'))->first()->id;
			   $type3=DB::getInstance()->query($sql,array('coding'))->first()->id;
			   echo '<div class="giveborder col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">';
			   if(count($rows1)!=0)
				   echo 'Subjective questions:</br>';
			   foreach($rows1 as $row)
			   {
				  echo '<button onclick="obtainQuestion('.$row->id.','.$type1.');">Question '.$i.'['.$row->points.']</button>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  if(count($rows2)!=0)
				   echo 'Objective questions:</br>';
			  foreach($rows2 as $row)
			   {
				  echo '<button onclick="obtainQuestion('.$row->id.','.$type2.');">Question '.$i.'['.$row->points.']</button>';
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  if(count($rows3)!=0)
				   echo 'Coding questions:</br>';
			  foreach($rows3 as $row)
			   {
				  echo '<button onclick="obtainQuestion('.$row->id.','.$type3.');">Question '.$i.'['.$row->points.']</button>';	
				  echo '</br>';
				  $total=$total+$row->points;
				  $i++;
			  }
			  echo 'Total points = '.$total.'</br>';
			  echo '</div>';
}

function getContestEndTime($contest_id)
{
	$conn=DB::getInstance()->get('contests',array('id','=',$contest_id));
	if($conn)
	{
		return $conn->first()->ending_time;
	}
	return false;
}

function login_form($message)
{
?> 
<div class="container">
  <form role="form" class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data" style="align:center";>
	    </br>
		</br>
        <div id="message" class="form-group">
        <?php
          if($message!="")
            echo '<label class="col-sm-offset-2 col-lg-offset-2 col-sm-10  col-lg-6">'.$message.'</label>';
        ?>
	    </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 col-lg-2 control-label">Username</label>
            <div class="col-sm-10 col-lg-6">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>            
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 col-lg-2 control-label">Password</label>
            <div class="col-sm-10 col-lg-6">
                <input type="password" class="form-control" id="password" name="password" >
            </div>        
        </div>
        <div class="form-group">
            <label for="remember" class="col-sm-1 col-lg-1 col-sm-offset-1 col-lg-offset-1 control-label">Remember me 
               <input type="checkbox" id="remember" name="remember"> 
            </label>                  
        </div>
	      <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<div class="form-group">
	    <div class="col-sm-offset-2 col-lg-offset-2 col-sm-2 col-lg-1">
            <button type="submit" name="admin_login" id="admin_login" class="btn btn-primary"><i class="fa fa-key"></i> Login</button>
        </div>
	    <div class="col-sm-offset-2 col-lg-offset-4 col-sm-2 col-lg-1">
            <a href="index.php?change_password_page">Forget password<span class="glyphicon glyphicon-question-sign"></span></a>
        </div>
	</div>
    </form>
	</div>
<?php
}
?>