<?php

	//Leave all this stuff as it is
	date_default_timezone_set('EST');
	include 'GIFEncoder.class.php';
	include 'php52-fix.php';
	$time = $_GET['time'];
	$future_date = new DateTime(date('r',strtotime($time)));
	$time_now = time();
	$now = new DateTime(date('r', $time_now));
	$frames = array();	
	$delays = array();



	


	$delay = 100;// milliseconds

	
	for($i = 0; $i <= 60; $i++){
		
		$interval = date_diff($future_date, $now);
		
		if($future_date < $now){
			$imageWidth=300; //width of your image
$imageHeight=200;// height of your image
$image = imagecreatetruecolor($imageWidth, $imageHeight); //create Image
//for transparent background
imagealphablending($image, false);
imagesavealpha($image, true);
$col=imagecolorallocatealpha($image,255,255,255,127);
imagefill($image, 0, 0, $col);
//for transparent background
$black = imagecolorallocate($image, 0, 0, 0); //for font color
$font = './Futura.ttc'; //font path
$fontsize= 20; // size of your font
$x=10; // x- position of your text
$y=20; // y- position of your text
$angle=0; //angle of your text 
			$text = $interval->format('00:00:00:00');
			imagettftext ($image , $fontsize , $angle , $x , $y , $black , $font, $text );
			ob_start();
			imagegif($image);
			$frames[]=ob_get_contents();
			$delays[]=$delay;
			$loops = 1;
			ob_end_clean();
			break;
		} else {
$imageWidth=300; //width of your image
$imageHeight=200;// height of your image
$image = imagecreatetruecolor($imageWidth, $imageHeight); //create Image
//for transparent background
imagealphablending($image, false);
imagesavealpha($image, true);
$col=imagecolorallocatealpha($image,255,255,255,127);
imagefill($image, 0, 0, $col);
//for transparent background
$black = imagecolorallocate($image, 0, 0, 0); //for font color
$font = './Futura.ttc'; //font path
$fontsize= 20; // size of your font
$x=10; // x- position of your text
$y=20; // y- position of your text
$angle=0; //angle of your text 
			
			$text = $interval->format(	'Holiday Party Countdown:
   Days  Hrs  Min  Sec
    %a     %H   %I    %S');
			imagettftext ($image , $fontsize , $angle , $x , $y , $black , $font, $text );
			ob_start();
			imagegif($image);
			$frames[]=ob_get_contents();
			$delays[]=$delay;
			$loops = 0;
			ob_end_clean();
		}

		$now->modify('+1 second');
	}

	//expire this image instantly
	header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', false );
	header( 'Pragma: no-cache' );
	$gif = new AnimatedGif($frames,$delays,$loops);
	$gif->display();