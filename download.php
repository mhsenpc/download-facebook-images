<?php
    include_once("config.php");
    include("curl.php");
    include("zip.php");
    $ranodm_str= substr( md5( microtime() * time()),1,8);
    
	$q=base64_decode( $_GET['q']);
    
	$data= Curl_download($api_url,$q);
	
	if(strpos($data,"error",0) ==FALSE ) {
		//load normally
		$data= unserialize(  urldecode($data));

        $files_to_zip=array();
        $key=0;
        
		$next= ($data['paging']['next']); //with url
		$next = str_replace("https://graph.facebook.com/v2.0", "", $next); //clear url query for next page
		
        $image_folder="images/".$ranodm_str;
        mkdir($image_folder);
        
		$data = $data['data'];
        foreach($data as $post){
            if(!empty($post['object_id'])){
                
                $url="https://graph.facebook.com/".$post['object_id']."/picture";
                $image= simple_Curl_download($url);
                
                
                $filename=$image_folder."/".$post['object_id'].".jpg";
                file_put_contents($filename,$image);
                $files_to_zip[$key++]=$filename;
                
            }

        }
        
        //if true, good; if false, zip creation failed
        $result = create_zip($files_to_zip, $image_folder.'.zip');
        echo $ranodm_str;
        //$url= $base_url."?q=". base64_encode($next);
        //simple_Curl_download($url);
        
        
	}
	else{
		$data=array('posts'=>array() ,'qr'=>$qr,'next'=>'' , 'previous' => '','pagename' =>$pageid,'error_message'=>'This Page Is not valid or has no posts <br/>');
	}


?>