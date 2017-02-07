<?php
class MIMEContainer
{
	protected $content_type="text/plain";
	protected $content_enc="7-bit";
	protected $content;
	protected $subcontainers;
	protected $boundary;
	protected $created;
	protected $add_header;
	function __construct()
	{
		$this->created=false;
		$this->boundary=uniqid(rand(1,10000));
	}
	public function get_message($add_headers="")
	{
		return $this->create($add_headers);
	}
	public function sendmail($to,$from,$subject,$add_headers="")
	{
		mail($to,$subject,$this->get_message($add_headers),"From:$from\r\n");
	}
	public function add_header($header)
	{
		$this->add_header[]=$header;
	}
	public function get_add_headers()
	{
		return $this->add_header;
	}
	public function set_content_type($newval)
	{
		$this->content_type=$newval;
	}
	public function get_content_type()
	{
		return $this->content_type;
	}
	public function set_content_enc($newval)
	{
		$this->content_enc=$newval;
	}
	public final function get_content_enc()
	{
		return $this->content_enc;
	}
	public function set_content($newval)
	{
		$this->content=$newval;
	}
	public function get_content()
	{
		return $this->content;
	}
	public final function add_subcontainer($container)
	{
		$this->subcontainers[]=$container;
	}	
	public final function get_subcontainers()
	{
		return $this->subcontainers;
	}	
	public function create()
	{
		$headers="MIME-VERSION: 1.0\r\n"."Content-Transfer-Encoding:".$this->get_content_enc()."\r\n";
		$addheaders=(is_array($this->add_header))?implode($this->add_header,"\r\n"):'';
		if(is_array($this->subcontainers)&&count($this->subcontainers)>0)
		{
			$headers=$headers."Content-Type:".$this->get_content_type().";boundary=".$this->boundary."\r\n".$addheaders."\r\n\r\n";
			$headers.=wordwrap("If you are reading this portion of the email then you are not reading this e-mail through
			                  a MIME compatible e-mail client\r\n\r\n");
			foreach($this->subcontainers as $subcontainer)
		    {
				if(method_exists($subcontainer,"create"))
			    {
					$headers=$headers."--$this->boundary\r\n";
				    $headers=$headers.$subcontainer->create();
			    }
		    }
		    $headers.="--$this->boundary--\r\n";
		}
		else
		{
			$headers=$headers."Content-Transfer:".
			$headers=$headers."Content-Type:".$this->get_content_type()."\r\n".$addheaders."\r\n\r\n".$this->get_content();
		}
		return $headers;
	}
}
?>