<?php
require_once '../core/init.php';
if(isset($_GET['type'])&&isset($_GET['id']))
{
	       
	       if(Input::get('type')==1)
		   {
			   $conn=DB::getInstance()->get('subjective_questions',array('id','=',Input::get('id')));
			   $result=$conn->first();
			   if($result->image!="")
			   {
				   if(file_exists($result->image))
					   unlink($result->image);
			   }
			   $conn=DB::getInstance()->delete('subjective_questions',array('id','=',Input::get('id')));
               			   
		   }
		   else if(Input::get('type')==2)
		   {
			   $conn=DB::getInstance()->get('subjective_questions',array('id','=',Input::get('id')));
			   $result=$conn->first();
			   if($result->image!="")
			   {
				   if(file_exists($result->image))
					   unlink($result->image);
			   }
			   $conn=DB::getInstance()->delete('mcq_questions',array('id','=',Input::get('id')));		
		   }
		   else if(Input::get('type')==3)
		   {
			   $conn=DB::getInstance()->get('subjective_questions',array('id','=',Input::get('id')));
			   $result=$conn->first();
				   if(file_exists($result->input_path))
					   unlink($result->input_path);
				   if(file_exists($result->output_path))
					   unlink($result->output_path);
			   $conn=DB::getInstance()->delete('coding_questions',array('id','=',Input::get('id')));		
		   }
		   else;
                   Redirect::to($_SERVER['HTTP_REFERER']);
}
else
	die();
?>