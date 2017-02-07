<?php
require_once('core/init.php');
$user=new user();
$sql="UPDATE users SET last_logout=CURRENT_TIMESTAMP WHERE id=?";
if(DB::getInstance()->query($sql,array($user->data()->id)))
{
	$user->logout();
    Redirect::to('index.php');
}
?>