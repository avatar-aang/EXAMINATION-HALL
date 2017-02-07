<?php
require_once '../core/init.php';
if(isset($_GET['id']))
{
	Session::put(Config::get('session/contest_session'),Input::get('id'));
	Redirect::to('add_questions.php');
}
?>