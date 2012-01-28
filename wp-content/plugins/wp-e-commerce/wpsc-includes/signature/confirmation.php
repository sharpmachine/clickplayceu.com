<?php
$signData = $_POST["ctlSignature_data"]; // the data that comes from client side
//$fileName = $_POST["ctlSignature_file"]; // the name of file for reference that comes from client side
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$userid = $_POST["userid"];
$email = $_POST["email"];

ini_set('display_errors',1);
error_reporting(E_ALL);

if (strlen($signData) > 0) 
{
	include 'license.php';
  	$im = GetSignatureImage($signData);
  	
  	if(null != $im)
  	{
 	  /*if(strlen($fileName) > 0)
	  {
   	   // Process the $im object here on your server you can save, email etc.
	  }*/
        $logo_file = $lastname."_".$firstname.".png";
		$image_file = "affidavit-20111203.gif";
		$targetfile = $userid .".jpg";
        $finalimg = $lastname."_" .$firstname. "_" . $userid .".png";
		
        imagepng($im, $logo_file);
		ImageDestroy($im);
		
		$photo = imagecreatefromgif($image_file);
		$fotoW = imagesx($photo);
		$fotoH = imagesy($photo);
		$logoImage = imagecreatefrompng($logo_file);
		$logoW = imagesx($logoImage);
		$logoH = imagesy($logoImage);
		$photoFrame = imagecreatetruecolor($fotoW,$fotoH);
		$dest_x = ($fotoW - $logoW)/2;
		$dest_y = 260;
		imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH);
		imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH);
		imagejpeg($photoFrame, $targetfile); 
        
		$name = $firstname." ".$lastname;
		
		// add name
		$font = 4;
		$width = imagefontwidth($font) * strlen($name) ;
		$height = imagefontheight($font) ;
		$im = imagecreatefromjpeg($targetfile);
		$x = imagesx($im) - $width ;
		$y = imagesy($im) - $height;
		$backgroundColor = imagecolorallocate ($im, 255, 255, 255);
		$textColor = imagecolorallocate ($im, 0, 0, 0);
		imagestring ($im, $font, 70, 330, $name, $textColor);
		imagepng($im, "withtext.png");
		//unlink("withtext.png");
		// add date
		$string = date("F j, Y, g:i a");
		$font = 4;
		$width = imagefontwidth($font) * strlen($string);
		$height = imagefontheight($font) ;
		$im = imagecreatefrompng("withtext.png");
		$x = imagesx($im) - $width ;
		$y = imagesy($im) - $height;
		$backgroundColor = imagecolorallocate ($im, 255, 255, 255);
		$textColor = imagecolorallocate ($im, 0, 0, 0);
		imagestring ($im, $font, 70, 400, $string, $textColor);
		imagepng($im, $finalimg);
		//header('Location: ?affidavit=true&filename='.$finalimg.'');
		//echo '<img src="'. $finalimg . '" />';
	} else {
		//echo "<h3>Error generating signature. Check license.</h3>";
	}
} else {
  //echo "<h3>Invalid or missing signature data.</h3>";
}
header('Location: http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . (dirname(dirname(dirname(dirname(dirname(dirname($_SERVER['REQUEST_URI']))))))) . '?affidavit=true&filename=' . $finalimg);
