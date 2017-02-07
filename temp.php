<?php
require_once 'core/init.php';
$ch=curl_init();
$fields=array(
    "format" => "json",
    "lang" => 5,
	"api_key" => 'hackerrank|627277-998|115f5a6489266ba05301600af6bfc12be4fa0770',
    "source" => "print 1",
    "testcases" => '[]',
    "wait" => 'true',
	'dataType' => 'json'
  );$fields_string="";
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');
$url = "http://api.hackerrank.com/checker/languages.json";
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json'
));
$result = curl_exec($ch);print_r($result);
$result = json_decode($result, true);
echo curl_error ($ch);
print_r($result);
curl_close($ch);
?>
<head>
    <meta charset="utf-8">
    <title> book store app</title>
    <meta name="description" content="bookstore app">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="style/css/bootstrap-theme.min.css" >
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <script type="text/javascript" src="style/js/jquery-2.2.4.min.js"></script>
    <script src="style/js/jquery.min.js"></script>
    <!-- Latest  compiled and minified JavaScript -->
    <script src="style/js/bootstrap.min.js"></script>
	<script src="functions/functions.js"></script>
    <style>
	.nonresizeable
	{
		resize:none;
	}
	body
		{
	        font-family: Comic Sans Ms;
	        background:url(gallery/bgnoise_lg.png);
	        color: #3a2127;
        }
		li{
			padding-top:8px;
		}
	</style>
</head>
<body>
</br>
</br>
<div class="container-fluid" align="centre">
     <div class="col-lg-offset-3 col-lg-6 col-lg-offset-3">
	      <div class="row">
		      <nav class="navbar navbar-default" role="navigation">
                 <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                 <span class="sr-only">Navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 </button>
                 </div>
				 <div class="divider"></div>
                <div class="collapse navbar-collapse" id="navbar-collapse">     
                    <ul class="nav navbar-nav navbar-left" id="menu">
					  <li>
					  <div class="col-lg-4">
					     <select class="form-control" id="s_language" name="s_language">
                           <?php
						     $languages=get_languages();
							 print_r($languages);
							 foreach($languages as $language)
                               {
                                   echo '<option value="'.$language->hck_id.'">'.$language->name.'</option>';
                               }
						   ?>
					     </select>
					   </div>
					      <div class="col-lg-offset-2 col-lg-6">
						     <input type="file" class="form-control  pull-right" id="upload_file" name="upload_file">
                          </div>
					 </li>
                    </ul>
                </div>
             </nav>
		  </div>
		  <div class="row">
			   <textarea class="form-control" rows="20" name="text_editor" id="text_editor">gfgfgfgg</textarea>
		  </div>
		  </br>
		  <div class="row">
			  <button class="btn btn-success pull-right" onclick="submit_code();">Submit <span class="glyphicon glyphicon-ok"></span></button>
		  </div>
		  </br>
		  <div class="row">
			   <textarea class="form-control nonresizeable" rows="1" name="output" id="output" readonly >gfgfgfgg</textarea>
		  </div>
	      </div>
  </div>
  </body>