<?php
session_start();
$GLOBALS['config']=array(
    'mysql' => array(
         'host' => '127.0.0.1',
         'username' => 'root',
         'password' => '',
         'db' => 'onlinejudge'
     ),
     'remember' => array(
         'cookie_name' => 'hash',
         'cookie_expiry' => 604800
     ),
     'session' => array(
         'session_name' => 'user',
		 'contest_session' => 'contestId',
		 'contest_session_participate' => 'contestParticipateId',
		 'token_name' => 'token',
		 'contest_end_time' => 'contestEndTime'	 
     )
);
spl_autoload_register(function($class) {
    require_once($_SERVER['DOCUMENT_ROOT'].'onlinejudge/classes/'.$class.'.php');
});
require_once($_SERVER['DOCUMENT_ROOT'].'onlinejudge/functions/sanitize.php');
require_once($_SERVER['DOCUMENT_ROOT'].'onlinejudge/functions/functions.php');

if(Cookie::exits(Config::get('remember/cookie_name'))&&!Session::exits(Config::get('session/session_name')))
{  
   $hash=Cookie::get(Config::get('remember/cookie_name'));
   $hashCheck=DB::getInstance()->get('users_session',array('hash','=',$hash));
   if($hashCheck->count())
   {
     $user=new user($hashCheck->first()->user_id);
     $user->login();
   }
}
?>