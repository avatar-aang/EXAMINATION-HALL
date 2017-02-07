<?php
require_once '../core/init.php';
if(isset($_GET['id']))
{
			   if(Session::delete(Config::get('session/contest_session')))
               header('Location:index.php');			 
               else
               echo 'some error occured';				   
}
else
	die();
?>