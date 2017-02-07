<?php
class MIMEAttachment extends MIMEContainer
{
	protected $content_type="application/octet-stream";
	protected $content_enc="base64";
	protected $filename;
	protected $content;
	function __construct($filename="",$mimetype="")
	{
		parent::__construct();
		if(!empty($filename))
		{
			$this->set_file($filename,$mimetype);
		}
		$this->content=uniqid(rand(1,1000));
	}
	public function set_file($filename,$mimetype="")
	{
		$fr=fopen($filename,"r");
		if(!$fr)
		{
			$classname=__CLASS__;
			trigger_error("$classname Couldn't open $filename to be attached",E_USER_NOTICE);
			return false;
		}
		if(!empty($mimetype))
		{
			$this->content_type=$mimetype;
		}
		$buffer=fread($fr,filesize($filename));
		$this->content=base64_encode($buffer);
		$this->filename=$filename;
		unset($buffer);
		fclose($fr);
		return true;
	}
	public function get_file()
	{
		$retval=array('filename'=>$this->filename,'mimetypr'=>$this->content_type);
		return $retval;
	}
	public function create()
	{
		if(!isset($this->content))
			return ;
		$finfo=pathinfo($this->filename);
		$filename=$finfo['basename'];
		$addheaders=(is_array($this->add_header))?implode($this->add_header,"\r\n"):'';
		$headers="Content-Type:$this->content_type;filename=$filename\r\n";
		$headers.="Content-Transfer-Encoding:".$this->content_enc."\r\n";
		$headers.="Content-Disposition:attachment\r\n$addheaders\r\n";
		$headers.=chunk_split($this->content)."\n";
		return $headers;
	}
}
?>