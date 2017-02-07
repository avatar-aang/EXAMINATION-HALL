<?php
class Validate
{
  private $_passed=false,
          $_errors=array(),
          $_db=null;
  public function __construct()
  {
    $this->_db=DB::getInstance();
  }
  public function check($source,$items=array())
  {
    foreach($items as $item=>$rules)
    {
       foreach($rules as $rule => $rule_value)
       {
          if($source!=$_FILES)
          $value=trim($source[$item]);
          else
          $value=$source[$item];
          $item=escape($item);
          if($rule==='required')
          {
             if($source!=$_FILES)
             {
               if(empty($value))
               {
                  $this->addError("$item is required");
               }
             }
             else
             {
               if(empty($value['name']))
               {
                  $this->addError("$item is required");
               }
             }
          }
          elseif(!empty($value))
          {
             switch($rule)
             {
               case 'min':
                 if(strlen($value)<$rule_value)
                 {
                    $this->addError("$item must be a minimum of $rule_value");
                 }
               break;
               case 'max':
                 if(strlen($value)>$rule_value)
                 {
                    $this->addError("$item must be a maximum of $rule_value");
                 }
               break;
               case 'matches':
                 if($value != $source[$rule_value])
                 {
                     $this->addError("$rule_value must match item");
                 }
               break;
			   case 'greaterthan':
			     if($value<$rule_value)
				 {
					 $this->addError("$item must be greater than $rule_value");
				 }
			   break;
               case 'unique':
                 $check=$this->_db->get($rule_value,array($item,'=',$value));
                 if($check->count()>0)
                 {
                    $this->addError("$item value already exits");
                 }
               break;
               case 'maxsize':
                 if($value['size']>$rule_value)
                 {
                    $this->addError("Size of uploaded image should be less than $rule_value ");
                 }
               break;
               case 'type':
                 if($value['type']==trim($rule_value))
                 {
                    $this->addError("Uploaded file should be $rule_value format");
                 }
               break;
               case 'extension':
                 $name=$value['name'];
                 $extension=strtolower(substr($name,strpos($name,'.')+1));
                 if($extension!==$rule_value)
                 {
                    $this->addError("Extension of image should be $rule_value ");
                 }
               break;
			   case 'valid':
			     $rule_values=explode('/',$rule_value);
			     $check=$this->_db->get($rule_values[0],array($rule_values[1],'=',$value));
				 if($check->count()==0)
                 {
                    $this->addError("$item value should be valid");
                 }
			   break;
			   case 'is_num':
			     if(!is_numeric($value))
				 {
					 $this->addError("$item should be numeric");
				 }
			   break;
             }  
          }
       }
    }  
    if(empty($this->_errors))
    {
       $this->_passed=true;
    }
    return $this;
  }
  private function addError($error)
  {
    $this->_errors[]=$error;
  } 
  public function errors()
  {
    return $this->_errors;
  }
  public function passed()
  {
    return $this->_passed;
  }
}
?>