<?php 
session_start();
$str=substr( md5( microtime() * time()),1,5);

$captcha = imagecreatefrompng("capchabg.png");
//get color
$black=imagecolorallocate($captcha,0,0,0);
$line=imagecolorallocate($captcha,233,239,239);

//draw line in pic
imageline($captcha,0,0,39,29,$line);
imageline($captcha,40,0,64,29,$line);

imagestring($captcha,5,20 ,10,$str,$black);
$_SESSION['key']=md5( $str);
header("Content-type: image/png");
imagepng($captcha);

?>