<?php
class Input
{
  public static function exits($type='POST')
  {
    switch($type)
	{
	  case 'POST':
	  return (!empty($_POST))?true:false;
	  break;
	  case 'GET':
	  return (!empty($_GET))?true:false;
	  break;
          case 'FILES':
          return (!empty($_FILES))?true:false;
	  default:
	  return false;
	}
  }
  public static function get($item)
  {
    if(isset($_POST[$item]))
	{
	   return $_POST[$item];
	}
	else if(isset($_GET[$item]))
	{
	   return $_GET[$item];
	}
	else
	{ 
	   return '';
	}
  }
  public static function fget($item,$detail)
  {
    if(isset($_FILES[$item][$detail]))
    {
        return $_FILES[$item][$detail];
    }
  }
}

?>