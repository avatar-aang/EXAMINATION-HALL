<?php
require '../core/init.php';
if(isset($_POST['no_options']))
{
  $no_options=escape($_POST['no_options']);
  $i=1;
  for($i=1;$i<=$no_options;$i++)
  {
	  echo '<div class="form-group">';
	    echo '<label for="option'.$i.'" class="col-sm-2 col-lg-2 control-label">Option'.$i.'</label>';
		echo '<div class="col-sm-10 col-lg-6">';
	    echo '<input type="text" name="option'.$i.'" id="option'.$i.'">';
		echo '</div>';
	  echo '</div>';
  }
}
?>