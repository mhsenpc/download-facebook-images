<?php
    @session_start();
    include_once("config.php");
    include("curl.php");
    
    $pageid=$_REQUEST['pageid'];
    $captcha=$_REQUEST['captcha'];

    if(md5($captcha)==$_SESSION['key'] ){ 	
    	$query = "/$pageid/posts?fields=message,picture,object_id&limit=30" ;  
        
        $url= $base_url."?q=". base64_encode($query);
        echo simple_Curl_download($url);
    }
    else
        die("captcha_error");