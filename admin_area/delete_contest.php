<?php
require_once '../core/init.php';
if(isset($_GET['id']))
{
			   $conn=DB::getInstance()->delete('contests',array('id','=',Input::get('id')));
			   if(!$conn->error())
               header('Location:index.php');			   
}
else
	die();
?>