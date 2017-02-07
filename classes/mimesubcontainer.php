<?php
class MIMESubcontainer extends MIMEContainer
{
	function __construct()
	{
		parent::__construct;
	}	
	public function create()
	{
		$addheaders=(is_array($this->add_header))?implode($this->add_header,"\r\n"):'';
		$headers="Content-Type:".$this->get_content_type().";boundary=".$this->boundary."\r\n".$add_headers."\r\n\r\n";
		if(is_array($this->subcontainers)&&count($this->subcontainers)>0)
		{
			$header=$header."Content-Type:".$this->get_content_type().";boundary=".$this->boundary."\r\n".$add_headers."\r\n\r\n";
			$header=$header."Content-Transfer-Encoding:".$this->get_content_enc()."\r\n".$addheaders."\r\n";
			if(is_array($this->subcontainers)&&count($this->subcontainers)>0)
		    {
				foreach($this->subcontainers as $subcontainer)
		        {
					$headers=$headers."--$this->boundary\r\n";
				    $headers=$headers.$subcontainer->create();
			    }
		    }
		    $headers.="--$this->boundary--\r\n";
		}
		return $headers;
	}
}
?>