<?php

class Session
{
  public static function put($name,$value)
  {
     return $_SESSION[$name]=$value;
  }
  public static function exits($name)
  {
     if(isset($_SESSION[$name]))
	 {
	    return true;
	 }
	 return false;
  }
  public static function get($name)
  {
     if(self::exits($name))
	 {
	    return $_SESSION[$name];
	 }
	 return false;
  }
  public static function delete($name)
  {
     if(self::exits($name))
	 {
	    unset($_SESSION[$name]);
		return true;
	 }
	 return false;
  }
  public static function flash($name,$string='')
  {
     if(self::exits($name))
     {
        $session=self::get($name);
        self::delete($name);
        return $session;
     }
     else if($string!='')
     {
        self::put($name,$string);
     }
  }
}


?>